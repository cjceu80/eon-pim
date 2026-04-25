<?php

namespace App\Security;

use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class FrontendUserProvider implements UserProviderInterface
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $row = $this->connection->createQueryBuilder()
            ->select('id', 'email', 'password', 'roles', 'is_active')
            ->from('frontend_users')
            ->where('email = :email')
            ->setParameter('email', mb_strtolower(trim($identifier)))
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchAssociative();

        if (!$row) {
            throw new UserNotFoundException(sprintf('User "%s" was not found.', $identifier));
        }

        if (!(bool) $row['is_active']) {
            throw new UserNotFoundException(sprintf('User "%s" is inactive.', $identifier));
        }

        $roles = json_decode((string) ($row['roles'] ?? '[]'), true);
        if (!is_array($roles)) {
            $roles = [];
        }

        return new FrontendUser(
            (int) $row['id'],
            (string) $row['email'],
            (string) $row['password'],
            $roles,
            (bool) $row['is_active'],
        );
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof FrontendUser) {
            throw new UnsupportedUserException(sprintf('Unsupported user class "%s".', $user::class));
        }

        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return FrontendUser::class === $class;
    }
}
