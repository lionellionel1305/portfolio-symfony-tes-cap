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


class DyscalculieController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/dys/dyscalculie', name: 'app_dyscalculie')]
    public function dyscalculie(EntityManagerInterface $em): Response
    {

        $typeDys = 'Dyscalculie';
        $dyscalculies = $em->getRepository(Dys::class)->findBy(['typeDys' => $typeDys]);

        // Si aucun résultat trouvé, retourner une vue avec un message par défaut
        if (empty($dyscalculies)) {
            return $this->render('Tous_les_Dys/dyscalculie/dyscalculie.html.twig', [
                'dyscalculies' => [],
                'message' => 'Aucune entrée trouvée pour Dyscalculie.',
            ]);
        }

        // Générer les formulaires pour chaque dyscalculie
        $forms = [];
        foreach ($dyscalculies as $dyscalculie) {
            $forms[] = $this->createFormBuilder($dyscalculie)
                ->add('description', TextareaType::class, [
                    'label' => 'Description de la dyscalculie',
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

        // Renvoyer les données et formulaires à la vue
        return $this->render('Tous_les_Dys/dyscalculie/dyscalculie.html.twig', [
            'dyscalculies' => $dyscalculies,
            'forms' => $forms,
        ]);
    }
    #[Route('/dys/dyscalculie/edit', name: 'app_dyscalculie_edit')]
    public function edit(Request $request, EntityManagerInterface $em, $id = 2): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $typeDys = 'Dyscalculie';
        $dyscalculie = $em->getRepository(Dys::class)->findOneBy(['typeDys' => $typeDys]);

        if (!$dyscalculie) {
            $dyscalculie = new Dys();
            $dyscalculie->setTypeDys($typeDys);
        }
        $form = $this->createForm(DysType::class, $dyscalculie)

        ->add('description', TextareaType::class, [
        'label' => 'Description de la dyscalculie',
        'attr' => [
            'rows' => 10,  // Hauteur en nombre de lignes
            'cols' => 10,  // Largeur en nombre de colonnes (généralement caractères)
            'class' => 'form-control custom-textarea' // Classe CSS personnalisée
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
            $this->entityManager->persist($dyscalculie);
            $this->entityManager->flush();

            // Redirige vers la route de liste des dyscalculies ou une autre page
            return $this->redirectToRoute('app_dyscalculie');
        }

        // Retourne le rendu de la vue avec le formulaire
        return $this->render('Tous_les_Dys/dyscalculie/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}