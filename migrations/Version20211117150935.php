<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117150935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone INT NOT NULL, email VARCHAR(255) NOT NULL, cmd LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_6EEAA67DF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE district (id_district INT AUTO_INCREMENT NOT NULL, nom_district VARCHAR(225) NOT NULL, region INT NOT NULL, PRIMARY KEY(id_district)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emploi (id_emploi INT AUTO_INCREMENT NOT NULL, experience INT NOT NULL, niveau_etude VARCHAR(225) NOT NULL, disponibilite VARCHAR(225) NOT NULL, sexe VARCHAR(225) NOT NULL, date_debut DATETIME NOT NULL, responsabilite VARCHAR(225) NOT NULL, ageMin INT NOT NULL, ageMax INT NOT NULL, nom_emploi VARCHAR(255) NOT NULL, PRIMARY KEY(id_emploi)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) NOT NULL, date_inscription DATE NOT NULL, forme_juridique VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, capital_sociale INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entretien (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, quizz_id INT NOT NULL, date DATE NOT NULL, heure DATETIME NOT NULL, type VARCHAR(255) NOT NULL, begin_at DATETIME NOT NULL, end_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, entreprise_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, nom VARCHAR(30) DEFAULT NULL, organisateur VARCHAR(30) DEFAULT NULL, lieu VARCHAR(30) DEFAULT NULL, date DATE DEFAULT NULL, note INT DEFAULT NULL, totalnote INT NOT NULL, attribution INT NOT NULL, compteur INT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_B26681EC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction_principale (id_fonction INT AUTO_INCREMENT NOT NULL, nom_fonction VARCHAR(225) NOT NULL, PRIMARY KEY(id_fonction)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id_formation INT AUTO_INCREMENT NOT NULL, domaine VARCHAR(225) NOT NULL, duree INT NOT NULL, lieu VARCHAR(225) NOT NULL, PRIMARY KEY(id_formation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) NOT NULL, date_inscription DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (NumOffre INT AUTO_INCREMENT NOT NULL, Date_creation DATE NOT NULL, Date_expiration DATE NOT NULL, Disponibilite INT NOT NULL, Nomoffre VARCHAR(255) NOT NULL, sexe VARCHAR(225) NOT NULL, experience INT NOT NULL, niveau_etude VARCHAR(225) NOT NULL, ageMin INT NOT NULL, ageMax INT NOT NULL, secteur VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, district INT NOT NULL, PRIMARY KEY(NumOffre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, prixtotal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, age INT NOT NULL, date_naissance DATE NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) NOT NULL, date_inscription DATE NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, roles JSON NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(2000) NOT NULL, prix DOUBLE PRECISION NOT NULL, fournisseur VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, image1 VARCHAR(255) NOT NULL, image2 VARCHAR(255) NOT NULL, image3 VARCHAR(255) NOT NULL, image4 VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT NOT NULL, personne_id INT DEFAULT NULL, nationalite VARCHAR(255) NOT NULL, competence VARCHAR(255) NOT NULL, dernier_diplome VARCHAR(255) NOT NULL, date_obtention DATE NOT NULL, dernier_emploi VARCHAR(255) NOT NULL, domaine_activite VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL, description_poste VARCHAR(255) NOT NULL, date_fin DATE NOT NULL, langue VARCHAR(255) NOT NULL, niveau_langue VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, desc_personnelle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E6D6B297A21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (question_id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, option1 VARCHAR(255) NOT NULL, option2 VARCHAR(255) NOT NULL, option3 VARCHAR(255) NOT NULL, option4 VARCHAR(255) NOT NULL, answer VARCHAR(255) NOT NULL, quiz INT NOT NULL, PRIMARY KEY(question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (quizId INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(quizId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id_region INT AUTO_INCREMENT NOT NULL, nom_region VARCHAR(225) NOT NULL, PRIMARY KEY(id_region)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (reponseId INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, userId INT NOT NULL, questionId INT NOT NULL, PRIMARY KEY(reponseId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat (id INT AUTO_INCREMENT NOT NULL, quizId INT NOT NULL, note VARCHAR(255) NOT NULL, userId INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secteur (id_secteur INT AUTO_INCREMENT NOT NULL, nom_secteur VARCHAR(255) NOT NULL, PRIMARY KEY(id_secteur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id_statut INT AUTO_INCREMENT NOT NULL, nom_statut VARCHAR(225) NOT NULL, PRIMARY KEY(id_statut)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_evenement (id INT AUTO_INCREMENT NOT NULL, secteur VARCHAR(30) DEFAULT NULL, description VARCHAR(30) DEFAULT NULL, specialite_cible VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC54C8C93 FOREIGN KEY (type_id) REFERENCES type_evenement (id)');
        $this->addSql('ALTER TABLE profil ADD CONSTRAINT FK_E6D6B297A21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profil DROP FOREIGN KEY FK_E6D6B297A21BD112');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF347EFB');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC54C8C93');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE district');
        $this->addSql('DROP TABLE emploi');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE entretien');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE fonction_principale');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE resultat');
        $this->addSql('DROP TABLE secteur');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE type_evenement');
        $this->addSql('DROP TABLE user');
    }
}
