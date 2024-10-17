<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Society;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testAddRole()
    {
        $user = new User();
        $society = new Society();

        $user->addRole($society, 'admin');
        $this->assertCount(1, $user->getRoles()); 
    }

    public function testCannotAddMultipleRolesInSameSociety()
    {
        $user = new User();
        $society = new Society();

        $user->addRole($society, 'admin');
        $user->addRole($society, 'manager'); 

        $this->assertCount(1, $user->getRoles()); 
    }
}