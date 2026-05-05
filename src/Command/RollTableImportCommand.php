<?php

namespace App\Command;

use App\Service\RollTable\RollTableImportAnalyzer;
use App\Service\RollTable\RollTableImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:roll-table:import',
    description: 'Analyze/import roll table JSON or YAML data.',
)]
class RollTableImportCommand extends Command
{
    public function __construct(
        private readonly RollTableImportAnalyzer $rollTableImportAnalyzer,
        private readonly RollTableImporter $rollTableImporter,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Path to JSON/YAML file containing one table object or an array of tables')
            ->addOption('apply', null, InputOption::VALUE_NONE, 'Persist roll tables to Pimcore DataObjects');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $file = (string) $input->getArgument('file');
        $apply = (bool) $input->getOption('apply');

        if (!is_file($file) || !is_readable($file)) {
            $io->error(sprintf('Import file "%s" does not exist or is not readable.', $file));

            return Command::INVALID;
        }

        $content = file_get_contents($file);
        if (false === $content) {
            $io->error(sprintf('Could not read file "%s".', $file));

            return Command::FAILURE;
        }

        $analysis = $this->rollTableImportAnalyzer->analyze($content);
        $lineMap = $this->buildYamlPathLineMap($content);
        $errors = $this->withLineHints($analysis['errors'], $lineMap);
        $warnings = $this->withLineHints($analysis['warnings'], $lineMap);

        $io->definitionList(
            ['Mode' => $apply ? 'apply persistence' : 'dry-run analysis'],
            ['Tables detected' => (string) $analysis['tables']],
            ['Entries detected (including inline subtables)' => (string) $analysis['entries']],
            ['Inline subtables detected' => (string) $analysis['inlineSubTables']],
            ['Errors' => (string) count($errors)],
            ['Warnings' => (string) count($warnings)],
        );

        if ([] !== $warnings) {
            $io->section('Warnings');
            foreach ($warnings as $warning) {
                $io->writeln(sprintf('- %s', $warning));
            }
        }

        if ([] !== $errors) {
            $io->section('Errors');
            foreach ($errors as $error) {
                $io->writeln(sprintf('- %s', $error));
            }

            $io->error('Import analysis failed due to validation errors.');

            return Command::FAILURE;
        }

        if (!$apply) {
            $io->success('Validation passed.');

            return Command::SUCCESS;
        }

        $tables = $this->rollTableImportAnalyzer->decodeTopLevelTables($content);
        if (null === $tables) {
            $io->error('Could not decode JSON for apply mode.');

            return Command::FAILURE;
        }

        $importStats = $this->rollTableImporter->import($tables, dryRun: false);
        $io->section('Persistence summary');
        $io->definitionList(
            ['Tables created' => (string) $importStats['tablesCreated']],
            ['Tables updated' => (string) $importStats['tablesUpdated']],
            ['Entries created' => (string) $importStats['entriesCreated']],
            ['Entries updated' => (string) $importStats['entriesUpdated']],
            ['Inline subtables created' => (string) $importStats['inlineSubTablesCreated']],
            ['Persistence errors' => (string) count($importStats['errors'])]
        );

        if ([] !== $importStats['errors']) {
            $io->section('Persistence errors');
            foreach ($importStats['errors'] as $error) {
                $io->writeln(sprintf('- %s', $error));
            }

            return Command::FAILURE;
        }

        $io->success('Import persisted successfully.');

        return Command::SUCCESS;
    }

    /**
     * @param array<int, string> $messages
     * @param array<string, int> $lineMap
     * @return array<int, string>
     */
    private function withLineHints(array $messages, array $lineMap): array
    {
        $result = [];
        foreach ($messages as $message) {
            $path = $this->extractPathFromMessage($message);
            if (null === $path) {
                $result[] = $message;
                continue;
            }

            $line = $this->resolveLineForPath($path, $lineMap);
            if (null === $line) {
                $result[] = $message;
                continue;
            }

            $result[] = sprintf('%s [line %d]', $message, $line);
        }

        return $result;
    }

    private function extractPathFromMessage(string $message): ?string
    {
        if (!preg_match('/(tables\[\d+\](?:\.[A-Za-z0-9_]+(?:\[\d+\])?)*)/', $message, $matches)) {
            return null;
        }

        return $matches[1];
    }

    /**
     * @param array<string, int> $lineMap
     */
    private function resolveLineForPath(string $path, array $lineMap): ?int
    {
        $candidate = $path;
        while ('' !== $candidate) {
            if (isset($lineMap[$candidate])) {
                return $lineMap[$candidate];
            }

            $pos = strrpos($candidate, '.');
            if (false === $pos) {
                break;
            }

            $candidate = substr($candidate, 0, $pos);
        }

        return $lineMap[$path] ?? null;
    }

