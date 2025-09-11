<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ErrorController extends AbstractController
{
    public function show(\Throwable $exception): Response
    {
        // Log l'erreur si nécessaire
        
        return $this->render('bundles/TwigBundle/Exception/error500.html.twig', [
            'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'status_text' => 'Internal Server Error'
        ], new Response('', Response::HTTP_INTERNAL_SERVER_ERROR));
    }
}