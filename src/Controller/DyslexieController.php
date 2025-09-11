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
class DyslexieController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/dys/dyslexie', name: 'app_dyslexie')]
    public function dyslexie(EntityManagerInterface $em): Response
    {
        $typeDys = 'Dyslexie';
        $dyslexies = $em->getRepository(Dys::class)->findBy(['typeDys' => $typeDys]);

        if (empty($dyslexies)) {
            return $this->render('Tous_les_Dys/dyslexie/dyslexie.html.twig', [
                'dyslexies' => [],
                'message' => 'Aucune entrée trouvée pour la dyslexies.',
            ]);
        }
        $forms = [];
        foreach ($dyslexies as $dyslexie) {
            $forms[] = $this->createFormBuilder($dyslexie)
                ->add('description', TextareaType::class, [
                    'label' => 'Description de la dyslexie',
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

        return $this->render('Tous_les_Dys/dyslexie/dyslexie.html.twig', [
            'dyslexies' => $dyslexies,
            'forms' => $forms,
        ]);
    }
    #[Route('/dys/dyslexie/edit', name: 'app_dyslexie_edit')]
    public function edit(Request $request, EntityManagerInterface $em, $id = 1): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $typeDys = 'Dyslexie';
        $dyslexie = $em->getRepository(Dys::class)->findOneBy(['typeDys' => $typeDys]);

        if (!$dyslexie) {
            $dyslexie = new Dys();
            $dyslexie->setTypeDys($typeDys);
        }
        $form = $this->createForm(DysType::class, $dyslexie)

            ->add('description', TextareaType::class, [
                'label' => 'Description de la dyslexie',
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
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($dyslexie);
            $this->entityManager->flush();


            return $this->redirectToRoute('app_dyslexie');
        }
        return $this->render('Tous_les_Dys/dyscalculie/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
