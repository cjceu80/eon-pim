<?php

namespace App\Service\RollTable;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\Service as DataObjectService;

final class RollTableImporter
{
    private const TEMPLATE_CLASS = '\\Pimcore\\Model\\DataObject\\RollTableTemplate';
    private const ENTRY_CLASS = '\\Pimcore\\Model\\DataObject\\RollTableEntryTemplate';
    private const RULESET_TEMPLATE_CLASS = '\\Pimcore\\Model\\DataObject\\RuleSetTemplate';
    /** @deprecated Old flat layout; kept for lookup fallback */
    private const LEGACY_ROLL_TABLES_ROOT = '/Templates/RollTables';
    /** @deprecated Old ruleset root; kept for lookup fallback */
    private const LEGACY_RULESET_ROOT_FOLDER = '/Templates/RuleSets';
    private const LIBRARY_ROOT = '/Library';
    private const UNSPECIFIED_RULESET = '_unspecified';

    /**
     * @param array<int, array<string, mixed>> $tables
     * @return array{
     *   tablesCreated:int,
     *   tablesUpdated:int,
     *   entriesCreated:int,
     *   entriesUpdated:int,
     *   inlineSubTablesCreated:int,
     *   errors:array<int, string>
     * }
     */
    public function import(array $tables, bool $dryRun = true): array
    {
        $stats = [
            'tablesCreated' => 0,
            'tablesUpdated' => 0,
            'entriesCreated' => 0,
            'entriesUpdated' => 0,
            'inlineSubTablesCreated' => 0,
            'errors' => [],
        ];

        if (!class_exists(self::TEMPLATE_CLASS) || !class_exists(self::ENTRY_CLASS)) {
            $stats['errors'][] = 'Required classes RollTableTemplate and/or RollTableEntryTemplate do not exist yet.';

            return $stats;
        }

        foreach ($tables as $index => $tableData) {
            try {
                $parentFolder = $this->resolveRollTablesParentFolder($tableData);
                $this->upsertTable(
                    tableData: $tableData,
                    parentId: (int) $parentFolder->getId(),
                    dryRun: $dryRun,
                    stats: $stats,
                    path: sprintf('tables[%d]', $index)
                );
            } catch (\Throwable $exception) {
                $stats['errors'][] = sprintf('tables[%d] failed: %s', $index, $exception->getMessage());
            }
        }

        return $stats;
    }

    /**
     * @param array<string, mixed> $tableData
     * @param array{
     *   tablesCreated:int,
     *   tablesUpdated:int,
     *   entriesCreated:int,
     *   entriesUpdated:int,
     *   inlineSubTablesCreated:int,
     *   errors:array<int, string>
     * } $stats
     */
    private function upsertTable(
        array $tableData,
        int $parentId,
        bool $dryRun,
        array &$stats,
        string $path
    ): ?object {
        $externalId = (string) ($tableData['slug'] ?? '');
        $name = (string) ($tableData['name'] ?? '');
        $diceNotation = (string) ($tableData['dice'] ?? '');
        if ('' === $externalId || '' === $name || '' === $diceNotation) {
            throw new \InvalidArgumentException(sprintf('%s requires slug, name and dice.', $path));
        }

        $existing = $this->findTemplateByExternalId($externalId);
        if (null === $existing) {
            $existing = $this->findTemplateByPath($externalId, $parentId);
        }
        $isCreate = null === $existing;

        $table = $existing ?? new (self::TEMPLATE_CLASS)();
        if (!is_object($table)) {
            throw new \RuntimeException(sprintf('%s could not instantiate template class.', $path));
        }

        if ($isCreate) {
            $table->setParentId($parentId);
            $table->setKey(DataObjectService::getValidKey($externalId, 'object'));
            $table->setPublished(true);
        } elseif ((int) $table->getParentId() !== $parentId) {
            $table->setParentId($parentId);
        }

        $this->setIfExists($table, 'setExternalId', $externalId);
        $this->setIfExists($table, 'setName', $name);
        $this->setIfExists($table, 'setDiceNotation', $diceNotation);
        $this->setIfExists($table, 'setDescription', $tableData['description'] ?? null);
        $this->setIfExists($table, 'setSource', $tableData['source'] ?? null);
        $this->setIfExists($table, 'setCopyrightNotice', $tableData['copyrightNotice'] ?? null);
        $rulesetCode = null;
        $ruleSetTemplate = null;
        if (isset($tableData['metadata']) && is_array($tableData['metadata'])) {
            $metadata = $tableData['metadata'];
            $ruleSetKey = $metadata['ruleSet'] ?? $metadata['ruleset'] ?? null;
            $rulesetCode = is_string($ruleSetKey) ? $ruleSetKey : null;
            $this->setIfExists($table, 'setRulesetCode', $rulesetCode);
            $ruleSetTemplate = $this->ensureRuleSetTemplateForImport($rulesetCode, $tableData);
        }
        $this->setRuleSetRelationIfSupported($table, $ruleSetTemplate);
        $this->setIfExists($table, 'setIsReadOnly', true);
        $this->setIfExists($table, 'setIsActive', true);

        if (!$dryRun) {
            $table->save();
        }

        if ($isCreate) {
            ++$stats['tablesCreated'];
        } else {
            ++$stats['tablesUpdated'];
        }

        $entries = $tableData['entries'] ?? [];
        if (!is_array($entries)) {
            return $table;
        }

        foreach ($entries as $entryIndex => $entryData) {
            if (!is_array($entryData)) {
                continue;
            }

            $this->upsertEntry(
                table: $table,
                entryData: $entryData,
                entryIndex: $entryIndex,
                dryRun: $dryRun,
                stats: $stats,
                path: sprintf('%s.entries[%d]', $path, $entryIndex)
            );
        }

        return $table;
    }

