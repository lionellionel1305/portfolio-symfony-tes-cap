<?php

namespace App\Controller;

use App\Entity\Lycee;
use App\Form\LyceeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class LyceeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/lycee', name: 'app_lycee')]
    public function Lycee(EntityManagerInterface $em): Response
    {
        $Lycee = $em->getRepository(Lycee::class)->find(1);

        if (!$Lycee) {
            return $this->render('lycee/lycee.html.twig', [
                'description' => 'Aucune description disponible.',
            ]);
        }
        $form = $this->createForm(LyceeType::class, $Lycee)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);
           

        return $this->render('lycee/lycee.html.twig', [
            'lycee' => $Lycee,
            'editableTitle'=>$Lycee->getEditableTitle(),
            'form' => $form->createView(),
        ]);
    }
}
