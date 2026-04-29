<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:frontend-user:delete',
    description: 'Delete a frontend user account by ID or email.',
)]
class FrontendUserDeleteCommand extends Command
{
    public function __construct(
        private readonly Connection $connection,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('id', null, InputOption::VALUE_OPTIONAL, 'Frontend user ID')
            ->addOption('email', null, InputOption::VALUE_OPTIONAL, 'Frontend user email')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Delete without interactive confirmation');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $idOption = $input->getOption('id');
        $emailOption = $input->getOption('email');
        $force = (bool) $input->getOption('force');

        if ((null === $idOption && null === $emailOption) || (null !== $idOption && null !== $emailOption)) {
            $io->error('Provide exactly one of --id or --email.');

            return Command::INVALID;
        }

        $qb = $this->connection->createQueryBuilder()
            ->select('id', 'email', 'is_active')
            ->from('frontend_users')
            ->setMaxResults(1);

        if (null !== $idOption) {
            $userId = (int) $idOption;
            if ($userId <= 0) {
                $io->error('The --id value must be a positive integer.');

                return Command::INVALID;
            }

            $qb->where('id = :id')
                ->setParameter('id', $userId);
        } else {
            $email = mb_strtolower(trim((string) $emailOption));
            if ('' === $email) {
                $io->error('The --email value must not be empty.');

                return Command::INVALID;
            }

            $qb->where('email = :email')
                ->setParameter('email', $email);
        }

        $row = $qb->executeQuery()->fetchAssociative();
        if (!$row) {
            $io->warning('No frontend user found for the provided selector.');

            return Command::FAILURE;
        }

        $frontendUserId = (int) $row['id'];
        $frontendUserEmail = (string) $row['email'];

        $io->definitionList(
            ['ID' => $frontendUserId],
            ['Email' => $frontendUserEmail],
            ['Active' => (bool) $row['is_active'] ? 'yes' : 'no'],
        );

        if (!$force && !$io->confirm('Delete this frontend user?', false)) {
            $io->text('Aborted.');

            return Command::SUCCESS;
        }

        $deletedRows = $this->connection->delete('frontend_users', ['id' => $frontendUserId]);
        if ($deletedRows < 1) {
            $io->error('Delete failed; no rows were removed.');

            return Command::FAILURE;
        }

        $io->success(sprintf(
            'Deleted frontend user %d (%s). Related frontend_user_entities row is removed automatically by FK cascade.',
            $frontendUserId,
            $frontendUserEmail
        ));

        return Command::SUCCESS;
    }
}