    /**
     * @param array<string, mixed> $entryData
     * @param array{
     *   tablesCreated:int,
     *   tablesUpdated:int,
     *   entriesCreated:int,
     *   entriesUpdated:int,
     *   inlineSubTablesCreated:int,
     *   errors:array<int, string>
     * } $stats
     */
    private function upsertEntry(
        object $table,
        array $entryData,
        int $entryIndex,
        bool $dryRun,
        array &$stats,
        string $path
    ): void {
        $min = (int) ($entryData['minValue'] ?? 0);
        $rawMax = $entryData['maxValue'] ?? null;
        $max = is_int($rawMax) ? $rawMax : null;
        $value = $entryData['value'] ?? null;
        $valueText = is_scalar($value) ? (string) $value : '';
        $entryKey = DataObjectService::getValidKey(
            sprintf('%03d-%03d-%s', $entryIndex + 1, $min, null === $max ? 'plus' : (string) $max),
            'object'
        );

        $parentPath = rtrim((string) $table->getFullPath(), '/');
        $entryPath = sprintf('%s/%s', $parentPath, $entryKey);
        $existing = DataObject::getByPath($entryPath);
        $isCreate = null === $existing;

        $entry = $existing ?? new (self::ENTRY_CLASS)();
        if (!is_object($entry)) {
            throw new \RuntimeException(sprintf('%s could not instantiate entry class.', $path));
        }

        if ($isCreate) {
            $entry->setParentId((int) $table->getId());
            $entry->setKey($entryKey);
            $entry->setPublished(true);
        }

        $this->setIfExists($entry, 'setRollTable', $table);
        $this->setIfExists($entry, 'setMinValue', $min);
        $this->setIfExists($entry, 'setMaxValue', $max);
        $this->setIfExists($entry, 'setValueText', $valueText);
        if (is_int($value) || is_float($value)) {
            $this->setIfExists($entry, 'setValueNumber', (float) $value);
        }
        $this->setIfExists($entry, 'setDescription', $entryData['description'] ?? null);
        $this->setIfExists($entry, 'setSortOrder', $entryIndex + 1);

        $subTable = $entryData['subTable'] ?? null;
        if (is_array($subTable)) {
            $subType = $subTable['type'] ?? null;
            if ('inline' === $subType) {
                $inlineSlug = sprintf(
                    '%s-inline-%03d-%s',
                    (string) $table->getKey(),
                    $min,
                    null === $max ? 'plus' : (string) $max
                );
                $inlineName = sprintf(
                    '%s (inline %d-%s)',
                    (string) $table->getKey(),
                    $min,
                    null === $max ? 'plus' : (string) $max
                );
                $inlineData = [
                    'slug' => $inlineSlug,
                    'name' => $inlineName,
                    'dice' => $subTable['dice'] ?? '1D100',
                    'description' => sprintf('Inline subtable from %s', $table->getKey()),
                    'entries' => $subTable['entries'] ?? [],
                ];
                $inlineObject = $this->upsertTable(
                    tableData: $inlineData,
                    parentId: (int) $table->getParentId(),
                    dryRun: $dryRun,
                    stats: $stats,
                    path: sprintf('%s.subTable', $path)
                );
                $this->setIfExists($entry, 'setSubTableMode', 'inline');
                $this->setIfExists($entry, 'setInlineSubTableRef', $inlineObject);
                ++$stats['inlineSubTablesCreated'];
            } elseif ('ref' === $subType) {
                $refExternalId = $subTable['tableExternalId'] ?? null;
                $refTable = is_string($refExternalId) ? $this->findTemplateByExternalId($refExternalId) : null;
                $this->setIfExists($entry, 'setSubTableMode', 'ref');
                $this->setIfExists($entry, 'setSubTableRef', $refTable);
            } else {
                $this->setIfExists($entry, 'setSubTableMode', 'none');
            }
        } else {
            $this->setIfExists($entry, 'setSubTableMode', 'none');
        }

        $effect = $entryData['effect'] ?? null;
        if (is_array($effect)) {
            $this->setIfExists($entry, 'setEffectHandlerId', $effect['handlerId'] ?? null);
            $this->setIfExists($entry, 'setEffectType', $effect['type'] ?? null);
            $this->setIfExists($entry, 'setEffectLabel', $effect['label'] ?? null);
            $this->setIfExists($entry, 'setEffectPayloadJson', json_encode($effect['details'] ?? [], JSON_THROW_ON_ERROR));
        }

        if (!$dryRun) {
            $entry->save();
        }

        if ($isCreate) {
            ++$stats['entriesCreated'];
        } else {
            ++$stats['entriesUpdated'];
        }
    }

