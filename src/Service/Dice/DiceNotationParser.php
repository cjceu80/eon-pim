<?php

namespace App\Service\Dice;

final class DiceNotationParser
{
    /**
     * @var array<int, bool>
     */
    private const ALLOWED_SIDES = [
        1 => true,
        3 => true,
        4 => true,
        6 => true,
        8 => true,
        10 => true,
        12 => true,
        20 => true,
        100 => true,
    ];

    public function parse(string $notation): DiceRollSpec
    {
        $trimmed = trim($notation);
        if ('' === $trimmed) {
            throw new \InvalidArgumentException('Dice notation cannot be empty.');
        }

        // Trivial "manual" tables: single outcome, no real randomness (used e.g. as dice: "1" in YAML).
        if ('1' === $trimmed) {
            return new DiceRollSpec(
                diceCount: 1,
                diceSides: 1,
                modifier: 0,
                openEnded: false,
                notationRaw: '1'
            );
        }

        if (!preg_match('/^(Ob)?([1-9][0-9]*)[dDtT](1|3|4|6|8|10|12|20|100)([+-][0-9]+)?$/', $trimmed, $match)) {
            throw new \InvalidArgumentException(sprintf('Invalid dice notation "%s".', $notation));
        }

        $openEnded = isset($match[1]) && '' !== $match[1];
        $diceCount = (int) $match[2];
        $diceSides = (int) $match[3];
        $modifier = isset($match[4]) ? (int) $match[4] : 0;

        if (!isset(self::ALLOWED_SIDES[$diceSides])) {
            throw new \InvalidArgumentException(sprintf('Dice side "%d" is not supported.', $diceSides));
        }

        return new DiceRollSpec(
            diceCount: $diceCount,
            diceSides: $diceSides,
            modifier: $modifier,
            openEnded: $openEnded,
            notationRaw: $trimmed
        );
    }
}
