<?php

namespace App\Service\Rule;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\Service as DataObjectService;

final class RuleSetTemplateInitializer
{
    private const RULESET_CLASS = \Pimcore\Model\DataObject\RuleSetTemplate::class;
    private const ROLL_TABLE_CLASS = \Pimcore\Model\DataObject\RollTableTemplate::class;
    private const LIBRARY_ROOT = '/Library';
    private const LEGACY_RULESET_ROOT = '/Templates/RuleSets';

    /**
     * @param array<string, mixed> $calendarPatch keys: calendarType, monthsPerYear, daysPerMonth, daysPerWeek, weeksPerMonth
     *
     * @return array{created:bool,path:string}
     */
    public function initialize(
        string $externalId,
        ?string $name,
        ?string $source,
        ?string $version,
        array $baseline = [],
        array $calendarPatch = [],
        bool $dryRun = false
    ): array
    {
        $externalId = trim($externalId);
        if ('' === $externalId) {
            throw new \InvalidArgumentException('ruleset externalId must be a non-empty string.');
        }

        if (!class_exists(self::RULESET_CLASS)) {
            throw new \RuntimeException('Required class RuleSetTemplate does not exist yet.');
        }

        $targetFolder = $this->resolveRuleSetParentFolder($externalId);
        $existing = $this->findRuleSetTemplateByExternalId($externalId);
        $created = false;

        $object = $existing;
        if (null === $object) {
            $object = new (self::RULESET_CLASS)();
            if (!is_object($object) || !is_a($object, self::RULESET_CLASS)) {
                throw new \RuntimeException('Could not instantiate RuleSetTemplate.');
            }
            $created = true;
            $this->setIfExists($object, 'setKey', DataObjectService::getValidKey($externalId, 'object'));
            $this->setIfExists($object, 'setPublished', true);
            $this->setIfExists($object, 'setIsReadOnly', true);
        }

        $this->setIfExists($object, 'setParentId', (int) $targetFolder->getId());
        $this->setIfExists($object, 'setExternalId', $externalId);
        $this->setIfExists($object, 'setName', null !== $name && '' !== trim($name) ? trim($name) : $externalId);

        if (null !== $source) {
            $this->setIfExists($object, 'setSource', '' !== trim($source) ? trim($source) : null);
        }
        if (null !== $version) {
            $this->setIfExists($object, 'setVersion', '' !== trim($version) ? trim($version) : null);
        }
        $this->applyRaceBaseline($object, $baseline);
        $this->applyCalendarPatch($object, $calendarPatch);

        if (!$dryRun) {
            $object->save();
        }

        return [
            'created' => $created,
            'path' => sprintf('%s/%s', rtrim((string) $targetFolder->getFullPath(), '/'), DataObjectService::getValidKey($externalId, 'object')),
        ];
    }

    /**
     * Upsert RuleSetTemplate from a `ruleSetTemplate` block inside a combined import file.
     *
     * @param array<string, mixed> $block
     *
     * @return array{created:bool,path:string}
     */
    public function applyRuleSetTemplateBlock(array $block, bool $dryRun): array
    {
        $externalId = trim((string) ($block['externalId'] ?? ''));
        if ('' === $externalId) {
            throw new \InvalidArgumentException('ruleSetTemplate.externalId is required.');
        }

        $name = isset($block['name']) && is_string($block['name']) ? trim($block['name']) : null;
        if ('' === ($name ?? '')) {
            $name = null;
        }

        $source = isset($block['source']) && is_string($block['source']) ? trim($block['source']) : null;
        if ('' === ($source ?? '')) {
            $source = null;
        }

        $version = isset($block['version']) && is_string($block['version']) ? trim($block['version']) : null;
        if ('' === ($version ?? '')) {
            $version = null;
        }

        $baseline = self::extractRaceBaselineValues($block);
        $calendarPatch = self::extractCalendarPatch($block);

        return $this->initialize($externalId, $name, $source, $version, $baseline, $calendarPatch, $dryRun);
    }

