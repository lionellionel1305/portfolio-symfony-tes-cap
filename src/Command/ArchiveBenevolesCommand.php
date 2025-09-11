<?php
namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\DBAL\Connection;
use App\Entity\Benevoles;

class ArchiveBenevolesCommand extends Command
{
    protected static $defaultName = 'app:archive:benevoles';

    private EntityManagerInterface $entityManager;
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connection = $entityManager->getConnection();

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Archive les bénévoles dans une table dédiée à l\'année en cours et vide la table benevoles.');

        $this->addArgument('annee', InputArgument::OPTIONAL, 'Année pour l\'archivage', date('Y'));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Récupérer l'année en cours
        $year = $input->getArgument('annee');
        $archiveTableName = 'benevolesArchive_' . $year;

        // Vérifier l'existence de la table
        $schemaManager = $this->connection->createSchemaManager();
        $tables = $schemaManager->listTableNames();

        if (in_array($archiveTableName, $tables)) {
            $output->writeln("La table d'archive $archiveTableName existe déjà.");
        } else {
            // Si la table d'archive n'existe pas, la créer
            $this->createArchiveTable($archiveTableName);
            $output->writeln("Table d'archive $archiveTableName créée.");
        }

        // Récupérer tous les bénévoles de la table principale
        $benevolesRepo = $this->entityManager->getRepository(Benevoles::class);
        $benevoles = $benevolesRepo->findAll();

        if (empty($benevoles)) {
            $output->writeln('Aucun bénévole à archiver.');
            return Command::SUCCESS;
        }

        // Début de la transaction
        $this->connection->beginTransaction();

        try {
            // Copier chaque bénévole dans la table d'archive
            foreach ($benevoles as $benevole) {
                $this->insertIntoArchiveTable($benevole, $archiveTableName);
            }

            // Vider la table benevoles après archivage
            $this->entityManager->createQuery('DELETE FROM App\Entity\Benevoles')->execute();

            // Commit de la transaction
            $this->connection->commit();

            $output->writeln("Les bénévoles ont été archivés et la table benevoles a été vidée.");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            $this->connection->rollBack();

            $output->writeln('Erreur lors de l\'archivage : ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function createArchiveTable(string $tableName): void
    {
        // Créer une nouvelle table d'archive en copiant la structure de la table `benevoles`
        $sql = "CREATE TABLE $tableName LIKE benevoles";
        $this->connection->executeStatement($sql);
    }

    private function insertIntoArchiveTable(Benevoles $benevole, string $tableName): void
    {
        // Insérer chaque bénévole dans la table d'archive
        $sql = "INSERT INTO $tableName (
            nom, prenom, age, sexe, enfant_suivie, telephone, 
            adresse, ville, code_postal, secteur, email, 
            casier_judiciaire, created_at
        ) VALUES (
            :nom, :prenom, :age, :sexe, :enfant_suivie, :telephone, 
            :adresse, :ville, :code_postal, :secteur, :email, 
            :casier_judiciaire, :created_at
        )";

        $createdAt = $benevole->getCreatedAt() ?? new \DateTime();

        $this->connection->executeStatement($sql, [
            'nom' => $benevole->getNom(),
            'prenom' => $benevole->getPrenom(),
            'age' => $benevole->getAge(),
            'sexe' => $benevole->getSexe(),
            'enfant_suivie' => $benevole->getEnfantSuivie(),
            'telephone' => $benevole->getTelephone(),
            'adresse' => $benevole->getAdresse(),
            'ville' => $benevole->getVille(),
            'code_postal' => $benevole->getCodePostal(),
            'secteur' => $benevole->getSecteur(),
            'email' => $benevole->getEmail(),
            'casier_judiciaire' => $benevole->getCasierJudiciaire(),
            'created_at' => $createdAt->format('Y-m-d H:i:s')
        ]);
    }
}