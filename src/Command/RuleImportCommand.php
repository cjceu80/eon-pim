<?php

namespace App\Command;

use App\Service\Rule\RuleImportAnalyzer;
use App\Service\Rule\RuleImporter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:rule:import',
    description: 'Analyze/import rule YAML/JSON into RuleTemplate objects (including ruleType calendar).',
)]
class RuleImportCommand extends Command
{
    public function __construct(
        private readonly RuleImportAnalyzer $ruleImportAnalyzer,
        private readonly RuleImporter $ruleImporter,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Path to YAML/JSON file containing one rule envelope or an array of rule envelopes')
            ->addOption('apply', null, InputOption::VALUE_NONE, 'Persist rules to Pimcore DataObjects');
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

        $analysis = $this->ruleImportAnalyzer->analyze($content);
        $errors = $analysis['errors'];
        $warnings = $analysis['warnings'];

        $io->definitionList(
            ['Mode' => $apply ? 'apply persistence' : 'dry-run analysis'],
            ['Rules detected' => (string) $analysis['rules']],
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

        $rules = $this->ruleImportAnalyzer->decodeTopLevelRules($content);
        if (null === $rules) {
            $io->error('Could not decode YAML/JSON for apply mode.');

            return Command::FAILURE;
        }

        $importStats = $this->ruleImporter->import($rules, dryRun: false);
        $io->section('Persistence summary');
        $io->definitionList(
            ['Rules created' => (string) $importStats['rulesCreated']],
            ['Rules updated' => (string) $importStats['rulesUpdated']],
            ['Calendars applied to RuleSetTemplate' => (string) ($importStats['calendarApplied'] ?? 0)],
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
