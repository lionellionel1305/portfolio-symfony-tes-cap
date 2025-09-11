<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605080207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enfant_inscription (id INT AUTO_INCREMENT NOT NULL, nom_enfant VARCHAR(100) NOT NULL, prenom_enfant VARCHAR(100) NOT NULL, date_naissance DATE NOT NULL, genre VARCHAR(10) NOT NULL, classe VARCHAR(100) NOT NULL, etablissement VARCHAR(150) NOT NULL, nouvelle_inscription TINYINT(1) NOT NULL, reinscription TINYINT(1) NOT NULL, ancien_accompagnement VARCHAR(150) DEFAULT NULL, nom_parent1 VARCHAR(100) NOT NULL, prenom_parent1 VARCHAR(100) NOT NULL, adresse_parent1 VARCHAR(150) NOT NULL, code_postal_parent1 VARCHAR(10) NOT NULL, ville_parent1 VARCHAR(100) NOT NULL, profession_parent1 VARCHAR(100) NOT NULL, telephone_parent1 VARCHAR(20) NOT NULL, email_parent1 VARCHAR(150) NOT NULL, nom_parent2 VARCHAR(100) DEFAULT NULL, prenom_parent2 VARCHAR(100) DEFAULT NULL, adresse_parent2 VARCHAR(150) DEFAULT NULL, code_postal_parent2 VARCHAR(10) DEFAULT NULL, ville_parent2 VARCHAR(100) DEFAULT NULL, profession_parent2 VARCHAR(100) DEFAULT NULL, telephone_parent2 VARCHAR(20) DEFAULT NULL, email_parent2 VARCHAR(150) DEFAULT NULL, matieres_souhaitees JSON NOT NULL COMMENT \'(DC2Type:json)\', diagnostic_etabli TINYINT(1) NOT NULL, accepte_activites_culturelles TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE enfant_inscription');
    }
}
