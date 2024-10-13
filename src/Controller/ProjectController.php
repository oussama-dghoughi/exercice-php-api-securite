<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Repository\SocietyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    #[Route('/society/{id}/projects', name: 'get_projects_by_society', methods: ['GET'])]
    public function getProjectsBySociety(int $id, SocietyRepository $societyRepository): JsonResponse
    {
        $society = $societyRepository->find($id);
        if (!$society) {
            return new JsonResponse(['error' => 'Society not found'], 404);
        }

        $projects = $society->getProjects(); 
        $projectsArray = [];

        foreach ($projects as $project) {
            $projectsArray[] = [
                'id' => $project->getId(),
                'title' => $project->getTitle(),
                'description' => $project->getDescription(),
                'createdAt' => $project->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse($projectsArray);
    }

    #[Route('/project/{id}', name: 'get_project', methods: ['GET'])]
    public function getProject(int $id, ProjectRepository $projectRepository): JsonResponse
    {
        $project = $projectRepository->find($id);
        if (!$project) {
            return new JsonResponse(['error' => 'Project not found'], 404);
        }

        $projectArray = [
            'id' => $project->getId(),
            'title' => $project->getTitle(),
            'description' => $project->getDescription(),
            'createdAt' => $project->getCreatedAt()->format('Y-m-d H:i:s'),
        ];

        return new JsonResponse($projectArray);
    }

    public function showSocietyProjects(Society $society): JsonResponse
{
    $projects = $society->getProjects();

    $projectsArray = [];
    foreach ($projects as $project) {
        $projectsArray[] = [
            'id' => $project->getId(),
            'title' => $project->getTitle(),
            'description' => $project->getDescription(),
            'createdAt' => $project->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }

    return new JsonResponse($projectsArray);
}

public function createProject($societyId)
{
    $user = $this->getUser(); 
    $role = $this->getDoctrine()->getRepository(UserRole::class)->findOneBy(['user' => $user, 'society' => $societyId]);

    if ($role && in_array($role->getRole(), ['admin', 'manager'])) {
       
    } else {
        throw $this->createAccessDeniedException('Vous n\'avez pas le droit de créer un projet.');
    }
}
}
