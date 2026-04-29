<?php

namespace App\Command;

use App\Security\FrontendUser;
use App\Service\FrontendUserProfileService;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:frontend-user:create',
    description: 'Create or update a frontend user account.',
)]
class FrontendUserCreateCommand extends Command
{
    public function __construct(
        private readonly Connection $connection,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly FrontendUserProfileService $frontendUserProfileService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'Plain text password')
            ->addOption('roles', null, InputOption::VALUE_OPTIONAL, 'Comma-separated roles', 'ROLE_FRONTEND_USER');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = mb_strtolower(trim((string) $input->getArgument('email')));
        $plainPassword = (string) $input->getArgument('password');
        $roles = array_values(array_filter(array_map(
            static fn (string $role): string => trim($role),
            explode(',', (string) $input->getOption('roles'))
        )));

        if ([] === $roles) {
            $roles = ['ROLE_FRONTEND_USER'];
        }

        $passwordHash = $this->passwordHasher->hashPassword(
            new FrontendUser(0, $email, '', $roles),
            $plainPassword
        );

        try {
            $this->connection->beginTransaction();
            $this->connection->executeStatement(
                <<<'SQL'
INSERT INTO frontend_users (email, password, roles, is_active, created_at, updated_at)
VALUES (:email, :password, :roles, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    id = LAST_INSERT_ID(id),
    password = VALUES(password),
    roles = VALUES(roles),
    is_active = 1,
    updated_at = NOW()
SQL,
                [
                    'email' => $email,
                    'password' => $passwordHash,
                    'roles' => json_encode($roles, JSON_THROW_ON_ERROR),
                ]
            );
            $frontendUserId = (int) $this->connection->lastInsertId();
            $this->connection->commit();
            $this->frontendUserProfileService->ensureForAuthUserId($frontendUserId, $email);
        } catch (\Throwable $exception) {
            if ($this->connection->isTransactionActive()) {
                $this->connection->rollBack();
            }

            $io->error(sprintf('Could not create frontend user: %s', $exception->getMessage()));

            return Command::FAILURE;
        }

        $io->success(sprintf('Frontend user "%s" is ready.', $email));

        return Command::SUCCESS;
    }
}
