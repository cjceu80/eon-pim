<?php

namespace App\Service\Dice;

final class DiceRollSpec
{
    /**
     * @param int<1, max> $diceCount
     * @param int<3|4|6|8|10|12|20|100> $diceSides
     */
    public function __construct(
        private readonly int $diceCount,
        private readonly int $diceSides,
        private readonly int $modifier = 0,
        private readonly bool $openEnded = false,
        private readonly string $notationRaw = '',
    ) {
    }

    public function getDiceCount(): int
    {
        return $this->diceCount;
    }

    public function getDiceSides(): int
    {
        return $this->diceSides;
    }

    public function getModifier(): int
    {
        return $this->modifier;
    }

    public function isOpenEnded(): bool
    {
        return $this->openEnded;
    }

    public function getNotationRaw(): string
    {
        return $this->notationRaw;
    }

    public function getNotationCanonical(): string
    {
        $prefix = $this->openEnded ? 'Ob' : '';
        $modifier = sprintf('%+d', $this->modifier);

        return sprintf('%s%dD%d%s', $prefix, $this->diceCount, $this->diceSides, $modifier);
    }
}
