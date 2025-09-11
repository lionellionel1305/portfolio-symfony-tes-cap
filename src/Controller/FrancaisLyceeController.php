<?php
namespace App\Controller;

use App\Entity\Lycee;
use App\Form\LyceeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FrancaisLyceeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/lycee/francais', name: 'app_lyceeFrancais')]
    public function LyceeFrancais(): Response
    {
        $matiere = 'LyceeFrancais';
        $LyceeFrancais = $this->entityManager->getRepository(Lycee::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($LyceeFrancais as $Lycee){
            $forms[] = $this->createFormBuilder($Lycee)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('lycee/francais/francais.html.twig', [
            'LyceeFrancais' => $LyceeFrancais,
            'forms' => $forms,
        ]);
    }

    #[Route('/lycee/francais/edit', name: 'app_lyceeFrancais_edit')]
    public function editLyceeFrancais(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'LyceeFrancais';
        $LyceeFrancais = $this->entityManager->getRepository(Lycee::class)->findOneBy(['matiere' => $matiere]);

        if (!$LyceeFrancais) {
            $LyceeFrancais = new Lycee();
            $LyceeFrancais->setMatiere($matiere);
        }

        $form = $this->createForm(LyceeType::class, $LyceeFrancais)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($LyceeFrancais);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_lyceeFrancais');
        }

        return $this->render('lycee/francais/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/lycee/mathematique', name: 'app_lyceeMath')]
    public function lyceeMath(): Response
    {
        $matiere = 'LyceeMath';
        $LyceeMath = $this->entityManager->getRepository(Lycee::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($LyceeMath as $LyceeMaths) {
            $forms[] = $this->createFormBuilder($LyceeMath)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('lycee/mathematique/mathematique.html.twig', [
            'LyceeMath' => $LyceeMath,
            'forms' => $forms,
        ]);
    }

    #[Route('/lycee/mathematique/edit', name: 'app_lyceeMath_edit')]
    public function editlyceeMathematique(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'lyceeMath';
        $LyceeMath = $this->entityManager->getRepository(Lycee::class)->findOneBy(['matiere' => $matiere]);

        if (!$LyceeMath) {
            $LyceeMath = new Lycee();
            $LyceeMath->setMatiere($matiere);
        }

        $form = $this->createForm(LyceeType::class, $LyceeMath)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($LyceeMath);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_lyceeMath');
        }

        return $this->render('lycee/mathematique/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/lycee/langues', name: 'app_lyceeAnglais')]
    public function LyceeLangue(): Response
    {
        $matiere = 'LyceeAnglais';
        $lyceeAnglais = $this->entityManager->getRepository(Lycee::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($lyceeAnglais as $lyceeAnglai) {
            $forms[] = $this->createFormBuilder($lyceeAnglais)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('lycee/anglais/anglais.html.twig', [
            'lyceeAnglais' => $lyceeAnglais,
            'forms' => $forms,
        ]);
    }

    #[Route('/lycee/langues/edit', name: 'app_lyceeAnglais_edit')]
    public function editAnglais(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'lyceeAnglais';
        $lyceeAnglais = $this->entityManager->getRepository(Lycee::class)->findOneBy(['matiere' => $matiere]);

        if (!$lyceeAnglais) {
            $lyceeAnglais = new lycee();
            $lyceeAnglais->setMatiere($matiere);
        }

        $form = $this->createForm(LyceeType::class, $lyceeAnglais)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($lyceeAnglais);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_lyceeAnglais');
        }

        return $this->render('lycee/anglais/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/lycee/physique-chimie', name: 'app_lyceePhysique')]
    public function physique(): Response
    {
        
        $matiere = 'lyceePhysiqueChimie';
        $lyceePhys = $this->entityManager->getRepository(Lycee::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($lyceePhys as $lyceePhy) {
            $forms[] = $this->createFormBuilder($lyceePhys)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('lycee/physique/physique-chimie.html.twig', [
            'lyceePhysiqueChimie' => $lyceePhys,
            'forms' => $forms,
        ]);
    }

    #[Route('/lycee/physique-chimie/edit', name: 'app_lyceePhysique_edit')]
    public function editPhysique(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'lyceePhysiqueChimie';
        $lyceePhys = $this->entityManager->getRepository(Lycee::class)->findOneBy(['matiere' => $matiere]);

        if (!$lyceePhys) {
            $lyceePhys = new Lycee();
            $lyceePhys->setMatiere($matiere);
        }

        $form = $this->createForm(LyceeType::class, $lyceePhys)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($lyceePhys);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_lyceePhysique');
        }

        return $this->render('lycee/physique/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/lycee/histoire-géographie', name: 'app_lyceeHist')]
    public function lyceeHistoire(): Response
    {
        $matiere = 'lyceeHistoire';
        $lyceeHis= $this->entityManager->getRepository(Lycee::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($lyceeHis as $lyceeHiss) {
            $forms[] = $this->createFormBuilder($lyceeHis)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('lycee/hist_Geo/histoire.html.twig', [
            'lyceeHistoire' => $lyceeHis,
            'forms' => $forms,
        ]);
    }

    #[Route('/lycee/histoire-géographie/edit', name: 'app_lyceeHist_edit')]
    public function editlyceeHistoire(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'lyceeHistoire';
        $lyceeHis = $this->entityManager->getRepository(Lycee::class)->findOneBy(['matiere' => $matiere]);

        if (!$lyceeHis) {
            $lyceeHis = new Lycee();
            $lyceeHis->setMatiere($matiere);
        }

        $form = $this->createForm(LyceeType::class, $lyceeHis)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($lyceeHis);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_lyceeHist');
        }

        return $this->render('lycee/hist_Geo/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/lycee/Svt', name: 'app_lyceeSvt')]
    public function lyceeSvt(): Response
    {
        
        $matiere = 'lyceeSvt';
        $lyceeSvt= $this->entityManager->getRepository(Lycee::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($lyceeSvt as $lyceeSvts) {
            $forms[] = $this->createFormBuilder($lyceeSvt)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('lycee/svt/svt.html.twig', [
            'lyceeSvt' => $lyceeSvt,
            'forms' => $forms,
        ]);
    }

    #[Route('/lycee/Svt/edit', name: 'app_lyceeSvt_edit')]
    public function editlyceeSvt(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'lyceeSvt';
        $lyceeSvt = $this->entityManager->getRepository(Lycee::class)->findOneBy(['matiere' => $matiere]);

        if (!$lyceeSvt) {
            $lyceeSvt = new lycee();
            $lyceeSvt->setMatiere($matiere);
        }

        $form = $this->createForm(LyceeType::class, $lyceeSvt)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($lyceeSvt);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_lyceeSvt');
        }

        return $this->render('lycee/svt/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/lycee/techno', name: 'app_lyceeTechno')]
    public function lyceeTechno(): Response
    {
        $matiere = 'lyceeTechno';
        $lyceeTechno= $this->entityManager->getRepository(Lycee::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($lyceeTechno as $lyceeTechnos) {
            $forms[] = $this->createFormBuilder($lyceeTechno)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('lycee/techno/technologie.html.twig', [
            'lyceeTechno' => $lyceeTechno,
            'forms' => $forms,
        ]);
    }

    #[Route('/lycee/techno/edit', name: 'app_lyceeTechno_edit')]
    public function editlyceeTechno(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'lyceeTechno';
        $lyceeTechno = $this->entityManager->getRepository(Lycee::class)->findOneBy(['matiere' => $matiere]);

        if (!$lyceeTechno) {
            $lyceeTechno = new Lycee();
            $lyceeTechno->setMatiere($matiere);
        }

        $form = $this->createForm(LyceeType::class, $lyceeTechno)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($lyceeTechno);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_lyceeTechno');
        }

        return $this->render('lycee/techno/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/lycee/loisir-creatif', name: 'app_lyceeLoisir')]
    public function lyceeLoisir(): Response
    {
        
        $matiere = 'lyceeLoisir';
        $lyceeLoisir= $this->entityManager->getRepository(Lycee::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($lyceeLoisir as $lyceeLoisirs) {
            $forms[] = $this->createFormBuilder($lyceeLoisir)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('lycee/loisir/loisir.html.twig', [
            'lyceeLoisir' => $lyceeLoisir,
            'forms' => $forms,
        ]);
    }


    #[Route('/lycee/loisir-creatif/edit', name: 'app_lyceeLoisir_edit')]
    public function editlyceeLoisir(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'lyceeLoisir';
        $lyceeLoisir = $this->entityManager->getRepository(Lycee::class)->findOneBy(['matiere' => $matiere]);

        if (!$lyceeLoisir) {
            $lyceeLoisir = new Lycee();
            $lyceeLoisir->setMatiere($matiere);
        }

        $form = $this->createForm(LyceeType::class, $lyceeLoisir)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($lyceeLoisir);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_lyceeLoisir');
        }

        return $this->render('lycee/loisir/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}