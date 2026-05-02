<?php

namespace App\Service\Race;

final class RaceEffectiveValueResolver
{
    /**
     * Resolve effective values with precedence race > category > ruleset baseline.
     *
     * @return array<string, mixed>
     */
    public function resolveForRace(object $race): array
    {
        $category = $this->callGetter($race, 'getCategoryTemplate');
        $ruleSet = $this->callGetter($race, 'getRuleSetTemplate');

        return [
            // Existing race-level scalar fields.
            'maleLength' => $this->resolveInt('maleLength', $race, $category, $ruleSet),
            'maleWeight' => $this->resolveInt('maleWeight', $race, $category, $ruleSet),
            'femaleLength' => $this->resolveInt('femaleLength', $race, $category, $ruleSet),
            'femaleWeight' => $this->resolveInt('femaleWeight', $race, $category, $ruleSet),

            // Existing race/category JSON maps (baseline currently optional/no-op).
            'modifiers' => $this->resolveJsonMap('modifierJson', $race, $category, $ruleSet),
            'highCharacteristics' => $this->resolveJsonMap('highCharacteristicsJson', $race, $category, $ruleSet),
            'lowCharacteristics' => $this->resolveJsonMap('lowCharacteristicsJson', $race, $category, $ruleSet),

            // New typed baseline fields with category fallback where available.
            'exhaustionColumnDivisor' => $this->resolveIntWithRuleSetField(
                'exhaustionColumnDivisor',
                'raceBaselineExhaustionColumnDivisor',
                $race,
                $category,
                $ruleSet
            ),
            'backgroundRolls' => $this->resolveFloatWithRuleSetField(
                'backgroundRolls',
                'raceBaselineBackgroundRolls',
                $race,
                $category,
                $ruleSet
            ),
            'movementModification' => $this->resolveInt('movementModification', $race, $category, $ruleSet),
            'numberOfLitters' => $this->resolveStringWithRuleSetField(
                'numberOfLitters',
                'raceBaselineNumberOfLitters',
                $race,
                $category,
                $ruleSet
            ),
            'litterSize' => $this->resolveStringWithRuleSetField(
                'litterSize',
                'raceBaselineLitterSize',
                $race,
                $category,
                $ruleSet
            ),
            'olderSiblingAgeFormula' => $this->resolveStringWithRuleSetField(
                'olderSiblingAgeFormula',
                'raceBaselineOlderSiblingAgeFormula',
                $race,
                $category,
                $ruleSet
            ),
            'youngerSiblingAgeFormula' => $this->resolveStringWithRuleSetField(
                'youngerSiblingAgeFormula',
                'raceBaselineYoungerSiblingAgeFormula',
                $race,
                $category,
                $ruleSet
            ),
            'genderFormula' => $this->resolveStringWithRuleSetField(
                'genderFormula',
                'raceBaselineGenderFormula',
                $race,
                $category,
                $ruleSet
            ),
            'parentAgeFormula' => $this->resolveStringWithRuleSetField(
                'parentAgeFormula',
                'raceBaselineParentAgeFormula',
                $race,
                $category,
                $ruleSet
            ),
            'parentStatusFormula' => $this->resolveStringWithRuleSetField(
                'parentStatusFormula',
                'raceBaselineParentStatusFormula',
                $race,
                $category,
                $ruleSet
            ),
            'parentStatusTableRef' => $this->resolveParentStatusTableRef($category, $ruleSet),
        ];
    }

    private function resolveInt(string $fieldName, object $race, ?object $category, ?object $ruleSet): ?int
    {
        $raceValue = $this->readIntFrom($race, $fieldName);
        if (null !== $raceValue) {
            return $raceValue;
        }

        if (null !== $category) {
            $categoryValue = $this->readIntFrom($category, $fieldName);
            if (null !== $categoryValue) {
                return $categoryValue;
            }
        }

        if (null === $ruleSet) {
            return null;
        }

        $baselineField = sprintf('raceBaseline%s', ucfirst($fieldName));

        return $this->readIntFrom($ruleSet, $baselineField);
    }

    /**
     * @return array<string, mixed>
     */
    private function resolveJsonMap(string $fieldName, object $race, ?object $category, ?object $ruleSet): array
    {
        $raceValue = $this->readJsonMapFrom($race, $fieldName);
        if ([] !== $raceValue) {
            return $raceValue;
        }

        if (null !== $category) {
            $categoryValue = $this->readJsonMapFrom($category, $fieldName);
            if ([] !== $categoryValue) {
                return $categoryValue;
            }
        }

        if (null === $ruleSet) {
            return [];
        }

        // No baseline map fields are defined yet in RuleSetTemplate.
        return [];
    }

