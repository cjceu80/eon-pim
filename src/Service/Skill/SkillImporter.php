<?php

namespace App\Service\Skill;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\Data\StructuredTable;
use Pimcore\Model\DataObject\Fieldcollection;
use Pimcore\Model\DataObject\Fieldcollection\Data\TableItem;
use Pimcore\Model\DataObject\Service as DataObjectService;

final class SkillImporter
{
    private const SKILL_CLASS = \Pimcore\Model\DataObject\Skill::class;
    private const SKILL_GROUP_CLASS = \Pimcore\Model\DataObject\SkillGroup::class;
    private const RULE_TEMPLATE_CLASS = \Pimcore\Model\DataObject\RuleTemplate::class;
    private const ROLL_TABLE_TEMPLATE_CLASS = \Pimcore\Model\DataObject\RollTableTemplate::class;
    private const RULE_OVERRIDE_CLASS = \Pimcore\Model\DataObject\RuleOverride::class;
    private const ROLL_TABLE_OVERRIDE_CLASS = \Pimcore\Model\DataObject\RollTableOverride::class;
    private const LIBRARY_ROOT = '/Library';

    /**
     * @param array<string, mixed> $document
     * @return array{
     *   skillGroupsCreated:int,
     *   skillGroupsUpdated:int,
     *   skillsCreated:int,
     *   skillsUpdated:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * }
     */
    public function import(array $document, bool $dryRun = true): array
    {
        $stats = [
            'skillGroupsCreated' => 0,
            'skillGroupsUpdated' => 0,
            'skillsCreated' => 0,
            'skillsUpdated' => 0,
            'errors' => [],
            'warnings' => [],
        ];

        if (!class_exists(self::SKILL_CLASS) || !class_exists(self::SKILL_GROUP_CLASS)) {
            $stats['errors'][] = 'Required classes Skill and/or SkillGroup do not exist.';
            return $stats;
        }

        $ruleSet = trim((string) ($document['ruleSet'] ?? ''));
        if ('' === $ruleSet) {
            $stats['errors'][] = 'ruleSet is required.';
            return $stats;
        }

        $skillGroups = $document['skillGroups'] ?? [];

        $skills = $document['skills'] ?? [];
        if (!is_array($skills)) {
            $stats['errors'][] = 'skills must be an array.';
            return $stats;
        }

        $parentFolder = $this->resolveSkillsParentFolder($ruleSet);
        $groupParentFolder = $this->resolveSkillGroupsParentFolder($ruleSet);
        $defaultExample = $this->nullableString($document['example'] ?? null);

        if (is_array($skillGroups)) {
            foreach ($skillGroups as $index => $groupData) {
                if (!is_array($groupData)) {
                    continue;
                }

                try {
                    $this->upsertSkillGroup(
                        groupData: $groupData,
                        parentId: (int) $groupParentFolder->getId(),
                        dryRun: $dryRun,
                        stats: $stats,
                        path: sprintf('skillGroups[%d]', $index)
                    );
                } catch (\Throwable $exception) {
                    $stats['errors'][] = sprintf('skillGroups[%d] failed: %s', $index, $exception->getMessage());
                }
            }
        }

        /** @var array<string, array<int, object>> $groupSkillAssignments */
        $groupSkillAssignments = [];

        /** @var array<string, object> $skillInstancesByExternalId last upserted instance per externalId */
        $skillInstancesByExternalId = [];

        foreach ($skills as $index => $skillData) {
            if (!is_array($skillData)) {
                continue;
            }

            try {
                $skillObject = $this->upsertSkill(
                    skillData: $skillData,
                    parentId: (int) $parentFolder->getId(),
                    dryRun: $dryRun,
                    stats: $stats,
                    path: sprintf('skills[%d]', $index),
                    defaultExample: $defaultExample
                );

                $ownerEid = trim((string) ($skillData['externalId'] ?? ''));
                if ('' !== $ownerEid && is_object($skillObject) && is_a($skillObject, self::SKILL_CLASS)) {
                    $skillInstancesByExternalId[$ownerEid] = $skillObject;
                }

                $groupExternalId = $this->extractSkillGroupExternalId($skillData);
                if (null !== $groupExternalId && null !== $skillObject) {
                    $groupSkillAssignments[$groupExternalId][] = $skillObject;
                }
            } catch (\Throwable $exception) {
                $stats['errors'][] = sprintf('skills[%d] failed: %s', $index, $exception->getMessage());
            }
        }

        foreach ($groupSkillAssignments as $groupExternalId => $assignedSkills) {
            try {
                $group = $this->findSkillGroupByExternalId($groupExternalId);
                if (null === $group) {
                    $stats['warnings'][] = sprintf(
                        'groupExternalId "%s" was referenced by skills but no SkillGroup with that externalId exists.',
                        $groupExternalId
                    );
                    continue;
                }
                $this->assignSkillsToGroup($group, $assignedSkills, $dryRun);
            } catch (\Throwable $exception) {
                $stats['errors'][] = sprintf(
                    'Failed assigning skills to group "%s": %s',
                    $groupExternalId,
                    $exception->getMessage()
                );
            }
        }

        $this->applyRelatedSkillsFromDocument($skills, $dryRun, $stats, $skillInstancesByExternalId, $parentFolder);

        return $stats;
    }

