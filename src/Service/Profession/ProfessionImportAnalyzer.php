<?php

namespace App\Service\Profession;

use Symfony\Component\Yaml\Yaml;

final class ProfessionImportAnalyzer
{
    private const RACE_POLICIES = ['all', 'except', 'only'];

    /**
     * @return array{
     *   professions:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * }
     */
    public function analyze(string $content): array
    {
        $document = $this->decodeDocument($content);
        if (null === $document) {
            return [
                'professions' => 0,
                'errors' => ['Import file must decode to a JSON or YAML object.'],
                'warnings' => [],
            ];
        }

        $stats = [
            'professions' => 0,
            'errors' => [],
            'warnings' => [],
        ];

        $ruleSet = $document['ruleSet'] ?? null;
        if (!is_string($ruleSet) || '' === trim($ruleSet)) {
            $stats['errors'][] = 'root.ruleSet is required and must be a string.';
        }

        $professions = $document['professions'] ?? null;
        if (!is_array($professions)) {
            $stats['errors'][] = 'root.professions must be an array.';

            return $stats;
        }

        foreach ($professions as $index => $profession) {
            $path = sprintf('professions[%d]', $index);
            if (!is_array($profession)) {
                $stats['errors'][] = sprintf('%s must be an object.', $path);

                continue;
            }

            ++$stats['professions'];
            $this->validateProfession($profession, $path, $stats);
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
     * @param array<string, mixed> $profession
     * @param array{professions:int, errors:array<int, string>, warnings:array<int, string>} $stats
     */
    private function validateProfession(array $profession, string $path, array &$stats): void
    {
        foreach (['externalId', 'name'] as $field) {
            $value = $profession[$field] ?? null;
            if (!is_string($value) || '' === trim($value)) {
                $stats['errors'][] = sprintf('%s.%s is required and must be a non-empty string.', $path, $field);
            }
        }

        if (isset($profession['description']) && !is_string($profession['description'])) {
            $stats['errors'][] = sprintf('%s.description must be a string if provided.', $path);
        }

        $policy = $this->normalizeRaceRestriction($profession['raceRestriction'] ?? null);
        if (null !== ($profession['raceRestriction'] ?? null) && !is_string($profession['raceRestriction'])) {
            $stats['errors'][] = sprintf('%s.raceRestriction must be a string if provided.', $path);
        } elseif (isset($profession['raceRestriction']) && is_string($profession['raceRestriction']) && null === $policy) {
            $stats['errors'][] = sprintf(
                '%s.raceRestriction must be one of: %s.',
                $path,
                implode(', ', self::RACE_POLICIES)
            );
        }

        $raceRefs = $this->extractRaceIdRefs($profession);
        if (null === $raceRefs) {
            $stats['errors'][] = sprintf(
                '%s.raceIds must be an array of external id strings (or omit). Use raceId for a single string.',
                $path
            );
        } else {
            foreach ($raceRefs as $idx => $ref) {
                if (!is_string($ref) || '' === trim($ref)) {
                    $stats['errors'][] = sprintf('%s.raceIds[%d] must be a non-empty string.', $path, $idx);
                }
            }
        }

        if (is_array($raceRefs) && in_array($policy, ['only', 'except'], true) && [] === $raceRefs) {
            $stats['errors'][] = sprintf(
                '%s.raceIds must list at least one race when raceRestriction is "%s".',
                $path,
                $policy
            );
        }

        if ('all' === $policy && is_array($raceRefs) && [] !== $raceRefs) {
            $stats['warnings'][] = sprintf(
                '%s has raceRestriction "all" but raceIds is non-empty; importer will clear raceIds.',
                $path
            );
        }

        if (isset($profession['subProfession'])) {
            if (!is_array($profession['subProfession'])) {
                $stats['errors'][] = sprintf('%s.subProfession must be an array when present.', $path);
            } else {
                foreach ($profession['subProfession'] as $i => $sub) {
                    if (!is_array($sub)) {
                        $stats['errors'][] = sprintf('%s.subProfession[%d] must be an object.', $path, $i);

                        continue;
                    }
                    $subExt = $sub['externalId'] ?? null;
                    if (!is_string($subExt) || '' === trim($subExt)) {
                        $stats['errors'][] = sprintf(
                            '%s.subProfession[%d].externalId is required and must be a non-empty string.',
                            $path,
                            $i
                        );
                    }
                    foreach (['name', 'description'] as $sf) {
                        if (isset($sub[$sf]) && !is_string($sub[$sf])) {
                            $stats['errors'][] = sprintf('%s.subProfession[%d].%s must be a string if provided.', $path, $i, $sf);
                        }
                    }

                    $hasSkillCheckKeys = $this->subProfessionDeclaresSkillChecks($sub);
                    foreach (['skillCheck1', 'skillCheck2', 'skillCheck3'] as $sf) {
                        if (isset($sub[$sf]) && !is_string($sub[$sf])) {
                            $stats['errors'][] = sprintf('%s.subProfession[%d].%s must be a string if provided.', $path, $i, $sf);
                        }
                    }

                    if ($hasSkillCheckKeys) {
                        foreach (['skillCheck1', 'skillCheck2', 'skillCheck3'] as $sf) {
                            $value = $sub[$sf] ?? null;
                            if (!is_string($value) || '' === trim($value)) {
                                $stats['errors'][] = sprintf(
                                    '%s.subProfession[%d].%s is required when any skillCheck field is set (uses EONSubProffesionVariant).',
                                    $path,
                                    $i,
                                    $sf
                                );
                            }
                        }
                    }
                }
            }
        }
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

    /**
     * @param array<string, mixed> $profession
     * @return list<string>|null null if invalid shape
     */
    public function extractRaceIdRefs(array $profession): ?array
    {
        if (isset($profession['raceIds'])) {
            if (!is_array($profession['raceIds'])) {
                return null;
            }

            $out = array_values(array_filter(
                array_map(static fn (mixed $v): string => is_string($v) ? trim($v) : '', $profession['raceIds']),
                static fn (string $s): bool => '' !== $s
            ));

            return $out;
        }

        if (!array_key_exists('raceId', $profession)) {
            return [];
        }

        $raw = $profession['raceId'];
        if (is_string($raw)) {
            $t = trim($raw);

            return '' === $t ? [] : [$t];
        }

        if (is_array($raw)) {
            return array_values(array_filter(
                array_map(static fn (mixed $v): string => is_string($v) ? trim($v) : '', $raw),
                static fn (string $s): bool => '' !== $s
            ));
        }

        return null;
    }

    public function normalizeRaceRestriction(mixed $value): ?string
    {
        if (null === $value) {
            return 'all';
        }

        if (!is_string($value)) {
            return null;
        }

        $t = strtolower(trim($value));

        return in_array($t, self::RACE_POLICIES, true) ? $t : null;
    }
}
