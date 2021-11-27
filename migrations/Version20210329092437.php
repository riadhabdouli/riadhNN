<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329092437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, nom VARCHAR(30) DEFAULT NULL, organisateur VARCHAR(30) DEFAULT NULL, lieu VARCHAR(30) DEFAULT NULL, date DATE DEFAULT NULL, note INT DEFAULT NULL, totalnote INT NOT NULL, attribution INT NOT NULL, compteur INT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_B26681EC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_evenement (id INT AUTO_INCREMENT NOT NULL, secteur VARCHAR(30) DEFAULT NULL, description VARCHAR(30) DEFAULT NULL, specialite_cible VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC54C8C93 FOREIGN KEY (type_id) REFERENCES type_evenement (id)');
        $this->addSql('ALTER TABLE profil CHANGE nationalite nationalite VARCHAR(255) NOT NULL, CHANGE competence competence VARCHAR(255) NOT NULL, CHANGE dernier_diplome dernier_diplome VARCHAR(255) NOT NULL, CHANGE date_obtention date_obtention DATE NOT NULL, CHANGE dernier_emploi dernier_emploi VARCHAR(255) NOT NULL, CHANGE domaine_activite domaine_activite VARCHAR(255) NOT NULL, CHANGE poste poste VARCHAR(255) NOT NULL, CHANGE description_poste description_poste VARCHAR(255) NOT NULL, CHANGE date_fin date_fin DATE NOT NULL, CHANGE langue langue VARCHAR(255) NOT NULL, CHANGE niveau_langue niveau_langue VARCHAR(255) NOT NULL, CHANGE pays pays VARCHAR(255) NOT NULL, CHANGE region region VARCHAR(255) NOT NULL, CHANGE ville ville VARCHAR(255) NOT NULL, CHANGE desc_personnelle desc_personnelle VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC54C8C93');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE type_evenement');
        $this->addSql('ALTER TABLE profil CHANGE nationalite nationalite VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE competence competence VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE dernier_diplome dernier_diplome VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_obtention date_obtention DATE DEFAULT NULL, CHANGE dernier_emploi dernier_emploi VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE domaine_activite domaine_activite VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE poste poste VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description_poste description_poste VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE date_fin date_fin DATE DEFAULT NULL, CHANGE langue langue VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE niveau_langue niveau_langue VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pays pays VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE region region VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville ville VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE desc_personnelle desc_personnelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
