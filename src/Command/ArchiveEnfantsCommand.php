<?php
namespace App\Command;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ArchiveEnfantsCommand extends Command
{
    protected static $defaultName = 'app:archive:enfants';

    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection = $entityManager->getConnection();
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription("Archive les inscriptions d'enfants dans une table enfantarchive_YYYY et vide la table enfant_inscription.");
        $this->addArgument('annee', InputArgument::OPTIONAL, "Année d'archivage", date('Y'));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $year = (string) $input->getArgument('annee');
        $sourceTable = 'enfant_inscription';
        $archiveTable = 'enfantarchive_' . $year;

        $schemaManager = $this->connection->createSchemaManager();
        $existingTables = $schemaManager->listTableNames();

        try {
            if (!in_array($archiveTable, $existingTables, true)) {
                // Crée la table archive avec la même structure
                $this->connection->executeStatement("CREATE TABLE `$archiveTable` LIKE `$sourceTable`");
                $output->writeln("Table d'archive $archiveTable créée.");
            } else {
                $output->writeln("La table d'archive $archiveTable existe déjà.");
            }

            // Vérifier s'il y a des données à archiver
            $count = (int) $this->connection->fetchOne("SELECT COUNT(*) FROM `$sourceTable`");
            if ($count === 0) {
                $output->writeln('Aucune inscription enfant à archiver.');
                return Command::SUCCESS;
            }

            $this->connection->beginTransaction();

            // Copier toutes les lignes (toutes colonnes) vers l'archive
            $this->connection->executeStatement("INSERT INTO `$archiveTable` SELECT * FROM `$sourceTable`");

            // Vider la table source
            $this->connection->executeStatement("TRUNCATE TABLE `$sourceTable`");

            $this->connection->commit();
            $output->writeln("$count inscription(s) enfant archivée(s) dans $archiveTable et table source vidée.");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            if ($this->connection->isTransactionActive()) {
                $this->connection->rollBack();
            }
            $output->writeln('<error>Erreur lors de l\'archivage: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }
}


