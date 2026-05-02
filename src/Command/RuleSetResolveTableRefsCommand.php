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
    name: 'app:ruleset:resolve-table-refs',
    description: 'Resolve deferred RuleSetTemplate baseline table refs to relations.',
)]
class RuleSetResolveTableRefsCommand extends Command
{
    public function __construct(
        private readonly RuleSetTemplateInitializer $initializer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('externalId', InputArgument::OPTIONAL, 'Optional RuleSetTemplate externalId to limit resolution')
            ->addOption('apply', null, InputOption::VALUE_NONE, 'Persist resolved relations (otherwise dry-run only)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $externalId = $input->getArgument('externalId');
        $apply = (bool) $input->getOption('apply');

        try {
            $result = $this->initializer->resolvePendingTableRefs(
                ruleSetExternalId: is_string($externalId) ? $externalId : null,
                dryRun: !$apply
            );
        } catch (\Throwable $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        $io->definitionList(
            ['Mode' => $apply ? 'apply persistence' : 'dry-run analysis'],
            ['Resolved relations' => (string) ($result['resolved'] ?? 0)],
            ['Missing table refs' => (string) ($result['missing'] ?? 0)],
        );

        if (!$apply) {
            $io->success('Dry-run complete. Re-run with --apply to persist resolved relations.');

            return Command::SUCCESS;
        }

        $io->success('Deferred table reference resolution complete.');

        return Command::SUCCESS;
    }
}

