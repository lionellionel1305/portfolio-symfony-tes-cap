<?php

namespace App\Controller;

use App\Entity\MentionsLegales;
use App\Form\MentionsLegalesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tesCap29.fr')]
class MentionsLegalesController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mentions/legales', name: 'app_mentions_legales')]
    public function MentionsLegal(Request $request): Response
    {
        // Récupérer les mentions légales depuis la base de données
        $MentionsLegales = $this->entityManager->getRepository(MentionsLegales::class)->find(1);

        // Si aucune mention légale n'est trouvée, utilisez un fallback
        if (!$MentionsLegales) {
            return $this->render('mentions_legales/Mentions_Legales.html.twig', [
                'titre' => 'Aucune mention légale disponible',
                'description' => 'Aucune description n’a été trouvée.',
                'form' => null,
            ]);
        }

        // Créer le formulaire lié à l'entité
        $form = $this->createForm(MentionsLegalesType::class, $MentionsLegales);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, enregistrer les modifications
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($MentionsLegales);
            $this->entityManager->flush();

            $this->addFlash('success', 'Les mentions légales ont été mises à jour.');

            return $this->redirectToRoute('app_mentions_legales');
        }

        // Rendre la vue avec les données et le formulaire
        return $this->render('mentions_legales/Mentions_Legales.html.twig', [
            'titre' => $MentionsLegales->getTitre(),
            'titre1' => $MentionsLegales->getTitre1(),
            'description' => $MentionsLegales->getDescription(),
            'description2' => $MentionsLegales->getDescription2(),
            'description3' => $MentionsLegales->getDescription3(),
            'description4' => $MentionsLegales->getDescription4(),
            'description5' => $MentionsLegales->getDescription5(),
            'description6' => $MentionsLegales->getDescription6(),
            'description7' => $MentionsLegales->getDescription7(),
            'description8' => $MentionsLegales->getDescription8(),
            'titre2' => $MentionsLegales->getTitre2(),
            'description9' => $MentionsLegales->getDescription9(),
            'description10' => $MentionsLegales->getDescription10(),
            'description11' => $MentionsLegales->getDescription11(),
            'titre3' => $MentionsLegales->getTitre3(),
            'description12' => $MentionsLegales->getDescription12(),
            'description13' => $MentionsLegales->getDescription13(),
            'description14' => $MentionsLegales->getDescription14(),
            'titre4' => $MentionsLegales->getTitre4(),
            'description15' => $MentionsLegales->getDescription15(),
            'description16' => $MentionsLegales->getDescription16(),
            'titre5' => $MentionsLegales->getTitre5(),
            'description17' => $MentionsLegales->getDescription17(),
            'titre6' => $MentionsLegales->getTitre6(),
            'description18' => $MentionsLegales->getDescription18(),
            'titre7' => $MentionsLegales->getTitre7(),
            'description19' => $MentionsLegales->getDescription19(),
            'description20' => $MentionsLegales->getDescription20(),
            'description21' => $MentionsLegales->getDescription21(),
            'titre8' => $MentionsLegales->getTitre8(),
            'description22' => $MentionsLegales->getDescription22(),
            'titre9' => $MentionsLegales->getTitre9(),
            'description23' => $MentionsLegales->getDescription23(),
            'description24' => $MentionsLegales->getDescription24(),

            'form' => $form->createView(),
        ]);
    }


    #[Route('/mentions/legales/edit', name: 'app_mentions_legales_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
{
    $this->denyAccessUnlessGranted('ROLE_ADMIN');
    $MentionsLegales = $this->entityManager->getRepository(MentionsLegales::class)->find(1);

    if (!$MentionsLegales) {
        $MentionsLegales = new MentionsLegales();
    }
    $form = $this->createForm(MentionsLegalesType::class, $MentionsLegales);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $this->entityManager->persist($MentionsLegales);
        $this->entityManager->flush();


        return $this->redirectToRoute('app_mentions_legales');
    }
    return $this->render('mentions_legales/edit.html.twig', [
        'form' => $form->createView(),

    ]);
}
}