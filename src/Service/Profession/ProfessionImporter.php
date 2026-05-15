<?php

namespace App\Service\Profession;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\Fieldcollection;
use Pimcore\Model\DataObject\Data\ObjectMetadata;
use Pimcore\Model\DataObject\Fieldcollection\Data\EONSubProffesionVariant;
use Pimcore\Model\DataObject\Fieldcollection\Data\ExtraDataSegment;
use Pimcore\Model\DataObject\Objectbrick\Data\EONProfessionBrick;
use Pimcore\Model\DataObject\Profession\ProfessionData;
use Pimcore\Model\DataObject\Service as DataObjectService;

final class ProfessionImporter
{
    private const PROFESSION_CLASS = \Pimcore\Model\DataObject\Profession::class;
    private const RACE_CLASS = \Pimcore\Model\DataObject\RaceTemplate::class;
    private const RACE_CATEGORY_CLASS = \Pimcore\Model\DataObject\RaceCategoryTemplate::class;
    private const SKILL_CLASS = \Pimcore\Model\DataObject\Skill::class;
    private const SKILL_GROUP_CLASS = \Pimcore\Model\DataObject\SkillGroup::class;

    private const LIBRARY_ROOT = '/Library';

    private const SKILL_AMOUNT_COLUMN = 'amount';

    /** @var array<string, string> YAML list key => brick setter (professionSkills uses advanced relation metadata). */
    private const SKILL_RELATION_SETTERS = [
        'professionSkills' => 'setProfessionSkills',
        'otherSkills' => 'setOtherSkills',
    ];

    /** @var list<string> YAML keys that trigger persisting EONProfessionBrick (avoid creating a brick for unrelated keys). */
    private const BRICK_TRIGGER_KEYS = [
        'skillCheck1',
        'skillCheck2',
        'skillCheck3',
        'professionSkillPointsFail',
        'professionSkillPointsSuccess',
        'professionSkillPointsPerfect',
        'professionSkills',
        'battleExperience',
        'spellPoints',
        'otherSkillPointsFail',
        'otherSkillPointsSuccess',
        'otherSkillPointsPerfect',
        'otherSkills',
        'coinMultipleFail',
        'coinMultipleSuccess',
        'coinMultiplePerfect',
        'coinDiceRoll',
        'aGearFail',
        'aGearSuccess',
        'aGearPerfect',
        'bGearFail',
        'bGearSuccess',
        'bGearPerfect',
        'cGearFail',
        'cGearSuccess',
        'CGearSuccess',
        'cGearPerfect',
        'CGearPerfect',
        'dGearFail',
        'dGearSuccess',
        'dGearPerfect',
        'xGearFail',
        'xGearSuccess',
        'xGearPerfect',
        'connectionsFail',
        'connectionsSuccess',
        'connectionsPerfect',
        'other',
    ];

    /**
     * yamlKey => brick setter (float)
     *
     * @var array<string, string>
     */
    private const BRICK_FLOAT_SETTERS = [
        'professionSkillPointsFail' => 'setProfessionSkillPointsFail',
        'professionSkillPointsSuccess' => 'setProfessionSkillPointsSuccess',
        'professionSkillPointsPerfect' => 'setProfessionSkillPointsPerfect',
        'otherSkillPointsFail' => 'setOtherSkillPointsFail',
        'otherSkillPointsSuccess' => 'setOtherSkillPointsSuccess',
        'otherSkillPointsPerfect' => 'setOtherSkillPointsPerfect',
        'coinMultipleFail' => 'setCoinMultipleFail',
        'coinMultipleSuccess' => 'setCoinMultipleSuccess',
        'coinMultiplePerfect' => 'setCoinMultiplePerfect',
        'aGearFail' => 'setAGearFail',
        'aGearSuccess' => 'setAGearSuccess',
        'aGearPerfect' => 'setAGearPerfect',
        'bGearFail' => 'setBGearFail',
        'bGearSuccess' => 'setBGearSuccess',
        'bGearPerfect' => 'setBGearPerfect',
        'cGearFail' => 'setCGearFail',
        'cGearSuccess' => 'setCGearSuccess',
        'CGearSuccess' => 'setCGearSuccess',
        'cGearPerfect' => 'setCGearPerfect',
        'CGearPerfect' => 'setCGearPerfect',
        'dGearFail' => 'setDGearFail',
        'dGearSuccess' => 'setDGearSuccess',
        'dGearPerfect' => 'setDGearPerfect',
        'xGearFail' => 'setXGearFail',
        'xGearSuccess' => 'setXGearSuccess',
        'xGearPerfect' => 'setXGearPerfect',
        'connectionsFail' => 'setConnectionsFail',
        'connectionsSuccess' => 'setConnectionsSuccess',
        'connectionsPerfect' => 'setConnectionsPerfect',
    ];

