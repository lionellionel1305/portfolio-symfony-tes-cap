<?php
namespace App\Service;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class ArchiveService

{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getArchiveTableName(int $year = null): string
    {
        $year = $year ?: (new \DateTime())->format('Y');
        return "benevolesarchive_$year";
    }

    public function getArchives(string $tableName): array
    {
        $sql = "SELECT * FROM $tableName";
        return $this->connection->fetchAllAssociative($sql);
    }

    public function searchArchives(string $tableName, string $field, string $search): array
    {
        // Requête sécurisée pour rechercher dans une table d'archives
        $sql = "SELECT * FROM $tableName WHERE $field LIKE :search";
        return $this->connection->fetchAllAssociative($sql, ['search' => '%' . $search . '%']);
    }

    /**
     * @throws Exception
     */
    public function getAvailableArchiveYears(): array
    {
        // Exécution de la requête pour obtenir les tables
        $sql = 'SHOW TABLES LIKE "benevolesarchive\_%"';
        $tables = $this->connection->fetchAllAssociative($sql);

        $years = [];
        foreach ($tables as $table) {
            // Vérification de la structure du tableau pour accéder au nom de la table
            // Le nom de la table peut se trouver sous une autre clé que 'Tables_in_dbname'
            // Inspections de la première ligne pour déterminer la bonne clé
            $firstKey = key($table);
            if (preg_match('/benevolesarchive_(\d{4})/', $table[$firstKey], $matches)) {
                $years[] = (int) $matches[1];
            }
        }

        return $years;
    }
}