    /**
     * @param array<string, mixed> $document root object or `ruleSetTemplate` subtree
     *
     * @return array<string, mixed>
     */
    public static function extractRaceBaselineValues(array $document): array
    {
        $allowed = [
            'raceBaselineExhaustionColumnDivisor',
            'raceBaselineBackgroundRolls',
            'raceBaselineMovementModification',
            'raceBaselineMovementFormula',
            'raceBaselineNumberOfLitters',
            'raceBaselineLitterSize',
            'raceBaselineOlderSiblingAgeFormula',
            'raceBaselineYoungerSiblingAgeFormula',
            'raceBaselineGenderFormula',
            'raceBaselineParentAgeFormula',
            'raceBaselineParentStatusFormula',
            'raceBaselineParentStatusTableRef',
        ];

        $baseline = [];
        $nested = $document['raceBaseline'] ?? null;
        if (is_array($nested)) {
            foreach ($allowed as $key) {
                if (array_key_exists($key, $nested)) {
                    $baseline[$key] = $nested[$key];
                }
            }
        }

        foreach ($allowed as $key) {
            if (array_key_exists($key, $document)) {
                $baseline[$key] = $document[$key];
            }
        }

        return $baseline;
    }

    /**
     * @param array<string, mixed> $source
     *
     * @return array<string, mixed>
     */
    public static function extractCalendarPatch(array $source): array
    {
        $patch = [];
        if (isset($source['calendarType']) && is_string($source['calendarType']) && '' !== trim($source['calendarType'])) {
            $patch['calendarType'] = trim($source['calendarType']);
        }

        foreach (['monthsPerYear', 'daysPerMonth', 'daysPerWeek', 'weeksPerMonth'] as $key) {
            if (!array_key_exists($key, $source)) {
                continue;
            }
            $value = $source[$key];
            if (null === $value || is_int($value)) {
                $patch[$key] = $value;
            }
        }

        return $patch;
    }

    /**
     * @param array<string, mixed> $baseline
     */
    private function applyRaceBaseline(object $ruleSetTemplate, array $baseline): void
    {
        if (array_key_exists('raceBaselineMovementFormula', $baseline)
            && !array_key_exists('raceBaselineMovementModification', $baseline)) {
            $legacy = $baseline['raceBaselineMovementFormula'];
            if (is_int($legacy)) {
                $baseline['raceBaselineMovementModification'] = $legacy;
            } elseif (is_string($legacy) && is_numeric(trim($legacy))) {
                $baseline['raceBaselineMovementModification'] = (int) $legacy;
            }
        }

        $intFields = [
            'raceBaselineExhaustionColumnDivisor' => 'setRaceBaselineExhaustionColumnDivisor',
            'raceBaselineMovementModification' => 'setRaceBaselineMovementModification',
        ];
        foreach ($intFields as $key => $setter) {
            if (!array_key_exists($key, $baseline)) {
                continue;
            }
            $value = $baseline[$key];
            if (null === $value || is_int($value)) {
                $this->setIfExists($ruleSetTemplate, $setter, $value);
            }
        }

        $floatFields = [
            'raceBaselineBackgroundRolls' => 'setRaceBaselineBackgroundRolls',
        ];
        foreach ($floatFields as $key => $setter) {
            if (!array_key_exists($key, $baseline)) {
                continue;
            }
            $value = $baseline[$key];
            if (null === $value || is_float($value) || is_int($value)) {
                $this->setIfExists($ruleSetTemplate, $setter, null === $value ? null : (float) $value);
            }
        }

        $stringFields = [
            'raceBaselineNumberOfLitters' => 'setRaceBaselineNumberOfLitters',
            'raceBaselineLitterSize' => 'setRaceBaselineLitterSize',
            'raceBaselineOlderSiblingAgeFormula' => 'setRaceBaselineOlderSiblingAgeFormula',
            'raceBaselineYoungerSiblingAgeFormula' => 'setRaceBaselineYoungerSiblingAgeFormula',
            'raceBaselineGenderFormula' => 'setRaceBaselineGenderFormula',
            'raceBaselineParentAgeFormula' => 'setRaceBaselineParentAgeFormula',
            'raceBaselineParentStatusFormula' => 'setRaceBaselineParentStatusFormula',
            'raceBaselineParentStatusTableRef' => 'setRaceBaselineParentStatusTableRef',
        ];
        foreach ($stringFields as $key => $setter) {
            if (!array_key_exists($key, $baseline)) {
                continue;
            }
            $value = $baseline[$key];
            if (null === $value || is_string($value)) {
                $this->setIfExists($ruleSetTemplate, $setter, is_string($value) ? trim($value) : null);
            }
        }

        if (!empty($baseline['raceBaselineParentStatusTableRef']) && is_string($baseline['raceBaselineParentStatusTableRef'])) {
            $resolved = $this->findRollTableTemplateByExternalId($baseline['raceBaselineParentStatusTableRef']);
            if (null !== $resolved) {
                $this->setIfExists($ruleSetTemplate, 'setRaceBaselineParentStatusTable', $resolved);
            }
        }
    }

