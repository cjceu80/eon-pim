<?php

namespace App\Service\Rule;

use Symfony\Component\Yaml\Yaml;

final class RuleImportAnalyzer
{
    /**
     * @return array{
     *   rules:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * }
     */
    public function analyze(string $content): array
    {
        $rules = $this->decodeTopLevelRules($content);
        if (null === $rules) {
            return [
                'rules' => 0,
                'errors' => ['Import file must decode to a JSON or YAML object/array.'],
                'warnings' => [],
            ];
        }

        $stats = [
            'rules' => 0,
            'errors' => [],
            'warnings' => [],
        ];

        foreach ($rules as $index => $rule) {
            $path = sprintf('rules[%d]', $index);
            if (!is_array($rule)) {
                $stats['errors'][] = sprintf('%s must be an object.', $path);

                continue;
            }

            ++$stats['rules'];
            $this->validateRule($rule, $path, $stats);
        }

        return $stats;
    }

    /**
     * @return array<int, array<string, mixed>>|null
     */
    public function decodeTopLevelRules(string $content): ?array
    {
        $decoded = json_decode($content, true);
        if (!is_array($decoded)) {
            try {
                $yamlDecoded = Yaml::parse($content);
            } catch (\Throwable) {
                $yamlDecoded = null;
            }

            if (is_array($yamlDecoded)) {
                $decoded = $yamlDecoded;
            }
        }

        if (!is_array($decoded)) {
            return null;
        }

        /** @var array<string, mixed>|array<int, mixed> $decoded */
        $rules = $this->looksLikeSingleRuleEnvelope($decoded) ? [$decoded] : $decoded;

        $normalized = [];
        foreach ($rules as $rule) {
            if (is_array($rule)) {
                /** @var array<string, mixed> $rule */
                $normalized[] = $rule;
            }
        }

        return $normalized;
    }

    /**
     * @param array<string, mixed> $decoded
     */
    private function looksLikeSingleRuleEnvelope(array $decoded): bool
    {
        if (!$this->isAssoc($decoded)) {
            return false;
        }

        return isset($decoded['ruleSet'], $decoded['externalId'], $decoded['name']);
    }

    /**
     * @param array<string, mixed> $rule
     * @param array{rules:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function validateRule(array $rule, string $path, array &$stats): void
    {
        $ruleSet = $rule['ruleSet'] ?? null;
        if (!is_string($ruleSet) || '' === trim($ruleSet)) {
            $stats['errors'][] = sprintf('%s.ruleSet is required and must be a string (RuleSetTemplate.externalId).', $path);
        }

        $externalId = $rule['externalId'] ?? null;
        if (!is_string($externalId) || '' === trim($externalId)) {
            $stats['errors'][] = sprintf('%s.externalId is required and must be a string.', $path);
        }

        $name = $rule['name'] ?? null;
        if (!is_string($name) || '' === trim($name)) {
            $stats['errors'][] = sprintf('%s.name is required and must be a string.', $path);
        }

        $payload = $rule['valueJson'] ?? $rule['data'] ?? null;
        if (!is_array($payload)) {
            $stats['errors'][] = sprintf('%s must include valueJson (or alias data) as an object.', $path);
        } else {
            $encoded = json_encode($payload);
            if (false === $encoded) {
                $stats['errors'][] = sprintf('%s.valueJson could not be JSON-encoded.', $path);
            }
        }

        if (isset($rule['sortOrder']) && !is_int($rule['sortOrder'])) {
            $stats['errors'][] = sprintf('%s.sortOrder must be an integer if provided.', $path);
        }
    }

    /**
     * @param array<mixed> $array
     */
    private function isAssoc(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
