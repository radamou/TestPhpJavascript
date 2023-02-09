<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Platforms\PostgreSQL100Platform;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration Version20230209153726.
 */
class Version20230209153726 extends AbstractMigration
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

        $this->addSql('ALTER TABLE comment DROP CONSTRAINT fk_9474526cad6c76b5');
        $this->addSql('DROP SEQUENCE comment_notation_id_seq CASCADE');
        $this->addSql('DROP TABLE comment_notation');
        $this->addSql('DROP INDEX idx_9474526cad6c76b5');
        $this->addSql('ALTER TABLE comment RENAME COLUMN comment_notation_id TO notation');

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
        $this->addSql('CREATE SEQUENCE comment_notation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comment_notation (id INT NOT NULL, note INT DEFAULT NULL, uuid UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, archived_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, archived_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_1f2cdf93d17f50a6 ON comment_notation (uuid)');
        $this->addSql('COMMENT ON COLUMN comment_notation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN comment_notation.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN comment_notation.archived_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE comment RENAME COLUMN notation TO comment_notation_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_9474526cad6c76b5 FOREIGN KEY (comment_notation_id) REFERENCES comment_notation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_9474526cad6c76b5 ON comment (comment_notation_id)');

        if ($_ENV['APP_ENV'] === 'test') {
            return;
        }
    }
}
