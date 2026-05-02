<?php

namespace App\Service\Race;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\Service as DataObjectService;

final class RaceImporter
{
    private const CATEGORY_CLASS = \Pimcore\Model\DataObject\RaceCategoryTemplate::class;
    private const RACE_CLASS = \Pimcore\Model\DataObject\RaceTemplate::class;
    private const RULESET_CLASS = \Pimcore\Model\DataObject\RuleSetTemplate::class;
    private const ROLL_TABLE_CLASS = \Pimcore\Model\DataObject\RollTableTemplate::class;

    private const LIBRARY_ROOT = '/Library';
    private const LEGACY_RULESET_ROOT = '/Templates/RuleSets';

    /**
     * @return array{
     *   categoriesCreated:int,
     *   categoriesUpdated:int,
     *   racesCreated:int,
     *   racesUpdated:int,
     *   errors:array<int, string>
     * }
     */
    public function import(array $document, bool $dryRun = true): array
    {
        $stats = [
            'categoriesCreated' => 0,
            'categoriesUpdated' => 0,
            'racesCreated' => 0,
            'racesUpdated' => 0,
            'errors' => [],
        ];

        if (!class_exists(self::CATEGORY_CLASS) || !class_exists(self::RACE_CLASS) || !class_exists(self::RULESET_CLASS)) {
            $stats['errors'][] = 'Required classes RaceCategoryTemplate / RaceTemplate / RuleSetTemplate do not exist yet.';

            return $stats;
        }

        $ruleSetExternalId = isset($document['ruleSet']) && is_string($document['ruleSet']) ? trim($document['ruleSet']) : '';
        if ('' === $ruleSetExternalId) {
            $stats['errors'][] = 'ruleSet is required.';

            return $stats;
        }

        $categories = $document['categories'] ?? [];
        $races = $document['races'] ?? [];
        if (!is_array($categories) || !is_array($races)) {
            $stats['errors'][] = 'categories and races must be arrays.';

            return $stats;
        }

        $ruleSetTemplate = $this->findOrCreateRuleSetTemplate($ruleSetExternalId, $dryRun);
        if (null === $ruleSetTemplate) {
            $stats['errors'][] = sprintf('Could not resolve RuleSetTemplate for ruleSet "%s".', $ruleSetExternalId);

            return $stats;
        }

        $categoryIndex = [];
        foreach ($categories as $index => $categoryData) {
            if (!is_array($categoryData)) {
                continue;
            }

            try {
                $categoryObject = $this->upsertCategory(
                    ruleSetExternalId: $ruleSetExternalId,
                    ruleSetTemplate: $ruleSetTemplate,
                    categoryData: $categoryData,
                    dryRun: $dryRun,
                    stats: $stats,
                    path: sprintf('categories[%d]', $index)
                );
                if (is_object($categoryObject)) {
                    $resolvedExt = RaceCategoryImportUtil::resolveCategoryExternalId($ruleSetExternalId, $categoryData);
                    $categoryIndex[$resolvedExt] = $categoryObject;
                }
            } catch (\Throwable $exception) {
                $stats['errors'][] = sprintf('categories[%d] failed: %s', $index, $exception->getMessage());
            }
        }

        foreach ($races as $index => $raceData) {
            if (!is_array($raceData)) {
                continue;
            }

            try {
                $categoryExternalId = trim((string) ($raceData['categoryExternalId'] ?? ''));
                $categoryObject = $categoryIndex[$categoryExternalId] ?? null;
                if (!is_object($categoryObject)) {
                    $categoryObject = $this->findCategoryByExternalId($categoryExternalId);
                }

                if (!is_object($categoryObject)) {
                    throw new \RuntimeException(sprintf(
                        'Category "%s" not found. Import categories before races, or ensure category exists.',
                        $categoryExternalId
                    ));
                }

                $this->upsertRace(
                    ruleSetTemplate: $ruleSetTemplate,
                    category: $categoryObject,
                    raceData: $raceData,
                    dryRun: $dryRun,
                    stats: $stats,
                    path: sprintf('races[%d]', $index)
                );
            } catch (\Throwable $exception) {
                $stats['errors'][] = sprintf('races[%d] failed: %s', $index, $exception->getMessage());
            }
        }

        return $stats;
    }

