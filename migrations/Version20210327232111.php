<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210327232111 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE district (id_district INT AUTO_INCREMENT NOT NULL, nom_district VARCHAR(225) NOT NULL, PRIMARY KEY(id_district)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emploi (id_emploi INT AUTO_INCREMENT NOT NULL, experience INT NOT NULL, niveau_etude VARCHAR(225) NOT NULL, disponibilite VARCHAR(225) NOT NULL, sexe VARCHAR(225) NOT NULL, date_debut DATETIME NOT NULL, responsabilite VARCHAR(225) NOT NULL, ageMin INT NOT NULL, ageMax INT NOT NULL, nom_emploi VARCHAR(255) NOT NULL, PRIMARY KEY(id_emploi)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction_principale (id_fonction INT AUTO_INCREMENT NOT NULL, nom_fonction VARCHAR(225) NOT NULL, PRIMARY KEY(id_fonction)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id_formation INT AUTO_INCREMENT NOT NULL, domaine VARCHAR(225) NOT NULL, duree INT NOT NULL, lieu VARCHAR(225) NOT NULL, PRIMARY KEY(id_formation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (NumOffre INT AUTO_INCREMENT NOT NULL, Date_creation DATE NOT NULL, Date_expiration DATE NOT NULL, Disponibilite INT NOT NULL, PRIMARY KEY(NumOffre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id_region INT AUTO_INCREMENT NOT NULL, nom_region VARCHAR(225) NOT NULL, PRIMARY KEY(id_region)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id_secteur INT AUTO_INCREMENT NOT NULL, nom_secteur VARCHAR(255) NOT NULL, PRIMARY KEY(id_secteur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id_statut INT AUTO_INCREMENT NOT NULL, nom_statut VARCHAR(225) NOT NULL, PRIMARY KEY(id_statut)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE emploi');
        $this->addSql('DROP TABLE fonction_principale');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE statut');
    }
}
