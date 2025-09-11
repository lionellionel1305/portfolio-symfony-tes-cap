<?php
namespace App\Controller;

use App\Entity\Primaire;
use App\Form\PrimaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tesCap29.fr')]
class FrancaisController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/primaire/francais', name: 'app_francais')]
    public function Francais(): Response
    {
        $matiere = 'Francais';
        $francais = $this->entityManager->getRepository(Primaire::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($francais as $francai) {
            $forms[] = $this->createFormBuilder($francai)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('primaire/francais/francais.html.twig', [
            'francais' => $francais,
            'forms' => $forms,
        ]);
    }

    #[Route('/primaire/francais/edit', name: 'app_francais_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function editFrancais(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'Francais';
        $francais = $this->entityManager->getRepository(Primaire::class)->findOneBy(['matiere' => $matiere]);

        if (!$francais) {
            $francais = new Primaire();
            $francais->setMatiere($matiere);
        }

        $form = $this->createForm(PrimaireType::class, $francais)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($francais);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_francais');
        }

        return $this->render('primaire/francais/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/primaire/mathematique', name: 'app_math')]
    public function Math(): Response
    {
        $matiere = 'Mathematique';
        $math = $this->entityManager->getRepository(Primaire::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($math as $maths) {
            $forms[] = $this->createFormBuilder($math)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('primaire/mathematique/mathematique.html.twig', [
            'mathematique' => $math,
            'forms' => $forms,
        ]);
    }

    #[Route('/primaire/mathematique/edit', name: 'app_math_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function editMathematique(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'mathematique';
        $math = $this->entityManager->getRepository(Primaire::class)->findOneBy(['matiere' => $matiere]);

        if (!$math) {
            $math = new Primaire();
            $math->setMatiere($matiere);
        }

        $form = $this->createForm(PrimaireType::class, $math)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($math);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_math');
        }

        return $this->render('primaire/mathematique/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/primaire/histoire-geographie', name: 'app_hist')]
    public function Histoire(): Response
    {
        $matiere = 'histoire';
        $hist = $this->entityManager->getRepository(Primaire::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($hist as $hists) {
            $forms[] = $this->createFormBuilder($hist)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('primaire/hist_Geo/histoire.html.twig', [
            'histoire' => $hist,
            'forms' => $forms,
        ]);
    }

    #[Route('/primaire/histoire-geographie/edit', name: 'app_hist_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function editHistoire(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'histoire';
        $hist = $this->entityManager->getRepository(Primaire::class)->findOneBy(['matiere' => $matiere]);

        if (!$hist) {
            $hist = new Primaire();
            $hist->setMatiere($matiere);
        }

        $form = $this->createForm(PrimaireType::class, $hist)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($hist);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_hist');
        }

        return $this->render('primaire/hist_Geo/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/primaire/anglais', name: 'app_anglais')]
    
    public function Langue(): Response
    {
        $matiere = 'Anglais';
        $anglais = $this->entityManager->getRepository(Primaire::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($anglais as $anglai) {
            $forms[] = $this->createFormBuilder($anglais)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('primaire/anglais/anglais.html.twig', [
            'anglais' => $anglais,
            'forms' => $forms,
        ]);
    }

    #[Route('/primaire/anglais/edit', name: 'app_anglais_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function editAnglais(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'Anglais';
        $anglais = $this->entityManager->getRepository(Primaire::class)->findOneBy(['matiere' => $matiere]);

        if (!$anglais) {
            $anglais = new Primaire();
            $anglais->setMatiere($matiere);
        }

        $form = $this->createForm(PrimaireType::class, $anglais)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($anglais);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_anglais');
        }

        return $this->render('primaire/anglais/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/primaire/loisir-creatif', name: 'app_loisirs')]
    public function Loisir(): Response
    {
        $matiere = 'Loisirs';
        $loisirs = $this->entityManager->getRepository(Primaire::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($loisirs as $loisir) {
            $forms[] = $this->createFormBuilder($loisirs)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('primaire/loisirs/loisir.html.twig', [
            'loisirs' => $loisirs,
            'forms' => $forms,
        ]);
    }

    #[Route('/primaire/loisir-creatif/edit', name: 'app_loisir_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function editloisir(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'Loisirs';
        $loisirs = $this->entityManager->getRepository(Primaire::class)->findOneBy(['matiere' => $matiere]);

        if (!$loisirs) {
            $loisirs = new Primaire();
            $loisirs->setMatiere($matiere);
        }

        $form = $this->createForm(PrimaireType::class, $loisirs)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($loisirs);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_loisirs');
        }

        return $this->render('primaire/loisirs/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
