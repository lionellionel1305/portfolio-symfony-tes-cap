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

class CollegeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/collège', name: 'app_college')]
    public function college(EntityManagerInterface $em): Response
    {
        $college = $em->getRepository(Primaire::class)->find(1);

        if (!$college) {
            return $this->render('college/college.html.twig', [
                'description' => 'Aucune description disponible.',
            ]);
        }
        $form = $this->createForm(PrimaireType::class, $college)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);
            // ->add('description1', TextareaType::class, [
            //     'label' => 'description 1',
            //     'attr' => ['rows' => 10, 'class' => 'form-control'],
            //     'required' => false,
            // ])
            // ->add('description2', TextareaType::class, [
            //     'label' => 'description 2',
            //     'attr' => ['rows' => 10, 'class' => 'form-control'],
            //     'required' => false,
            // ])
            // ->add('description3', TextareaType::class, [
            //     'label' => 'description 3',
            //     'attr' => ['rows' => 10, 'class' => 'form-control'],
            //     'required' => false,
            // ])
            // ->add('description4', TextareaType::class, [
            //     'label' => 'description 4',
            //     'attr' => ['rows' => 10, 'class' => 'form-control'],
            //     'required' => false,
            // ])
            // ->add('description5', TextareaType::class, [
            //     'label' => 'description 5',
            //     'attr' => ['rows' => 10, 'class' => 'form-control'],
            //     'required' => false,
            // ]);

        return $this->render('college/college.html.twig', [
            'college' => $college,
            'editableTitle'=>$college->getEditableTitle(),
            'description' => $college->getDescription(),
            // 'description2' => $college->getDescription2(),
            // 'description3' => $college->getDescription3(),
            // 'description4' => $college->getDescription4(),
            // 'description5' => $college->getDescription5(),
            'form' => $form->createView(),
        ]);
    }
}

