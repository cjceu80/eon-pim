<?php

namespace App\Service\Race;

use Symfony\Component\Yaml\Yaml;

final class RaceImportAnalyzer
{
    /**
     * @return array{
     *   categories:int,
     *   races:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * }
     */
    public function analyze(string $content): array
    {
        $decoded = $this->decodeDocument($content);
        if (null === $decoded) {
            return [
                'categories' => 0,
                'races' => 0,
                'errors' => ['Import file must decode to a JSON or YAML object.'],
                'warnings' => [],
            ];
        }

        $stats = [
            'categories' => 0,
            'races' => 0,
            'errors' => [],
            'warnings' => [],
        ];

        $ruleSet = $decoded['ruleSet'] ?? null;
        if (!is_string($ruleSet) || '' === trim($ruleSet)) {
            $stats['errors'][] = 'root.ruleSet is required and must be a string (RuleSetTemplate.externalId).';
        }

        $categories = $decoded['categories'] ?? null;
        if (!is_array($categories)) {
            $stats['errors'][] = 'root.categories must be an array.';
        } else {
            foreach ($categories as $index => $category) {
                $path = sprintf('categories[%d]', $index);
                if (!is_array($category)) {
                    $stats['errors'][] = sprintf('%s must be an object.', $path);

                    continue;
                }

                ++$stats['categories'];
                $this->validateCategory($category, $path, $stats);
            }
        }

        $races = $decoded['races'] ?? null;
        if (!is_array($races)) {
            $stats['errors'][] = 'root.races must be an array.';
        } else {
            foreach ($races as $index => $race) {
                $path = sprintf('races[%d]', $index);
                if (!is_array($race)) {
                    $stats['errors'][] = sprintf('%s must be an object.', $path);

                    continue;
                }

                ++$stats['races'];
                $this->validateRace($race, $path, $stats);
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

        if (!is_array($decoded)) {
            return null;
        }

        /** @var array<string, mixed> $decoded */
        return $decoded;
    }

    /**
     * @param array<string, mixed> $category
     * @param array{categories:int, races:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function validateCategory(array $category, string $path, array &$stats): void
    {
        $externalId = $category['externalId'] ?? null;
        if (!is_string($externalId) || '' === trim($externalId)) {
            $stats['errors'][] = sprintf('%s.externalId is required.', $path);
        }

        $name = $category['name'] ?? null;
        if (!is_string($name) || '' === trim($name)) {
            $stats['errors'][] = sprintf('%s.name is required.', $path);
        }

        foreach (['exhaustionColumnDivisor', 'backgroundRolls'] as $numericKey) {
            if (!array_key_exists($numericKey, $category)) {
                continue;
            }
            $value = $category[$numericKey];
            if (null !== $value && !is_int($value)) {
                $stats['errors'][] = sprintf('%s.%s must be an integer if provided.', $path, $numericKey);
            }
        }
    }

    /**
     * @param array<string, mixed> $race
     * @param array{categories:int, races:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function validateRace(array $race, string $path, array &$stats): void
    {
        $externalId = $race['externalId'] ?? null;
        if (!is_string($externalId) || '' === trim($externalId)) {
            $stats['errors'][] = sprintf('%s.externalId is required.', $path);
        }

        $name = $race['name'] ?? null;
        if (!is_string($name) || '' === trim($name)) {
            $stats['errors'][] = sprintf('%s.name is required.', $path);
        }

        $categoryExternalId = $race['categoryExternalId'] ?? null;
        if (!is_string($categoryExternalId) || '' === trim($categoryExternalId)) {
            $stats['errors'][] = sprintf('%s.categoryExternalId is required.', $path);
        }

        foreach (['maleLength', 'maleWeight', 'femaleLength', 'femaleWeight'] as $numericKey) {
            if (!array_key_exists($numericKey, $race)) {
                continue;
            }
            $value = $race[$numericKey];
            if (null !== $value && !is_int($value)) {
                $stats['errors'][] = sprintf('%s.%s must be an integer if provided.', $path, $numericKey);
            }
        }

        if (isset($race['modifiers']) && !is_array($race['modifiers'])) {
            $stats['errors'][] = sprintf('%s.modifiers must be an object/map if provided.', $path);
        }
    }
}
