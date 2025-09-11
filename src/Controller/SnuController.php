<?php

namespace App\Controller;

use App\Entity\Snu;
use App\Form\SnuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SnuController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/service/snu', name: 'app_service_snu')]
    public function snu(EntityManagerInterface $em): Response
    {


        $snu = $em->getRepository(Snu::class)->find(1);

        if (!$snu) {

            return $this->render('snu/snu.html.twig', [
                'description' => 'Aucune description disponible.',
            ]);
        }
        $form = $this->createFormBuilder($snu)
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description SNU',
                'attr' => ['rows' => 10, 'class' => 'form-control']
            ])
            ->getForm();

        return $this->render('snu/snu.html.twig', [
            'titre' => $snu->getTitre(),
            'description' => $snu->getDescription(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/service/snu/edit', name: 'app_snu_edit')]
    public function edit(Request $request, EntityManagerInterface $em,$id = 1): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $snu = $this->entityManager->getRepository(Snu::class)->find($id);
        if (!$snu) {
            $snu = new Snu();
        }
        $form = $this->createForm(SnuType::class, $snu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($snu);
            $this->entityManager->flush();


            return $this->redirectToRoute( 'app_service_snu');
        }

        return $this->render('snu/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
