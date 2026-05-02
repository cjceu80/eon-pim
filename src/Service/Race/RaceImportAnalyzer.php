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
        $categoryExternalIds = [];
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
            if (is_string($ruleSet) && '' !== trim($ruleSet)) {
                foreach ($categories as $index => $category) {
                    if (!is_array($category)) {
                        continue;
                    }
                    try {
                        $categoryExternalIds[] = RaceCategoryImportUtil::resolveCategoryExternalId(trim($ruleSet), $category);
                    } catch (\Throwable) {
                        // validateCategory already reported missing name/externalId
                    }
                }
                $categoryExternalIds = array_values(array_unique($categoryExternalIds));
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
                $this->validateRace($race, $path, $stats, $categoryExternalIds);
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
        $hasExternalId = is_string($externalId) && '' !== trim($externalId);

        $name = $category['name'] ?? null;
        $hasName = is_string($name) && '' !== trim($name);

        if (!$hasExternalId && !$hasName) {
            $stats['errors'][] = sprintf('%s requires externalId or name.', $path);
        }

        if (array_key_exists('externalId', $category) && null !== $category['externalId'] && !is_string($category['externalId'])) {
            $stats['errors'][] = sprintf('%s.externalId must be a string if provided.', $path);
        }

        if (array_key_exists('name', $category) && null !== $category['name'] && !is_string($category['name'])) {
            $stats['errors'][] = sprintf('%s.name must be a string if provided.', $path);
        }

        foreach (['exhaustionColumnDivisor', 'backgroundRolls', 'movementModification'] as $numericKey) {
            if (!array_key_exists($numericKey, $category)) {
                continue;
            }
            $value = $category[$numericKey];
            if (null === $value) {
                continue;
            }
            if (!is_int($value) && !(is_float($value) && floor($value) == $value)) {
                $stats['errors'][] = sprintf('%s.%s must be an integer if provided.', $path, $numericKey);
            }
        }

        foreach (['apparentAgeFormula', 'actualAgeFromApparentFormula', 'parentAgeFormula', 'parentStatusFormula', 'parentStatusTableRef', 'apparentAgeTableRef'] as $stringKey) {
            if (!array_key_exists($stringKey, $category)) {
                continue;
            }
            $value = $category[$stringKey];
            if (null === $value) {
                continue;
            }
            if (!is_string($value)) {
                $stats['errors'][] = sprintf('%s.%s must be a string if provided.', $path, $stringKey);
            }
        }

        if (isset($category['siblingFormula'])) {
            if (!is_array($category['siblingFormula'])) {
                $stats['errors'][] = sprintf('%s.siblingFormula must be an object.', $path);
            } else {
                $allowedSiblingKeys = [
                    'numberOfLitters',
                    'litterSize',
                    'olderSiblingAgeFormula',
                    'youngerSiblingAgeFormula',
                    'genderFormula',
                ];
                foreach ($allowedSiblingKeys as $sk) {
                    if (!array_key_exists($sk, $category['siblingFormula'])) {
                        continue;
                    }
                    $sv = $category['siblingFormula'][$sk];
                    if (null !== $sv && !is_string($sv)) {
                        $stats['errors'][] = sprintf('%s.siblingFormula.%s must be a string if provided.', $path, $sk);
                    }
                }
            }
        }

        if (isset($category['metadata']) && !is_array($category['metadata'])) {
            $stats['errors'][] = sprintf('%s.metadata must be an object if provided.', $path);
        }
    }

    /**
     * @param array<string, mixed> $race
     * @param array{categories:int, races:int, errors:array<int, string>, warnings:array<int, string>} $stats
     * @param array<int, string> $categoryExternalIds
     */
    private function validateRace(array $race, string $path, array &$stats, array $categoryExternalIds): void
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
        } elseif ([] !== $categoryExternalIds && !in_array(trim($categoryExternalId), $categoryExternalIds, true)) {
            $stats['errors'][] = sprintf(
                '%s.categoryExternalId "%s" does not match any category externalId in this file.',
                $path,
                trim($categoryExternalId)
            );
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
