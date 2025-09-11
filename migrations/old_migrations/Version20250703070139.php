<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250703070139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
{
    // Nettoyer les données JSON existantes en supprimant les crochets et guillemets
    $this->addSql('UPDATE benevole SET matieres_accompagment = REPLACE(REPLACE(REPLACE(matieres_accompagment, \'[\', \'\'), \']\', \'\'), \'"\', \'\')');
    $this->addSql('UPDATE benevole SET niveau_accompagment = REPLACE(REPLACE(REPLACE(niveau_accompagment, \'[\', \'\'), \']\', \'\'), \'"\', \'\')');
    $this->addSql('UPDATE benevole SET plages_distances = REPLACE(REPLACE(REPLACE(plages_distances, \'[\', \'\'), \']\', \'\'), \'"\', \'\')');
    $this->addSql('UPDATE benevole SET connaitretescap = REPLACE(REPLACE(REPLACE(connaitretescap, \'[\', \'\'), \']\', \'\'), \'"\', \'\')');
    
    // Remplacer les virgules par des virgules avec espaces pour un meilleur affichage
    $this->addSql('UPDATE benevole SET matieres_accompagment = REPLACE(matieres_accompagment, \',\', \', \')');
    $this->addSql('UPDATE benevole SET niveau_accompagment = REPLACE(niveau_accompagment, \',\', \', \')');
    $this->addSql('UPDATE benevole SET plages_distances = REPLACE(plages_distances, \',\', \', \')');
    $this->addSql('UPDATE benevole SET connaitretescap = REPLACE(connaitretescap, \',\', \', \')');
}
}