    /**
     * @param array<int, mixed> $skills
     * @param array<string, object> $skillInstancesByExternalId
     * @param array{
     *   skillGroupsCreated:int,
     *   skillGroupsUpdated:int,
     *   skillsCreated:int,
     *   skillsUpdated:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * } $stats
     */
    private function applyRelatedSkillsFromDocument(
        array $skills,
        bool $dryRun,
        array &$stats,
        array $skillInstancesByExternalId,
        AbstractObject $skillsParentFolder
    ): void
    {
        $documentExternalIds = [];
        foreach ($skills as $skillData) {
            if (!is_array($skillData)) {
                continue;
            }
            $eid = trim((string) ($skillData['externalId'] ?? ''));
            if ('' !== $eid) {
                $documentExternalIds[$eid] = true;
            }
        }

        foreach ($skills as $index => $skillData) {
            if (!is_array($skillData) || !array_key_exists('relatedSkills', $skillData)) {
                continue;
            }

            $path = sprintf('skills[%d]', $index);
            if (!is_array($skillData['relatedSkills'])) {
                continue;
            }

            $ownerExternalId = trim((string) ($skillData['externalId'] ?? ''));
            if ('' === $ownerExternalId) {
                continue;
            }

            $resolved = [];
            $unresolved = [];

            foreach ($skillData['relatedSkills'] as $ref) {
                if (!is_string($ref) || '' === trim($ref)) {
                    continue;
                }
                $trimmedRef = trim($ref);
                if ($trimmedRef === $ownerExternalId) {
                    continue;
                }

                $related = $this->resolveSkillForRelatedLink(
                    $trimmedRef,
                    $skillInstancesByExternalId,
                    $skillsParentFolder
                );
                if (null !== $related) {
                    $resolved[(string) $related->getId()] = $related;
                } elseif ($dryRun && isset($documentExternalIds[$trimmedRef])) {
                    // Declared in the same file; will exist after a successful apply run.
                } else {
                    $unresolved[] = $trimmedRef;
                }
            }

            if ([] !== $unresolved) {
                $stats['warnings'][] = sprintf(
                    '%s.relatedSkills could not resolve: %s',
                    $path,
                    implode(', ', $unresolved)
                );
            }

            if ($dryRun || !method_exists(self::SKILL_CLASS, 'setRelatedSkills')) {
                continue;
            }

            $owner = $this->resolveSkillForRelatedLink(
                $ownerExternalId,
                $skillInstancesByExternalId,
                $skillsParentFolder
            );
            if (null === $owner) {
                $stats['warnings'][] = sprintf(
                    '%s.relatedSkills not persisted: owner skill "%s" not found in storage.',
                    $path,
                    $ownerExternalId
                );

                continue;
            }

            $this->setIfExists($owner, 'setRelatedSkills', array_values($resolved));
            try {
                $owner->save();
            } catch (\Throwable $exception) {
                $stats['errors'][] = sprintf('%s.relatedSkills save failed: %s', $path, $exception->getMessage());
            }
        }
    }

