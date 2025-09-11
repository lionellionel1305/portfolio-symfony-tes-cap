<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Photo;
use App\Form\CommentairesType;
use App\Form\PhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class PhotoController extends AbstractController
{
     private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/vie/association/photos', name: 'app_photo_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $photos = $em->getRepository(Photo::class)->findBy([], ['createdAt' => 'DESC']);

        usort($photos, function($a, $b) {
            // Extraire la date du format 'jj/mm/yyyy' dans la description
            preg_match('/\d{2}\/\d{4}/', $a->getDescription(), $dateA);
            preg_match('/\d{2}\/\d{4}/', $b->getDescription(), $dateB);

            // Convertir les dates en objets DateTime pour les comparer
            $dateA = $dateA ? \DateTime::createFromFormat('m/Y', $dateA[0]) : null;
            $dateB = $dateB ? \DateTime::createFromFormat('m/Y', $dateB[0]) : null;

            // Comparer les dates pour effectuer le tri
            if ($dateA && $dateB) {
                return $dateB <=> $dateA; // Tri décroissant (le plus récent en premier)
            }

            return 0; // Si aucune date n'est trouvée, pas de changement
        });

        return $this->render('vie_de_l_asso/photo/index.html.twig', [
            'photos' => $photos,
        ]);
    }
     #[Route('/photos/new', name: 'photo_new')]
     #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, SluggerInterface $slugger): Response
    {
    $photo = new Photo();
    $form = $this->createForm(PhotoType::class, $photo);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Récupérer le fichier image
        $imageFile = $form->get('imageFile')->getData();

        // Vérifier si un fichier a été téléchargé
        if ($imageFile) {
            // Utiliser la méthode setImageFile() pour mettre à jour imagePath et updatedAt
            $photo->setImageFile($imageFile);

            // Déplacer le fichier image
            try {
                // Déplacer le fichier vers le répertoire spécifié
                $imageFile->move(
                    $this->getParameter('photos_directory'), // Vérifie que ce paramètre est bien défini dans ton config
                    $photo->getImagePath() // Le chemin où l'image sera enregistrée
                );
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur lors du téléchargement du fichier.');
                return $this->redirectToRoute('photo_new');
            }
        } else {
            // Ajouter un message d'erreur si aucune image n'est sélectionnée
            $this->addFlash('error', 'Veuillez sélectionner une image.');
            return $this->redirectToRoute('photo_new');
        }

        // Sauvegarder la photo dans la base de données
        $entityManager = $this->entityManager;
        $entityManager->persist($photo);
        $entityManager->flush();

        // Rediriger vers une page de succès ou une autre action
        return $this->redirectToRoute('app_photo_index');
    }

    // Rendu du formulaire si ce n'est pas soumis ou valide
    return $this->render('photo/new.html.twig', [
        'form' => $form->createView(),
    ]);
}

    #[Route('/photos/{id}/delete', name: 'photo_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Photo $photo, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photo->getId(), $request->request->get('_token'))) {
            $em->remove($photo);
            $em->flush();

            $this->addFlash('success', 'Photo supprimée avec succès.');
        }

        return $this->redirectToRoute('app_photo_index');
    }

//    #[Route('/vie/association/photos/{id}', name: 'app_photo_show')]
//    public function show(Photo $photo, Request $request, EntityManagerInterface $em): Response
//    {
//        $commentaire = new Commentaire();
//        $form = $this->createForm(CommentairesType::class, $commentaire);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $commentaire->setPhoto($photo);
//            $commentaire->setCreatedAt(new \DateTime());
//
//            $em->persist($commentaire);
//            $em->flush();
//
//            $this->addFlash('success', 'Votre commentaire a été ajouté.');
//
//            return $this->redirectToRoute('app_photo_show', ['id' => $photo->getId()]);
//        }
//
//        return $this->render('vie_de_l_asso/show.html.twig', [
//            'photo' => $photo,
//            'commentForm' => $form->createView(),
//        ]);
//    }
}
