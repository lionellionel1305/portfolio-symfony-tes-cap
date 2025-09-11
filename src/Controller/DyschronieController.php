<?php

namespace App\Controller;

use App\Entity\Dys;
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

#[Route('/tesCap29.fr')]
class DyschronieController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/dys/dyschronie', name: 'app_dyschronie')]
    public function dyschronie(EntityManagerInterface $em): Response
    {

        $typeDys = 'Dyschronie';
        $dyschronies = $em->getRepository(Dys::class)->findBy(['typeDys' => $typeDys]);

        if (empty($dyschronies)) {
            return $this->render('Tous_les_Dys/dyschronie/dyschronie.html.twig', [
                'dyschronies' => [],
            ]);
        }
        $forms = [];
        foreach ($dyschronies as $dyschronie) {
            $forms[] = $this->createFormBuilder($dyschronie)
                ->add('description', TextareaType::class, [
                    'label' => 'Description de la dyschornie',
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

        return $this->render('Tous_les_Dys/dyschronie/dyschronie.html.twig', [
            'dyschronies' => $dyschronies,
            'form' => $forms,
        ]);
    }

    #[Route('/dys/dyschronie/edit', name: 'app_dyschronie_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $typeDys = 'Dyschronie';
        $dyschronie = $em->getRepository(Dys::class)->findOneBy(['typeDys' => $typeDys]);

        if (!$dyschronie) {
            $dyschronie = new Dys();
            $dyschronie->setTypeDys($typeDys);
        }
        $form = $this->createForm(DysType::class, $dyschronie)

            ->add('description', TextareaType::class, [
                'label' => 'Description de la dyschronie',
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
            $this->entityManager->persist($dyschronie);
            $this->entityManager->flush();

            // Redirige vers la route de liste des dyscalculies ou une autre page
            return $this->redirectToRoute('app_dyschronie');
        }

        // Retourne le rendu de la vue avec le formulaire
        return $this->render('Tous_les_Dys/dyschronie/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}