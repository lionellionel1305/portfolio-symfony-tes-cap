<?php

namespace App\Controller;

use App\Entity\EnfantInscription;
use App\Form\EnfantInscriptionType;
use App\Service\PdfGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EnfantInscriptionController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription/enfant', name: 'app_enfant_inscription')]
    #[IsGranted('PUBLIC_ACCESS')]
    public function inscription(Request $request, MailerInterface $mailer): Response
    {
        $enfant = new EnfantInscription();
        $form = $this->createForm(EnfantInscriptionType::class, $enfant, [
            'csrf_protection' => false,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile|null $pdfFile */
        $pdfFile = $form->get('quotientFamilialPdf')->getData();
        
        if ($pdfFile) {
            $uploadDir = $this->getParameter('quotient_familial_directory');
        
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true);
            }
        
            $newFilename = 'quotient_familial_' . uniqid() . '.' . $pdfFile->guessExtension();
        
            try {
                $pdfFile->move($uploadDir, $newFilename);
                $enfant->setQuotientFamilialPdf($newFilename);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de l’upload du PDF : ' . $e->getMessage());
            }
        }
        
            $this->entityManager->persist($enfant);
            $this->entityManager->flush();
            // Envoi de l'email
            $email = (new Email())
                ->from('tescapcontact@gmail.com')
                ->to('tescapcontact@gmail.com') // Adresse de l'admin
                ->subject('Nouvelle inscription enfant')
                ->html("
                    <h2>Nouvelle inscription d'enfant</h2>
                    <ul>
                        <li><strong>Nom :</strong> {$enfant->getNomEnfant()}</li>
                        <li><strong>Prénom :</strong> {$enfant->getPrenomEnfant()}</li>
                        <li><strong>Date de naissance :</strong> {$enfant->getDateNaissance()?->format('d/m/Y')}</li>
                        
                    </ul>
                ");
            $mailer->send($email);

            $this->addFlash('success', "L'inscription de l'enfant a été enregistrée avec succès.\nCe formulaire ne constitue pas une demande définitive.\nEn remplissant ce formulaire, vous exprimez simplement votre souhait d'avoir un accompagnement scolaire pour votre enfant.\nVous serez informé(e) des modalités et de la disponibilité lorsqu'un bénévole vous sera trouvé.\nLe réglement doit être envoyé au siége de T'es Cap aprés de la soumission du formulaire. Il ne sera encaissé que lorsqu’un bénévole aura été attribué.\n Merci de votre compréhension.");



            return $this->redirectToRoute('app_enfant_inscription');
            
        }

        return $this->render('inscription_enfant/inscription_enfant.html.twig', [
            'form' => $form->createView(),
            
        ]);
    }

    #[Route('/enfant/liste', name: 'app_enfant_liste')]
