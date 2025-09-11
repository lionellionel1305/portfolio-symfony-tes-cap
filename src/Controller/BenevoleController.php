<?php

namespace App\Controller;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Benevole;
use App\Form\BenevoleType;
use App\Service\ArchiveService;
use App\Service\PdfGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BenevoleController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private $archiveService;

    public function __construct(EntityManagerInterface $entityManager ,ArchiveService $archiveService, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->archiveService = $archiveService;

    }

    #[Route('/benevoles/inscription', name: 'app_benevoles_benevoles_inscription')]
    #[IsGranted('PUBLIC_ACCESS')]
    public function benevole_inscription(Request $request,  SluggerInterface $slugger, MailerInterface $mailer): Response
    {
        
        $benevole = new Benevole();
        $form = $this->createForm(BenevoleType::class, $benevole, [
            'csrf_protection' => false,  // Désactiver la protection CSRF

        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $file */
            $file = $form->get('casierJudiciaire')->getData();

            if ($file) {
                $filename = uniqid() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('casier_judiciaire_directory'),
                        $filename
                    );
                    $benevole->setCasierJudiciaire($filename);

                } catch (FileException $e) {
                    $this->addFlash('danger', 'Une erreur est survenue lors du téléchargement du fichier.');
                    return $this->redirectToRoute('app_benevoles_benevoles_inscription');
                }

            } else {

                $this->addFlash('error', 'Le fichier du casier judiciaire est requis.');
                return $this->render('benevoles/benevoles_inscription.html.twig', [
                    'form' => $form,
                ]);
            }

            $this->entityManager->persist($benevole);
            $this->entityManager->flush();
            
            $email = (new Email())
            ->from('tescapcontact@gmail.com')
            ->to('tescapcontact@gmail.com') // Remplace avec l’email de l’admin
            ->subject('Nouvelle inscription bénévole')
            ->html("
                <h2>Nouvelle inscription</h2>
                <p>Un nouveau bénévole s'est inscrit :</p>
                <ul>
                    <li><strong>Nom :</strong> {$benevole->getNom()}</li>
                    <li><strong>Prénom :</strong> {$benevole->getPrenom()}</li>
                    <li><strong>Email :</strong> {$benevole->getEmail()}</li>
                    <li><strong>Ville :</strong>{$benevole->getVille()}</li>
                </ul>
             
            ");

        $mailer->send($email);
        
            $this->addFlash('success', 'L\'inscription a été réussie, un responsable de secteur vous contactera ultérieurement.');
            return $this->redirectToRoute('app_charger_mission');
        }
        return $this->render('benevoles/benevoles_inscription.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/benevoles/liste', name: 'app_benevoles_liste')]
    #[IsGranted('ROLE_ADMIN')]
    public function listeBenevoles(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Supporte recherche multi-champs cumulée via field[] & search[] (ou valeurs uniques)
        // Utiliser all() pour accepter les tableaux sans BadRequest
        $rawField = $request->query->all('field');
        $rawSearch = $request->query->all('search');
        // Normalise: transforme en tableaux plats de scalaires (évite les tableaux imbriqués)
        $fields = is_array($rawField) ? $rawField : (isset($rawField) ? [$rawField] : []);
        $searches = is_array($rawSearch) ? $rawSearch : (isset($rawSearch) ? [$rawSearch] : []);
        $fields = array_values(array_filter(array_map(function ($v) { return is_array($v) ? null : $v; }, $fields), function ($v) { return $v !== null; }));
        $searches = array_values(array_filter(array_map(function ($v) { return is_array($v) ? null : $v; }, $searches), function ($v) { return $v !== null; }));
        $year = $request->query->get('year');

        $connection = $entityManager->getConnection();
        $schemaManager = $connection->getSchemaManager();

        $tables = $schemaManager->listTableNames();


        $archiveTables = array_filter($tables, function($table) {
            return strpos($table, 'benevolesarchive_') === 0;
        });

        $availableYears = array_map(function($table) {
            return str_replace('benevolesarchive_', '', $table);
        }, $archiveTables);

        // Utilise un alias stable pour permettre des sous-requêtes/joins
        $baseTable = 'benevole';
        $sql = "SELECT b.* FROM {$baseTable} b";

        if ($year && $year !== 'all') {
            $archiveTableName = 'benevolesarchive_' . $year;

            if (in_array($archiveTableName, $tables)) {
                $baseTable = $archiveTableName;
                $sql = "SELECT b.* FROM {$baseTable} b";
            } else {
                throw new \Exception("Table $archiveTableName non trouvée");
            }
        }

        // Construction dynamique des filtres cumulés (AND)
        $allowedFields = ['nom', 'prenom', 'email','sexe', 'secteur' , 'enfant_suivie','telephone','adresse','code_postal', 'ville', 'age', 'plageDistance' , 'matieresAccompagment', 'niveauAccompagment', 'connaitretescap','don_libre' ];

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
                throw new \InvalidArgumentException("Champ de recherche invalide.");
            }
            $paramName = 's' . $i;
            if ($currentField === 'enfant_suivie') {
                // Recherche par nom/prénom enfant dans la table famille (enfant_inscription) et même secteur
                $conditions[] = "EXISTS (SELECT 1 FROM enfant_inscription ei WHERE (ei.nom_enfant LIKE :{$paramName} OR ei.prenom_enfant LIKE :{$paramName}_p) AND ei.secteur = b.secteur)";
                $params[$paramName] = '%' . $currentSearch . '%';
                $params[$paramName . '_p'] = '%' . $currentSearch . '%';
            } else {
                $conditions[] = "b.$currentField LIKE :$paramName";
                $params[$paramName] = '%' . $currentSearch . '%';
            }
        }

        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }



        $stmt = $connection->prepare($sql);
        foreach ($params as $name => $value) {
            $stmt->bindValue($name, $value);
        }

        $benevoles = $stmt->executeQuery()->fetchAllAssociative();
          $emails = [];
    foreach ($benevoles as $benevole) {
        if (!empty($benevole['email'])) {
            $emails[] = $benevole['email'];
        }
    }

    // Décodage JSON d'un éventuel champ (exemple : 'matieresAccompagment')
      foreach ($benevoles as &$benevole) {
        foreach (['matieres_accompagment', 'niveau_accompagment', 'connaitretescap', 'plages_distances'] as $field) {
            if (!empty($benevole[$field])) {
                $cleaned = stripslashes($benevole[$field]); // enlève les \
                $decoded = json_decode($cleaned, true);
                $benevole[$field] = is_array($decoded) ? $decoded : [];
            } else {
                $benevole[$field] = [];
            }
        }
    }
    unset($benevole);


    // Ajoute "all" au début de la liste des années disponibles
    array_unshift($availableYears, 'all');


        array_unshift($availableYears, 'all');

        return $this->render('benevoles/liste.html.twig', [
            'benevoles' => $benevoles,
             'emails' => $emails,
            'year' => $year ?? 'all',
            'availableYears' => $availableYears,
        ]);
    }

