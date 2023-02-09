<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\PostgreSQL100Platform;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration Version20230209100803.
 */
class Version20230209100803 extends AbstractMigration
{
    /**
     * Description migration.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Add Social media authentication fields';
    }

    /**
     * Up migration.
     *
     * @param Schema $schema
     *
     * @return void
     *
     * @throws Exception
     */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof PostgreSQL100Platform,
            "Migration can only be executed safely on '\App\Doctrine\Platform\PostgreSQL100Platform'."
        );

        $this->addSql('ALTER TABLE "user" ADD google_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD facebook_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD api_token VARCHAR(255) NOT NULL');
    }

    /**
     * Down migration.
     *
     * @param Schema $schema
     *
     * @return void
     *
     * @throws Exception
     */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof PostgreSQL100Platform,
            "Migration can only be executed safely on '\App\Doctrine\Platform\PostgreSQL100Platform'."
        );

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP google_id');
        $this->addSql('ALTER TABLE "user" DROP facebook_id');
        $this->addSql('ALTER TABLE "user" DROP api_token');
    }
}
