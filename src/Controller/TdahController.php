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


class TdahController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/dys/Tdah', name: 'app_dys_tdah')]
    public function tdah(EntityManagerInterface $em): Response
    {
        $typeDys = 'Tdah';
        $tdahs = $em->getRepository(Dys::class)->findBy(['typeDys' => $typeDys]);

        if (empty($tdahs)) {
            return $this->render('Tous_les_Dys/tdah/tdah.html.twig', [
                'tdahs' => [],
                'message' => 'Aucune entrée trouvée pour tdah.',
            ]);
        }

        // Générer les formulaires pour chaque dyscalculie
        $forms = [];
        foreach ($tdahs as $tdah) {
            $forms[] = $this->createFormBuilder($tdah)
                ->add('description', TextareaType::class, [
                    'label' => 'Description  tdah',
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
        return $this->render('Tous_les_Dys/tdah/tdah.html.twig', [
            'tdahs' => $tdahs,
            'forms' => $forms,
        ]);
    }
    #[Route('/dys/TDAH/edit', name: 'app_tdah_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $typeDys = 'Tdah';
        $tdah = $em->getRepository(Dys::class)->findOneBy(['typeDys' => $typeDys]);

        if (!$tdah) {
            $tdah = new Dys();
            $tdah->setTypeDys($typeDys);
        }
        $form = $this->createForm(DysType::class, $tdah)

            ->add('description', TextareaType::class, [
                'label' => 'Description tdah',
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
            $this->entityManager->persist($tdah);
            $this->entityManager->flush();

            // Redirige vers la route de liste des dyscalculies ou une autre page
            return $this->redirectToRoute('app_dys_tdah');
        }

        // Retourne le rendu de la vue avec le formulaire
        return $this->render('Tous_les_Dys/tdah/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}