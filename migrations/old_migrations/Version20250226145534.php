<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226145534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lycee DROP description1, DROP description2, DROP description3, DROP description4, DROP description5');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lycee ADD description1 LONGTEXT DEFAULT NULL, ADD description2 LONGTEXT DEFAULT NULL, ADD description3 LONGTEXT DEFAULT NULL, ADD description4 LONGTEXT DEFAULT NULL, ADD description5 LONGTEXT DEFAULT NULL');
    }
}