    /**
     * @var array<string, string>
     */
    private const BRICK_STRING_SETTERS = [
        'skillCheck1' => 'setSkillCheck1',
        'skillCheck2' => 'setSkillCheck2',
        'skillCheck3' => 'setSkillCheck3',
        'battleExperience' => 'setBattleExperience',
        'spellPoints' => 'setSpellPoints',
        'coinDiceRoll' => 'setCoinDiceRoll',
        'other' => 'setOther',
    ];

    /**
     * @param array<string, mixed> $document
     * @return array{
     *   professionsCreated:int,
     *   professionsUpdated:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * }
     */
    public function import(array $document, bool $dryRun = true): array
    {
        $stats = [
            'professionsCreated' => 0,
            'professionsUpdated' => 0,
            'errors' => [],
            'warnings' => [],
        ];

        if (!class_exists(self::PROFESSION_CLASS)) {
            $stats['errors'][] = 'Profession class is not available.';

            return $stats;
        }

        $ruleSet = trim((string) ($document['ruleSet'] ?? ''));
        if ('' === $ruleSet) {
            $stats['errors'][] = 'ruleSet is required.';

            return $stats;
        }

        $professions = $document['professions'] ?? [];
        if (!is_array($professions)) {
            $stats['errors'][] = 'professions must be an array.';

            return $stats;
        }

        $analyzer = new ProfessionImportAnalyzer();
        $parentFolder = $this->resolveProfessionsParentFolder($ruleSet);
        $skillsParentFolder = $this->resolveSkillsParentFolder($ruleSet);
        $skillGroupsParentFolder = $this->resolveSkillGroupsParentFolder($ruleSet);

        foreach ($professions as $index => $professionData) {
            if (!is_array($professionData)) {
                continue;
            }

            $path = sprintf('professions[%d]', $index);

            try {
                $this->upsertProfession(
                    professionData: $professionData,
                    parentId: (int) $parentFolder->getId(),
                    dryRun: $dryRun,
                    stats: $stats,
                    path: $path,
                    analyzer: $analyzer,
                    skillsParentFolder: $skillsParentFolder,
                    skillGroupsParentFolder: $skillGroupsParentFolder
                );
            } catch (\Throwable $exception) {
                $stats['errors'][] = sprintf('%s failed: %s', $path, $exception->getMessage());
            }
        }

        return $stats;
    }

