<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminpdfController extends AbstractController
{
    #[Route('/adminpdf/upload/famille', name: 'app_adminpdf_upload_famille')]
    public function uploadFamille(Request $request): Response
    {
        return $this->handleUpload($request, 'famille');
    }

    #[Route('/adminpdf/upload/benevole', name: 'app_adminpdf_upload_benevole')]
    public function uploadBenevole(Request $request): Response
    {
        return $this->handleUpload($request, 'benevole');
    }

    private function handleUpload(Request $request, string $type): Response
    {
        $form = $this->createFormBuilder()
            ->add('pdf_file', FileType::class, [
                'label' => 'Choisir un fichier PDF',
                'mapped' => false,
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Télécharger',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('pdf_file')->getData();

            if ($file && $file->guessExtension() === 'pdf') {
                $baseDirectory = $this->getParameter('pdfs_directory');
                $destination = $baseDirectory . '/' . $type;

                // Crée le dossier si nécessaire
                if (!is_dir($destination)) {
                    mkdir($destination, 0775, true);
                }

                // Nom du fichier en fonction du type
                $newFilename = 'formulaire_' . $type . '.pdf';

                // Supprimer l'ancien fichier s'il existe
                $oldFilePath = $destination . '/' . $newFilename;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }

                // Déplacement du fichier
                $file->move($destination, $newFilename);

                // Mise à jour du JSON
                $this->updatePdfFilenameInJson($newFilename, $type);

                $this->addFlash('success', 'Le fichier PDF a été téléchargé avec succès.');
                return $this->redirectToRoute('app_adminpdf_upload_' . $type);
            } else {
                $this->addFlash('error', 'Veuillez télécharger un fichier PDF valide.');
            }
        }

        return $this->render('admin/upload_pdf.html.twig', [
            'form' => $form->createView(),
            'type' => $type,
        ]);
    }

    private function updatePdfFilenameInJson(string $filename, string $type): void
    {
        $jsonPath = $this->getParameter('pdfs_directory') . '/pdf_files.json';

        // Lire le contenu JSON actuel
        $data = [];
        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
            $data = json_decode($jsonContent, true);
        }

        // Mettre à jour ou ajouter l'entrée
        $data[$type] = $filename;

        // Enregistrer dans le fichier JSON
        file_put_contents($jsonPath, json_encode($data, JSON_PRETTY_PRINT));
    }
}
