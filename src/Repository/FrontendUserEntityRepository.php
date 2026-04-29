<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class FrontendUserEntityRepository
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    /**
     * @throws Exception
     */
    public function ensureTableExists(): void
    {
        $this->connection->executeStatement(
            <<<'SQL'
CREATE TABLE IF NOT EXISTS frontend_user_entities (
    id INT AUTO_INCREMENT NOT NULL,
    frontend_user_id BIGINT UNSIGNED NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE INDEX uniq_frontend_user_entities_frontend_user_id (frontend_user_id),
    PRIMARY KEY(id),
    CONSTRAINT fk_frontend_user_entities_frontend_users
        FOREIGN KEY (frontend_user_id) REFERENCES frontend_users (id)
        ON DELETE CASCADE
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
SQL
        );
    }

    /**
     * Ensures a dedicated domain entity exists for this auth user ID.
     *
     * @throws Exception
     */
    public function ensureForAuthUserId(int $frontendUserId): void
    {
        $this->connection->executeStatement(
            <<<'SQL'
INSERT INTO frontend_user_entities (frontend_user_id, created_at, updated_at)
VALUES (:frontend_user_id, NOW(), NOW())
ON DUPLICATE KEY UPDATE
    updated_at = NOW()
SQL,
            [
                'frontend_user_id' => $frontendUserId,
            ]
        );
    }

    public function findEntityIdByAuthUserId(int $frontendUserId): ?int
    {
        $entityId = $this->connection->createQueryBuilder()
            ->select('id')
            ->from('frontend_user_entities')
            ->where('frontend_user_id = :frontendUserId')
            ->setParameter('frontendUserId', $frontendUserId)
            ->setMaxResults(1)
            ->executeQuery()
            ->fetchOne();

        if (false === $entityId) {
            return null;
        }

        return (int) $entityId;
    }
}
