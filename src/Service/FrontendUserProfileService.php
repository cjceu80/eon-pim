<?php

namespace App\Service;

use Pimcore\Model\DataObject\FrontendUserProfile;
use Pimcore\Model\DataObject\Service;

class FrontendUserProfileService
{
    private const PROFILE_FOLDER_PATH = '/FrontendUsers';

    public function __construct(
        private readonly ImportSlugPolicy $importSlugPolicy,
    ) {
    }

    public function ensureForAuthUserId(int $frontendUserId, string $email): FrontendUserProfile
    {
        $existing = FrontendUserProfile::getByFrontendUserId((float) $frontendUserId, 1);
        if ($existing instanceof FrontendUserProfile) {
            return $existing;
        }

        $parentFolder = Service::createFolderByPath(self::PROFILE_FOLDER_PATH);
        $profile = new FrontendUserProfile();
        $profile->setKey(
            $this->importSlugPolicy->createStableKeyFromExternalId(
                sprintf('frontend-user-%d', $frontendUserId),
                $email
            )
        );
        $profile->setParentId($parentFolder->getId());
        $profile->setPublished(true);
        $profile->setFrontendUserId((float) $frontendUserId);
        $profile->setName($this->deriveNameFromEmail($email));
        $profile->save();

        return $profile;
    }

    private function deriveNameFromEmail(string $email): string
    {
        $localPart = trim((string) strstr($email, '@', true));
        if ('' !== $localPart) {
            return $localPart;
        }

        return $email;
    }
}