    /**
     * @param array<string, mixed> $calendarPatch
     */
    private function applyCalendarPatch(object $ruleSetTemplate, array $calendarPatch): void
    {
        if ([] === $calendarPatch) {
            return;
        }

        $map = [
            'calendarType' => 'setCalendarType',
            'monthsPerYear' => 'setMonthsPerYear',
            'daysPerMonth' => 'setDaysPerMonth',
            'daysPerWeek' => 'setDaysPerWeek',
            'weeksPerMonth' => 'setWeeksPerMonth',
        ];

        foreach ($map as $field => $setter) {
            if (!array_key_exists($field, $calendarPatch)) {
                continue;
            }
            $value = $calendarPatch[$field];
            if ('calendarType' === $field) {
                if (is_string($value) && '' !== trim($value)) {
                    $this->setIfExists($ruleSetTemplate, $setter, trim($value));
                }

                continue;
            }

            if (null === $value || is_int($value)) {
                $this->setIfExists($ruleSetTemplate, $setter, $value);
            }
        }
    }

    private function resolveRuleSetParentFolder(string $ruleSetExternalId): AbstractObject
    {
        $key = DataObjectService::getValidKey(trim($ruleSetExternalId), 'object');
        $path = sprintf('%s/%s/RuleSets', rtrim(self::LIBRARY_ROOT, '/'), $key);

        return DataObjectService::createFolderByPath($path);
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

    public function resolvePendingTableRefs(?string $ruleSetExternalId = null, bool $dryRun = false): array
    {
        if (!class_exists(self::RULESET_CLASS) || !method_exists(self::RULESET_CLASS, 'getList')) {
            return ['resolved' => 0, 'missing' => 0];
        }

        $resolved = 0;
        $missing = 0;
        $list = (self::RULESET_CLASS)::getList();
        if (is_string($ruleSetExternalId) && '' !== trim($ruleSetExternalId) && method_exists($list, 'setCondition')) {
            $list->setCondition('externalId = ?', [trim($ruleSetExternalId)]);
        }

        $items = method_exists($list, 'load') ? $list->load() : [];
        foreach ($items as $item) {
            if (!is_object($item) || !method_exists($item, 'getRaceBaselineParentStatusTableRef')) {
                continue;
            }
            $ref = $item->getRaceBaselineParentStatusTableRef();
            if (!is_string($ref) || '' === trim($ref)) {
                continue;
            }

            $table = $this->findRollTableTemplateByExternalId($ref);
            if (null === $table) {
                ++$missing;
                continue;
            }

            if (method_exists($item, 'setRaceBaselineParentStatusTable')) {
                $item->setRaceBaselineParentStatusTable($table);
                if (!$dryRun) {
                    $item->save();
                }
                ++$resolved;
            }
        }

        return ['resolved' => $resolved, 'missing' => $missing];
    }

    private function findRollTableTemplateByExternalId(string $externalId): ?object
    {
        if (!class_exists(self::ROLL_TABLE_CLASS)) {
            return null;
        }
        $externalId = trim($externalId);
        if ('' === $externalId) {
            return null;
        }

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

