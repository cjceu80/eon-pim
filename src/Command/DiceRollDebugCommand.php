<?php

namespace App\Command;

use App\Service\Dice\DiceNotationParser;
use App\Service\Dice\DiceRoller;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:dice:roll-debug',
    description: 'Parse and roll a dice notation string for debugging.',
)]
class DiceRollDebugCommand extends Command
{
    public function __construct(
        private readonly DiceNotationParser $diceNotationParser,
        private readonly DiceRoller $diceRoller,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('notation', InputArgument::REQUIRED, 'Dice notation, e.g. Ob3T6+2');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $notation = (string) $input->getArgument('notation');

        try {
            $spec = $this->diceNotationParser->parse($notation);
        } catch (\InvalidArgumentException $exception) {
            $io->error($exception->getMessage());

            return Command::INVALID;
        }

        $result = $this->diceRoller->roll($spec);

        $io->definitionList(
            ['Raw notation' => $spec->getNotationRaw()],
            ['Canonical notation' => $spec->getNotationCanonical()],
            ['Dice count' => (string) $spec->getDiceCount()],
            ['Dice sides' => (string) $spec->getDiceSides()],
            ['Modifier' => sprintf('%+d', $spec->getModifier())],
            ['Open ended' => $spec->isOpenEnded() ? 'yes' : 'no'],
        );

        $io->section('Roll result');
        $io->definitionList(
            ['First rolls' => implode(', ', $result->getFirstRolls())],
            ['Resolved dice totals' => implode(', ', $result->getResolvedDiceTotals())],
            ['All rolled values' => implode(', ', $result->getAllRolledValues())],
            ['Per-die breakdown' => $result->getPrintableRollBreakdown()],
            ['Base sum' => (string) $result->getBaseSum()],
            ['Final total' => (string) $result->getFinalTotal()],
            ['Critical' => $result->isCritical() ? 'yes' : 'no'],
            ['Fumble' => $result->isFumble() ? 'yes' : 'no'],
        );

        return Command::SUCCESS;
    }
}
