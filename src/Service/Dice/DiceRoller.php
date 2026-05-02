<?php

namespace App\Service\Dice;

final class DiceRoller
{
    /**
     * @param callable(int, int): int|null $randomInt Optional random function(min, max).
     */
    public function roll(DiceRollSpec $spec, ?callable $randomInt = null): DiceRollResult
    {
        $rng = $randomInt ?? static fn (int $min, int $max): int => random_int($min, $max);
        $sides = $spec->getDiceSides();
        $count = $spec->getDiceCount();

        $rollChains = [];
        $firstRolls = [];
        $resolvedDiceTotals = [];

        for ($i = 0; $i < $count; ++$i) {
            $chain = [];

            do {
                $roll = (int) $rng(1, $sides);
                $chain[] = $roll;
            } while ($spec->isOpenEnded() && $roll === $sides);

            $rollChains[] = $chain;
            $firstRolls[] = $chain[0];
            $resolvedDiceTotals[] = array_sum($chain);
        }

        $baseSum = array_sum($resolvedDiceTotals);
        $finalTotal = $baseSum + $spec->getModifier();

        return new DiceRollResult(
            spec: $spec,
            rollChains: $rollChains,
            firstRolls: $firstRolls,
            resolvedDiceTotals: $resolvedDiceTotals,
            baseSum: $baseSum,
            finalTotal: $finalTotal,
            critical: $this->isCritical($spec, $firstRolls),
            fumble: $this->isFumble($spec, $firstRolls)
        );
    }

    /**
     * @param array<int, int> $firstRolls
     */
    private function isCritical(DiceRollSpec $spec, array $firstRolls): bool
    {
        if (!$spec->isOpenEnded()) {
            return false;
        }

        if (1 === $spec->getDiceCount()) {
            $threshold = (int) floor($spec->getDiceSides() / 2);

            return isset($firstRolls[0]) && $firstRolls[0] <= $threshold;
        }

        $ones = count(array_filter($firstRolls, static fn (int $value): bool => 1 === $value));

        return $ones >= ($spec->getDiceCount() - 1);
    }

    /**
     * @param array<int, int> $firstRolls
     */
    private function isFumble(DiceRollSpec $spec, array $firstRolls): bool
    {
        if (!$spec->isOpenEnded() || 1 === $spec->getDiceCount()) {
            return false;
        }

        $maxOnFirstRoll = count(array_filter(
            $firstRolls,
            static fn (int $value): bool => $value === $spec->getDiceSides()
        ));

        return $maxOnFirstRoll >= 2;
    }
}