    /**
     * @param array<string, mixed> $professionData
     * @param array{
     *   professionsCreated:int,
     *   professionsUpdated:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * } $stats
     */
    private function upsertProfession(
        array $professionData,
        int $parentId,
        bool $dryRun,
        array &$stats,
        string $path,
        ProfessionImportAnalyzer $analyzer,
        AbstractObject $skillsParentFolder,
        AbstractObject $skillGroupsParentFolder
    ): void {
        $externalId = trim((string) ($professionData['externalId'] ?? ''));
        $name = trim((string) ($professionData['name'] ?? ''));
        if ('' === $externalId || '' === $name) {
            throw new \InvalidArgumentException(sprintf('%s requires externalId and name.', $path));
        }

        $existing = $this->findProfessionByExternalId($externalId, $parentId);
        if (null === $existing) {
            $key = DataObjectService::getValidKey($externalId, 'object');
            $parent = DataObject::getById($parentId);
            $fullPath = sprintf('%s/%s', rtrim((string) ($parent?->getFullPath() ?? ''), '/'), $key);
            $byPath = DataObject::getByPath($fullPath);
            if (is_object($byPath) && is_a($byPath, self::PROFESSION_CLASS)) {
                $existing = $byPath;
            }
        }

        $isCreate = null === $existing;
        $profession = $existing ?? new (self::PROFESSION_CLASS)();
        if (!is_object($profession) || !is_a($profession, self::PROFESSION_CLASS)) {
            throw new \RuntimeException(sprintf('%s could not instantiate Profession.', $path));
        }

        if ($isCreate) {
            $profession->setParentId($parentId);
            $profession->setKey(DataObjectService::getValidKey($externalId, 'object'));
            $profession->setPublished(true);
        } elseif ((int) $profession->getParentId() !== $parentId) {
            $profession->setParentId($parentId);
        }

        $this->setIfExists($profession, 'setExternalId', $externalId);
        $this->setIfExists($profession, 'setName', $name);

        if (array_key_exists('description', $professionData)) {
            $this->setIfExists($profession, 'setDescription', $this->normalizeProfessionDescription($professionData['description']));
        }

        if ($this->professionYamlDeclaresRaceFields($professionData)) {
            $this->applyRaceFields($profession, $professionData, $analyzer, $stats, $path);
        }

        if (array_key_exists('subProfession', $professionData)) {
            $this->applySubProfessionFieldCollection($profession, $professionData['subProfession'], $stats, $path);
        }


        if ($this->professionRowHasBrickKeys($professionData)) {
            $this->applyEonProfessionBrick(
                profession: $profession,
                professionData: $professionData,
                stats: $stats,
                path: $path,
                skillsParentFolder: $skillsParentFolder,
                skillGroupsParentFolder: $skillGroupsParentFolder
            );
        }

        if (!$dryRun) {
            $profession->save();
        }

        if ($isCreate) {
            ++$stats['professionsCreated'];
        } else {
            ++$stats['professionsUpdated'];
        }
    }

