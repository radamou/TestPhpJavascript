<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\PostgreSQL100Platform;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration Version20230209104049.
 */
class Version20230209104049 extends AbstractMigration
{
    /**
     * Description migration.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return 'Add Unique constraints';
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

        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64976F5C865 ON "user" (google_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6499BE8FD98 ON "user" (facebook_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497BA2F5EB ON "user" (api_token)');

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
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX UNIQ_8D93D64976F5C865');
        $this->addSql('DROP INDEX UNIQ_8D93D6499BE8FD98');
        $this->addSql('DROP INDEX UNIQ_8D93D6497BA2F5EB');

        if ($_ENV['APP_ENV'] === 'test') {
            return;
        }
    }
}