#[IsGranted('ROLE_ADMIN')]
public function listeEnfants(Request $request, EntityManagerInterface $entityManager): Response
{
    // Multi-critères: accepter field[] & search[] (ou scalaires)
    $rawField = $request->query->all('field');
    $rawSearch = $request->query->all('search');
    $fields = is_array($rawField) ? $rawField : (isset($rawField) ? [$rawField] : []);
    $searches = is_array($rawSearch) ? $rawSearch : (isset($rawSearch) ? [$rawSearch] : []);
    // Normalisation: tableaux plats scalaires
    $fields = array_values(array_filter(array_map(function ($v) { return is_array($v) ? null : $v; }, $fields), function ($v) { return $v !== null; }));
    $searches = array_values(array_filter(array_map(function ($v) { return is_array($v) ? null : $v; }, $searches), function ($v) { return $v !== null; }));
    $year = $request->query->get('year');

    $connection = $entityManager->getConnection();
    $schemaManager = $connection->getSchemaManager();

    $tables = $schemaManager->listTableNames();

    // Rechercher toutes les tables d'archives enfantarchive_YYYY
    $archiveTables = array_filter($tables, function ($table) {
        return strpos($table, 'enfantarchive_') === 0;
    });

    $availableYears = array_map(function ($table) {
        return str_replace('enfantarchive_', '', $table);
    }, $archiveTables);

    $baseTable = 'enfant_inscription';
    $sql = "SELECT e.* FROM {$baseTable} e";

    // Gestion de l'année : choisir la table archive si année sélectionnée
    if ($year && $year !== 'all') {
        $archiveTableName = 'enfantarchive_' . $year;

        if (in_array($archiveTableName, $tables)) {
            $baseTable = $archiveTableName;
            $sql = "SELECT e.* FROM {$baseTable} e";
        } else {
            throw new \Exception("Table $archiveTableName non trouvée");
        }
    }

    // Liste des champs autorisés pour la recherche — en snake_case comme dans ta BDD
    $allowedFields = [
        'nom_enfant', 'prenom_enfant', 'ancien_accompagnement', 'genre', 'classe', 'etablissement',
        'paiment', 'secteur', 'quotient_familial',
        'prenom_parent2', 'nom_parent2', 'email_parent2', 'ville_parent2', 'telephone_parent2',
        'prenom_parent1', 'nom_parent1', 'email_parent1', 'ville_parent1', 'telephone_parent1',
        'protocole','niveau_scolaire','don_libre'
    ];

    // Construction des filtres cumulés (AND)
    $conditions = [];
    $params = [];
    $pairCount = min(count($fields), count($searches));

    for ($i = 0; $i < $pairCount; $i++) {
        $currentField = $fields[$i];
        $currentSearch = $searches[$i];
        if ($currentField === null || $currentSearch === null || $currentSearch === '') {
            continue;
        }
        if (!in_array($currentField, $allowedFields, true)) {
            throw new \InvalidArgumentException("Champ de recherche invalide : $currentField");
        }

        $paramName = 's' . $i;

        if ($currentField === 'protocole') {
            $val = strtolower((string)$currentSearch);
            $boolValue = null;
            if (in_array($val, ['1','true','oui','yes'], true)) { $boolValue = 1; }
            if (in_array($val, ['0','false','non','no'], true)) { $boolValue = 0; }
            if ($boolValue !== null) {
                if ($boolValue === 1) {
                    $conditions[] = "e.protocole = :$paramName";
                } else {
                    // traiter 'non' comme faux ou null
                    $conditions[] = "(e.protocole = :$paramName OR e.protocole IS NULL)";
                }
                $params[$paramName] = [$boolValue, \PDO::PARAM_BOOL];
            }
            // si valeur invalide, on ignore ce critère
        } else {
            $conditions[] = "e.$currentField LIKE :$paramName";
            $params[$paramName] = '%' . $currentSearch . '%';
        }
    }

    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $stmt = $connection->prepare($sql);
    foreach ($params as $name => $value) {
        if (is_array($value)) {
            $stmt->bindValue($name, $value[0], $value[1]);
        } else {
            $stmt->bindValue($name, $value);
        }
    }

    $enfants = $stmt->executeQuery()->fetchAllAssociative();

    // Construire la liste des emails
    $emails = [];

    foreach ($enfants as $enfant) {
        if (!empty($enfant['email_parent1'])) {
            $emails[] = $enfant['email_parent1'];
        }
        if (!empty($enfant['email_parent2'])) {
            $emails[] = $enfant['email_parent2'];
        }
    }

    foreach ($enfants as &$enfant) {
        if (!empty($enfant['matieres_souhaitees'])) {
            $decoded = json_decode($enfant['matieres_souhaitees'], true);
            $enfant['matieres_souhaitees'] = is_array($decoded) ? $decoded : [];
        } else {
            $enfant['matieres_souhaitees'] = [];
        }
    }
    unset($enfant);

    // Ajoute "all" au début de la liste des années disponibles
    array_unshift($availableYears, 'all');

    return $this->render('inscription_enfant/liste.html.twig', [
        'enfants' => $enfants,
        'year' => $year ?? 'all',
        'emails' => $emails,
        'availableYears' => $availableYears,
    ]);
}

    #[Route('/enfant/{id}/detail', name: 'app_enfant_detail')]
    #[IsGranted('ROLE_ADMIN')]
    public function detail(int $id): Response
    {
        $enfant = $this->entityManager->getRepository(EnfantInscription::class)->find($id);

        if (!$enfant) {
            throw $this->createNotFoundException('Enfant non trouvé');
        }

        return $this->render('inscription_enfant/detail.html.twig', [
            'enfant' => $enfant,
        ]);
    }

    #[Route('/enfant/{id}/modifier', name: 'app_enfant_modifier')]
