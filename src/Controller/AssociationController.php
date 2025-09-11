<?php
namespace App\Controller;

use App\Entity\Association;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



class AssociationController extends AbstractController
{
    #[Route('/association', name: 'app_association')]
    public function show(EntityManagerInterface $em): Response
    {
        $association = $em->getRepository(Association::class)->find(1);

        if (!$association) {
            $this->addFlash('error', 'Aucune description disponible.');
            return $this->redirectToRoute('app_association');
        }

        return $this->render('association/show.html.twig', [
            'description' => $association->getDescription(),
        ]);
    }

    #[Route('/association/edit', name: 'app_association_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $association = $em->getRepository(Association::class)->find(1);

        if (!$association) {
            $association = new Association();
        }

        $form = $this->createFormBuilder($association)
            ->add('description', TextareaType::class, [
                'label' => 'Modifier la description',
                'attr' => ['rows' => 30 , 'style' => 'width: 100%;'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($association);
            $em->flush();

            $this->addFlash('success', 'Description mise à jour.');
            return $this->redirectToRoute('app_association');
        }

        return $this->render('association/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}