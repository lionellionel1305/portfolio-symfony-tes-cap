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
class DysorthoController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/dys/dysorthographie', name: 'app_dysorthographie')]
    public function dysorthographie(EntityManagerInterface $em): Response
    {

        $typeDys = 'Dysortho';
        $dysorthos = $em->getRepository(Dys::class)->findBy(['typeDys' => $typeDys]);

        // Si aucun résultat trouvé, retourner une vue avec un message par défaut
        if (empty($dysorthos)) {
            return $this->render('Tous_les_Dys/dysortho/dysorthographie.html.twig', [
                'dysorthos' => [],
                'message' => 'Aucune entrée trouvée pour la dysorthographie.',
            ]);
        }

        // Générer les formulaires pour chaque dyscalculie
        $forms = [];
        foreach ($dysorthos as $dysortho) {
            $forms[] = $this->createFormBuilder($dysortho)
                ->add('description', TextareaType::class, [
                    'label' => 'Description de la dysorthographie',
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
        return $this->render('Tous_les_Dys/dysortho/dysorthographie.html.twig', [
            'dysorthos' => $dysorthos,
            'forms' => $forms,
        ]);
    }
    #[Route('/dys/dysorthographie/edit', name: 'app_dysorthographie_edit')]
    public function edit(Request $request, EntityManagerInterface $em, $id = 1): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $typeDys = 'Dysortho';
        $dysortho = $em->getRepository(Dys::class)->findOneBy(['typeDys' => $typeDys]);

        if (!$dysortho) {
            $dysortho = new Dys();
            $dysortho->setTypeDys($typeDys);
        }
        $form = $this->createForm(DysType::class, $dysortho)

            ->add('description', TextareaType::class, [
                'label' => 'Description de la dysortho',
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
            $this->entityManager->persist($dysortho);
            $this->entityManager->flush();

            // Redirige vers la route de liste des dyscalculies ou une autre page
            return $this->redirectToRoute('app_dysorthographie');
        }

        // Retourne le rendu de la vue avec le formulaire
        return $this->render('Tous_les_Dys/dysortho/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}