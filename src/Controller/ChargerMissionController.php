<?php

namespace App\Controller;

use App\Entity\ChargerMission;
use App\Form\ChargerMissionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ChargerMissionController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/charger/mission', name: 'app_charger_mission')]
    public function chargerMission(EntityManagerInterface $em): Response
    {
        $chargerMission = $em->getRepository(ChargerMission::class)->find(1);

        if (!$chargerMission) {
            // Instead of redirecting, render a template with a message
            return $this->render('charger_mission/benevol.html.twig', [
                'description' => 'Aucune description disponible.',
            ]);
        }
        $form = $this->createForm(ChargerMissionType::class, $chargerMission)
            ->add('information1', TextareaType::class, [
                'label' => 'Information 1',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false, // Si vous voulez que ce champ soit facultatif
            ])
            ->add('information2', TextareaType::class, [
                'label' => 'Information 2',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information3', TextareaType::class, [
                'label' => 'Information 3',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information4', TextareaType::class, [
                'label' => 'Information 4',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information5', TextareaType::class, [
                'label' => 'Information 5',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information6', TextareaType::class, [
                'label' => 'Information 6',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information7', TextareaType::class, [
                'label' => 'Information 7',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('information8', TextareaType::class, [
                'label' => 'Information 8',
                'attr' => ['rows' => 10, 'class' => 'form-control'],
                'required' => false,
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        return $this->render('charger_mission/benevol.html.twig', [
            'titre' => $chargerMission->getTitre(),
            'information1' => $chargerMission->getInformation1(),
            'information2' => $chargerMission->getInformation2(),
            'information3' => $chargerMission->getInformation3(),
            'information4' => $chargerMission->getInformation4(),
            'information5' => $chargerMission->getInformation5(),
            'information6' => $chargerMission->getInformation6(),
            'information7' => $chargerMission->getInformation7(),
            'information8' => $chargerMission->getInformation8(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/charger/mission/edit', name: 'app_charger_mission_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $chargerMission = $this->entityManager->getRepository(ChargerMission::class)->find(1);

        if (!$chargerMission) {
            $chargerMission = new ChargerMission();
        }
        $form = $this->createForm(ChargerMissionType::class, $chargerMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($chargerMission);
            $this->entityManager->flush();


            return $this->redirectToRoute('app_charger_mission');
        }
        return $this->render('charger_mission/benevol_edit.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
