<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250619123904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enfant_inscription DROP nom_parent1, DROP code_postal_parent1, DROP telephone_parent1, CHANGE prenom_parent1 prenom_parent1 VARCHAR(150) NOT NULL, CHANGE email_parent1 email_parent1 VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enfant_inscription ADD nom_parent1 VARCHAR(100) NOT NULL, ADD code_postal_parent1 VARCHAR(10) NOT NULL, ADD telephone_parent1 VARCHAR(20) NOT NULL, CHANGE prenom_parent1 prenom_parent1 VARCHAR(100) NOT NULL, CHANGE email_parent1 email_parent1 VARCHAR(150) NOT NULL');
    }
}
