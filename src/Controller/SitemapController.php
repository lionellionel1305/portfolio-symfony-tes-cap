<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'app_sitemap', methods: ['GET'])]
    public function sitemap(): Response
    {
        $urls = [
            // Page d'accueil
            [
                'loc' => $this->generateUrl('accueil_accueil', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '1.0'
            ],
            
            // Pages principales
            [
                'loc' => $this->generateUrl('app_contact', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_partenaires', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_association', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            
            // Pages éducatives - Primaire
            [
                'loc' => $this->generateUrl('app_primaire', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => $this->generateUrl('app_francais', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_math', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_hist', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_anglais', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_loisirs', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            
            // Pages éducatives - Collège
            [
                'loc' => $this->generateUrl('app_college', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => $this->generateUrl('app_collegeFrancais', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_collegeMath', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_collegeAnglais', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_collegePhysique', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_CollegeHist', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_CollegeSvt', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_CollegeTechno', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'loc' => $this->generateUrl('app_CollegeLoisir', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            
            // Pages éducatives - Lycée
            [
                'loc' => $this->generateUrl('app_lycee', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => $this->generateUrl('app_lyceeFrancais', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_lyceeMath', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_lyceeAnglais', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_lyceePhysique', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_lyceeHist', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_lyceeSvt', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_lyceeTechno', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'loc' => $this->generateUrl('app_lyceeLoisir', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            
            // Pages DYS
            [
                'loc' => $this->generateUrl('app_dys', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.9'
            ],
            [
                'loc' => $this->generateUrl('app_dyslexie', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_dyscalculie', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_dysgraphie', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_dysorthographie', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_dysphasie', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_dyspraxie', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_dyschronie', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_dys_tdah', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_dys_tsa', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_autres_lien_dys', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            
            // Pages famille et services
            [
                'loc' => $this->generateUrl('app_famille', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => $this->generateUrl('app_pages_famille', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => $this->generateUrl('app_service_snu', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'loc' => $this->generateUrl('app_scivique', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            [
                'loc' => $this->generateUrl('app_charger_mission', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            
            // Pages vie de l'association
            [
                'loc' => $this->generateUrl('app_photo_index', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ],
            [
                'loc' => $this->generateUrl('app_document_index', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.6'
            ],
            
            // Pages légales
            [
                'loc' => $this->generateUrl('app_mentions_legales', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'yearly',
                'priority' => '0.3'
            ],
        ];

        $response = new Response();
        $response->headers->set('Content-Type', 'application/xml; charset=UTF-8');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . "\n";
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . "\n";
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        $response->setContent($xml);

        return $response;
    }
}