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
use Symfony\Component\Yaml\Yaml;

#[AsCommand(
    name: 'app:ruleset:import',
    description: 'Import RuleSetTemplate root/baseline from YAML or JSON.',
)]
class RuleSetImportCommand extends Command
{
    public function __construct(
        private readonly RuleSetTemplateInitializer $initializer,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Path to ruleset YAML/JSON file')
            ->addOption('apply', null, InputOption::VALUE_NONE, 'Persist import (otherwise dry-run only)')
            ->addOption('resolve-table-refs', null, InputOption::VALUE_NONE, 'After import, resolve deferred table refs for this ruleset');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $file = (string) $input->getArgument('file');
        $apply = (bool) $input->getOption('apply');
        $resolveTableRefs = (bool) $input->getOption('resolve-table-refs');

        if (!is_file($file) || !is_readable($file)) {
            $io->error(sprintf('Import file "%s" does not exist or is not readable.', $file));

            return Command::INVALID;
        }

        $content = file_get_contents($file);
        if (false === $content) {
            $io->error(sprintf('Could not read file "%s".', $file));

            return Command::FAILURE;
        }

        $document = $this->decodeDocument($content);
        if (!is_array($document)) {
            $io->error('Import file must decode to a YAML/JSON object.');

            return Command::FAILURE;
        }

        if (!$this->isAssoc($document)) {
            $io->error('RuleSet import file must be an object, not a top-level list.');

            return Command::FAILURE;
        }

        $externalId = $this->readString($document, ['externalId', 'ruleSet']);
        if (null === $externalId) {
            $io->error('ruleset externalId is required (use key externalId or ruleSet).');

            return Command::FAILURE;
        }

        $name = $this->readString($document, ['name']);
        $source = $this->readString($document, ['source']);
        $version = $this->readString($document, ['version']);
        $baseline = RuleSetTemplateInitializer::extractRaceBaselineValues($document);
        $calendarPatch = RuleSetTemplateInitializer::extractCalendarPatch($document);

        try {
            $result = $this->initializer->initialize(
                externalId: $externalId,
                name: $name,
                source: $source,
                version: $version,
                baseline: $baseline,
                calendarPatch: $calendarPatch,
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
            ['Baseline keys' => (string) count($baseline)],
        );

        if ($resolveTableRefs) {
            $resolution = $this->initializer->resolvePendingTableRefs(
                ruleSetExternalId: $externalId,
                dryRun: !$apply
            );
            $io->definitionList(
                ['Resolved table refs' => (string) ($resolution['resolved'] ?? 0)],
                ['Missing table refs' => (string) ($resolution['missing'] ?? 0)],
            );
        }

        if (!$apply) {
            $io->success('Dry-run complete. Re-run with --apply to persist.');

            return Command::SUCCESS;
        }

        $io->success('RuleSet import persisted successfully.');

        return Command::SUCCESS;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function decodeDocument(string $content): ?array
    {
        $decoded = json_decode($content, true);
        if (!is_array($decoded)) {
            try {
                $decoded = Yaml::parse($content);
            } catch (\Throwable) {
                $decoded = null;
            }
        }

        return is_array($decoded) ? $decoded : null;
    }

    /**
     * @param array<string, mixed> $document
     * @param array<int, string> $keys
     */
    private function readString(array $document, array $keys): ?string
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $document) || !is_string($document[$key])) {
                continue;
            }
            $trimmed = trim($document[$key]);
            if ('' !== $trimmed) {
                return $trimmed;
            }
        }

        return null;
    }

    /**
     * @param array<mixed> $array
     */
    private function isAssoc(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}

