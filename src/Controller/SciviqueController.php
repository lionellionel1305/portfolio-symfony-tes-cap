<?php

namespace App\Controller;

use App\Entity\Scivique;
use App\Form\SciviqueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tesCap29.fr')]
class SciviqueController extends AbstractController
{
    #[Route('/service/civique', name: 'app_scivique')]
    public function scivique(EntityManagerInterface $em): Response
    {
        $scivique = $em->getRepository(Scivique::class)->find(1);

        if (!$scivique) {
            return $this->render('service/civique.html.twig', [
                'description' => 'Aucune description disponible.',
            ]);
        }

        $form = $this->createFormBuilder($scivique)
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description Service Civique',
                'attr' => ['rows' => 10, 'class' => 'form-control']
            ])
            ->getForm();

        return $this->render('service/civique.html.twig', [
            'titre' => $scivique->getTitre(),
            'description' => $scivique->getDescription(),
            'form' => $form->createView(), // Correct: Call createView() on the form, not the entity
        ]);
    }
    #[Route('/service/civique/edit', name: 'app_scivique_edit')]
    public function edit(Request $request, EntityManagerInterface $em, int $id =1): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // Récupération ou création de l'entité
        $scivique = $em->getRepository(Scivique::class)->find($id);

        if (!$scivique) {
            $scivique = new Scivique();
        }

        // Formulaire basé sur la classe SciviqueType
        $form = $this->createForm(SciviqueType::class, $scivique);
        $form->handleRequest($request);

        // Gestion du formulaire soumis
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($scivique);
            $em->flush();

            return $this->redirectToRoute('app_scivique');
        }

        return $this->render('service/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


