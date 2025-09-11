<?php
namespace App\Command;

use App\Service\DysDataFusionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateDyscalculieToDysCommand extends Command
{
    protected static $defaultName = 'app:migrate-Tsa';
    private DysDataFusionService $migrationService;

    public function __construct(DysDataFusionService $migrationService)
    {
        parent::__construct();
        $this->migrationService = $migrationService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Migrates data from Tsa to Dys.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->migrationService->migrateData();
        $output->writeln('Data migration completed successfully.');

        return Command::SUCCESS;
    }
}
