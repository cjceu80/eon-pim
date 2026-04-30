<?php

namespace App\Controller;

use App\Service\WorldEntityResolver;
use Pimcore\Model\DataObject\FrontendUserProfile;
use Pimcore\Model\DataObject\GameWorld;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WorldEntityDebugController extends AbstractController
{
    #[Route('/debug/world-entities/{gameWorldRef}', name: 'debug_world_entities', methods: ['GET'])]
    #[Route('/account/debug/world-entities/{gameWorldRef}', name: 'account_debug_world_entities', methods: ['GET'])]
    public function resolve(string $gameWorldRef, WorldEntityResolver $worldEntityResolver): Response
    {
        $this->denyAccessUnlessGranted('ROLE_FRONTEND_USER');

        $gameWorld = $this->resolveGameWorld($gameWorldRef);
        if (!$gameWorld instanceof GameWorld) {
            return $this->json(['error' => 'GameWorld not found.'], Response::HTTP_NOT_FOUND);
        }

        $currentUserProfileId = $this->resolveCurrentFrontendUserProfileId();
        if (null === $currentUserProfileId) {
            return $this->json(['error' => 'No frontend profile available for current user.'], Response::HTTP_FORBIDDEN);
        }

        $owner = $gameWorld->getOwner();
        if (!$owner instanceof FrontendUserProfile || $owner->getId() !== $currentUserProfileId) {
            return $this->json(['error' => 'You are not allowed to inspect this GameWorld.'], Response::HTTP_FORBIDDEN);
        }

        $resolved = $worldEntityResolver->resolveForGameWorld($gameWorld);
        $payload = array_map(fn (array $entry): array => $this->normalizeResolvedEntry($entry), $resolved);

        return new JsonResponse([
            'gameWorldId' => $gameWorld->getId(),
            'gameWorldRef' => $gameWorldRef,
            'count' => count($payload),
            'items' => $payload,
        ]);
    }

    private function resolveGameWorld(string $gameWorldRef): ?GameWorld
    {
        if (ctype_digit($gameWorldRef)) {
            $byId = GameWorld::getById((int) $gameWorldRef);
            if ($byId instanceof GameWorld) {
                return $byId;
            }
        }

        $byExternalId = GameWorld::getByExternalId($gameWorldRef, 1);
        if ($byExternalId instanceof GameWorld) {
            return $byExternalId;
        }

        return null;
    }

    private function resolveCurrentFrontendUserProfileId(): ?int
    {
        $user = $this->getUser();
        if (!method_exists($user, 'getId')) {
            return null;
        }

        $frontendUserId = (int) $user->getId();
        if ($frontendUserId <= 0) {
            return null;
        }

        $profile = FrontendUserProfile::getByFrontendUserId((float) $frontendUserId, 1);
        if (!$profile instanceof FrontendUserProfile) {
            return null;
        }

        return $profile->getId();
    }

    /**
     * @param array{
     *   effectiveId: string,
     *   source: string,
     *   entityType: ?string,
     *   name: ?string,
     *   summary: ?string,
     *   sortOrder: ?int,
     *   tags: array<int, \Pimcore\Model\DataObject\Tag>,
     *   payload: ?\Pimcore\Model\DataObject\Objectbrick,
     *   template: ?\Pimcore\Model\DataObject\WorldEntityTemplate,
     *   override: ?\Pimcore\Model\DataObject\WorldEntityOverride
     * } $entry
     */
    private function normalizeResolvedEntry(array $entry): array
    {
        return [
            'effectiveId' => $entry['effectiveId'],
            'source' => $entry['source'],
            'entityType' => $entry['entityType'],
            'name' => $entry['name'],
            'summary' => $entry['summary'],
            'sortOrder' => $entry['sortOrder'],
            'tagIds' => array_map(static fn ($tag): int => $tag->getId(), $entry['tags']),
            'templateId' => $entry['template']?->getId(),
            'overrideId' => $entry['override']?->getId(),
            'payloadBrick' => $this->detectPayloadBrick($entry['payload']),
        ];
    }

    private function detectPayloadBrick(?\Pimcore\Model\DataObject\Objectbrick $payload): ?string
    {
        if (null === $payload) {
            return null;
        }

        if (null !== $payload->getEntityFactionBrick()) {
            return 'EntityFactionBrick';
        }

        if (null !== $payload->getEntityLocationBrick()) {
            return 'EntityLocationBrick';
        }

        if (null !== $payload->getEntityNpcBrick()) {
            return 'EntityNpcBrick';
        }

        return null;
    }
}
