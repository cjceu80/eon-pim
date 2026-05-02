<?php

namespace App\Service\Race;

/**
 * Resolves stable RaceCategoryTemplate.externalId values from import YAML
 * (explicit externalId, or ruleSet + slug(name) when externalId is omitted).
 */
final class RaceCategoryImportUtil
{
    /**
     * @param array<string, mixed> $category
     */
    public static function resolveCategoryExternalId(string $ruleSetExternalId, array $category): string
    {
        $ext = trim((string) ($category['externalId'] ?? ''));
        if ('' !== $ext) {
            return $ext;
        }

        $name = trim((string) ($category['name'] ?? ''));
        if ('' === $name) {
            throw new \InvalidArgumentException('Category requires externalId or name.');
        }

        return sprintf('%s:%s', trim($ruleSetExternalId), self::slugFromDisplayName($name));
    }

    public static function slugFromDisplayName(string $name): string
    {
        $lower = mb_strtolower(trim($name), 'UTF-8');
        $chars = [
            'å' => 'a', 'ä' => 'a', 'ö' => 'o', 'ü' => 'u', 'é' => 'e', 'è' => 'e', 'ê' => 'e',
            'ë' => 'e', 'û' => 'u', 'ù' => 'u', 'ú' => 'u', 'î' => 'i', 'ï' => 'i', 'í' => 'i',
            'ô' => 'o', 'ó' => 'o', 'á' => 'a', 'à' => 'a', 'ý' => 'y', 'ñ' => 'n', 'ç' => 'c',
            'ð' => 'd', 'þ' => 'th',
        ];
        $s = strtr($lower, $chars);
        $translit = @iconv('UTF-8', 'ASCII//TRANSLIT', $s);
        if (false !== $translit && '' !== $translit) {
            $s = $translit;
        }
        $s = strtolower($s);
        $s = preg_replace('/[^a-z0-9]+/', '-', $s) ?? '';
        $s = trim($s, '-');

        return '' !== $s ? $s : 'category';
    }
}
