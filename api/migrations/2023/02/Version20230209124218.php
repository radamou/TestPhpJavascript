<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\PostgreSQL100Platform;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration Version20230209124218.
 */
class Version20230209124218 extends AbstractMigration
{
    /**
     * Description migration.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return '';
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

        $this->addSql('ALTER TABLE address ALTER archived_by DROP NOT NULL');
        $this->addSql('ALTER TABLE article ALTER archived_by DROP NOT NULL');
        $this->addSql('ALTER TABLE comment ALTER archived_by DROP NOT NULL');
        $this->addSql('ALTER TABLE comment_notation ALTER archived_by DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER archived_by DROP NOT NULL');

        if ($_ENV['APP_ENV'] === 'test') {
            return;
        }
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
        $this->addSql('ALTER TABLE address ALTER archived_by SET NOT NULL');
        $this->addSql('ALTER TABLE comment ALTER archived_by SET NOT NULL');
        $this->addSql('ALTER TABLE comment_notation ALTER archived_by SET NOT NULL');
        $this->addSql('ALTER TABLE article ALTER archived_by SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER archived_by SET NOT NULL');

        if ($_ENV['APP_ENV'] === 'test') {
            return;
        }
    }
}
