<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328131932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profil ADD personne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profil ADD CONSTRAINT FK_E6D6B297A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6D6B297A21BD112 ON profil (personne_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profil DROP FOREIGN KEY FK_E6D6B297A21BD112');
        $this->addSql('DROP INDEX UNIQ_E6D6B297A21BD112 ON profil');
        $this->addSql('ALTER TABLE profil DROP personne_id');
    }
}