    private function findTemplateByExternalId(string $externalId): ?object
    {
        $result = (self::TEMPLATE_CLASS)::getByExternalId($externalId, 1);
        if (is_object($result) && is_a($result, self::TEMPLATE_CLASS)) {
            return $result;
        }

        if ($result instanceof DataObject\Listing) {
            $objects = $result->load();
            if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], self::TEMPLATE_CLASS)) {
                return $objects[0];
            }
        }

        return null;
    }

    private function findTemplateByPath(string $externalId, int $parentId): ?object
    {
        $parent = DataObject::getById($parentId);
        if (!$parent instanceof AbstractObject) {
            return null;
        }

        $key = DataObjectService::getValidKey($externalId, 'object');
        $path = rtrim((string) $parent->getFullPath(), '/');
        $fullPath = sprintf('%s/%s', $path, $key);
        $byPath = DataObject::getByPath($fullPath);
        if (!is_object($byPath)) {
            // Legacy flat layout: /Templates/RollTables/<key>
            $legacyRoot = DataObjectService::createFolderByPath(self::LEGACY_ROLL_TABLES_ROOT);
            $legacyParentId = (int) $legacyRoot->getId();
            if ($legacyParentId !== $parentId) {
                return $this->findTemplateByPath($externalId, $legacyParentId);
            }

            return null;
        }

        return $byPath instanceof (self::TEMPLATE_CLASS) ? $byPath : null;
    }

    /**
     * @param array<string, mixed> $tableData
     */
    private function resolveRollTablesParentFolder(array $tableData): AbstractObject
    {
        $metadata = $tableData['metadata'] ?? [];
        $ruleSetKey = null;
        if (is_array($metadata)) {
            $ruleSetKey = $metadata['ruleSet'] ?? $metadata['ruleset'] ?? null;
        }
        $slug = is_string($ruleSetKey) ? trim($ruleSetKey) : '';
        if ('' === $slug) {
            $slug = self::UNSPECIFIED_RULESET;
        }

        $path = sprintf('%s/%s/RollTables', rtrim(self::LIBRARY_ROOT, '/'), DataObjectService::getValidKey($slug, 'object'));

        return DataObjectService::createFolderByPath($path);
    }

    /**
     * @param array<string, mixed> $tableData
     */
    private function ensureRuleSetTemplateForImport(?string $rulesetExternalId, array $tableData): ?object
    {
        if (null === $rulesetExternalId || '' === trim($rulesetExternalId)) {
            return null;
        }

        $existing = $this->findRuleSetTemplateByExternalId($rulesetExternalId);
        if (null !== $existing) {
            $targetFolder = $this->resolveRuleSetTemplateParentFolder($rulesetExternalId);
            if ((int) $existing->getParentId() !== (int) $targetFolder->getId()) {
                $existing->setParentId((int) $targetFolder->getId());
                if (!$dryRun) {
                    $existing->save();
                }
            }

            return $existing;
        }

        if (!class_exists(self::RULESET_TEMPLATE_CLASS)) {
            return null;
        }

        $key = DataObjectService::getValidKey($rulesetExternalId, 'object');
        $legacyPath = sprintf('%s/%s', rtrim(self::LEGACY_RULESET_ROOT_FOLDER, '/'), $key);
        $legacyObject = DataObject::getByPath($legacyPath);
        if ($legacyObject instanceof (self::RULESET_TEMPLATE_CLASS)) {
            $targetFolder = $this->resolveRuleSetTemplateParentFolder($rulesetExternalId);
            $legacyObject->setParentId((int) $targetFolder->getId());
            if (!$dryRun) {
                $legacyObject->save();
            }

            return $legacyObject;
        }

        $folder = $this->resolveRuleSetTemplateParentFolder($rulesetExternalId);
        $object = new (self::RULESET_TEMPLATE_CLASS)();
        if (!is_object($object)) {
            return null;
        }

        $key = DataObjectService::getValidKey($rulesetExternalId, 'object');
        $this->setIfExists($object, 'setParentId', $folder->getId());
        $this->setIfExists($object, 'setKey', $key);
        $this->setIfExists($object, 'setPublished', true);
        $this->setIfExists($object, 'setExternalId', $rulesetExternalId);
        $this->setIfExists($object, 'setName', (string) ($tableData['source'] ?? $rulesetExternalId));
        $this->setIfExists($object, 'setSource', (string) ($tableData['source'] ?? 'roll-table-import'));
        if (isset($tableData['metadata']) && is_array($tableData['metadata'])) {
            $metadata = $tableData['metadata'];
            $versionKey = $metadata['ruleSetVersion'] ?? $metadata['rulesetVersion'] ?? null;
            $this->setIfExists($object, 'setVersion', is_string($versionKey) ? $versionKey : null);
        }
        $this->setIfExists($object, 'setIsReadOnly', true);
        $object->save();

        return $object;
    }

    private function setRuleSetRelationIfSupported(object $table, ?object $ruleSetTemplate): void
    {
        $relationSetters = [
            'setRuleSetTemplate',
            'setRuleSetTemplateRef',
            'setRulesetTemplateRef',
            'setRuleSetRef',
            'setRulesetRef',
        ];

        $hasRelationSetter = false;
        foreach ($relationSetters as $setter) {
            if (method_exists($table, $setter)) {
                $hasRelationSetter = true;
                break;
            }
        }

        if (!$hasRelationSetter) {
            return;
        }
        foreach ($relationSetters as $setter) {
            $this->setIfExists($table, $setter, $ruleSetTemplate);
        }
    }

    private function findRuleSetTemplateByExternalId(?string $externalId): ?object
    {
        if (null === $externalId || '' === trim($externalId)) {
            return null;
        }

        if (!class_exists(self::RULESET_TEMPLATE_CLASS)) {
            return null;
        }

        $result = (self::RULESET_TEMPLATE_CLASS)::getByExternalId($externalId, 1);
        if (is_object($result) && is_a($result, self::RULESET_TEMPLATE_CLASS)) {
            return $result;
        }

        if ($result instanceof DataObject\Listing) {
            $objects = $result->load();
            if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], self::RULESET_TEMPLATE_CLASS)) {
                return $objects[0];
            }
        }

        $key = DataObjectService::getValidKey($externalId, 'object');
        $preferredPath = sprintf('%s/%s/RuleSets/%s', rtrim(self::LIBRARY_ROOT, '/'), $key, $key);
        $byPath = DataObject::getByPath($preferredPath);
        if (is_object($byPath) && is_a($byPath, self::RULESET_TEMPLATE_CLASS)) {
            return $byPath;
        }

        $legacyPath = sprintf('%s/%s', rtrim(self::LEGACY_RULESET_ROOT_FOLDER, '/'), $key);
        $legacyByPath = DataObject::getByPath($legacyPath);
        if (is_object($legacyByPath) && is_a($legacyByPath, self::RULESET_TEMPLATE_CLASS)) {
            return $legacyByPath;
        }

        return null;
    }

    private function resolveRuleSetTemplateParentFolder(string $rulesetExternalId): AbstractObject
    {
        $slug = trim($rulesetExternalId);
        if ('' === $slug) {
            $slug = self::UNSPECIFIED_RULESET;
        }

        $key = DataObjectService::getValidKey($slug, 'object');
        $path = sprintf('%s/%s/RuleSets', rtrim(self::LIBRARY_ROOT, '/'), $key);

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
