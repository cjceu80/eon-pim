<?php

namespace App\Command;

use App\Service\Skill\SkillImportAnalyzer;
use App\Service\Skill\SkillImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:skill:import',
    description: 'Analyze/import skill YAML or JSON data.',
)]
class SkillImportCommand extends Command
{
    public function __construct(
        private readonly SkillImportAnalyzer $skillImportAnalyzer,
        private readonly SkillImporter $skillImporter,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Path to YAML/JSON file containing ruleSet, skillGroups, and skills')
            ->addOption('apply', null, InputOption::VALUE_NONE, 'Persist skills to Pimcore DataObjects');
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

        $analysis = $this->skillImportAnalyzer->analyze($content);
        $errors = $analysis['errors'];
        $warnings = $analysis['warnings'];

        $io->definitionList(
            ['Mode' => $apply ? 'apply persistence' : 'dry-run analysis'],
            ['Skill groups detected' => (string) $analysis['skillGroups']],
            ['Skills detected' => (string) $analysis['skills']],
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

        $document = $this->skillImportAnalyzer->decodeDocument($content);
        if (null === $document) {
            $io->error('Could not decode YAML/JSON for apply mode.');
            return Command::FAILURE;
        }

        $importStats = $this->skillImporter->import($document, dryRun: false);

        $allWarnings = array_merge($warnings, $importStats['warnings']);
        if ([] !== $allWarnings) {
            $io->section('Import warnings');
            foreach ($allWarnings as $warning) {
                $io->writeln(sprintf('- %s', $warning));
            }
        }

        $io->section('Persistence summary');
        $io->definitionList(
            ['Skill groups created' => (string) $importStats['skillGroupsCreated']],
            ['Skill groups updated' => (string) $importStats['skillGroupsUpdated']],
            ['Skills created' => (string) $importStats['skillsCreated']],
            ['Skills updated' => (string) $importStats['skillsUpdated']],
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

