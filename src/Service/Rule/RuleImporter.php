<?php

namespace App\Service\Rule;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\Service as DataObjectService;

final class RuleImporter
{
    private const RULE_CLASS = \Pimcore\Model\DataObject\RuleTemplate::class;
    private const RULESET_CLASS = \Pimcore\Model\DataObject\RuleSetTemplate::class;
    private const LIBRARY_ROOT = '/Library';
    /** @deprecated Pre-library layout */
    private const LEGACY_RULESET_ROOT = '/Templates/RuleSets';
    /** @deprecated Pre-library layout */
    private const LEGACY_RULES_ROOT = '/Templates/Rules';

    /**
     * @param array<int, array<string, mixed>> $rules
     * @return array{rulesCreated:int, rulesUpdated:int, errors:array<int, string>}
     */
    public function import(array $rules, bool $dryRun = true): array
    {
        $stats = [
            'rulesCreated' => 0,
            'rulesUpdated' => 0,
            'errors' => [],
        ];

        if (!class_exists(self::RULE_CLASS) || !class_exists(self::RULESET_CLASS)) {
            $stats['errors'][] = 'Required classes RuleTemplate and/or RuleSetTemplate do not exist yet.';

            return $stats;
        }

        foreach ($rules as $index => $ruleData) {
            try {
                $this->upsertRule(
                    ruleData: $ruleData,
                    dryRun: $dryRun,
                    stats: $stats,
                    path: sprintf('rules[%d]', $index)
                );
            } catch (\Throwable $exception) {
                $stats['errors'][] = sprintf('rules[%d] failed: %s', $index, $exception->getMessage());
            }
        }

        return $stats;
    }

    /**
     * @param array<string, mixed> $ruleData
     * @param array{rulesCreated:int, rulesUpdated:int, errors:array<int, string>} $stats
     */
    private function upsertRule(
        array $ruleData,
        bool $dryRun,
        array &$stats,
        string $path
    ): void {
        $ruleSetExternalId = trim((string) ($ruleData['ruleSet'] ?? ''));
        $externalId = trim((string) ($ruleData['externalId'] ?? ''));
        $name = trim((string) ($ruleData['name'] ?? ''));

        if ('' === $ruleSetExternalId || '' === $externalId || '' === $name) {
            throw new \InvalidArgumentException(sprintf('%s requires ruleSet, externalId, and name.', $path));
        }

        $ruleSetTemplate = $this->findOrCreateRuleSetTemplate($ruleSetExternalId, $dryRun);
        if (null === $ruleSetTemplate) {
            throw new \RuntimeException(sprintf('%s could not resolve RuleSetTemplate for ruleSet "%s".', $path, $ruleSetExternalId));
        }

        $rulesFolder = $this->resolveRulesFolder($ruleSetExternalId);

        $objectKey = DataObjectService::getValidKey($externalId, 'object');
        $folderPath = rtrim((string) $rulesFolder->getFullPath(), '/');
        $fullPath = sprintf('%s/%s', $folderPath, $objectKey);

        $existing = $this->findRuleByExternalId($externalId);
        if (null === $existing) {
            $byPath = DataObject::getByPath($fullPath);
            if (is_object($byPath) && is_a($byPath, self::RULE_CLASS)) {
                $existing = $byPath;
            }
        }

        if (null === $existing) {
            $legacyRulesFolder = DataObjectService::createFolderByPath(self::LEGACY_RULES_ROOT);
            $legacyPath = sprintf(
                '%s/%s/%s',
                rtrim((string) $legacyRulesFolder->getFullPath(), '/'),
                DataObjectService::getValidKey($ruleSetExternalId, 'object'),
                $objectKey
            );
            $legacyByPath = DataObject::getByPath($legacyPath);
            if (is_object($legacyByPath) && is_a($legacyByPath, self::RULE_CLASS)) {
                $existing = $legacyByPath;
            }
        }

        $isCreate = null === $existing;
        $rule = $existing ?? new (self::RULE_CLASS)();
        if (!is_object($rule) || !is_a($rule, self::RULE_CLASS)) {
            throw new \RuntimeException(sprintf('%s could not instantiate rule class.', $path));
        }

        if ($isCreate) {
            $rule->setParentId((int) $rulesFolder->getId());
            $rule->setKey($objectKey);
            $rule->setPublished(true);
        } elseif ((int) $rule->getParentId() !== (int) $rulesFolder->getId()) {
            $rule->setParentId((int) $rulesFolder->getId());
        }

        $payload = $ruleData['valueJson'] ?? $ruleData['data'] ?? null;
        if (!is_array($payload)) {
            throw new \InvalidArgumentException(sprintf('%s is missing valueJson/data object.', $path));
        }

        $this->setIfExists($rule, 'setExternalId', $externalId);
        $this->setIfExists($rule, 'setName', $name);
        $this->setIfExists($rule, 'setRuleSetTemplate', $ruleSetTemplate);
        $this->setIfExists(
            $rule,
            'setValueJson',
            json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
        );

        if (isset($ruleData['description']) && is_string($ruleData['description'])) {
            $this->setIfExists($rule, 'setDescription', $ruleData['description']);
        }

        if (isset($ruleData['sortOrder']) && is_int($ruleData['sortOrder'])) {
            $this->setIfExists($rule, 'setSortOrder', $ruleData['sortOrder']);
        }

        $ruleType = $this->resolveRuleType($ruleData);
        if (is_string($ruleType) && '' !== trim($ruleType)) {
            $this->setIfExists($rule, 'setRuleType', $ruleType);
        }

        $this->setIfExists($rule, 'setIsReadOnly', true);

        if (!$dryRun) {
            $rule->save();
        }

        if ($isCreate) {
            ++$stats['rulesCreated'];
        } else {
            ++$stats['rulesUpdated'];
        }
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
        $this->setIfExists($object, 'setSource', 'rule-import');
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

    private function findRuleByExternalId(string $externalId): ?object
    {
        $result = (self::RULE_CLASS)::getByExternalId($externalId, 1);
        if (is_object($result) && is_a($result, self::RULE_CLASS)) {
            return $result;
        }

        if ($result instanceof DataObject\Listing) {
            $objects = $result->load();
            if (isset($objects[0]) && is_object($objects[0]) && is_a($objects[0], self::RULE_CLASS)) {
                return $objects[0];
            }
        }

        return null;
    }

    private function resolveRulesFolder(string $ruleSetExternalId): AbstractObject
    {
        $key = DataObjectService::getValidKey(trim($ruleSetExternalId), 'object');
        $path = sprintf('%s/%s/Rules', rtrim(self::LIBRARY_ROOT, '/'), $key);

        return DataObjectService::createFolderByPath($path);
    }

    private function resolveRuleSetParentFolder(string $ruleSetExternalId): AbstractObject
    {
        $key = DataObjectService::getValidKey(trim($ruleSetExternalId), 'object');
        $path = sprintf('%s/%s/RuleSets', rtrim(self::LIBRARY_ROOT, '/'), $key);

        return DataObjectService::createFolderByPath($path);
    }

    /**
     * @param array<string, mixed> $ruleData
     */
    private function resolveRuleType(array $ruleData): ?string
    {
        $candidates = [
            $ruleData['ruleType'] ?? null,
            $ruleData['ruleKind'] ?? null,
            $ruleData['kind'] ?? null,
        ];

        foreach ($candidates as $candidate) {
            if (is_string($candidate) && '' !== trim($candidate)) {
                return $candidate;
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
