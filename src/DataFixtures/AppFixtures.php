<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Ad;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 30; $i++) {
            $ad = new Ad();
            $ad->setTitle("Titre de l'annonce n°$i")
                ->setSlug("titre-de-l-annonce-n-$i")
                ->setCoverImage("http://placehold.it/1000x300")
                ->setIntroduction("Voici une introduction")
                ->setContent("<p>Voici un contenu.</p>")
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5));

            $manager->persist($ad);
        }


        $manager->flush();
    }
}
