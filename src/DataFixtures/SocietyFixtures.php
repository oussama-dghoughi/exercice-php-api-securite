<?php

namespace App\DataFixtures;

use App\Entity\Society;
use App\Entity\Project; 
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SocietyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $societyOne = (new Society())
            ->setName('Society One')
            ->setSiret('12345678901234')
            ->setAddress('123 Main St, Anytown')
            ->setEmail('contact@societyone.com');

        
        $projectOneA = (new Project())
            ->setTitle('Projet One A')
            ->setDescription('Description du projet One A')
            ->setCreatedAt(new \DateTimeImmutable()) 
            ->setSociety($societyOne); 

        $projectOneB = (new Project())
            ->setTitle('Projet One B')
            ->setDescription('Description du projet One B')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setSociety($societyOne);

        $manager->persist($societyOne);
        $manager->persist($projectOneA);
        $manager->persist($projectOneB);

        
        $societyTwo = (new Society())
            ->setName('Society Two')
            ->setSiret('23456789012345')
            ->setAddress('456 Elm St, Othertown')
            ->setEmail('info@societytwo.com');

        
        $projectTwoA = (new Project())
            ->setTitle('Projet Two A')
            ->setDescription('Description du projet Two A')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setSociety($societyTwo);

        $manager->persist($societyTwo);
        $manager->persist($projectTwoA);

        
        $societyThree = (new Society())
            ->setName('Society Three')
            ->setSiret('34567890123456')
            ->setAddress('789 Oak St, Sometown')
            ->setEmail('contact@societythree.com');

       
        $projectThreeA = (new Project())
            ->setTitle('Projet Three A')
            ->setDescription('Description du projet Three A')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setSociety($societyThree);

        $manager->persist($societyThree);
        $manager->persist($projectThreeA);

        
        $manager->flush();
    }
}
