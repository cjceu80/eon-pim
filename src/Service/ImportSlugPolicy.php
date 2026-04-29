<?php

namespace App\Service;

use Pimcore\Model\DataObject\Listing;
use Pimcore\Model\DataObject\Service;

class ImportSlugPolicy
{
    public function createKeyFromLabel(string $label): string
    {
        $normalized = trim($label);
        if ('' === $normalized) {
            $normalized = 'item';
        }

        return Service::getValidKey($normalized, 'object');
    }

    public function createStableKeyFromExternalId(string $externalId, string $fallbackLabel = 'item'): string
    {
        $normalizedExternalId = trim($externalId);
        if ('' === $normalizedExternalId) {
            return $this->createKeyFromLabel($fallbackLabel);
        }

        return Service::getValidKey($normalizedExternalId, 'object');
    }

    public function ensureUniqueKeyInParent(string $baseKey, int $parentId): string
    {
        $candidate = $this->createKeyFromLabel($baseKey);
        if (!$this->keyExistsInParent($candidate, $parentId)) {
            return $candidate;
        }

        $suffix = 2;
        while (true) {
            $nextCandidate = Service::getValidKey(sprintf('%s-%d', $candidate, $suffix), 'object');
            if (!$this->keyExistsInParent($nextCandidate, $parentId)) {
                return $nextCandidate;
            }

            ++$suffix;
        }
    }

    private function keyExistsInParent(string $key, int $parentId): bool
    {
        $listing = new Listing();
        $listing->setUnpublished(true);
        $listing->setCondition('`key` = ? AND parentId = ?', [$key, $parentId]);
        $listing->setLimit(1);
        $existing = $listing->load();

        return [] !== $existing;
    }
}
