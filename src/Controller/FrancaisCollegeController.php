<?php
namespace App\Controller;

use App\Entity\College;
use App\Form\CollegeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FrancaisCollegeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/college/francais', name: 'app_collegeFrancais')]
    public function Francais(): Response
    {
        $matiere = 'CollegeFrancais';
        $CollegeFrancais = $this->entityManager->getRepository(College::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($CollegeFrancais as $Collegefrancai) {
            $forms[] = $this->createFormBuilder($CollegeFrancais)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('college/francais/francais.html.twig', [
            'CollegeFrancais' => $CollegeFrancais,
            'forms' => $forms,
        ]);
    }

    #[Route('/college/francais/edit', name: 'app_collegeFrancais_edit')]
    public function editFrancais(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'CollegeFrancais';
        $CollegeFrancais = $this->entityManager->getRepository(College::class)->findOneBy(['matiere' => $matiere]);

        if (!$CollegeFrancais) {
            $CollegeFrancais = new college();
            $CollegeFrancais->setMatiere($matiere);
        }

        $form = $this->createForm(CollegeType::class, $CollegeFrancais)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($CollegeFrancais);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_collegeFrancais');
        }

        return $this->render('college/francais/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/college/mathematique', name: 'app_collegeMath')]
    public function Math(): Response
    {
        $matiere = 'CollegeMathematique';
        $collegemath = $this->entityManager->getRepository(College::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($collegemath as $collegemaths) {
            $forms[] = $this->createFormBuilder($collegemath)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('college/mathematique/mathematique.html.twig', [
            'CollegeMathematique' => $collegemath,
            'forms' => $forms,
        ]);
    }

    #[Route('/college/mathematique/edit', name: 'app_collegeMath_edit')]
    public function editMathematique(Request $request): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'CollegeMathematique';
        $collegemath = $this->entityManager->getRepository(College::class)->findOneBy(['matiere' => $matiere]);

        if (!$collegemath) {
            $collegemath = new College();
            $collegemath->setMatiere($matiere);
        }

        $form = $this->createForm(CollegeType::class, $collegemath)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($collegemath);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_collegeMath');
        }

        return $this->render('college/mathematique/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/college/anglais', name: 'app_collegeAnglais')]
    public function Langue(): Response
    {
        $matiere = 'CollegeAnglais';
        $CollegeAnglais = $this->entityManager->getRepository(College::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($CollegeAnglais as $collegeAnglais) {
            $forms[] = $this->createFormBuilder($CollegeAnglais)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('college/anglais/anglais.html.twig', [
            'CollegeAnglais' => $CollegeAnglais,
            'forms' => $forms,
        ]);
    }

    #[Route('/college/anglais/edit', name: 'app_CollegeAnglais_edit')]
    public function editAnglais(Request $request): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'CollegeAnglais';
        $CollegeAnglais = $this->entityManager->getRepository(College::class)->findOneBy(['matiere' => $matiere]);

        if (!$CollegeAnglais) {
            $CollegeAnglais = new College();
            $CollegeAnglais->setMatiere($matiere);
        }

        $form = $this->createForm(CollegeType::class, $CollegeAnglais)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($CollegeAnglais);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_collegeAnglais');
        }

        return $this->render('college/anglais/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        #[Route('/college/physique-chimie', name: 'app_collegePhysique')]
    public function Histoire(): Response
    {
        $matiere = 'Physique-chimie';
        $Phys = $this->entityManager->getRepository(College::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($Phys as $Phy) {
            $forms[] = $this->createFormBuilder($Phys)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('college/physique/physique-chimie.html.twig', [
            'PhysiqueChimie' => $Phys,
            'forms' => $forms,
        ]);
    }

    #[Route('/college/physique-chimie/edit', name: 'app_collegePhysique_edit')]
    public function editHistoire(Request $request): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'Physique-chimie';
        $Phys = $this->entityManager->getRepository(College::class)->findOneBy(['matiere' => $matiere]);

        if (!$Phys) {
            $Phys = new College();
            $Phys->setMatiere($matiere);
        }

        $form = $this->createForm(CollegeType::class, $Phys)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($Phys);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_collegePhysique');
        }

        return $this->render('college/physique/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/college/histoire-geographie', name: 'app_CollegeHist')]
    public function CollegeHistoire(): Response
    {
        $matiere = 'CollegeHistoire';
        $CollegeHis= $this->entityManager->getRepository(College::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($CollegeHis as $CollegeHiss) {
            $forms[] = $this->createFormBuilder($CollegeHis)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('college/hist_Geo/histoire.html.twig', [
            'CollegeHistoire' => $CollegeHis,
            'forms' => $forms,
        ]);
    }

    #[Route('/college/histoire-geographie/edit', name: 'app_collegeHist_edit')]
    public function editCollegeHistoire(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'CollegeHistoire';
        $CollegeHis = $this->entityManager->getRepository(College::class)->findOneBy(['matiere' => $matiere]);

        if (!$CollegeHis) {
            $CollegeHis = new College();
            $CollegeHis->setMatiere($matiere);
        }

        $form = $this->createForm(CollegeType::class, $CollegeHis)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($CollegeHis);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_CollegeHist');
        }

        return $this->render('college/hist_Geo/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/college/Svt', name: 'app_CollegeSvt')]
    public function CollegeSvt(): Response
    {
        $matiere = 'CollegeSvt';
        $CollegeSvt= $this->entityManager->getRepository(College::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($CollegeSvt as $CollegeSvts) {
            $forms[] = $this->createFormBuilder($CollegeSvt)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('college/svt/svt.html.twig', [
            'CollegeSvt' => $CollegeSvt,
            'forms' => $forms,
        ]);
    }

    #[Route('/college/Svt/edit', name: 'app_collegeSvt_edit')]
    public function editCollegeSvt(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'CollegeSvt';
        $CollegeSvt = $this->entityManager->getRepository(College::class)->findOneBy(['matiere' => $matiere]);

        if (!$CollegeSvt) {
            $CollegeSvt = new College();
            $CollegeSvt->setMatiere($matiere);
        }

        $form = $this->createForm(CollegeType::class, $CollegeSvt)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($CollegeSvt);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_CollegeSvt');
        }

        return $this->render('college/svt/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/college/techno', name: 'app_CollegeTechno')]
    public function CollegeTechno(): Response
    {
        $matiere = 'CollegeTechno';
        $CollegeTechno= $this->entityManager->getRepository(College::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($CollegeTechno as $CollegeTechnos) {
            $forms[] = $this->createFormBuilder($CollegeTechno)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('college/techno/technologie.html.twig', [
            'CollegeTechno' => $CollegeTechno,
            'forms' => $forms,
        ]);
    }

    #[Route('/college/techno/edit', name: 'app_CollegeTechno_edit')]
    public function editCollegeTechno(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'CollegeTechno';
        $CollegeTechno = $this->entityManager->getRepository(College::class)->findOneBy(['matiere' => $matiere]);

        if (!$CollegeTechno) {
            $CollegeTechno = new College();
            $CollegeTechno->setMatiere($matiere);
        }

        $form = $this->createForm(CollegeType::class, $CollegeTechno)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($CollegeTechno);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_CollegeTechno');
        }

        return $this->render('college/techno/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/college/loisir-creatif', name: 'app_CollegeLoisir')]
    public function CollegeLoisir(): Response
    {
        $matiere = 'CollegeLoisir';
        $CollegeLoisir= $this->entityManager->getRepository(College::class)->findBy(['matiere' => $matiere]);

        $forms = [];
        foreach ($CollegeLoisir as $CollegeLoisirs) {
            $forms[] = $this->createFormBuilder($CollegeLoisir)
                ->add('editableTitle', TextType::class, [
                    'label' => 'Titre modifiable',
                    'required' => false,
                ])
                ->getForm()->createView();
        }

        return $this->render('college/loisir/loisir.html.twig', [
            'CollegeLoisir' => $CollegeLoisir,
            'forms' => $forms,
        ]);
    }


    #[Route('/college/loisir-creatif/edit', name: 'app_collegeLoisir_edit')]
    public function editCollegeLoisir(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $matiere = 'CollegeLoisir';
        $CollegeLoisir = $this->entityManager->getRepository(College::class)->findOneBy(['matiere' => $matiere]);

        if (!$CollegeLoisir) {
            $CollegeLoisir = new College();
            $CollegeLoisir->setMatiere($matiere);
        }

        $form = $this->createForm(CollegeType::class, $CollegeLoisir)
            ->add('editableTitle', TextType::class, [
                'label' => 'Titre modifiable',
                'required' => false,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($CollegeLoisir);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_CollegeLoisir');
        }

        return $this->render('college/loisir/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}