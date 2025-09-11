<?php

namespace App\Controller;


use App\Entity\Dys;
use App\Form\DysType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class DysController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/dys', name: 'app_dys')]
    public function dys(EntityManagerInterface $em): Response
    {
        $dys = $em->getRepository(Dys::class)->find(1);

        if (!$dys) {
            return $this->render('Tous_les_Dys/dys/dys.html.twig', [
                'description' => 'Aucune description disponible.',
            ]);
        }
        $form = $this->createForm(DysType::class, $dys)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ])
            ->add('description1', TextareaType::class, [
                'label' => 'description 1',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false, // Si vous voulez que ce champ soit facultatif
            ])
            ->add('description2', TextareaType::class, [
                'label' => 'description 2',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('description3', TextareaType::class, [
                'label' => 'description 3',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('description4', TextareaType::class, [
                'label' => 'description 4',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('description5', TextareaType::class, [
                'label' => 'description 5',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ]);

        return $this->render('Tous_les_Dys/dys/dys.html.twig', [
            'dys' => $dys,
            'editableTitle'=>$dys->getEditableTitle(),
            'description1' => $dys->getDescription1(),
            'description2' => $dys->getDescription2(),
            'description3' => $dys->getDescription3(),
            'description4' => $dys->getDescription4(),
            'description5' => $dys->getDescription5(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/dys/edit', name: 'app_dys_edit')]
    #[IsGranted('ROLE_ADMIN')]

    public function edit(Request $request, EntityManagerInterface $em): Response
    {

        $dys = $this->entityManager->getRepository(Dys::class)->find(1);

        if (!$dys) {
            $dys = new Dys();
        }
        $form = $this->createForm(DysType::class, $dys);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($dys);
            $this->entityManager->flush();


            return $this->redirectToRoute('app_dys');
        }
        return $this->render('Tous_les_Dys/dys/edit.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
