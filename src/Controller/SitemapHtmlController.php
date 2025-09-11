<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SitemapHtmlController extends AbstractController
{
    #[Route('/sitemap', name: 'app_sitemap_html', methods: ['GET'])]
    public function sitemapHtml(): Response
    {
        $pages = [
            'Pages principales' => [
                'Accueil' => $this->generateUrl('accueil_accueil'),
                'Contact' => $this->generateUrl('app_contact'),
                'Partenaires' => $this->generateUrl('app_partenaires'),
                'Association' => $this->generateUrl('app_association'),
            ],
            
            'Accompagnement Primaire' => [
                'Primaire' => $this->generateUrl('app_primaire'),
                'Français' => $this->generateUrl('app_francais'),
                'Mathématiques' => $this->generateUrl('app_math'),
                'Histoire-Géographie' => $this->generateUrl('app_hist'),
                'Anglais' => $this->generateUrl('app_anglais'),
                'Loisirs créatifs' => $this->generateUrl('app_loisirs'),
            ],
            
            'Accompagnement Collège' => [
                'Collège' => $this->generateUrl('app_college'),
                'Français' => $this->generateUrl('app_collegeFrancais'),
                'Mathématiques' => $this->generateUrl('app_collegeMath'),
                'Anglais' => $this->generateUrl('app_collegeAnglais'),
                'Physique-Chimie' => $this->generateUrl('app_collegePhysique'),
                'Histoire-Géographie' => $this->generateUrl('app_CollegeHist'),
                'SVT' => $this->generateUrl('app_CollegeSvt'),
                'Technologie' => $this->generateUrl('app_CollegeTechno'),
                'Loisirs créatifs' => $this->generateUrl('app_CollegeLoisir'),
            ],
            
            'Accompagnement Lycée' => [
                'Lycée' => $this->generateUrl('app_lycee'),
                'Français' => $this->generateUrl('app_lyceeFrancais'),
                'Mathématiques' => $this->generateUrl('app_lyceeMath'),
                'Langues' => $this->generateUrl('app_lyceeAnglais'),
                'Physique-Chimie' => $this->generateUrl('app_lyceePhysique'),
                'Histoire-Géographie' => $this->generateUrl('app_lyceeHist'),
                'SVT' => $this->generateUrl('app_lyceeSvt'),
                'Technologie' => $this->generateUrl('app_lyceeTechno'),
                'Loisirs créatifs' => $this->generateUrl('app_lyceeLoisir'),
            ],
            
            'Troubles DYS' => [
                'Tous les DYS' => $this->generateUrl('app_dys'),
                'Dyslexie' => $this->generateUrl('app_dyslexie'),
                'Dyscalculie' => $this->generateUrl('app_dyscalculie'),
                'Dysgraphie' => $this->generateUrl('app_dysgraphie'),
                'Dysorthographie' => $this->generateUrl('app_dysorthographie'),
                'Dysphasie' => $this->generateUrl('app_dysphasie'),
                'Dyspraxie' => $this->generateUrl('app_dyspraxie'),
                'Dyschronie' => $this->generateUrl('app_dyschronie'),
                'TDAH' => $this->generateUrl('app_dys_tdah'),
                'TSA' => $this->generateUrl('app_dys_tsa'),
                'Autres liens DYS' => $this->generateUrl('app_autres_lien_dys'),
            ],
            
            'Famille et Services' => [
                'Pages Famille' => $this->generateUrl('app_famille'),
                'Informations Familles' => $this->generateUrl('app_pages_famille'),
                'Service SNU' => $this->generateUrl('app_service_snu'),
                'Service Civique' => $this->generateUrl('app_scivique'),
                'Charger Mission' => $this->generateUrl('app_charger_mission'),
            ],
            
            'Vie de l\'Association' => [
                'Photos' => $this->generateUrl('app_photo_index'),
                'Documents' => $this->generateUrl('app_document_index'),
            ],
            
            'Pages légales' => [
                'Mentions légales' => $this->generateUrl('app_mentions_legales'),
            ],
        ];

        return $this->render('sitemap.html.twig', [
            'pages' => $pages,
        ]);
    }
}