    /**
     * @param array<string, mixed> $professionData
     * @param array{professionsCreated:int, professionsUpdated:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function applyRaceFields(
        object $profession,
        array $professionData,
        ProfessionImportAnalyzer $analyzer,
        array &$stats,
        string $path
    ): void {
        $policy = $analyzer->normalizeRaceRestriction($professionData['raceRestriction'] ?? null);
        if (null === $policy) {
            $policy = 'all';
        }

        $refs = $analyzer->extractRaceIdRefs($professionData);
        if (!is_array($refs)) {
            $refs = [];
        }

        if ('all' === $policy) {
            $refs = [];
        }

        $resolved = [];
        $unresolved = [];
        foreach ($refs as $ref) {
            if (!is_string($ref) || '' === trim($ref)) {
                continue;
            }
            $trimmed = trim($ref);
            $obj = $this->findRaceRelationByExternalId($trimmed);
            if (null !== $obj) {
                $resolved[(string) $obj->getId()] = $obj;
            } else {
                $unresolved[] = $trimmed;
            }
        }

        if ([] !== $unresolved) {
            $stats['warnings'][] = sprintf(
                '%s.raceIds could not resolve: %s',
                $path,
                implode(', ', $unresolved)
            );
        }

        $this->setIfExists($profession, 'setRaceRestriction', $policy);
        $this->setIfExists($profession, 'setRaceIds', array_values($resolved));
    }

    /**
     * @param array<string, mixed>|mixed $raw
     * @param array{professionsCreated:int, professionsUpdated:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function applySubProfessionFieldCollection(object $profession, mixed $raw, array &$stats, string $path): void
    {
        if (!class_exists(ExtraDataSegment::class) && !class_exists(EONSubProffesionVariant::class)) {
            $stats['warnings'][] = sprintf('%s.subProfession skipped: fieldcollection classes missing.', $path);

            return;
        }

        if (null === $raw || [] === $raw) {
            $this->setIfExists($profession, 'setSubProfession', new Fieldcollection());

            return;
        }

        if (!is_array($raw)) {
            $stats['warnings'][] = sprintf('%s.subProfession must be an array; left unchanged.', $path);

            return;
        }

        $collection = new Fieldcollection();

        foreach ($raw as $index => $sub) {
            if (!is_array($sub)) {
                $stats['warnings'][] = sprintf('%s.subProfession[%s] skipped: not an object.', $path, (string) $index);

                continue;
            }

            $subExternalId = isset($sub['externalId']) && is_string($sub['externalId']) ? trim($sub['externalId']) : '';
            if ('' === $subExternalId) {
                $stats['warnings'][] = sprintf('%s.subProfession[%s] skipped: missing externalId.', $path, (string) $index);

                continue;
            }

            $item = $this->buildSubProfessionFieldCollectionItem($sub, $subExternalId, $stats, $path, (string) $index);
            if (null !== $item) {
                $collection->add($item);
            }
        }

        $this->setIfExists($profession, 'setSubProfession', $collection);
    }

    /**
     * @param array<string, mixed> $sub
     */
    private function buildSubProfessionFieldCollectionItem(
        array $sub,
        string $subExternalId,
        array &$stats,
        string $path,
        string $index
    ): ExtraDataSegment|EONSubProffesionVariant|null {
        $name = $this->nullableTrimmedString($sub['name'] ?? null);
        $description = $this->nullableTrimmedString($sub['description'] ?? null);

        if ($this->subProfessionDeclaresSkillChecks($sub)) {
            if (!class_exists(EONSubProffesionVariant::class)) {
                $stats['warnings'][] = sprintf(
                    '%s.subProfession[%s] has skillCheck fields but EONSubProffesionVariant class is missing.',
                    $path,
                    $index
                );

                return null;
            }

            $variant = new EONSubProffesionVariant();
            $variant->setExternalId($subExternalId);
            $variant->setName($name);
            $variant->setDescription($description);
            $variant->setSkillCheck1($this->nullableTrimmedString($sub['skillCheck1'] ?? null));
            $variant->setSkillCheck2($this->nullableTrimmedString($sub['skillCheck2'] ?? null));
            $variant->setSkillCheck3($this->nullableTrimmedString($sub['skillCheck3'] ?? null));

            return $variant;
        }

        if (!class_exists(ExtraDataSegment::class)) {
            $stats['warnings'][] = sprintf('%s.subProfession[%s] skipped: ExtraDataSegment class missing.', $path, $index);

            return null;
        }

        $segment = new ExtraDataSegment();
        $segment->setExternalId($subExternalId);
        $segment->setName($name);
        $segment->setDescription($description);

        return $segment;
    }

    /**
     * @param array<string, mixed> $sub
     */
    private function subProfessionDeclaresSkillChecks(array $sub): bool
    {
        foreach (['skillCheck1', 'skillCheck2', 'skillCheck3'] as $key) {
            if (array_key_exists($key, $sub)) {
                return true;
            }
        }

        return false;
    }

    private function nullableTrimmedString(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $trimmed = trim($value);

        return '' === $trimmed ? null : $trimmed;
    }

    private function normalizeProfessionDescription(mixed $value): ?string
    {
        if (null === $value) {
            return null;
        }

        if (is_string($value)) {
            $t = trim($value);

            return '' === $t ? null : $t;
        }

        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }

