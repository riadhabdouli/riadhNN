<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331182811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE district ADD region INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD Nomoffre VARCHAR(255) NOT NULL, ADD sexe VARCHAR(225) NOT NULL, ADD experience INT NOT NULL, ADD niveau_etude VARCHAR(225) NOT NULL, ADD ageMin INT NOT NULL, ADD ageMax INT NOT NULL, ADD secteur VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD district INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE district DROP region');
        $this->addSql('ALTER TABLE offre DROP Nomoffre, DROP sexe, DROP experience, DROP niveau_etude, DROP ageMin, DROP ageMax, DROP secteur, DROP description, DROP district');
    }
}
