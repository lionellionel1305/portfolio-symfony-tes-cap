<?php

namespace App\Controller;

use App\Entity\AutresLienDys;
use App\Form\AutresLienDysType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class AutresLienDysController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/autres/liens/dys', name: 'app_autres_lien_dys')]
    public function AutresLienDys(EntityManagerInterface $em): Response
    {
        
        $autresLienDys = $em->getRepository(AutresLienDys::class)->find(1);

        if (!$autresLienDys) {
            return $this->render('autres_lien_dys/autres_lien_dys.html.twig', [
                'description' => 'Aucune description disponible.',
            ]);
        }
        return $this->render('autres_lien_dys/autres_lien_dys.html.twig', [
            'titre'=> $autresLienDys->getTitre(),
            'description' => $autresLienDys->getDescription(),
            'description1' => $autresLienDys->getDescription1(),
            'description2' => $autresLienDys->getDescription2(),
            'description3' => $autresLienDys->getDescription3(),
            'description4' => $autresLienDys->getDescription4(),
        ]);
    }
    #[Route('/autres/liens/dys/edit', name: 'app_autres_lien_dys_edit')]
    #[IsGranted('ROLE_ADMIN')]

    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $autresLienDys = $this->entityManager->getRepository(AutresLienDys::class)->find(1);

        if (!$autresLienDys) {
            $autresLienDys = new AutresLienDys();
        }
        $form = $this->createForm(AutresLienDysType::class, $autresLienDys);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($autresLienDys);
            $this->entityManager->flush();


            return $this->redirectToRoute('app_autres_lien_dys');
        }
        return $this->render('autres_lien_dys/edit.html.twig', [
            'form' => $form->createView(),

        ]);
    }

}
