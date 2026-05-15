<?php

namespace App\Service\Skill;

use Symfony\Component\Yaml\Yaml;

final class SkillImportAnalyzer
{
    /**
     * @return array{
     *   skillGroups:int,
     *   skills:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * }
     */
    public function analyze(string $content): array
    {
        $document = $this->decodeDocument($content);
        if (null === $document) {
            return [
                'skillGroups' => 0,
                'skills' => 0,
                'errors' => ['Import file must decode to a JSON or YAML object.'],
                'warnings' => [],
            ];
        }

        $stats = [
            'skillGroups' => 0,
            'skills' => 0,
            'errors' => [],
            'warnings' => [],
        ];

        $ruleSet = $document['ruleSet'] ?? null;
        if (!is_string($ruleSet) || '' === trim($ruleSet)) {
            $stats['errors'][] = 'root.ruleSet is required and must be a string.';
        }

        if (isset($document['example']) && !is_string($document['example'])) {
            $stats['errors'][] = 'root.example must be a string when provided.';
        }

        $skillGroups = $document['skillGroups'] ?? [];
        if (!is_array($skillGroups)) {
            $stats['errors'][] = 'root.skillGroups must be an array when present.';
        } else {
            foreach ($skillGroups as $index => $group) {
                $path = sprintf('skillGroups[%d]', $index);
                if (!is_array($group)) {
                    $stats['errors'][] = sprintf('%s must be an object.', $path);
                    continue;
                }
                ++$stats['skillGroups'];
                $this->validateSkillGroup($group, $path, $stats);
            }
        }

        $skills = $document['skills'] ?? null;
        if (!is_array($skills)) {
            $stats['errors'][] = 'root.skills must be an array.';
        } else {
            foreach ($skills as $index => $skill) {
                $path = sprintf('skills[%d]', $index);
                if (!is_array($skill)) {
                    $stats['errors'][] = sprintf('%s must be an object.', $path);
                    continue;
                }
                ++$stats['skills'];
                $this->validateSkill($skill, $path, $stats);
            }
        }

        return $stats;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function decodeDocument(string $content): ?array
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

        return is_array($decoded) ? $decoded : null;
    }

