<?php

namespace App\DataFixtures;

use App\Entity\Society;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SocietyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer les sociétés avec les nouvelles informations
        $manager->persist((new Society())
            ->setName('Society One')
            ->setSiret('12345678901234')
            ->setAddress('123 Main St, Anytown')
            ->setEmail('contact@societyone.com') // Email correspondant à la société
        );

        $manager->persist((new Society())
            ->setName('Society Two')
            ->setSiret('23456789012345')
            ->setAddress('456 Elm St, Othertown')
            ->setEmail('info@societytwo.com') // Email correspondant à la société
        );

        $manager->persist((new Society())
            ->setName('Society Three')
            ->setSiret('34567890123456')
            ->setAddress('789 Oak St, Sometown')
            ->setEmail('contact@societythree.com') // Email correspondant à la société
        );

        // Enregistrer les modifications dans la base de données
        $manager->flush();
    }
}
