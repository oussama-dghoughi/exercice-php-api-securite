<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserAccessTest extends WebTestCase
{
    public function testAdminCanAccessProjects()
    {
        $client = static::createClient();
        $client->loginUser($this->createUserWithRole('admin')); // Méthode pour créer un utilisateur avec un rôle

        $client->request('GET', '/api/projects');
        $this->assertResponseIsSuccessful(); // Vérifie si la réponse est 2xx
    }

    public function testManagerCanCreateProject()
    {
        $client = static::createClient();
        $client->loginUser($this->createUserWithRole('manager'));

        $client->request('POST', '/api/projects', [
            'json' => [
                'title' => 'New Project',
                'description' => 'Project description',
                'createdAt' => new \DateTime(),
            ],
        ]);
        $this->assertResponseIsSuccessful();
    }

    public function testConsultantCannotCreateProject()
    {
        $client = static::createClient();
        $client->loginUser($this->createUserWithRole('consultant'));

        $client->request('POST', '/api/projects', [
            'json' => [
                'title' => 'Forbidden Project',
                'description' => 'This should not be allowed',
                'createdAt' => new \DateTime(),
            ],
        ]);
        $this->assertResponseStatusCodeSame(403); // Vérifie le code 403
    }

    public function testNonMemberCannotAccessProject()
    {
        $client = static::createClient();
        $client->loginUser($this->createUserWithoutMembership());

        $client->request('GET', '/api/projects/1');
        $this->assertResponseStatusCodeSame(403); // Vérifie le code 403
    }

}