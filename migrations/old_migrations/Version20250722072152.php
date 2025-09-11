<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250722072152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE benevole CHANGE matieres_accompagment matieres_accompagment JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE niveau_accompagment niveau_accompagment JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE connaitretescap connaitretescap JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE plages_distances plages_distances JSON NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE enfant_inscription ADD don_libre DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE benevole CHANGE matieres_accompagment matieres_accompagment LONGTEXT NOT NULL, CHANGE niveau_accompagment niveau_accompagment LONGTEXT NOT NULL, CHANGE connaitretescap connaitretescap LONGTEXT NOT NULL, CHANGE plages_distances plages_distances LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE enfant_inscription DROP don_libre');
    }
}