    /**
     * @param array<string, mixed> $groupData
     * @param array{
     *   skillGroupsCreated:int,
     *   skillGroupsUpdated:int,
     *   skillsCreated:int,
     *   skillsUpdated:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * } $stats
     */
    private function upsertSkillGroup(array $groupData, int $parentId, bool $dryRun, array &$stats, string $path): void
    {
        $externalId = trim((string) ($groupData['externalId'] ?? ''));
        $name = trim((string) ($groupData['name'] ?? ''));
        if ('' === $externalId || '' === $name) {
            throw new \InvalidArgumentException(sprintf('%s requires externalId and name.', $path));
        }

        $key = DataObjectService::getValidKey($externalId, 'object');
        $parent = DataObject::getById($parentId);
        $fullPath = sprintf('%s/%s', rtrim((string) ($parent?->getFullPath() ?? ''), '/'), $key);
        $existing = DataObject::getByPath($fullPath);
        $isCreate = null === $existing;

        $group = $existing ?? new (self::SKILL_GROUP_CLASS)();
        if (!is_object($group) || !is_a($group, self::SKILL_GROUP_CLASS)) {
            throw new \RuntimeException(sprintf('%s could not instantiate SkillGroup.', $path));
        }

        if ($isCreate) {
            $group->setParentId($parentId);
            $group->setKey($key);
            $group->setPublished(true);
        } elseif ((int) $group->getParentId() !== $parentId) {
            $group->setParentId($parentId);
        }

        // Persist to generated class fields.
        $this->setIfExists($group, 'setExternalId', $externalId);
        // Current SkillGroup class does not expose a name field; keep as property for readability.
        $group->setProperty('name', 'text', $name);
        $mapping = [
            'improvementByExperience' => 'setImproveByExperience',
            'improvementByTraining' => 'setImproveByTraining',
            'improvementByTutoring' => 'setImproveByTutoring',
            'improvementByStudy' => 'setImproveByStudy',
        ];
        foreach ($mapping as $yamlKey => $setter) {
            if (isset($groupData[$yamlKey]) && is_string($groupData[$yamlKey])) {
                $this->setIfExists($group, $setter, trim($groupData[$yamlKey]));
            }
        }

        if (!$dryRun) {
            $group->save();
        }

        if ($isCreate) {
            ++$stats['skillGroupsCreated'];
        } else {
            ++$stats['skillGroupsUpdated'];
        }
    }

    /**
     * @param array<string, mixed> $skillData
     * @param array{
     *   skillGroupsCreated:int,
     *   skillGroupsUpdated:int,
     *   skillsCreated:int,
     *   skillsUpdated:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * } $stats
     */
    private function upsertSkill(
        array $skillData,
        int $parentId,
        bool $dryRun,
        array &$stats,
        string $path,
        ?string $defaultExample = null
    ): ?object
    {
        $externalId = trim((string) ($skillData['externalId'] ?? ''));
        $name = trim((string) ($skillData['name'] ?? ''));
        if ('' === $externalId || '' === $name) {
            throw new \InvalidArgumentException(sprintf('%s requires externalId and name.', $path));
        }

        $existing = $this->findSkillByExternalId($externalId);
        if (null === $existing) {
            $key = DataObjectService::getValidKey($externalId, 'object');
            $parent = DataObject::getById($parentId);
            $fullPath = sprintf('%s/%s', rtrim((string) ($parent?->getFullPath() ?? ''), '/'), $key);
            $byPath = DataObject::getByPath($fullPath);
            if (is_object($byPath) && is_a($byPath, self::SKILL_CLASS)) {
                $existing = $byPath;
            }
        }

        $isCreate = null === $existing;
        $skill = $existing ?? new (self::SKILL_CLASS)();
        if (!is_object($skill) || !is_a($skill, self::SKILL_CLASS)) {
            throw new \RuntimeException(sprintf('%s could not instantiate Skill.', $path));
        }

        if ($isCreate) {
            $skill->setParentId($parentId);
            $skill->setKey(DataObjectService::getValidKey($externalId, 'object'));
            $skill->setPublished(true);
        } elseif ((int) $skill->getParentId() !== $parentId) {
            $skill->setParentId($parentId);
        }

        $this->setIfExists($skill, 'setExternalId', $externalId);
        $this->setIfExists($skill, 'setName', $name);
        $this->setIfExists($skill, 'setBase', $this->nullableString($skillData['base'] ?? null));
        $this->setIfExists($skill, 'setBase2', $this->nullableString($skillData['base2'] ?? null));
        $example = $this->nullableString($skillData['example'] ?? null) ?? $defaultExample;
        $this->setIfExists($skill, 'setExample', $example);

        $divider = $skillData['divider'] ?? null;
        if (is_int($divider) || is_float($divider)) {
            $this->setIfExists($skill, 'setDivider', (float) $divider);
        }

        if (isset($skillData['specializations'])) {
            if (is_array($skillData['specializations'])) {
                $specializations = array_values(array_filter(
                    array_map(static fn (mixed $v): string => is_string($v) ? trim($v) : '', $skillData['specializations']),
                    static fn (string $v): bool => '' !== $v
                ));
                $this->setIfExists($skill, 'setSpecializations', implode("\n", $specializations));
            } elseif (is_string($skillData['specializations'])) {
                $this->setIfExists($skill, 'setSpecializations', $skillData['specializations']);
            }
        }

        if (isset($skillData['rules']) && is_array($skillData['rules'])) {
            $resolvedRules = [];
            $unresolved = [];
            foreach ($skillData['rules'] as $ruleRef) {
                if (!is_string($ruleRef) || '' === trim($ruleRef)) {
                    continue;
                }
                $trimmedRef = trim($ruleRef);
                $resolvedRule = $this->findRuleRelationByExternalId($trimmedRef);
                if (null !== $resolvedRule) {
                    $resolvedRules[(string) $resolvedRule->getId()] = $resolvedRule;
                } else {
                    $unresolved[] = $trimmedRef;
                }
            }

            if ([] !== $resolvedRules) {
                if (method_exists($skill, 'setRules')) {
                    $this->setIfExists($skill, 'setRules', array_values($resolvedRules));
                } elseif (method_exists($skill, 'setRule')) {
                    // Backward compatibility if class still uses single relation.
                    $this->setIfExists($skill, 'setRule', reset($resolvedRules));
                }
            }

            if ([] !== $unresolved) {
                $stats['warnings'][] = sprintf(
                    '%s.rules could not resolve relation for: %s',
                    $path,
                    implode(', ', $unresolved)
                );
            }
        }

        $fieldCollection = $this->buildDescriptionFieldCollection($skillData);
        if (null !== $fieldCollection) {
            $this->setIfExists($skill, 'setDescription', $fieldCollection);
        }

        if (!$dryRun) {
            $skill->save();
        }

        if ($isCreate) {
            ++$stats['skillsCreated'];
        } else {
            ++$stats['skillsUpdated'];
        }

        return $skill;
    }

