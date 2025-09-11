<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tesCap29.fr')]
class MessagesFlashController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function index(SessionInterface $session): Response
    {
        // Ajouter un flag à la session pour afficher la carte de Noël
        $session->set('show_christmas_card', true);

        // Retourner la vue d'accueil avec la carte de Noël
        return $this->render('default/messageflash.html.twig');
    }

    #[Route('/close-christmas-card', name: 'close_christmas_card', methods: ['POST'])]
    public function closeChristmasCard(SessionInterface $session): Response
    {
        // Supprimer le flag de session pour ne plus afficher la carte
        $session->set('show_christmas_card', false);

        // Retourner une réponse vide pour l'appel AJAX
        return new Response();
    }
}

