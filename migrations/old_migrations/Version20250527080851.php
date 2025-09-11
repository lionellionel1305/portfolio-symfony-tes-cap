<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527080851 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // Ancien code :
        // $this->addSql('ALTER TABLE benevole ADD lu_et_approuve TINYINT(1) NOT NULL, DROP plages_distances');

        // Nouveau code :
        $this->addSql('ALTER TABLE benevole ADD lu_et_approuve TINYINT(1) NOT NULL DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // En cas de rollback
        $this->addSql('ALTER TABLE benevole DROP lu_et_approuve');
    }
}
