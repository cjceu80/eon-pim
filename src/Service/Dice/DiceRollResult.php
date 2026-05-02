<?php

namespace App\Service\Dice;

final class DiceRollResult
{
    /**
     * @param array<int, array<int, int>> $rollChains
     * @param array<int, int> $firstRolls
     * @param array<int, int> $resolvedDiceTotals
     */
    public function __construct(
        private readonly DiceRollSpec $spec,
        private readonly array $rollChains,
        private readonly array $firstRolls,
        private readonly array $resolvedDiceTotals,
        private readonly int $baseSum,
        private readonly int $finalTotal,
        private readonly bool $critical,
        private readonly bool $fumble,
    ) {
    }

    public function getSpec(): DiceRollSpec
    {
        return $this->spec;
    }

    /**
     * Full per-die roll chains.
     * Example for Ob2D6: [[6, 3], [2]]
     *
     * @return array<int, array<int, int>>
     */
    public function getRollChains(): array
    {
        return $this->rollChains;
    }

    /**
     * First value rolled for each die before any Ob rerolls.
     *
     * @return array<int, int>
     */
    public function getFirstRolls(): array
    {
        return $this->firstRolls;
    }

    /**
     * @return array<int, int>
     */
    public function getResolvedDiceTotals(): array
    {
        return $this->resolvedDiceTotals;
    }

    public function getBaseSum(): int
    {
        return $this->baseSum;
    }

    public function getModifier(): int
    {
        return $this->spec->getModifier();
    }

    public function getFinalTotal(): int
    {
        return $this->finalTotal;
    }

    public function isCritical(): bool
    {
        return $this->critical;
    }

    public function isFumble(): bool
    {
        return $this->fumble;
    }

    /**
     * Flat list of all rolled values in order.
     *
     * @return array<int, int>
     */
    public function getAllRolledValues(): array
    {
        $flat = [];
        foreach ($this->rollChains as $chain) {
            foreach ($chain as $value) {
                $flat[] = $value;
            }
        }

        return $flat;
    }

    /**
     * Example: "Die 1: [6,3], Die 2: [2]".
     */
    public function getPrintableRollBreakdown(): string
    {
        $parts = [];
        foreach ($this->rollChains as $index => $chain) {
            $parts[] = sprintf('Die %d: [%s]', $index + 1, implode(',', $chain));
        }

        return implode(', ', $parts);
    }
}
