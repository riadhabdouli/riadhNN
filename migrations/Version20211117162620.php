<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117162620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE item_panier');
        $this->addSql('ALTER TABLE commande DROP idpanier, CHANGE cmd cmd LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE district ADD region INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD Nomoffre VARCHAR(255) NOT NULL, ADD sexe VARCHAR(225) NOT NULL, ADD experience INT NOT NULL, ADD niveau_etude VARCHAR(225) NOT NULL, ADD ageMin INT NOT NULL, ADD ageMax INT NOT NULL, ADD secteur VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD district INT NOT NULL');
        $this->addSql('ALTER TABLE panier CHANGE prixtotal prixtotal INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27FB88E14F');
        $this->addSql('DROP INDEX IDX_29A5EC27FB88E14F ON produit');
        $this->addSql('ALTER TABLE produit DROP utilisateur_id, CHANGE image image VARCHAR(255) NOT NULL, CHANGE image1 image1 VARCHAR(255) NOT NULL, CHANGE image2 image2 VARCHAR(255) NOT NULL, CHANGE image3 image3 VARCHAR(255) NOT NULL, CHANGE image4 image4 VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT NOT NULL, type VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, dateCreation DATE DEFAULT NULL, dateExpiration DATE DEFAULT NULL, validite INT DEFAULT NULL) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE item_panier (id INT AUTO_INCREMENT NOT NULL, idpanier INT DEFAULT NULL, idproduit INT DEFAULT NULL, quantite INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`, prix DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande ADD idpanier INT DEFAULT NULL, CHANGE cmd cmd LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE district DROP region');
        $this->addSql('ALTER TABLE offre DROP Nomoffre, DROP sexe, DROP experience, DROP niveau_etude, DROP ageMin, DROP ageMax, DROP secteur, DROP description, DROP district');
        $this->addSql('ALTER TABLE panier CHANGE prixtotal prixtotal DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE produit ADD utilisateur_id INT DEFAULT NULL, CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image1 image1 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image2 image2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image3 image3 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image4 image4 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27FB88E14F ON produit (utilisateur_id)');
    }
}
