<?php

namespace App\Controller;

use App\Entity\Dys;
use App\Entity\Dysphasie;
use App\Form\DysphasieType;
use App\Form\DysType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Dyslexie;
use App\Form\AssociationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class DysphasieController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/dys/dysphasie', name: 'app_dysphasie')]
    public function dysphasie(EntityManagerInterface $em): Response
    {

        // Récupération de la description
        $typeDys = 'Dysphasie';
        $dysphasies = $em->getRepository(Dys::class)->findBy(['typeDys' => $typeDys]);

        // Si aucun résultat trouvé, retourner une vue avec un message par défaut
        if (empty($dysphasies)) {
            return $this->render('Tous_les_Dys/dysphasie/dysphasie.html.twig', [
                'dysphasie' => [],
                'message' => 'Aucune entrée trouvée pour la Dysphasie.',
            ]);
        }

        // Générer les formulaires pour chaque dyscalculie
        $forms = [];
        foreach ($dysphasies as $dysphasie) {
            $forms[] = $this->createFormBuilder($dysphasie)
                ->add('description', TextareaType::class, [
                    'label' => 'Description de la Dysphasie',
                    'attr' => [
                        'rows' => 10,
                        'cols' => 30,
                        'class' => 'form-control'
                    ],
                ])
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }
        return $this->render('Tous_les_Dys/dysphasie/dysphasie.html.twig', [
            'dysphasies' => $dysphasies,
            'forms' => $forms,
        ]);
    }
    #[Route('/dys/dysphasie/edit', name: 'app_dysphasie_edit')]
    public function edit(Request $request, EntityManagerInterface $em, $id = 1): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $typeDys = 'Dysphasie';
        $dyphasie = $em->getRepository(Dys::class)->findOneBy(['typeDys' => $typeDys]);

        if (!$dyphasie) {
            $dyphasie = new Dys();
            $dyphasie->setTypeDys($typeDys);
        }
        $form = $this->createForm(DysType::class, $dyphasie)

            ->add('description', TextareaType::class, [
                'label' => 'Description de la dyphasie',
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
            $this->entityManager->persist($dyphasie);
            $this->entityManager->flush();

            // Redirige vers la route de liste des dyscalculies ou une autre page
            return $this->redirectToRoute('app_dysphasie');
        }

        // Retourne le rendu de la vue avec le formulaire
        return $this->render('Tous_les_Dys/dysphasie/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}