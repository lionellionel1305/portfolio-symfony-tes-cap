<?php

namespace App\DataFixtures;

use App\Entity\Accueil;
use App\Entity\Association;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AccueilFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $accueil = new accueil();
        $accueil->setDescription(
            "Créée en 2007, l'association T'es Cap a pour mission d'accompagner les enfants en difficulté scolaire, quelles que soient les raisons de ces difficultés, sans discrimination, de manière individuelle et directement au domicile des familles.

Aujourd'hui, T'es Cap est active dans une cinquantaine de communes du Finistère-sud, offrant un soutien précieux et personnalisé à de nombreux enfants et leurs familles.

Notre association met un point d'honneur à promouvoir une attitude de respect mutuel entre les bénévoles et les familles bénéficiaires. Nous croyons fermement que la collaboration et la confiance sont essentielles pour créer un environnement propice à l'apprentissage et au développement personnel.

Pour maintenir un niveau d'engagement élevé et continuer à offrir un soutien de qualité, T'es Cap est constamment à la recherche de nouveaux bénévoles et de jeunes en service civique.

Rejoignez-nous et contribuez à faire une différence positive dans la vie des enfants et de leurs familles."
        );
        $manager->persist($accueil);
        $manager->flush();
    }
}