#[IsGranted('ROLE_ADMIN')]
public function modifier(int $id, Request $request): Response
{
    $enfant = $this->entityManager->getRepository(EnfantInscription::class)->find($id);

    if (!$enfant) {
        $this->addFlash('error', 'L\'enfant n\'existe pas.');
        return $this->redirectToRoute('app_enfant_liste');
    }

    $form = $this->createForm(EnfantInscriptionType::class, $enfant);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        /** @var UploadedFile|null $pdfFile */
        $pdfFile = $form->get('quotientFamilialPdf')->getData();

        if ($pdfFile) {
            $uploadDir = $this->getParameter('quotient_familial_directory');

            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
                    $this->addFlash('error', 'Impossible de créer le dossier d\'upload.');
                    return $this->redirectToRoute('app_enfant_modifier', ['id' => $id]);
                }
            }

            $newFilename = 'quotient_familial_' . uniqid() . '.' . $pdfFile->guessExtension();

            try {
                $pdfFile->move($uploadDir, $newFilename);
                $enfant->setQuotientFamilialPdf($newFilename);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de l’upload du PDF : ' . $e->getMessage());
                return $this->redirectToRoute('app_enfant_modifier', ['id' => $id]);
            }
        }

        $this->entityManager->flush();

        $this->addFlash('success', 'Les informations ont été mises à jour avec succès.');
        return $this->redirectToRoute('app_enfant_liste');
    }

    return $this->render('inscription_enfant/modifier.html.twig', [
        'form' => $form->createView(),
        'enfant' => $enfant,
    ]);
}


    #[Route('/enfant/{id}/supprimer', name: 'app_enfant_supprimer')]
    #[IsGranted('ROLE_ADMIN')]
    public function supprimer(int $id): Response
    {
        $enfant = $this->entityManager->getRepository(EnfantInscription::class)->find($id);

        if (!$enfant) {
            $this->addFlash('danger', 'L\'enfant n\'a pas été trouvé.');
        } else {
            $this->entityManager->remove($enfant);
            $this->entityManager->flush();
            $this->addFlash('success', 'L\'enfant a été supprimé avec succès.');
        }

        return $this->redirectToRoute('app_enfant_liste');
    }
    
    #[Route('/enfant/{id}/generate-pdf', name: 'app_enfant_generate_pdf')]
    #[IsGranted('ROLE_ADMIN')]
    public function generateEnfantPdf(int $id, EntityManagerInterface $entityManager, PdfGenerator $pdfGenerator): Response
    {
        // Récupérer l'enfant par son ID
        $enfant = $entityManager->getRepository(EnfantInscription::class)->find($id);
        if (!$enfant) {
            throw $this->createNotFoundException('Enfant non trouvé');
        }
        
        // Créer le contenu HTML pour le PDF
        $htmlContent = $this->renderView('inscription_enfant/detail.html.twig', [
            'enfant' => $enfant,
        ]);
        
        // Utiliser le service PdfGenerator pour générer le PDF
        return $pdfGenerator->generatePdf($htmlContent);
    }
}
