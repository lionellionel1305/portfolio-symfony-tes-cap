<?php

namespace App\Controller;

use App\Entity\Primaire;
use App\Form\PrimaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/tesCap29.fr')]

class PrimaireController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/primaire', name: 'app_primaire')]
    public function primaire(EntityManagerInterface $em): Response
    {
        $primaire = $em->getRepository(Primaire::class)->find(1);

        if (!$primaire) {
            return $this->render('primaire/primaire.html.twig', [
                'description' => 'Aucune description disponible.',
            ]);
        }
        $form = $this->createForm(PrimaireType::class, $primaire)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);
            

        return $this->render('primaire/primaire.html.twig', [
            'primaire' => $primaire,
            'editableTitle'=>$primaire->getEditableTitle(),
            
            'form' => $form->createView(),
        ]);
    }
}
