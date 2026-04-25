<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FrontendUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @param string[] $roles
     */
    public function __construct(
        private readonly int $id,
        private readonly string $email,
        private readonly string $password,
        private readonly array $roles = ['ROLE_FRONTEND_USER'],
        private readonly bool $active = true,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return array_values(array_unique([...$this->roles, 'ROLE_FRONTEND_USER']));
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function eraseCredentials(): void
    {
        // No temporary sensitive data is stored on the user object.
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
