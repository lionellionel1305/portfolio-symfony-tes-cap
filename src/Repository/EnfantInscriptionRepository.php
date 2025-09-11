<?php

namespace App\Repository;

use App\Entity\EnfantInscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EnfantInscription>
 *
 * @method EnfantInscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnfantInscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnfantInscription[]    findAll()
 * @method EnfantInscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnfantInscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnfantInscription::class);
    }

    /**
     * Exemple : Trouver les inscriptions par prénom d’enfant
     */
    public function findByPrenomEnfant(string $prenom): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.prenomEnfant = :prenom')
            ->setParameter('prenom', $prenom)
            ->orderBy('e.nomEnfant', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Ajoutez ici vos autres méthodes personnalisées au besoin
}
