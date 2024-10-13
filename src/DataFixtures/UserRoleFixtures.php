<?php

namespace App\DataFixtures;

use App\Entity\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserRoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $userRole1 = new UserRole();
        $userRole1->setUser($user1) 
                  ->setSociety($society1) 
                  ->setRole('admin');
        $manager->persist($userRole1);

        
        $userRole2 = new UserRole();
        $userRole2->setUser($user2) 
                  ->setSociety($society2) 
                  ->setRole('manager');
        $manager->persist($userRole2);

       
        $userRole3 = new UserRole();
        $userRole3->setUser($user3) 
                  ->setSociety($society3) 
                  ->setRole('consultant');
        $manager->persist($userRole3);

        
        $manager->flush();
    }
}
