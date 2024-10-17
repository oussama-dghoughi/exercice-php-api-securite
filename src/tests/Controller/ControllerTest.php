<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProjectControllerTest extends WebTestCase
{
    public function testAdminCanCreateProject()
    {
        $client = static::createClient();
        $client->loginUser($this->createUserWithRole('admin'));

        $client->request('POST', '/api/projects', [
            'json' => [
                'title' => 'New Admin Project',
                'description' => 'Project description',
                'createdAt' => (new \DateTime())->format('Y-m-d H:i:s'), 
            ],
        ]);
        
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED); 
    }

    public function testManagerCanModifyProject()
    {
        $client = static::createClient();
        $client->loginUser($this->createUserWithRole('manager'));

        
        $client->request('PUT', '/api/projects/1', [
            'json' => [
                'title' => 'Updated Project Title',
                'description' => 'Updated description',
                'createdAt' => (new \DateTime())->format('Y-m-d H:i:s'),
            ],
        ]);
        
        $this->assertResponseStatusCodeSame(Response::HTTP_OK); 
    }

    public function testConsultantCannotModifyProject()
    {
        $client = static::createClient();
        $client->loginUser($this->createUserWithRole('consultant'));

        // Tentative de modification d'un projet
        $client->request('PUT', '/api/projects/1', [
            'json' => [
                'title' => 'Unauthorized Update',
                'description' => 'This should not be allowed',
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testNonMemberCannotAccessProject()
    {
        $client = static::createClient();
        $client->loginUser($this->createUserWithoutMembership());

        // Tentative d'accès à un projet
        $client->request('GET', '/api/projects/1');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN); 
    }

}