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
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tesCap29.fr')]
class TsaController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/dys/Tsa', name: 'app_dys_tsa')]
    public function tsa(): Response
    {
        $typeDys = 'Tsa';
        $tsas = $this->entityManager->getRepository(Dys::class)->findBy(['typeDys' => $typeDys]);

        if (empty($tsas)) {
            return $this->render('Tous_les_Dys/tsa/tsa.html.twig', [
                'tsas' => [],
                'message' => 'Aucune entrée trouvée pour tsas.',
            ]);
        }

        // Générer les formulaires pour chaque Tsa
        $forms = [];
        foreach ($tsas as $tsa) {
            $forms[] = $this->createFormBuilder($tsa)
                ->add('description', TextareaType::class, [
                    'label' => 'Description tsas',
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

        return $this->render('Tous_les_Dys/tsa/tsa.html.twig', [
            'tsas' => $tsas,
            'forms' => $forms,
        ]);
    }

    #[Route('/dys/tsa/edit', name: 'app_tsa_edit')]
    public function edit(Request $request,EntityManagerInterface $em ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $typeDys = 'Tsa';
        $tsa = $em->getRepository(Dys::class)->findOneBy(['typeDys' => $typeDys]);

        if (!$tsa) {
            $tsa = new Dys();
            $tsa->setTypeDys($typeDys);
        }
        $form = $this->createForm(DysType::class, $tsa)

            ->add('description', TextareaType::class, [
                'label' => 'Description tsa',
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
            $this->entityManager->persist($tsa);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_dys_tsa');
        }
        return $this->render('Tous_les_Dys/tsa/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}


