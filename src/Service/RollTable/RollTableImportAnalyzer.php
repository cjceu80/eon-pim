<?php

namespace App\Service\RollTable;

use App\Service\Dice\DiceNotationParser;
use Symfony\Component\Yaml\Yaml;

final class RollTableImportAnalyzer
{
    public function __construct(
        private readonly DiceNotationParser $diceNotationParser,
    ) {
    }

    /**
     * @return array{
     *   tables:int,
     *   entries:int,
     *   inlineSubTables:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * }
     */
    public function analyze(string $content): array
    {
        $tables = $this->decodeTopLevelTables($content);
        if (null === $tables) {
            return [
                'tables' => 0,
                'entries' => 0,
                'inlineSubTables' => 0,
                'errors' => ['Import file must decode to a JSON or YAML object/array.'],
                'warnings' => [],
            ];
        }
        $stats = [
            'tables' => 0,
            'entries' => 0,
            'inlineSubTables' => 0,
            'errors' => [],
            'warnings' => [],
        ];

        foreach ($tables as $tableIndex => $table) {
            $path = sprintf('tables[%d]', $tableIndex);
            if (!is_array($table)) {
                $stats['errors'][] = sprintf('%s must be an object.', $path);
                continue;
            }

            ++$stats['tables'];
            $this->validateTable($table, $path, $stats);
        }

        return $stats;
    }

    /**
     * @return array<int, array<string, mixed>>|null
     */
    public function decodeTopLevelTables(string $content): ?array
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

        $tables = $this->isAssoc($decoded) ? [$decoded] : $decoded;
        $normalized = [];
        foreach ($tables as $table) {
            if (is_array($table)) {
                /** @var array<string, mixed> $table */
                $normalized[] = $table;
            }
        }

