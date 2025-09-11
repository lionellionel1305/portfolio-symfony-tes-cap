<?php
namespace App\Service;

use App\Entity\Dys;


use App\Entity\Tsa;
use Doctrine\ORM\EntityManagerInterface;

class DysDataFusionService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function migrateData(): void
    {

        $tsaRepository = $this->entityManager->getRepository(Tsa::class);
        $tsas = $tsaRepository->findAll();

        foreach ($tsas as $tsa) {
            $dys = new Dys();

            // Transférer les données
            $dys->setDescription($tsa->getDescription());
            $dys->setEditableTitle($tsa->getEditableTitle());

            $this->entityManager->persist($dys);
        }


        $this->entityManager->flush();
    }
}
