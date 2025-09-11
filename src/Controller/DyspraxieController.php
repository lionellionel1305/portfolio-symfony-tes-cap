<?php

namespace App\Controller;

use App\Entity\Dys;
use App\Form\DysType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/tesCap29.fr')]
class DyspraxieController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/dys/dyspraxie', name: 'app_dyspraxie')]
    public function dyspraxie(EntityManagerInterface $em): Response
    {
        $typeDys = 'Dyspraxie';
        $dyspraxies = $em->getRepository(Dys::class)->findBy(['typeDys' => $typeDys]);

// Si aucun résultat trouvé, retourner une vue avec un message par défaut
        if (empty($dyspraxies)) {
            return $this->render('Tous_les_Dys/dyspraxie/dyspraxie.html.twig', [
                'dyspraxies' => [],  // Correction ici
                'message' => 'Aucune entrée trouvée pour la dyspraxie.',
            ]);
        }

        $forms = [];
        foreach ($dyspraxies as $dyspraxie) {
            $forms[] = $this->createFormBuilder($dyspraxie)
                ->add('description', TextareaType::class, [
                    'label' => 'Description de la dyspraxie',
                    'attr' => [
                        'rows' => 10,
                        'cols' => 30,
                        'class' => 'form-control',
                    ],
                ])
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('Tous_les_Dys/dyspraxie/dyspraxie.html.twig', [
            'dyspraxies' => $dyspraxies,  // Correction ici
            'forms' => $forms,
        ]);
    }
    #[Route('/dys/dyspraxie/edit', name: 'app_dyspraxie_edit')]
    public function edit(Request $request, EntityManagerInterface $em, $id = 1): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $typeDys = 'Dyspraxie';
        $dypraxie = $em->getRepository(Dys::class)->findOneBy(['typeDys' => $typeDys]);

        if (!$dypraxie) {
            $dypraxie = new Dys();
            $dypraxie->setTypeDys($typeDys);
        }
        $form = $this->createForm(DysType::class, $dypraxie)

            ->add('description', TextareaType::class, [
                'label' => 'Description de la dypraxie',
                'attr' => [
                    'rows' => 10,
                    'cols' => 10,
                    'class' => 'form-control custom-textarea'
                ]
            ])
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        // Traite la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide, persiste les modifications dans la base de données
            $this->entityManager->persist($dypraxie);
            $this->entityManager->flush();

            // Redirige vers la route de liste des dyscalculies ou une autre page
            return $this->redirectToRoute('app_dyspraxie');
        }

        // Retourne le rendu de la vue avec le formulaire
        return $this->render('Tous_les_Dys/dyspraxie/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}