    /**
     * @param array<string, mixed> $group
     * @param array{skillGroups:int, skills:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function validateSkillGroup(array $group, string $path, array &$stats): void
    {
        foreach (['externalId', 'name'] as $field) {
            $value = $group[$field] ?? null;
            if (!is_string($value) || '' === trim($value)) {
                $stats['errors'][] = sprintf('%s.%s is required and must be a string.', $path, $field);
            }
        }

        foreach (['improvementByExperience', 'improvementByTraining', 'improvementByTutoring', 'improvementByStudy'] as $field) {
            if (!array_key_exists($field, $group)) {
                continue;
            }
            $value = $group[$field];
            if (null !== $value && !is_string($value)) {
                $stats['errors'][] = sprintf('%s.%s must be a string if provided.', $path, $field);
            }
        }
    }

    /**
     * @param array<string, mixed> $skill
     * @param array{skillGroups:int, skills:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function validateSkill(array $skill, string $path, array &$stats): void
    {
        foreach (['externalId', 'name'] as $field) {
            $value = $skill[$field] ?? null;
            if (!is_string($value) || '' === trim($value)) {
                $stats['errors'][] = sprintf('%s.%s is required and must be a string.', $path, $field);
            }
        }

        if (isset($skill['base']) && !is_string($skill['base'])) {
            $stats['errors'][] = sprintf('%s.base must be a string if provided.', $path);
        }

        if (isset($skill['base2']) && !is_string($skill['base2'])) {
            $stats['errors'][] = sprintf('%s.base2 must be a string if provided.', $path);
        }

        if (isset($skill['divider']) && !is_int($skill['divider']) && !is_float($skill['divider'])) {
            $stats['errors'][] = sprintf('%s.divider must be numeric if provided.', $path);
        }

        if (isset($skill['description']) && !is_string($skill['description'])) {
            $stats['errors'][] = sprintf('%s.description must be a string if provided.', $path);
        }

        if (isset($skill['example']) && !is_string($skill['example'])) {
            $stats['errors'][] = sprintf('%s.example must be a string if provided.', $path);
        }

        if (isset($skill['groupExternalId']) && !is_string($skill['groupExternalId'])) {
            $stats['errors'][] = sprintf('%s.groupExternalId must be a string if provided.', $path);
        }

        if (isset($skill['specializations'])) {
            if (!is_array($skill['specializations'])) {
                $stats['errors'][] = sprintf('%s.specializations must be an array of strings.', $path);
            } else {
                foreach ($skill['specializations'] as $idx => $spec) {
                    if (!is_string($spec)) {
                        $stats['errors'][] = sprintf('%s.specializations[%d] must be a string.', $path, $idx);
                    }
                }
            }
        }

        if (isset($skill['rules'])) {
            if (!is_array($skill['rules'])) {
                $stats['errors'][] = sprintf('%s.rules must be an array of externalId strings.', $path);
            } else {
                foreach ($skill['rules'] as $idx => $ref) {
                    if (!is_string($ref) || '' === trim($ref)) {
                        $stats['errors'][] = sprintf('%s.rules[%d] must be a non-empty string.', $path, $idx);
                    }
                }
            }
        }

        if (isset($skill['relatedSkills'])) {
            if (!is_array($skill['relatedSkills'])) {
                $stats['errors'][] = sprintf('%s.relatedSkills must be an array of skill externalId strings.', $path);
            } else {
                foreach ($skill['relatedSkills'] as $idx => $ref) {
                    if (!is_string($ref) || '' === trim($ref)) {
                        $stats['errors'][] = sprintf('%s.relatedSkills[%d] must be a non-empty string.', $path, $idx);
                    }
                }
            }
        }

        $hasTables = isset($skill['tables']);
        $hasLegacyTable = isset($skill['table']);
        if ($hasTables) {
            if (!is_array($skill['tables'])) {
                $stats['errors'][] = sprintf('%s.tables must be an array when present.', $path);
            } else {
                foreach ($skill['tables'] as $idx => $table) {
                    $this->validateSkillTableBlock(
                        is_array($table) ? $table : [],
                        sprintf('%s.tables[%d]', $path, $idx),
                        $stats,
                        is_array($table)
                    );
                }
            }
        }

        if ($hasLegacyTable) {
            if (!is_array($skill['table'])) {
                $stats['errors'][] = sprintf('%s.table must be an object when present.', $path);
            } else {
                $this->validateSkillTableBlock($skill['table'], sprintf('%s.table', $path), $stats, true);
            }
        }

        if ($hasTables && is_array($skill['tables']) && [] !== $skill['tables'] && $hasLegacyTable) {
            $stats['warnings'][] = sprintf(
                '%s has both `tables` and legacy `table`; importer uses `tables` only.',
                $path
            );
        }
    }

    /**
     * @param array<string, mixed> $table
     * @param array{skillGroups:int, skills:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function validateSkillTableBlock(array $table, string $path, array &$stats, bool $isObject): void
    {
        if (!$isObject) {
            $stats['errors'][] = sprintf('%s must be an object.', $path);

            return;
        }

        if (isset($table['description']) && !is_string($table['description'])) {
            $stats['errors'][] = sprintf('%s.description must be a string if provided.', $path);
        }

        if (isset($table['columns']) && !is_array($table['columns'])) {
            $stats['errors'][] = sprintf('%s.columns must be an array.', $path);
        }
        if (isset($table['rows']) && !is_array($table['rows'])) {
            $stats['errors'][] = sprintf('%s.rows must be an array.', $path);
        }

        if (isset($table['columns']) && is_array($table['columns'])) {
            foreach ($table['columns'] as $index => $column) {
                if (!is_array($column)) {
                    $stats['errors'][] = sprintf('%s.columns[%d] must be an object.', $path, $index);
                    continue;
                }
                $key = $column['key'] ?? null;
                if (!is_string($key) || '' === trim($key)) {
                    $stats['errors'][] = sprintf('%s.columns[%d].key is required and must be a string.', $path, $index);
                }
            }
        }

        if (isset($table['rows']) && is_array($table['rows'])) {
            foreach ($table['rows'] as $index => $row) {
                if (!is_array($row)) {
                    $stats['errors'][] = sprintf('%s.rows[%d] must be an object/map.', $path, $index);
                }
            }
        }
    }
}