    /**
     * @param array<string, mixed> $skillData
     */
    private function buildDescriptionFieldCollection(array $skillData): ?Fieldcollection
    {
        $skillDescription = $this->nullableString($skillData['description'] ?? null);
        $tableBlocks = $this->normalizeSkillTableBlocks($skillData);

        if (null === $skillDescription && [] === $tableBlocks) {
            return null;
        }

        $collection = new Fieldcollection();

        if ([] === $tableBlocks) {
            $item = new TableItem();
            $item->setDescription($skillDescription);
            $collection->add($item);

            return $collection;
        }

        foreach ($tableBlocks as $index => $table) {
            if (!is_array($table)) {
                continue;
            }

            $item = new TableItem();
            if (0 === $index) {
                $item->setDescription($skillDescription);
            } else {
                $item->setDescription($this->nullableString($table['description'] ?? null));
            }

            $externalId = $this->nullableString($table['externalId'] ?? null);
            if (null !== $externalId) {
                $item->setExternalId($externalId);
            }

            $structured = $this->buildStructuredTableFromYaml($table);
            if (null !== $structured) {
                $item->setTable($structured);
            }

            $collection->add($item);
        }

        return $collection;
    }

    /**
     * Prefer `tables` when non-empty; otherwise legacy single `table`.
     *
     * @param array<string, mixed> $skillData
     * @return array<int, array<string, mixed>>
     */
    private function normalizeSkillTableBlocks(array $skillData): array
    {
        $tables = $skillData['tables'] ?? null;
        if (is_array($tables) && [] !== $tables) {
            $out = [];
            foreach ($tables as $t) {
                if (is_array($t)) {
                    $out[] = $t;
                }
            }

            return $out;
        }

        $table = $skillData['table'] ?? null;
        if (is_array($table)) {
            return [$table];
        }

        return [];
    }

