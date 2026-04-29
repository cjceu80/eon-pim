<?php

namespace App\Service;

use App\Security\FrontendUser;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Pimcore\Model\DataObject\FrontendUserProfile;

class FrontendUserEntityResolver
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    public function resolveCurrentUserEntityId(): ?int
    {
        return $this->resolveEntityIdForUser($this->security->getUser());
    }

    public function requireCurrentUserEntityId(): int
    {
        $entityId = $this->resolveCurrentUserEntityId();
        if (null === $entityId) {
            throw new \LogicException('No frontend user entity found for the current user.');
        }

        return $entityId;
    }

    public function resolveEntityIdForUser(?UserInterface $user): ?int
    {
        if (!$user instanceof FrontendUser) {
            return null;
        }

        $profile = FrontendUserProfile::getByFrontendUserId((float) $user->getId(), 1);
        if (!$profile instanceof FrontendUserProfile) {
            return null;
        }

        return $profile->getId();
    }
}
