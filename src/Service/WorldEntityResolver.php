<?php

namespace App\Service;

use Pimcore\Model\DataObject\FrontendUserProfile;
use Pimcore\Model\DataObject\GameWorld;
use Pimcore\Model\DataObject\Tag;
use Pimcore\Model\DataObject\WorldEntityOverride;
use Pimcore\Model\DataObject\WorldEntityTemplate;
use Pimcore\Model\DataObject\WorldEntityTemplate\Listing as WorldEntityTemplateListing;
use Pimcore\Model\DataObject\WorldEntityOverride\Listing as WorldEntityOverrideListing;
use Pimcore\Model\DataObject\Objectbrick;

class WorldEntityResolver
{
    /**
     * Resolves effective entities for a game world by layering:
     * template base + owner overrides (override/add/remove).
     *
     * @return array<int, array{
     *   effectiveId: string,
     *   source: string,
     *   entityType: ?string,
     *   name: ?string,
     *   summary: ?string,
     *   sortOrder: ?int,
     *   tags: array<int, Tag>,
     *   payload: ?Objectbrick,
     *   template: ?WorldEntityTemplate,
     *   override: ?WorldEntityOverride
     * }>
     */
    public function resolveForGameWorld(GameWorld $gameWorld): array
    {
        $owner = $gameWorld->getOwner();
        if (!$owner instanceof FrontendUserProfile) {
            throw new \LogicException('GameWorld must have an owner to resolve overrides.');
        }

        $gameWorldTemplate = $gameWorld->getTemplateRef();
        if (null === $gameWorldTemplate) {
            return $this->resolveAddsOnly($gameWorld, $owner);
        }

        $templates = $this->loadTemplates($gameWorldTemplate->getId());
        $overrides = $this->loadOverrides($gameWorld->getId(), $owner->getId());

        $templatesById = [];
        $templatesByExternalId = [];
        $effective = [];

        foreach ($templates as $template) {
            $templatesById[$template->getId()] = $template;
            $externalId = $template->getExternalId();
            if (null !== $externalId && '' !== $externalId) {
                $templatesByExternalId[$externalId] = $template;
            }

            if (false === $template->getIsActive()) {
                continue;
            }

            $effective[$template->getId()] = [
                'effectiveId' => sprintf('tpl:%s', (string) $template->getExternalId()),
                'source' => 'template',
                'entityType' => $template->getEntityType(),
                'name' => $template->getName(),
                'summary' => $template->getSummary(),
                'sortOrder' => $template->getSortOrder(),
                'tags' => $template->getTags(),
                'payload' => $template->getPayload(),
                'template' => $template,
                'override' => null,
            ];
        }

        $adds = [];
        foreach ($overrides as $override) {
            if (false === $override->getIsActive()) {
                continue;
            }

            $changeType = (string) $override->getChangeType();
            if ('add' === $changeType) {
                $adds[] = $this->buildAddEntry($override);
                continue;
            }

            $template = $this->resolveTemplateReference($override, $templatesById, $templatesByExternalId);
            if (!$template instanceof WorldEntityTemplate) {
                continue;
            }

            $templateId = $template->getId();
            if ('remove' === $changeType || true === $override->getIsDeletedOverride()) {
                unset($effective[$templateId]);
                continue;
            }

            if ('override' === $changeType && isset($effective[$templateId])) {
                $effective[$templateId] = $this->mergeTemplateWithOverride(
                    $effective[$templateId],
                    $template,
                    $override
                );
            }
        }

        $resolved = [...array_values($effective), ...$adds];
        usort($resolved, static function (array $a, array $b): int {
            $aSort = $a['sortOrder'] ?? PHP_INT_MAX;
            $bSort = $b['sortOrder'] ?? PHP_INT_MAX;
            if ($aSort !== $bSort) {
                return $aSort <=> $bSort;
            }

            return strcmp((string) ($a['name'] ?? ''), (string) ($b['name'] ?? ''));
        });

        return $resolved;
    }

