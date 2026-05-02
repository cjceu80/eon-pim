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

        if ($this->isCalendarRule($rule)) {
            $this->validateCalendarRule($rule, $path, $stats);
        } else {
            $payload = $rule['valueJson'] ?? $rule['data'] ?? null;
            if (!is_array($payload)) {
                $stats['errors'][] = sprintf('%s must include valueJson (or alias data) as an object.', $path);
            } else {
                $encoded = json_encode($payload);
                if (false === $encoded) {
                    $stats['errors'][] = sprintf('%s.valueJson could not be JSON-encoded.', $path);
                }
            }
        }

        if (isset($rule['sortOrder']) && !is_int($rule['sortOrder'])) {
            $stats['errors'][] = sprintf('%s.sortOrder must be an integer if provided.', $path);
        }
    }

    /**
     * @param array<string, mixed> $rule
     */
    private function isCalendarRule(array $rule): bool
    {
        $type = $rule['ruleType'] ?? null;

        return is_string($type) && 'calendar' === strtolower(trim($type));
    }

    /**
     * @param array<string, mixed> $rule
     * @param array{rules:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function validateCalendarRule(array $rule, string $path, array &$stats): void
    {
        if (isset($rule['schemaVersion']) && !is_int($rule['schemaVersion'])) {
            $stats['errors'][] = sprintf('%s.schemaVersion must be an integer if provided.', $path);
        }

        foreach (['numberOfMonths', 'numberOfWeeks', 'numberOfWeekdays'] as $key) {
            if (!array_key_exists($key, $rule) || !is_int($rule[$key]) || $rule[$key] < 1) {
                $stats['errors'][] = sprintf('%s.%s is required and must be a positive integer.', $path, $key);
            }
        }

        foreach (['months', 'weeks', 'weekdays'] as $listKey) {
            if (!isset($rule[$listKey]) || !is_array($rule[$listKey])) {
                $stats['errors'][] = sprintf('%s.%s is required and must be a list.', $path, $listKey);

                continue;
            }
            $nonEmpty = 0;
            foreach ($rule[$listKey] as $index => $item) {
                if (!is_string($item)) {
                    $stats['errors'][] = sprintf('%s.%s[%d] must be a string.', $path, $listKey, $index);

                    continue;
                }
                if ('' !== trim($item)) {
                    ++$nonEmpty;
                }
            }
            if (0 === $nonEmpty) {
                $stats['errors'][] = sprintf('%s.%s must contain at least one non-empty name.', $path, $listKey);
            }
        }

        if (!is_array($rule['months'] ?? null) || !is_array($rule['weeks'] ?? null) || !is_array($rule['weekdays'] ?? null)) {
            return;
        }

        if (!is_int($rule['numberOfMonths'] ?? null) || !is_int($rule['numberOfWeeks'] ?? null) || !is_int($rule['numberOfWeekdays'] ?? null)) {
            return;
        }

        $expectedMonths = (int) $rule['numberOfMonths'];
        $expectedWeeks = (int) $rule['numberOfWeeks'];
        $expectedWeekdays = (int) $rule['numberOfWeekdays'];

        $monthCount = $this->countNonEmptyStrings($rule['months']);
        $weekCount = $this->countNonEmptyStrings($rule['weeks']);
        $weekdayCount = $this->countNonEmptyStrings($rule['weekdays']);

        if ($monthCount !== $expectedMonths) {
            $stats['errors'][] = sprintf(
                '%s.months has %d non-empty entries but numberOfMonths is %d.',
                $path,
                $monthCount,
                $expectedMonths
            );
        }

        if ($weekCount !== $expectedWeeks) {
            $stats['errors'][] = sprintf(
                '%s.weeks has %d non-empty entries but numberOfWeeks is %d.',
                $path,
                $weekCount,
                $expectedWeeks
            );
        }

        if ($weekdayCount !== $expectedWeekdays) {
            $stats['errors'][] = sprintf(
                '%s.weekdays has %d non-empty entries but numberOfWeekdays is %d.',
                $path,
                $weekdayCount,
                $expectedWeekdays
            );
        }
    }

    /**
     * @param array<mixed> $items
     */
    private function countNonEmptyStrings(array $items): int
    {
        $n = 0;
        foreach ($items as $item) {
            if (is_string($item) && '' !== trim($item)) {
                ++$n;
            }
        }

        return $n;
    }

    /**
     * @param array<mixed> $array
     */
    private function isAssoc(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
