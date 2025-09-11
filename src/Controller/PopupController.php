<?php
// src/Controller/PopupController.php
namespace App\Controller;

use App\Entity\Popup;
use App\Form\PopupType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PopupController extends AbstractController
{
    #[Route('/popup', name: 'popup')]
    public function showPopup(EntityManagerInterface $em): Response
    {
        $popup = $em->getRepository(Popup::class)->findOneBy([]);
            
            if (!$popup) {
                $popup = null; // Ne pas instancier un objet vide
            }
            
        return $this->render('popup/index.html.twig', [
                'popup' => $popup
]);

    }

   #[Route('/popup/edit', name: 'popup_edit')]
   #[IsGranted('ROLE_ADMIN')]
public function editPopup(Request $request, EntityManagerInterface $em)
{
    // Récupérer la pop-up existante (ou null si elle n'existe pas)
    $popup = $em->getRepository(Popup::class)->findOneBy([]);

    // Vérifier si aucune pop-up n'existe
    if (!$popup) {
        $this->addFlash('error', 'Aucune pop-up trouvée à modifier.');
        return $this->redirectToRoute('accueil_accueil');
    }

    // Créer le formulaire
    $form = $this->createForm(PopupType::class, $popup);
    $form->handleRequest($request);

    // Vérifier et sauvegarder les modifications
    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        $this->addFlash('success', 'La pop-up a été mise à jour.');
        return $this->redirectToRoute('accueil_accueil');
    }

    // Rendre le formulaire
    return $this->render('popup/edit.html.twig', [
        'form' => $form->createView(),
    ]);
}

}