    /**
     * @return WorldEntityTemplate[]
     */
    private function loadTemplates(int $gameWorldTemplateId): array
    {
        $listing = new WorldEntityTemplateListing();
        $listing->setUnpublished(true);
        $listing->setCondition('gameWorldTemplate__id = ?', [$gameWorldTemplateId]);

        return $listing->load();
    }

    /**
     * @return WorldEntityOverride[]
     */
    private function loadOverrides(int $gameWorldId, int $ownerId): array
    {
        $listing = new WorldEntityOverrideListing();
        $listing->setUnpublished(true);
        $listing->setCondition('gameWorld__id = ? AND owner__id = ?', [$gameWorldId, $ownerId]);

        return $listing->load();
    }

    private function buildAddEntry(WorldEntityOverride $override): array
    {
        return [
            'effectiveId' => sprintf('ovr:%d', $override->getId()),
            'source' => 'override_add',
            'entityType' => $override->getEntityType(),
            'name' => $override->getName(),
            'summary' => $override->getSummary(),
            'sortOrder' => null,
            'tags' => $override->getTags(),
            'payload' => $override->getPayload(),
            'template' => null,
            'override' => $override,
        ];
    }

    private function resolveTemplateReference(
        WorldEntityOverride $override,
        array $templatesById,
        array $templatesByExternalId
    ): ?WorldEntityTemplate {
        $templateRef = $override->getTemplateRef();
        if ($templateRef instanceof WorldEntityTemplate) {
            return $templateRef;
        }

        $templateExternalId = $override->getTemplateExternalId();
        if (null !== $templateExternalId && '' !== $templateExternalId) {
            return $templatesByExternalId[$templateExternalId] ?? null;
        }

        return null;
    }

    private function mergeTemplateWithOverride(
        array $current,
        WorldEntityTemplate $template,
        WorldEntityOverride $override
    ): array {
        $name = $override->getName();
        $summary = $override->getSummary();
        $entityType = $override->getEntityType();
        $overrideTags = $override->getTags();
        $overridePayload = $override->getPayload();

        $current['source'] = 'override';
        $current['name'] = (null !== $name && '' !== $name) ? $name : $template->getName();
        $current['summary'] = (null !== $summary && '' !== $summary) ? $summary : $template->getSummary();
        $current['entityType'] = (null !== $entityType && '' !== $entityType) ? $entityType : $template->getEntityType();
        $current['tags'] = [] !== $overrideTags ? $overrideTags : $template->getTags();
        $current['payload'] = $this->hasAnyPayloadBrick($overridePayload) ? $overridePayload : $template->getPayload();
        $current['override'] = $override;

        return $current;
    }

    private function hasAnyPayloadBrick(?Objectbrick $payload): bool
    {
        if (null === $payload) {
            return false;
        }

        return null !== $payload->getEntityFactionBrick()
            || null !== $payload->getEntityLocationBrick()
            || null !== $payload->getEntityNpcBrick();
    }

    /**
     * @return array<int, array{
     *   effectiveId: string,
     *   source: string,
     *   entityType: ?string,
     *   name: ?string,
     *   summary: ?string,
     *   sortOrder: ?int,
     *   tags: array<int, Tag>,
     *   payload: ?Objectbrick,
     *   template: ?WorldEntityTemplate,
     *   override: ?WorldEntityOverride
     * }>
     */
    private function resolveAddsOnly(GameWorld $gameWorld, FrontendUserProfile $owner): array
    {
        $overrides = $this->loadOverrides($gameWorld->getId(), $owner->getId());
        $entries = [];
        foreach ($overrides as $override) {
            if (false === $override->getIsActive()) {
                continue;
            }

            if ('add' !== (string) $override->getChangeType()) {
                continue;
            }

            $entries[] = $this->buildAddEntry($override);
        }

        return $entries;
    }
}