    private function readIntFrom(object $source, string $fieldName): ?int
    {
        $value = $this->callGetter($source, sprintf('get%s', ucfirst($fieldName)));
        if (is_int($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    private function readJsonMapFrom(object $source, string $fieldName): array
    {
        $value = $this->callGetter($source, sprintf('get%s', ucfirst($fieldName)));
        if (!is_string($value) || '' === trim($value)) {
            return [];
        }

        $decoded = json_decode($value, true);
        if (!is_array($decoded)) {
            return [];
        }

        return $decoded;
    }

    private function resolveIntWithRuleSetField(
        string $fieldName,
        string $ruleSetBaselineField,
        object $race,
        ?object $category,
        ?object $ruleSet
    ): ?int
    {
        $raceValue = $this->readIntFrom($race, $fieldName);
        if (null !== $raceValue) {
            return $raceValue;
        }

        if (null !== $category) {
            $categoryValue = $this->readIntFrom($category, $fieldName);
            if (null !== $categoryValue) {
                return $categoryValue;
            }
        }

        if (null === $ruleSet) {
            return null;
        }

        return $this->readIntFrom($ruleSet, $ruleSetBaselineField);
    }

    private function resolveFloatWithRuleSetField(
        string $fieldName,
        string $ruleSetBaselineField,
        object $race,
        ?object $category,
        ?object $ruleSet
    ): ?float {
        $raceValue = $this->readFloatFrom($race, $fieldName);
        if (null !== $raceValue) {
            return $raceValue;
        }

        if (null !== $category) {
            $categoryValue = $this->readFloatFrom($category, $fieldName);
            if (null !== $categoryValue) {
                return $categoryValue;
            }
        }

        if (null === $ruleSet) {
            return null;
        }

        return $this->readFloatFrom($ruleSet, $ruleSetBaselineField);
    }

    private function resolveStringWithRuleSetField(
        string $fieldName,
        string $ruleSetBaselineField,
        object $race,
        ?object $category,
        ?object $ruleSet
    ): ?string {
        $raceValue = $this->readStringFrom($race, $fieldName);
        if (null !== $raceValue) {
            return $raceValue;
        }
        if (null !== $category) {
            $categoryValue = $this->readStringFrom($category, $fieldName);
            if (null !== $categoryValue) {
                return $categoryValue;
            }
        }
        if (null === $ruleSet) {
            return null;
        }

        return $this->readStringFrom($ruleSet, $ruleSetBaselineField);
    }

    private function readFloatFrom(?object $source, string $fieldName): ?float
    {
        if (null === $source) {
            return null;
        }
        $value = $this->callGetter($source, sprintf('get%s', ucfirst($fieldName)));
        if (is_float($value) || is_int($value)) {
            return (float) $value;
        }

        return null;
    }

    private function readStringFrom(?object $source, string $fieldName): ?string
    {
        if (null === $source) {
            return null;
        }
        $value = $this->callGetter($source, sprintf('get%s', ucfirst($fieldName)));
        if (!is_string($value)) {
            return null;
        }
        $trimmed = trim($value);

        return '' === $trimmed ? null : $trimmed;
    }

    /**
     * Prefer linked RollTableTemplate.externalId, then stored ref string.
     * Precedence: category > RuleSetTemplate baseline.
     */
    private function resolveParentStatusTableRef(?object $category, ?object $ruleSet): ?string
    {
        if (null !== $category) {
            $fromCategory = $this->resolveParentStatusTableRefFromSource(
                $category,
                'getParentStatusTable',
                'parentStatusTableRef'
            );
            if (null !== $fromCategory) {
                return $fromCategory;
            }
        }

        if (null === $ruleSet) {
            return null;
        }

        return $this->resolveParentStatusTableRefFromSource(
            $ruleSet,
            'getRaceBaselineParentStatusTable',
            'raceBaselineParentStatusTableRef'
        );
    }

    /**
     * @param string $tableGetter Pimcore getter returning linked roll table or null
     * @param string $refFieldName property name for deferred ref string
     */
    private function resolveParentStatusTableRefFromSource(
        object $source,
        string $tableGetter,
        string $refFieldName
    ): ?string {
        $table = $this->callGetter($source, $tableGetter);
        if (is_object($table) && method_exists($table, 'getExternalId')) {
            $externalId = $table->getExternalId();
            if (is_string($externalId) && '' !== trim($externalId)) {
                return trim($externalId);
            }
        }

        return $this->readStringFrom($source, $refFieldName);
    }

    private function callGetter(object $source, string $getter): mixed
    {
        if (!method_exists($source, $getter)) {
            return null;
        }

        return $source->{$getter}();
    }
}

