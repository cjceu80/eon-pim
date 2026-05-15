<?php

namespace App\Command;

use App\Service\Profession\ProfessionImportAnalyzer;
use App\Service\Profession\ProfessionImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:profession:import',
    description: 'Analyze/import profession YAML or JSON (ruleSet, professions, raceRestriction, raceIds, EON brick fields).',
)]
class ProfessionImportCommand extends Command
{
    public function __construct(
        private readonly ProfessionImportAnalyzer $professionImportAnalyzer,
        private readonly ProfessionImporter $professionImporter,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Path to YAML/JSON file containing ruleSet and professions')
            ->addOption('apply', null, InputOption::VALUE_NONE, 'Persist professions to Pimcore DataObjects');
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

        $analysis = $this->professionImportAnalyzer->analyze($content);
        $errors = $analysis['errors'];
        $warnings = $analysis['warnings'];

        $io->definitionList(
            ['Mode' => $apply ? 'apply persistence' : 'dry-run analysis'],
            ['Professions detected' => (string) $analysis['professions']],
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

        $document = $this->professionImportAnalyzer->decodeDocument($content);
        if (null === $document) {
            $io->error('Could not decode YAML/JSON for apply mode.');

            return Command::FAILURE;
        }

        $importStats = $this->professionImporter->import($document, dryRun: false);

        $allWarnings = array_merge($warnings, $importStats['warnings']);
        if ([] !== $allWarnings) {
            $io->section('Import warnings');
            foreach ($allWarnings as $warning) {
                $io->writeln(sprintf('- %s', $warning));
            }
        }

        $io->section('Persistence summary');
        $io->definitionList(
            ['Professions created' => (string) $importStats['professionsCreated']],
            ['Professions updated' => (string) $importStats['professionsUpdated']],
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