        return null;
    }

    /**
     * @param array<string, mixed> $professionData
     */
    private function professionRowHasBrickKeys(array $professionData): bool
    {
        foreach (self::BRICK_TRIGGER_KEYS as $key) {
            if (array_key_exists($key, $professionData)) {
                return true;
            }
        }

        return false;
    }

    /**
     * When no race keys are present in YAML, leave existing Pimcore race fields unchanged.
     *
     * @param array<string, mixed> $professionData
     */
    private function professionYamlDeclaresRaceFields(array $professionData): bool
    {
        return array_key_exists('raceRestriction', $professionData)
            || array_key_exists('raceIds', $professionData)
            || array_key_exists('raceId', $professionData);
    }

    /**
     * @param array<string, mixed> $professionData
     * @param array{professionsCreated:int, professionsUpdated:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function applyEonProfessionBrick(
        object $profession,
        array $professionData,
        array &$stats,
        string $path,
        AbstractObject $skillsParentFolder,
        AbstractObject $skillGroupsParentFolder
    ): void {
        if (!class_exists(EONProfessionBrick::class) || !class_exists(ProfessionData::class)) {
            $stats['warnings'][] = sprintf('%s professionData skipped: brick classes missing.', $path);

            return;
        }

        $brick = new EONProfessionBrick($profession);

        foreach (self::BRICK_STRING_SETTERS as $yamlKey => $setter) {
            if (!array_key_exists($yamlKey, $professionData)) {
                continue;
            }
            $v = $professionData[$yamlKey];
            if (null === $v) {
                $this->setIfExists($brick, $setter, null);

                continue;
            }
            if (is_string($v) || is_int($v) || is_float($v)) {
                $this->setIfExists($brick, $setter, is_string($v) ? $v : (string) $v);
            }
        }

        foreach (self::BRICK_FLOAT_SETTERS as $yamlKey => $setter) {
            if (!array_key_exists($yamlKey, $professionData)) {
                continue;
            }
            $v = $professionData[$yamlKey];
            if (null === $v || '' === $v) {
                continue;
            }
            if (is_int($v) || is_float($v)) {
                $this->setIfExists($brick, $setter, (float) $v);
            } elseif (is_string($v) && is_numeric($v)) {
                $this->setIfExists($brick, $setter, (float) $v);
            }
        }

        if (isset($professionData['professionSkills'])) {
            $this->applySkillRelationList(
                $brick,
                $professionData['professionSkills'],
                $stats,
                $path,
                'professionSkills',
                $skillsParentFolder,
                $skillGroupsParentFolder
            );
        }

        if (isset($professionData['otherSkills'])) {
            $this->applySkillRelationList(
                $brick,
                $professionData['otherSkills'],
                $stats,
                $path,
                'otherSkills',
                $skillsParentFolder,
                $skillGroupsParentFolder
            );
        }

        $professionDataContainer = $profession->getProfessionData();
        if (!$professionDataContainer instanceof ProfessionData) {
            return;
        }

        $professionDataContainer->setEONProfessionBrick($brick);
        $this->setIfExists($profession, 'setProfessionData', $professionDataContainer);
    }

    /**
     * Resolves each ref to a {@see Skill} or {@see SkillGroup}.
     * {@see self::SKILL_RELATION_SETTERS} `professionSkills` uses advanced metadata (`amount` only for skill groups).
     *
     * @param array<string, mixed>|mixed $raw
     */
    private function applySkillRelationList(
        object $brick,
        mixed $raw,
        array &$stats,
        string $path,
        string $fieldLabel,
        AbstractObject $skillsParentFolder,
        AbstractObject $skillGroupsParentFolder
    ): void {
        $setter = self::SKILL_RELATION_SETTERS[$fieldLabel] ?? null;
        if (null === $setter || !is_array($raw)) {
            return;
        }

        if ('professionSkills' === $fieldLabel) {
            $this->applyAdvancedProfessionSkills($brick, $setter, $raw, $stats, $path, $skillsParentFolder, $skillGroupsParentFolder);

            return;
        }

        $this->applyPlainSkillRelationList(
            $brick,
            $setter,
            $raw,
            $stats,
            $path,
            $fieldLabel,
            $skillsParentFolder,
            $skillGroupsParentFolder
        );
    }

    /**
     * @param array<int, mixed> $raw
     */
    private function applyAdvancedProfessionSkills(
        object $brick,
        string $setter,
        array $raw,
        array &$stats,
        string $path,
        AbstractObject $skillsParentFolder,
        AbstractObject $skillGroupsParentFolder
    ): void {
        $counts = $this->parseSkillRefCounts($raw);
        if ([] === $counts) {
            return;
        }

        /** @var list<ObjectMetadata> $metadata */
        $metadata = [];
        $unresolved = [];

        foreach ($counts as $externalId => $amount) {
            $element = $this->findSkillOrSkillGroupByExternalId($externalId, $skillsParentFolder, $skillGroupsParentFolder);
            if (null === $element) {
                $unresolved[] = $externalId;

                continue;
            }

            $entry = new ObjectMetadata('professionSkills', [self::SKILL_AMOUNT_COLUMN], $element);
            if (is_a($element, self::SKILL_GROUP_CLASS)) {
                $entry->setAmount((string) $amount);
            } else {
                $entry->setAmount('1');
            }

            $metadata[] = $entry;
        }

        if ([] !== $unresolved) {
            $stats['warnings'][] = sprintf(
                '%s.professionSkills could not resolve (skill or skill group): %s',
                $path,
                implode(', ', array_values(array_unique($unresolved)))
            );
        }

        $this->setIfExists($brick, $setter, $metadata);
    }

    /**
     * @param array<int, mixed> $raw
     */
    private function applyPlainSkillRelationList(
        object $brick,
        string $setter,
        array $raw,
        array &$stats,
        string $path,
        string $fieldLabel,
        AbstractObject $skillsParentFolder,
        AbstractObject $skillGroupsParentFolder
    ): void {
        /** @var list<object> $resolved */
        $resolved = [];
        $unresolved = [];

        foreach ($raw as $ref) {
            if (!is_string($ref) || '' === trim($ref)) {
                continue;
            }
            $trimmedRef = trim($ref);
            $element = $this->findSkillOrSkillGroupByExternalId($trimmedRef, $skillsParentFolder, $skillGroupsParentFolder);
            if (null !== $element) {
                $resolved[] = $element;
            } else {
                $unresolved[] = $trimmedRef;
            }
        }

        if ([] !== $unresolved) {
            $stats['warnings'][] = sprintf(
                '%s.%s could not resolve (skill or skill group): %s',
                $path,
                $fieldLabel,
                implode(', ', array_values(array_unique($unresolved)))
            );
        }

        $unique = [];
        foreach ($resolved as $element) {
            $unique[(string) $element->getId()] = $element;
        }

        $this->setIfExists($brick, $setter, array_values($unique));
    }

    /**
     * @param array<int, mixed> $raw
     *
     * @return array<string, int> externalId => amount (first-seen order preserved)
     */
    private function parseSkillRefCounts(array $raw): array
    {
        /** @var array<string, int> $counts */
        $counts = [];
        /** @var list<string> $order */
        $order = [];

        foreach ($raw as $ref) {
            $externalId = null;
            $amount = 1;

            if (is_string($ref)) {
                $externalId = trim($ref);
            } elseif (is_array($ref)) {
                if (isset($ref['externalId']) && is_string($ref['externalId'])) {
                    $externalId = trim($ref['externalId']);
                }
                if (isset($ref['amount']) && is_numeric($ref['amount'])) {
                    $amount = max(1, (int) $ref['amount']);
                }
            }

            if (null === $externalId || '' === $externalId) {
                continue;
            }

            if (!isset($counts[$externalId])) {
                $order[] = $externalId;
                $counts[$externalId] = 0;
            }

            $counts[$externalId] += $amount;
        }

        $ordered = [];
        foreach ($order as $externalId) {
            $ordered[$externalId] = $counts[$externalId];
        }

        return $ordered;
    }

    private function findRaceRelationByExternalId(string $externalId): ?object
    {
        foreach ([self::RACE_CLASS, self::RACE_CATEGORY_CLASS] as $className) {
            if (!class_exists($className)) {
                continue;
            }

            $result = $className::getByExternalId($externalId, 1);
            if (is_object($result) && is_a($result, $className)) {
                return $result;
            }

            if ($result instanceof DataObject\Listing) {
                $objects = $result->load();
                if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], $className)) {
                    return $objects[0];
                }
            }
        }

        return null;
    }

    private function findProfessionByExternalId(string $externalId, ?int $parentId = null): ?object
    {
        if (!is_callable([self::PROFESSION_CLASS, 'getByExternalId'])) {
            return null;
        }

        $result = (self::PROFESSION_CLASS)::getByExternalId($externalId, 1);
        if (is_object($result) && is_a($result, self::PROFESSION_CLASS)) {
            return $result;
        }

        if ($result instanceof DataObject\Listing) {
            $objects = $result->load();
            if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], self::PROFESSION_CLASS)) {
                return $objects[0];
            }
        }

        if (null !== $parentId) {
            $parent = DataObject::getById($parentId);
            if ($parent instanceof AbstractObject) {
                $key = DataObjectService::getValidKey($externalId, 'object');
                $fullPath = sprintf('%s/%s', rtrim((string) $parent->getFullPath(), '/'), $key);
                $byPath = DataObject::getByPath($fullPath);
                if (is_object($byPath) && is_a($byPath, self::PROFESSION_CLASS)) {
                    return $byPath;
                }
            }
        }

        return null;
    }

    private function findSkillByExternalId(string $externalId, AbstractObject $skillsParentFolder): ?object
    {
        if (!class_exists(self::SKILL_CLASS) || !is_callable([self::SKILL_CLASS, 'getByExternalId'])) {
            return null;
        }

        $result = (self::SKILL_CLASS)::getByExternalId($externalId, 1);
        if (is_object($result) && is_a($result, self::SKILL_CLASS)) {
            return $result;
        }

        if ($result instanceof DataObject\Listing) {
            $objects = $result->load();
            if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], self::SKILL_CLASS)) {
                return $objects[0];
            }
        }

        $key = DataObjectService::getValidKey($externalId, 'object');
        $fullPath = sprintf('%s/%s', rtrim((string) $skillsParentFolder->getFullPath(), '/'), $key);
        $byPath = DataObject::getByPath($fullPath);
        if (is_object($byPath) && is_a($byPath, self::SKILL_CLASS)) {
            return $byPath;
        }

        return null;
    }

    /**
     * Prefer a concrete {@see Skill}; otherwise a {@see SkillGroup} (matches professionSkills allowed classes).
     */
    private function findSkillOrSkillGroupByExternalId(
        string $externalId,
        AbstractObject $skillsParentFolder,
        AbstractObject $skillGroupsParentFolder
    ): ?object {
        $skill = $this->findSkillByExternalId($externalId, $skillsParentFolder);
        if (null !== $skill) {
            return $skill;
        }

        return $this->findSkillGroupByExternalId($externalId, $skillGroupsParentFolder);
    }

    private function findSkillGroupByExternalId(string $externalId, AbstractObject $skillGroupsParentFolder): ?object
    {
        if (!class_exists(self::SKILL_GROUP_CLASS) || !is_callable([self::SKILL_GROUP_CLASS, 'getByExternalId'])) {
            return null;
        }

        $result = (self::SKILL_GROUP_CLASS)::getByExternalId($externalId, 1);
        if (is_object($result) && is_a($result, self::SKILL_GROUP_CLASS)) {
            return $result;
        }

        if ($result instanceof DataObject\Listing) {
            $objects = $result->load();
            if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], self::SKILL_GROUP_CLASS)) {
                return $objects[0];
            }
        }

        $key = DataObjectService::getValidKey($externalId, 'object');
        $fullPath = sprintf('%s/%s', rtrim((string) $skillGroupsParentFolder->getFullPath(), '/'), $key);
        $byPath = DataObject::getByPath($fullPath);
        if (is_object($byPath) && is_a($byPath, self::SKILL_GROUP_CLASS)) {
            return $byPath;
        }

        return null;
    }

    private function resolveProfessionsParentFolder(string $ruleSet): AbstractObject
    {
        $path = sprintf('%s/%s/Professions', rtrim(self::LIBRARY_ROOT, '/'), DataObjectService::getValidKey($ruleSet, 'object'));

        return DataObjectService::createFolderByPath($path);
    }

    private function resolveSkillsParentFolder(string $ruleSet): AbstractObject
    {
        $path = sprintf('%s/%s/Skills', rtrim(self::LIBRARY_ROOT, '/'), DataObjectService::getValidKey($ruleSet, 'object'));

        return DataObjectService::createFolderByPath($path);
    }

    private function resolveSkillGroupsParentFolder(string $ruleSet): AbstractObject
    {
        $path = sprintf('%s/%s/SkillGroups', rtrim(self::LIBRARY_ROOT, '/'), DataObjectService::getValidKey($ruleSet, 'object'));

        return DataObjectService::createFolderByPath($path);
    }

    private function setIfExists(object $target, string $method, mixed $value): void
    {
        if (!method_exists($target, $method)) {
            return;
        }

        $target->{$method}($value);
    }
}
