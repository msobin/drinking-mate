<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240523101654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE mate (id UUID NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, point geometry(POINT, 4326) NOT NULL, status SMALLINT DEFAULT 1 NOT NULL, created_at BIGINT NOT NULL, last_active_at BIGINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D79678F0B7A5F324 ON mate USING GIST(point)');
        $this->addSql('COMMENT ON COLUMN mate.id IS \'(DC2Type:App\\Infrastructure\\Uuid\\UuidType)\'');
        $this->addSql('COMMENT ON COLUMN mate.point IS \'(DC2Type:App\\Infrastructure\\Point\\PointType)\'');
        $this->addSql('CREATE TABLE mate_message (id UUID NOT NULL, to_id UUID NOT NULL, from_id UUID NOT NULL, message VARCHAR(255) NOT NULL, created_at BIGINT NOT NULL, PRIMARY KEY(id, to_id, from_id))');
        $this->addSql('CREATE INDEX IDX_12F30D1330354A65 ON mate_message (to_id)');
        $this->addSql('COMMENT ON COLUMN mate_message.id IS \'(DC2Type:App\\Infrastructure\\Uuid\\UuidType)\'');
        $this->addSql('COMMENT ON COLUMN mate_message.to_id IS \'(DC2Type:App\\Infrastructure\\Uuid\\UuidType)\'');
        $this->addSql('COMMENT ON COLUMN mate_message.from_id IS \'(DC2Type:App\\Infrastructure\\Uuid\\UuidType)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE mate');
        $this->addSql('DROP TABLE mate_message');
    }
}
