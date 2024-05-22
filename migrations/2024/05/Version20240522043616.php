<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522043616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE topology.topology_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.county_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.state_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.place_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.cousub_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.edges_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.addrfeat_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.faces_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.featnames_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.addr_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.zcta5_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.tract_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.tabblock_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.bg_gid_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.pagc_gaz_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.pagc_lex_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tiger.pagc_rules_id_seq CASCADE');
        $this->addSql('ALTER TABLE mate ALTER status TYPE SMALLINT');
        $this->addSql('ALTER TABLE mate ALTER status SET DEFAULT 1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA tiger_data');
        $this->addSql('CREATE SCHEMA tiger');
        $this->addSql('CREATE SCHEMA topology');
        $this->addSql('CREATE SEQUENCE topology.topology_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.county_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.state_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.place_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.cousub_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.edges_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.addrfeat_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.faces_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.featnames_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.addr_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.zcta5_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.tract_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.tabblock_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.bg_gid_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.pagc_gaz_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.pagc_lex_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tiger.pagc_rules_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE mate ALTER status TYPE INT');
        $this->addSql('ALTER TABLE mate ALTER status DROP DEFAULT');
    }
}