    /**
     * @param array<string, mixed> $categoryData
     * @param array{
     *   categoriesCreated:int,
     *   categoriesUpdated:int,
     *   racesCreated:int,
     *   racesUpdated:int,
     *   errors:array<int, string>
     * } $stats
     */
    private function upsertCategory(
        string $ruleSetExternalId,
        object $ruleSetTemplate,
        array $categoryData,
        bool $dryRun,
        array &$stats,
        string $path
    ): ?object {
        $externalId = RaceCategoryImportUtil::resolveCategoryExternalId($ruleSetExternalId, $categoryData);

        $name = trim((string) ($categoryData['name'] ?? ''));
        if ('' === $name) {
            $name = $externalId;
        }

        $folder = $this->resolveRaceCategoryFolder($ruleSetExternalId);
        $objectKey = DataObjectService::getValidKey($externalId, 'object');
        $fullPath = sprintf('%s/%s', rtrim((string) $folder->getFullPath(), '/'), $objectKey);

        $existing = $this->findCategoryByExternalId($externalId);
        if (null === $existing) {
            $byPath = DataObject::getByPath($fullPath);
            if (is_object($byPath) && is_a($byPath, self::CATEGORY_CLASS)) {
                $existing = $byPath;
            }
        }

        $isCreate = null === $existing;
        $object = $existing ?? new (self::CATEGORY_CLASS)();
        if (!is_object($object) || !is_a($object, self::CATEGORY_CLASS)) {
            throw new \RuntimeException(sprintf('%s could not instantiate RaceCategoryTemplate.', $path));
        }

        if ($isCreate) {
            $object->setParentId((int) $folder->getId());
            $object->setKey($objectKey);
            $object->setPublished(true);
        } elseif ((int) $object->getParentId() !== (int) $folder->getId()) {
            $object->setParentId((int) $folder->getId());
        }

        $this->setIfExists($object, 'setExternalId', $externalId);
        $this->setIfExists($object, 'setRuleSetTemplate', $ruleSetTemplate);
        $this->setIfExists($object, 'setName', $name);
        $this->setIfExists($object, 'setDescription', is_string($categoryData['description'] ?? null) ? $categoryData['description'] : null);

        $exhaustion = $this->readOptionalInt($categoryData, 'exhaustionColumnDivisor');
        if (null !== $exhaustion) {
            $this->setIfExists($object, 'setExhaustionColumnDivisor', $exhaustion);
        }

        $backgroundRolls = $this->readOptionalInt($categoryData, 'backgroundRolls');
        if (null !== $backgroundRolls) {
            $this->setIfExists($object, 'setBackgroundRolls', $backgroundRolls);
        }

        $movement = $this->readOptionalInt($categoryData, 'movementModification');
        if (null !== $movement) {
            $this->setIfExists($object, 'setMovementModification', $movement);
        }

        if (isset($categoryData['apparentAgeFormula']) && is_string($categoryData['apparentAgeFormula'])) {
            $this->setIfExists($object, 'setApparentAgeFormula', $categoryData['apparentAgeFormula']);
        }

        if (isset($categoryData['parentAgeFormula']) && is_string($categoryData['parentAgeFormula'])) {
            $this->setIfExists($object, 'setParentAgeFormula', $categoryData['parentAgeFormula']);
        }

        if (isset($categoryData['parentStatusFormula']) && is_string($categoryData['parentStatusFormula'])) {
            $this->setIfExists($object, 'setParentStatusFormula', $categoryData['parentStatusFormula']);
        }

        if (isset($categoryData['siblingFormula']) && is_array($categoryData['siblingFormula'])) {
            $this->applySiblingFormulaBlock($object, $categoryData['siblingFormula']);
        }

        $metadata = [];
        if (isset($categoryData['metadata']) && is_array($categoryData['metadata'])) {
            $metadata = $categoryData['metadata'];
        }
        if (isset($categoryData['actualAgeFromApparentFormula']) && is_string($categoryData['actualAgeFromApparentFormula'])) {
            $trimmed = trim($categoryData['actualAgeFromApparentFormula']);
            if ('' !== $trimmed) {
                $metadata['actualAgeFromApparentFormula'] = $trimmed;
            }
        }
        if ([] !== $metadata) {
            $this->setIfExists(
                $object,
                'setMetadataJson',
                json_encode($metadata, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        $apparentAgeTableSlug = $categoryData['apparentAgeTableRef'] ?? null;
        if (is_string($apparentAgeTableSlug) && '' !== trim($apparentAgeTableSlug)) {
            $rollTable = $this->findRollTableTemplateByExternalId(trim($apparentAgeTableSlug));
            if (null !== $rollTable) {
                $this->setIfExists($object, 'setApparentAgeTableRef', $rollTable);
            }
        }

        $parentStatusRef = $categoryData['parentStatusTableRef'] ?? null;
        if (is_string($parentStatusRef) && '' !== trim($parentStatusRef)) {
            $trimmed = trim($parentStatusRef);
            $this->setIfExists($object, 'setParentStatusTableRef', $trimmed);
            $resolved = $this->findRollTableTemplateByExternalId($trimmed);
            if (null !== $resolved) {
                $this->setIfExists($object, 'setParentStatusTable', $resolved);
            }
        }

        $this->setIfExists($object, 'setIsReadOnly', true);
        $this->setIfExists($object, 'setIsActive', true);

        if (!$dryRun) {
            $object->save();
        }

        if ($isCreate) {
            ++$stats['categoriesCreated'];
        } else {
            ++$stats['categoriesUpdated'];
        }

        return $object;
    }

    /**
     * @param array<string, mixed> $sibling
     */
    private function applySiblingFormulaBlock(object $object, array $sibling): void
    {
        $stringMap = [
            'numberOfLitters' => 'setNumberOfLitters',
            'litterSize' => 'setLitterSize',
            'olderSiblingAgeFormula' => 'setOlderSiblingAgeFormula',
            'youngerSiblingAgeFormula' => 'setYoungerSiblingAgeFormula',
            'genderFormula' => 'setGenderFormula',
        ];
        foreach ($stringMap as $yamlKey => $setter) {
            if (!array_key_exists($yamlKey, $sibling)) {
                continue;
            }
            $value = $sibling[$yamlKey];
            if (is_string($value)) {
                $this->setIfExists($object, $setter, $value);
            }
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    private function readOptionalInt(array $data, string $key): ?int
    {
        if (!array_key_exists($key, $data)) {
            return null;
        }
        $value = $data[$key];
        if (is_int($value)) {
            return $value;
        }
        if (is_float($value) && floor($value) == $value) {
            return (int) $value;
        }

        return null;
    }

    /**
     * @param array<string, mixed> $raceData
     * @param array{
     *   categoriesCreated:int,
     *   categoriesUpdated:int,
     *   racesCreated:int,
     *   racesUpdated:int,
     *   errors:array<int, string>
     * } $stats
     */
    private function upsertRace(
        object $ruleSetTemplate,
        object $category,
        array $raceData,
        bool $dryRun,
        array &$stats,
        string $path
    ): void {
        $externalId = trim((string) ($raceData['externalId'] ?? ''));
        $name = trim((string) ($raceData['name'] ?? ''));
        if ('' === $externalId || '' === $name) {
            throw new \InvalidArgumentException(sprintf('%s requires externalId and name.', $path));
        }

        $objectKey = DataObjectService::getValidKey($externalId, 'object');
        $fullPath = sprintf('%s/%s', rtrim((string) $category->getFullPath(), '/'), $objectKey);

        $existing = $this->findRaceByExternalId($externalId);
        if (null === $existing) {
            $byPath = DataObject::getByPath($fullPath);
            if (is_object($byPath) && is_a($byPath, self::RACE_CLASS)) {
                $existing = $byPath;
            }
        }

        $isCreate = null === $existing;
        $race = $existing ?? new (self::RACE_CLASS)();
        if (!is_object($race) || !is_a($race, self::RACE_CLASS)) {
            throw new \RuntimeException(sprintf('%s could not instantiate RaceTemplate.', $path));
        }

        if ($isCreate) {
            $race->setParentId((int) $category->getId());
            $race->setKey($objectKey);
            $race->setPublished(true);
        } elseif ((int) $race->getParentId() !== (int) $category->getId()) {
            $race->setParentId((int) $category->getId());
        }

        $this->setIfExists($race, 'setExternalId', $externalId);
        $this->setIfExists($race, 'setRuleSetTemplate', $ruleSetTemplate);
        $this->setIfExists($race, 'setCategoryTemplate', $category);
        $this->setIfExists($race, 'setName', $name);
        $this->setIfExists($race, 'setDescription', is_string($raceData['description'] ?? null) ? $raceData['description'] : null);

        foreach (['maleLength', 'maleWeight', 'femaleLength', 'femaleWeight'] as $field) {
            if (array_key_exists($field, $raceData) && is_int($raceData[$field])) {
                $setter = 'set'.ucfirst($field);
                $this->setIfExists($race, $setter, $raceData[$field]);
            }
        }

        if (isset($raceData['modifiers']) && is_array($raceData['modifiers'])) {
            $this->setIfExists(
                $race,
                'setModifierJson',
                json_encode($raceData['modifiers'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        if (isset($raceData['highCharacteristics']) && is_array($raceData['highCharacteristics'])) {
            $this->setIfExists(
                $race,
                'setHighCharacteristicsJson',
                json_encode($raceData['highCharacteristics'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        if (isset($raceData['lowCharacteristics']) && is_array($raceData['lowCharacteristics'])) {
            $this->setIfExists(
                $race,
                'setLowCharacteristicsJson',
                json_encode($raceData['lowCharacteristics'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        if (isset($raceData['highCharacteristicsJson']) && is_array($raceData['highCharacteristicsJson'])) {
            $this->setIfExists(
                $race,
                'setHighCharacteristicsJson',
                json_encode($raceData['highCharacteristicsJson'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        if (isset($raceData['lowCharacteristicsJson']) && is_array($raceData['lowCharacteristicsJson'])) {
            $this->setIfExists(
                $race,
                'setLowCharacteristicsJson',
                json_encode($raceData['lowCharacteristicsJson'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        if (isset($raceData['tableOverrides']) && is_array($raceData['tableOverrides'])) {
            $this->setIfExists(
                $race,
                'setTableOverridesJson',
                json_encode($raceData['tableOverrides'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        if (isset($raceData['ruleOverrides']) && is_array($raceData['ruleOverrides'])) {
            $this->setIfExists(
                $race,
                'setRuleOverrideJson',
                json_encode($raceData['ruleOverrides'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        if (isset($raceData['ruleOverrideJson']) && is_array($raceData['ruleOverrideJson'])) {
            $this->setIfExists(
                $race,
                'setRuleOverrideJson',
                json_encode($raceData['ruleOverrideJson'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        if (isset($raceData['metadata']) && is_array($raceData['metadata'])) {
            $this->setIfExists(
                $race,
                'setMetadataJson',
                json_encode($raceData['metadata'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }

        $this->setIfExists($race, 'setIsReadOnly', true);
        $this->setIfExists($race, 'setIsActive', true);

        if (!$dryRun) {
            $race->save();
        }

        if ($isCreate) {
            ++$stats['racesCreated'];
        } else {
            ++$stats['racesUpdated'];
        }
    }

    private function resolveRaceCategoryFolder(string $ruleSetExternalId): AbstractObject
    {
        $key = DataObjectService::getValidKey(trim($ruleSetExternalId), 'object');
        $path = sprintf('%s/%s/Races', rtrim(self::LIBRARY_ROOT, '/'), $key);

        return DataObjectService::createFolderByPath($path);
    }

    private function resolveRuleSetParentFolder(string $ruleSetExternalId): AbstractObject
    {
        $key = DataObjectService::getValidKey(trim($ruleSetExternalId), 'object');
        $path = sprintf('%s/%s/RuleSets', rtrim(self::LIBRARY_ROOT, '/'), $key);

        return DataObjectService::createFolderByPath($path);
    }

    private function findOrCreateRuleSetTemplate(string $externalId, bool $dryRun): ?object
    {
        $externalId = trim($externalId);
        $existing = $this->findRuleSetTemplateByExternalId($externalId);
        if (null !== $existing) {
            $targetFolder = $this->resolveRuleSetParentFolder($externalId);
            if ((int) $existing->getParentId() !== (int) $targetFolder->getId() && !$dryRun) {
                $existing->setParentId((int) $targetFolder->getId());
                $existing->save();
            }

            return $existing;
        }

        if (!class_exists(self::RULESET_CLASS)) {
            return null;
        }

        $folder = $this->resolveRuleSetParentFolder($externalId);
        $object = new (self::RULESET_CLASS)();
        if (!is_object($object) || !is_a($object, self::RULESET_CLASS)) {
            return null;
        }

        $key = DataObjectService::getValidKey($externalId, 'object');
        $this->setIfExists($object, 'setParentId', $folder->getId());
        $this->setIfExists($object, 'setKey', $key);
        $this->setIfExists($object, 'setPublished', true);
        $this->setIfExists($object, 'setExternalId', $externalId);
        $this->setIfExists($object, 'setName', $externalId);
        $this->setIfExists($object, 'setSource', 'race-import');
        $this->setIfExists($object, 'setIsReadOnly', true);

        if (!$dryRun) {
            $object->save();
        }

        return $object;
    }

    private function findRuleSetTemplateByExternalId(string $externalId): ?object
    {
        $externalId = trim($externalId);
        $result = (self::RULESET_CLASS)::getByExternalId($externalId, 1);
        if (is_object($result) && is_a($result, self::RULESET_CLASS)) {
            return $result;
        }

        if ($result instanceof DataObject\Listing) {
            $objects = $result->load();
            if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], self::RULESET_CLASS)) {
                return $objects[0];
            }
        }

        $key = DataObjectService::getValidKey($externalId, 'object');
        $preferredPath = sprintf('%s/%s/RuleSets/%s', rtrim(self::LIBRARY_ROOT, '/'), $key, $key);
        $byPath = DataObject::getByPath($preferredPath);
        if (is_object($byPath) && is_a($byPath, self::RULESET_CLASS)) {
            return $byPath;
        }

        $legacyPath = sprintf('%s/%s', rtrim(self::LEGACY_RULESET_ROOT, '/'), $key);
        $legacyByPath = DataObject::getByPath($legacyPath);
        if (is_object($legacyByPath) && is_a($legacyByPath, self::RULESET_CLASS)) {
            return $legacyByPath;
        }

        return null;
    }

    private function findCategoryByExternalId(string $externalId): ?object
    {
        $externalId = trim($externalId);
        $result = (self::CATEGORY_CLASS)::getByExternalId($externalId, 1);
        if (is_object($result) && is_a($result, self::CATEGORY_CLASS)) {
            return $result;
        }

        if ($result instanceof DataObject\Listing) {
            $objects = $result->load();
            if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], self::CATEGORY_CLASS)) {
                return $objects[0];
            }
        }

        return null;
    }

    private function findRaceByExternalId(string $externalId): ?object
    {
        $externalId = trim($externalId);
        $result = (self::RACE_CLASS)::getByExternalId($externalId, 1);
        if (is_object($result) && is_a($result, self::RACE_CLASS)) {
            return $result;
        }

        if ($result instanceof DataObject\Listing) {
            $objects = $result->load();
            if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], self::RACE_CLASS)) {
                return $objects[0];
            }
        }

        return null;
    }

    private function findRollTableTemplateByExternalId(string $externalId): ?object
    {
        if (!class_exists(self::ROLL_TABLE_CLASS)) {
            return null;
        }

        $externalId = trim($externalId);
        $result = (self::ROLL_TABLE_CLASS)::getByExternalId($externalId, 1);
        if (is_object($result) && is_a($result, self::ROLL_TABLE_CLASS)) {
            return $result;
        }

        if ($result instanceof DataObject\Listing) {
            $objects = $result->load();
            if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], self::ROLL_TABLE_CLASS)) {
                return $objects[0];
            }
        }

        return null;
    }

    private function setIfExists(object $target, string $method, mixed $value): void
    {
        if (!method_exists($target, $method)) {
            return;
        }

        $target->{$method}($value);
    }
}