#[Route('benevoles/liste/modifier/{id}', name: 'app_benevole_modifier')]
#[IsGranted('ROLE_ADMIN')]
public function modifier(int $id, Request $request, EntityManagerInterface $entityManager): Response
{
    $benevole = $entityManager->getRepository(Benevole::class)->find($id);

    if (!$benevole) {
        $this->addFlash('error', 'Le bénévole n\'existe pas.');
        return $this->redirectToRoute('app_benevoles_liste');
    }

    $form = $this->createForm(BenevoleType::class, $benevole, [
        'is_edit' => true
    ]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile|null $file */
        $file = $form->get('casierJudiciaire')->getData();

        // Si un fichier est soumis
        if ($file) {
            $filename = uniqid() . '.' . $file->guessExtension();
            
            try {
                // Récupérer le nom de l'ancien fichier
                $oldFilename = $benevole->getCasierJudiciaire();
                if ($oldFilename) {
                    // Construction du chemin complet du fichier
                    $oldFilePath = $this->getParameter('casier_judiciaire_directory') . '/' . $oldFilename;

                    // Vérifier l'existence du fichier avant de tenter de le supprimer
                    if (file_exists($oldFilePath) && is_file($oldFilePath)) {
                        unlink($oldFilePath); // Supprimer l'ancien fichier
                    }
                }

                // Déplacer le nouveau fichier
                $file->move(
                    $this->getParameter('casier_judiciaire_directory'),
                    $filename
                );

                // Mettre à jour le nom du fichier dans l'entité
                $benevole->setCasierJudiciaire($filename);

            } catch (FileException $e) {
                $this->addFlash('danger', 'Une erreur est survenue lors du téléchargement du fichier.');
                return $this->redirectToRoute('app_benevole_modifier', ['id' => $benevole->getId()]);
            }
        } else {
            // Si aucun fichier n'est soumis, on laisse la valeur du casier judiciaire inchangée
            if ($benevole->getCasierJudiciaire() === null) {
                // Affecte une valeur par défaut (par exemple, une chaîne vide ou une valeur par défaut)
                $benevole->setCasierJudiciaire('');
            }
        }

        // Sauvegarder les modifications dans la base de données
        $entityManager->flush();
        $this->addFlash('success', 'Le bénévole a été modifié avec succès.');
        return $this->redirectToRoute('app_benevoles_liste');
    }

    return $this->render('benevoles/modifier.html.twig', [
        'benevole' => $benevole,
        'form' => $form->createView()
    ]);
}


    #[Route('/benevoles/liste/supprimer/{id}', name: 'app_benevoles_supprimer')]
    #[IsGranted('ROLE_ADMIN')]
    public function supprimer(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {

        $benevole = $entityManager->getRepository(Benevole::class)->find($id);

        if (!$benevole) {
            $this->addFlash('danger', "Le bénévole avec l'ID $id n'existe pas.");
            return $this->redirectToRoute('app_benevoles_liste'); // Redirection vers la liste
        }

        // Supprimez le bénévole
        $entityManager->remove($benevole);
        $entityManager->flush();

        // Ajoutez un message flash pour informer de la suppression
        $this->addFlash('success', "Le bénévole a été supprimé avec succès.");

        // Redirigez vers la liste des bénévoles
        return $this->redirectToRoute('app_benevoles_liste');
    }

    #[Route('/benevoles/{id}/detail', name: 'app_benevoles_details')]
    #[IsGranted('ROLE_ADMIN')]
    public function detail(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le bénévole par son ID
        $benevole = $entityManager->getRepository(Benevole::class)->find($id);

        if (!$benevole) {
            throw $this->createNotFoundException('Bénévole non trouvé');
        }

        return $this->render('benevoles/detail.html.twig', [
            'benevole' => $benevole,
        ]);
    }
    #[Route('/benevoles/{id}/generate-pdf', name: 'app_benevoles_generate_pdf')]
    #[IsGranted('ROLE_ADMIN')]
    public function generatePdf(int $id, EntityManagerInterface $entityManager, PdfGenerator $pdfGenerator): Response
    {
        // Récupérer le bénévole par son ID
        $benevole = $entityManager->getRepository(Benevole::class)->find($id);

        if (!$benevole) {
            throw $this->createNotFoundException('Bénévole non trouvé');
        }

        // Créer le contenu HTML pour le PDF
        $htmlContent = $this->renderView('benevoles/detail.html.twig', [
            'benevole' => $benevole,
        ]);

        // Utiliser le service PdfGenerator pour générer le PDF
        return $pdfGenerator->generatePdf($htmlContent);
    }

}
