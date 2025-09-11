<?php

namespace App\Controller;

use App\Entity\PagesFamille;
use App\Form\PagesFamilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesFamilleController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/familles', name: 'app_pages_famille')]
    public function viewPagesFamille(EntityManagerInterface $em): Response
    {
        $pagesFamille = $em->getRepository(PagesFamille::class)->find(1);

        if (!$pagesFamille) {
            return $this->render('pages_famille/view.html.twig', [
                'description' => 'Aucune description disponible.',
            ]);
        }
            $form = $this->createForm(PagesFamilleType::class, $pagesFamille)
            ->add('information1', TextareaType::class, [
                'label' => 'Information 1',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false, // Si vous voulez que ce champ soit facultatif
            ])
            ->add('information2', TextareaType::class, [
                'label' => 'Information 2',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information3', TextareaType::class, [
                'label' => 'Information 3',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information4', TextareaType::class, [
                'label' => 'Information 4',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information5', TextareaType::class, [
                'label' => 'Information 5',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information6', TextareaType::class, [
                'label' => 'Information 6',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information7', TextareaType::class, [
                'label' => 'Information 7',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information8', TextareaType::class, [
                'label' => 'Information 8',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        return $this->render('pages_famille/view.html.twig', [
            'titre' => $pagesFamille->getTitre(),
            'information1' => $pagesFamille->getInformation1(),
            'information2' => $pagesFamille->getInformation2(),
            'information3' => $pagesFamille->getInformation3(),
            'information4' => $pagesFamille->getInformation4(),
            'information5' => $pagesFamille->getInformation5(),
            'information6' => $pagesFamille->getInformation6(),
            'information7' => $pagesFamille->getInformation7(),
            'information8' => $pagesFamille->getInformation8(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('familles/edit', name: 'app_pages_famille_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $pagesFamille = $this->entityManager->getRepository(PagesFamille::class)->find(1);

        if (!$pagesFamille) {
            $pagesFamille = new PagesFamille();
        }

        $form = $this->createForm(PagesFamilleType::class, $pagesFamille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($pagesFamille);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_pages_famille');
        }

        return $this->render('pages_famille/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
