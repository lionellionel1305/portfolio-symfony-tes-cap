<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Popup;
use App\Entity\Accueil;
use App\Form\AccueilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'accueil_accueil', methods: ['GET', 'POST'])]
    public function show(EntityManagerInterface $em): Response
    {
        // Récupération de la description
        $accueil = $em->getRepository(Accueil::class)->find(1);

        if (!$accueil) {
            $this->addFlash('error', 'Description non trouvée.');
            return $this->redirectToRoute('accueil_accueil');
        }
        $popup = $em->getRepository(Popup::class)->findOneBy(['isActive' => true]);
        return $this->render('accueil/show.html.twig', [
            'accueil' => $accueil,
            'popup' => $popup,   
        ]);
    }

    #[Route('/accueil/edit', name: 'app_accueil_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $accueil = $em->getRepository(Accueil::class)->find(1);

        if (!$accueil) {
            $accueil = new Accueil();
        }


        $form = $this->createForm(AccueilType::class, $accueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($accueil);
            $em->flush();

            $this->addFlash('success', 'Description mise à jour avec succès.');
            return $this->redirectToRoute('accueil_accueil');
        }

        return $this->render('accueil/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(): Response
    {
        return $this->render('contact.html.twig');
    }

    #[Route('/partenaires', name: 'app_partenaires', methods: ['GET', 'POST'])]
    public function partenaires(): Response
    {
        return $this->render('partenaires.html.twig');
    }

    #[Route('/primaire', name: 'app_primaire', methods: ['GET', 'Post'])]
    public function primaire(): Response
    {
        return $this->render('primaire.html.twig');
    }
    #[Route('/college', name: 'app_college', methods: ['GET', 'Post'])]
    public function college(): Response
    {
        return $this->render('college.html.twig');
    }
    #[Route('/lycee', name: 'app_lycee', methods: ['GET', 'Post'])]
    public function lycee(): Response
    {
        return $this->render('lycee.html.twig');
    }
    #[Route('/dys', name: 'app_dys', methods: ['GET', 'Post'])]
    public function dys(): Response
    {
        return $this->render('dys.html.twig');
    }
    #[Route('/famille', name: 'app_famille', methods: ['GET', 'POST'])]
    public function famille(EntityManagerInterface $em): Response
    {
        return $this->render('famille.html.twig');
    }
}

