<?php

namespace App\Command;

use App\Service\Rule\RuleSetTemplateInitializer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:ruleset:init',
    description: 'Initialize/update a RuleSetTemplate root object.',
)]
class RuleSetInitCommand extends Command
{
    public function __construct(
        private readonly RuleSetTemplateInitializer $initializer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('externalId', InputArgument::REQUIRED, 'RuleSetTemplate externalId, e.g. EON')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Display name override (default: externalId)')
            ->addOption('source', null, InputOption::VALUE_REQUIRED, 'Source metadata to set on RuleSetTemplate')
            ->addOption('version', null, InputOption::VALUE_REQUIRED, 'Version metadata to set on RuleSetTemplate')
            ->addOption('race-baseline-exhaustion-column-divisor', null, InputOption::VALUE_REQUIRED, 'Race baseline exhaustion divisor')
            ->addOption('race-baseline-background-rolls', null, InputOption::VALUE_REQUIRED, 'Race baseline background rolls')
            ->addOption('race-baseline-movement-modification', null, InputOption::VALUE_REQUIRED, 'Race baseline movement modification (integer)')
            ->addOption('race-baseline-number-of-litters', null, InputOption::VALUE_REQUIRED, 'Race baseline number of litters formula')
            ->addOption('race-baseline-litter-size', null, InputOption::VALUE_REQUIRED, 'Race baseline litter size formula')
            ->addOption('race-baseline-older-sibling-age-formula', null, InputOption::VALUE_REQUIRED, 'Race baseline older sibling age formula')
            ->addOption('race-baseline-younger-sibling-age-formula', null, InputOption::VALUE_REQUIRED, 'Race baseline younger sibling age formula')
            ->addOption('race-baseline-gender-formula', null, InputOption::VALUE_REQUIRED, 'Race baseline gender formula')
            ->addOption('race-baseline-parent-age-formula', null, InputOption::VALUE_REQUIRED, 'Race baseline parent age formula')
            ->addOption('race-baseline-parent-status-formula', null, InputOption::VALUE_REQUIRED, 'Race baseline parent status formula')
            ->addOption('race-baseline-parent-status-table-ref', null, InputOption::VALUE_REQUIRED, 'Race baseline parent status roll table externalId (deferred relation supported)')
            ->addOption('apply', null, InputOption::VALUE_NONE, 'Persist changes (otherwise dry-run only)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $externalId = (string) $input->getArgument('externalId');
        $name = $input->getOption('name');
        $source = $input->getOption('source');
        $version = $input->getOption('version');
        $apply = (bool) $input->getOption('apply');

        if (!is_string($name) && null !== $name) {
            $io->error('--name must be a string.');

            return Command::INVALID;
        }

        if (!is_string($source) && null !== $source) {
            $io->error('--source must be a string.');

            return Command::INVALID;
        }

        if (!is_string($version) && null !== $version) {
            $io->error('--version must be a string.');

            return Command::INVALID;
        }

        try {
            $baseline = $this->collectBaselineOptions($input);
            $result = $this->initializer->initialize(
                externalId: $externalId,
                name: $name,
                source: $source,
                version: $version,
                baseline: $baseline,
                calendarPatch: [],
                dryRun: !$apply
            );
        } catch (\Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        $io->definitionList(
            ['Mode' => $apply ? 'apply persistence' : 'dry-run analysis'],
            ['Action' => $result['created'] ? 'create RuleSetTemplate' : 'update RuleSetTemplate'],
            ['Target path' => $result['path']],
        );

        if (!$apply) {
            $io->success('Dry-run complete. Re-run with --apply to persist.');

            return Command::SUCCESS;
        }

        $io->success('RuleSetTemplate initialized/updated successfully.');

        return Command::SUCCESS;
    }

    /**
     * @return array<string, mixed>
     */
    private function collectBaselineOptions(InputInterface $input): array
    {
        $baseline = [];

        $intRaw = $input->getOption('race-baseline-exhaustion-column-divisor');
        if (is_string($intRaw) && '' !== trim($intRaw)) {
            $baseline['raceBaselineExhaustionColumnDivisor'] = (int) $intRaw;
        }

        $movementModRaw = $input->getOption('race-baseline-movement-modification');
        if (is_string($movementModRaw) && '' !== trim($movementModRaw)) {
            $baseline['raceBaselineMovementModification'] = (int) $movementModRaw;
        }

        $floatRaw = $input->getOption('race-baseline-background-rolls');
        if (is_string($floatRaw) && '' !== trim($floatRaw)) {
            $baseline['raceBaselineBackgroundRolls'] = (float) $floatRaw;
        }

        $map = [
            'race-baseline-number-of-litters' => 'raceBaselineNumberOfLitters',
            'race-baseline-litter-size' => 'raceBaselineLitterSize',
            'race-baseline-older-sibling-age-formula' => 'raceBaselineOlderSiblingAgeFormula',
            'race-baseline-younger-sibling-age-formula' => 'raceBaselineYoungerSiblingAgeFormula',
            'race-baseline-gender-formula' => 'raceBaselineGenderFormula',
            'race-baseline-parent-age-formula' => 'raceBaselineParentAgeFormula',
            'race-baseline-parent-status-formula' => 'raceBaselineParentStatusFormula',
            'race-baseline-parent-status-table-ref' => 'raceBaselineParentStatusTableRef',
        ];

        foreach ($map as $opt => $key) {
            $value = $input->getOption($opt);
            if (is_string($value) && '' !== trim($value)) {
                $baseline[$key] = trim($value);
            }
        }

        return $baseline;
    }
}