    /**
     * @param array<string, mixed> $table
     */
    private function buildStructuredTableFromYaml(array $table): ?StructuredTable
    {
        $columns = $table['columns'] ?? null;
        $rows = $table['rows'] ?? null;
        if (!is_array($columns) || !is_array($rows) || [] === $columns) {
            return null;
        }

        $columnKeys = [];
        foreach ($columns as $column) {
            if (!is_array($column)) {
                continue;
            }
            $key = $column['key'] ?? null;
            if (is_string($key) && '' !== trim($key)) {
                $columnKeys[] = trim($key);
            }
        }

        if ([] === $columnKeys) {
            return null;
        }

        $data = [];
        foreach ($rows as $rowIndex => $row) {
            if (!is_array($row)) {
                continue;
            }

            $rowKey = sprintf('r%d', $rowIndex + 1);
            $data[$rowKey] = [];
            foreach ($columnKeys as $columnKey) {
                $value = $row[$columnKey] ?? '';
                if (is_scalar($value)) {
                    $data[$rowKey][$columnKey] = (string) $value;
                } else {
                    $data[$rowKey][$columnKey] = '';
                }
            }
        }

        if ([] === $data) {
            $data = ['' => ['' => '']];
        }

        // Safety for current tableItem schema where StructuredTable row/col keys may still be empty
        // placeholders; Pimcore persistence expects these keys to exist.
        if (!isset($data[''])) {
            $data[''] = [];
        }
        if (!array_key_exists('', $data[''])) {
            $data[''][''] = '';
        }

        return new StructuredTable($data);
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

    /**
     * Prefer the instance from the current import (index/cache may not see objects saved earlier in the same request).
     *
     * @param array<string, object> $skillInstancesByExternalId
     */
    private function resolveSkillForRelatedLink(
        string $externalId,
        array $skillInstancesByExternalId,
        AbstractObject $skillsParentFolder
    ): ?object {
        if (isset($skillInstancesByExternalId[$externalId])) {
            $candidate = $skillInstancesByExternalId[$externalId];
            if (is_object($candidate) && is_a($candidate, self::SKILL_CLASS)) {
                return $candidate;
            }
        }

        return $this->findSkillByExternalId($externalId, $skillsParentFolder);
    }

    private function findSkillByExternalId(string $externalId, ?AbstractObject $skillsParentFolder = null): ?object
    {
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

        if (null !== $skillsParentFolder) {
            $key = DataObjectService::getValidKey($externalId, 'object');
            $fullPath = sprintf('%s/%s', rtrim((string) $skillsParentFolder->getFullPath(), '/'), $key);
            $byPath = DataObject::getByPath($fullPath);
            if (is_object($byPath) && is_a($byPath, self::SKILL_CLASS)) {
                return $byPath;
            }
        }

        return null;
    }

    private function findSkillGroupByExternalId(string $externalId): ?object
    {
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

        return null;
    }

    /**
     * @param array<int, object> $assignedSkills
     */
    private function assignSkillsToGroup(object $group, array $assignedSkills, bool $dryRun): void
    {
        if (!method_exists($group, 'getSkills') || !method_exists($group, 'setSkills')) {
            return;
        }

        $current = $group->getSkills();
        $merged = [];

        foreach ($current as $skill) {
            if (is_object($skill) && method_exists($skill, 'getId')) {
                $merged[(string) $skill->getId()] = $skill;
            }
        }

        foreach ($assignedSkills as $skill) {
            if (is_object($skill) && method_exists($skill, 'getId')) {
                $merged[(string) $skill->getId()] = $skill;
            }
        }

        $group->setSkills(array_values($merged));
        if (!$dryRun) {
            $group->save();
        }
    }

    /**
     * @param array<string, mixed> $skillData
     */
    private function extractSkillGroupExternalId(array $skillData): ?string
    {
        foreach (['groupExternalId', 'skillGroupExternalId'] as $key) {
            $value = $skillData[$key] ?? null;
            if (is_string($value) && '' !== trim($value)) {
                return trim($value);
            }
        }

        return null;
    }

    private function findRuleRelationByExternalId(string $externalId): ?object
    {
        foreach ([self::RULE_TEMPLATE_CLASS, self::ROLL_TABLE_TEMPLATE_CLASS, self::RULE_OVERRIDE_CLASS, self::ROLL_TABLE_OVERRIDE_CLASS] as $className) {
            if (!class_exists($className) || !method_exists($className, 'getByExternalId')) {
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

    private function nullableString(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $trimmed = trim($value);
        return '' === $trimmed ? null : $trimmed;
    }

    private function setIfExists(object $target, string $method, mixed $value): void
    {
        if (!method_exists($target, $method)) {
            return;
        }

        $target->{$method}($value);
    }
}

