<?php

namespace App\Command;

use App\Service\Race\RaceImportAnalyzer;
use App\Service\Race\RaceImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:race:import',
    description: 'Analyze/import race category/template YAML or JSON.',
)]
class RaceImportCommand extends Command
{
    public function __construct(
        private readonly RaceImportAnalyzer $raceImportAnalyzer,
        private readonly RaceImporter $raceImporter,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Path to YAML/JSON file containing ruleSet, categories, and races')
            ->addOption('apply', null, InputOption::VALUE_NONE, 'Persist races to Pimcore DataObjects');
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

        $analysis = $this->raceImportAnalyzer->analyze($content);
        $errors = $analysis['errors'];
        $warnings = $analysis['warnings'];

        $io->definitionList(
            ['Mode' => $apply ? 'apply persistence' : 'dry-run analysis'],
            ['Categories detected' => (string) $analysis['categories']],
            ['Races detected' => (string) $analysis['races']],
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

        $document = $this->raceImportAnalyzer->decodeDocument($content);
        if (null === $document) {
            $io->error('Could not decode YAML/JSON for apply mode.');

            return Command::FAILURE;
        }

        $importStats = $this->raceImporter->import($document, dryRun: false);
        $io->section('Persistence summary');
        $io->definitionList(
            ['Categories created' => (string) $importStats['categoriesCreated']],
            ['Categories updated' => (string) $importStats['categoriesUpdated']],
            ['Races created' => (string) $importStats['racesCreated']],
            ['Races updated' => (string) $importStats['racesUpdated']],
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