    /**
     * Builds a best-effort mapping from import paths to YAML line numbers.
     *
     * @return array<string, int>
     */
    private function buildYamlPathLineMap(string $content): array
    {
        $lines = preg_split('/\R/', $content);
        if (false === $lines) {
            return [];
        }

        $map = [];
        $tableIndex = -1;
        $entryIndex = -1;
        $inlineEntryIndex = -1;
        $currentEntryPath = null;
        $inlinePath = null;
        $inTableEntries = false;
        $inInlineEntries = false;
        $tableIndent = null;
        $entryIndent = null;
        $inlineIndent = null;
        $inlineEntriesIndent = null;

        foreach ($lines as $lineNumberZero => $rawLine) {
            $lineNumber = $lineNumberZero + 1;
            $trimmed = trim($rawLine);
            if ('' === $trimmed || str_starts_with($trimmed, '#')) {
                continue;
            }

            preg_match('/^(\s*)/', $rawLine, $indentMatch);
            $indent = strlen($indentMatch[1] ?? '');

            if (preg_match('/^\s*-\s*slug\s*:/', $rawLine)) {
                ++$tableIndex;
                $entryIndex = -1;
                $inlineEntryIndex = -1;
                $currentEntryPath = null;
                $inlinePath = null;
                $inTableEntries = false;
                $inInlineEntries = false;
                $tableIndent = $indent;
                $entryIndent = null;
                $inlineIndent = null;
                $inlineEntriesIndent = null;
                $map[sprintf('tables[%d]', $tableIndex)] = $lineNumber;
                continue;
            }

            if ($tableIndex < 0 && preg_match('/^\s*slug\s*:/', $rawLine)) {
                $tableIndex = 0;
                $map['tables[0]'] = $lineNumber;
                continue;
            }

            if ($tableIndex < 0) {
                continue;
            }

            $tablePath = sprintf('tables[%d]', $tableIndex);
            if (!isset($map[$tablePath])) {
                $map[$tablePath] = $lineNumber;
            }

            if (null !== $tableIndent && $indent <= $tableIndent && preg_match('/^\s*-\s*slug\s*:/', $rawLine)) {
                continue;
            }

            if (preg_match('/^\s*entries\s*:\s*$/', $rawLine) && !$inInlineEntries) {
                $inTableEntries = true;
                $entryIndex = -1;
                continue;
            }

            if ($inTableEntries && preg_match('/^\s*-\s*minValue\s*:/', $rawLine)) {
                ++$entryIndex;
                $entryIndent = $indent;
                $inlinePath = null;
                $inInlineEntries = false;
                $inlineEntryIndex = -1;
                $currentEntryPath = sprintf('%s.entries[%d]', $tablePath, $entryIndex);
                $map[$currentEntryPath] = $lineNumber;
                continue;
            }

            if (null !== $entryIndent && $inTableEntries && $indent <= $entryIndent && preg_match('/^\s*-\s*[A-Za-z_]+/', $rawLine) && !preg_match('/^\s*-\s*minValue\s*:/', $rawLine)) {
                $currentEntryPath = null;
                $inlinePath = null;
                $inInlineEntries = false;
            }

            if (null !== $currentEntryPath && preg_match('/^\s*subTable\s*:\s*$/', $rawLine)) {
                $inlinePath = sprintf('%s.subTable', $currentEntryPath);
                $inlineIndent = $indent;
                $inInlineEntries = false;
                $inlineEntryIndex = -1;
                $map[$inlinePath] = $lineNumber;
                continue;
            }

            if (null !== $inlinePath && preg_match('/^\s*entries\s*:\s*$/', $rawLine)) {
                $inInlineEntries = true;
                $inlineEntriesIndent = $indent;
                $inlineEntryIndex = -1;
                continue;
            }

            if ($inInlineEntries && null !== $inlinePath && preg_match('/^\s*-\s*minValue\s*:/', $rawLine)) {
                ++$inlineEntryIndex;
                $map[sprintf('%s.entries[%d]', $inlinePath, $inlineEntryIndex)] = $lineNumber;
                continue;
            }

            if (null !== $inlineEntriesIndent && $inInlineEntries && $indent <= $inlineEntriesIndent && preg_match('/^\s*[A-Za-z_]+\s*:/', $rawLine)) {
                $inInlineEntries = false;
            }

            if (null !== $inlineIndent && null !== $inlinePath && $indent <= $inlineIndent && !preg_match('/^\s*-\s*minValue\s*:/', $rawLine) && preg_match('/^\s*[A-Za-z_]+\s*:/', $rawLine)) {
                $inlinePath = null;
                $inInlineEntries = false;
                $inlineEntryIndex = -1;
            }
        }

        return $map;
    }
}
