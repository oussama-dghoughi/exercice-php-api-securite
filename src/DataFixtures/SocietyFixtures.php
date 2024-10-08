<?php

namespace App\DataFixtures;

use App\Entity\Society;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SocietyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $society1 = new Society();
        $society1->setName('Society One')
                 ->setSiret('12345678901234')
                 ->setAddress('123 Main St, Anytown');

        $manager->persist($society1);

        $society2 = new Society();
        $society2->setName('Society Two')
                 ->setSiret('23456789012345')
                 ->setAddress('456 Elm St, Othertown');

        $manager->persist($society2);

        $manager->flush();
    }
}
