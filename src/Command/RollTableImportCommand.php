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
        $errors = $analysis['errors'];
        $warnings = $analysis['warnings'];

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
}