        return $normalized;
    }

    /**
     * @param array<string, mixed> $table
     * @param array{
     *   tables:int,
     *   entries:int,
     *   inlineSubTables:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * } $stats
     */
    private function validateTable(array $table, string $path, array &$stats): void
    {
        $name = $table['name'] ?? null;
        $slug = $table['slug'] ?? null;
        $dice = $table['dice'] ?? null;
        $entries = $table['entries'] ?? null;

        if (!is_string($name) || '' === trim($name)) {
            $stats['errors'][] = sprintf('%s.name is required and must be a string.', $path);
        }
        if (!is_string($slug) || '' === trim($slug)) {
            $stats['errors'][] = sprintf('%s.slug is required and must be a string.', $path);
        }

        if (!is_string($dice) || '' === trim($dice)) {
            $stats['errors'][] = sprintf('%s.dice is required and must be a dice string.', $path);
        } else {
            $this->validateDice($dice, sprintf('%s.dice', $path), $stats);
        }

        if (!is_array($entries)) {
            $stats['errors'][] = sprintf('%s.entries is required and must be an array.', $path);

            return;
        }

        $intervals = [];
        foreach ($entries as $entryIndex => $entry) {
            $entryPath = sprintf('%s.entries[%d]', $path, $entryIndex);
            if (!is_array($entry)) {
                $stats['errors'][] = sprintf('%s must be an object.', $entryPath);
                continue;
            }

            ++$stats['entries'];
            $interval = $this->validateEntry($entry, $entryPath, $stats);
            if (null !== $interval) {
                $intervals[] = $interval;
            }
        }

        $this->validateIntervalOverlaps($intervals, $path, $stats);
    }

    /**
     * @param array<string, mixed> $entry
     * @param array{
     *   tables:int,
     *   entries:int,
     *   inlineSubTables:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * } $stats
     * @return array{min:int,max:?int,entryPath:string}|null
     */
    private function validateEntry(array $entry, string $entryPath, array &$stats): ?array
    {
        $min = $entry['minValue'] ?? null;
        $max = $entry['maxValue'] ?? null;
        $value = $entry['value'] ?? null;

        if (!is_int($min)) {
            $stats['errors'][] = sprintf('%s requires integer minValue.', $entryPath);

            return null;
        }

        if (null !== $max && !is_int($max)) {
            $stats['errors'][] = sprintf('%s.maxValue must be an integer or null.', $entryPath);

            return null;
        }

        if (is_int($max) && $min > $max) {
            $stats['errors'][] = sprintf('%s has minValue greater than maxValue.', $entryPath);
        }

        if (!is_string($value) && !is_int($value) && !is_float($value)) {
            $stats['warnings'][] = sprintf('%s.value should be text or number.', $entryPath);
        }

        if (isset($entry['subTable'])) {
            $subTable = $entry['subTable'];
            if (!is_array($subTable)) {
                $stats['errors'][] = sprintf('%s.subTable must be an object.', $entryPath);
            } else {
                $subType = $subTable['type'] ?? null;
                if ('inline' === $subType) {
                    ++$stats['inlineSubTables'];
                    $inlinePath = sprintf('%s.subTable', $entryPath);
                    $this->validateInlineSubTable($subTable, $inlinePath, $stats);
                } elseif ('ref' === $subType) {
                    $tableExternalId = $subTable['tableExternalId'] ?? null;
                    if (!is_string($tableExternalId) || '' === trim($tableExternalId)) {
                        $stats['errors'][] = sprintf('%s.subTable.tableExternalId is required for ref subtables.', $entryPath);
                    }
                } else {
                    $stats['errors'][] = sprintf('%s.subTable.type must be "inline" or "ref".', $entryPath);
                }
            }
        }

        if (isset($entry['effect']) && !is_array($entry['effect'])) {
            $stats['errors'][] = sprintf('%s.effect must be an object when present.', $entryPath);
        }

        return ['min' => $min, 'max' => $max, 'entryPath' => $entryPath];
    }

    /**
     * @param array<string, mixed> $subTable
     * @param array{
     *   tables:int,
     *   entries:int,
     *   inlineSubTables:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * } $stats
     */
    private function validateInlineSubTable(array $subTable, string $path, array &$stats): void
    {
        $dice = $subTable['dice'] ?? null;
        $entries = $subTable['entries'] ?? null;

        if (!is_string($dice) || '' === trim($dice)) {
            $stats['errors'][] = sprintf('%s.dice is required for inline subtables.', $path);
        } else {
            $this->validateDice($dice, sprintf('%s.dice', $path), $stats);
        }

        if (!is_array($entries)) {
            $stats['errors'][] = sprintf('%s.entries is required for inline subtables.', $path);

            return;
        }

        $intervals = [];
        foreach ($entries as $idx => $entry) {
            $entryPath = sprintf('%s.entries[%d]', $path, $idx);
            if (!is_array($entry)) {
                $stats['errors'][] = sprintf('%s must be an object.', $entryPath);
                continue;
            }

            ++$stats['entries'];
            $interval = $this->validateEntry($entry, $entryPath, $stats);
            if (null !== $interval) {
                $intervals[] = $interval;
            }
        }
        $this->validateIntervalOverlaps($intervals, $path, $stats);
    }

    /**
     * @param array<int, array{min:int,max:?int,entryPath:string}> $intervals
     * @param array{
     *   tables:int,
     *   entries:int,
     *   inlineSubTables:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * } $stats
     */
    private function validateIntervalOverlaps(array $intervals, string $path, array &$stats): void
    {
        usort($intervals, static fn (array $a, array $b): int => $a['min'] <=> $b['min']);

        for ($i = 1, $count = count($intervals); $i < $count; ++$i) {
            $prev = $intervals[$i - 1];
            $current = $intervals[$i];
            $prevMax = $prev['max'] ?? PHP_INT_MAX;

            if ($current['min'] <= $prevMax) {
                $stats['errors'][] = sprintf(
                    '%s has overlapping intervals between %s and %s.',
                    $path,
                    $prev['entryPath'],
                    $current['entryPath']
                );
            }
        }
    }

    /**
     * @param array{
     *   tables:int,
     *   entries:int,
     *   inlineSubTables:int,
     *   errors:array<int, string>,
     *   warnings:array<int, string>
     * } $stats
     */
    private function validateDice(string $dice, string $path, array &$stats): void
    {
        try {
            $this->diceNotationParser->parse($dice);
        } catch (\InvalidArgumentException $exception) {
            $stats['errors'][] = sprintf('%s is invalid: %s', $path, $exception->getMessage());
        }
    }

    /**
     * @param array<mixed> $array
     */
    private function isAssoc(array $array): bool
    {
        if ([] === $array) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }
}
