<?php

namespace App\Controller;

use App\Entity\Society;
use App\Repository\SocietyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/societies')]
class SocietyController extends AbstractController
{
    private SocietyRepository $societyRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(SocietyRepository $societyRepository, EntityManagerInterface $entityManager)
    {
        $this->societyRepository = $societyRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'get_societies', methods: ['GET'])]
    public function getSocieties(): JsonResponse
    {
        $societies = $this->societyRepository->findAll();
        return $this->json($societies);
    }

    #[Route('/{id}', name: 'get_society', methods: ['GET'])]
    public function getSociety(int $id): JsonResponse
    {
        $society = $this->societyRepository->find($id);

        if (!$society) {
            return $this->json(['error' => 'Society not found'], 404);
        }

        return $this->json($society);
    }

    #[Route('/api/societies', name: 'societies', methods: ['POST'])]
    public function addSociety(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        
        // Vérifiez que les données sont présentes
        if (!isset($data['name'], $data['siret'], $data['address'])) {
            return $this->json(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }

        $society = new Society();
        $society->setName($data['name']);
        $society->setSiret($data['siret']);
        $society->setAddress($data['address']);

        $entityManager->persist($society);
        $entityManager->flush();

        return $this->json($society, Response::HTTP_CREATED);
    }


    #[Route('/api/societies/{id}', name: 'update_society', methods: ['PUT'])]
    public function updateSociety(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $society = $entityManager->getRepository(Society::class)->find($id);
        if (!$society) {
            return $this->json(['error' => 'Society not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        if (isset($data['name'])) {
            $society->setName($data['name']);
        }
        if (isset($data['siret'])) {
            $society->setSiret($data['siret']);
        }
        if (isset($data['address'])) {
            $society->setAddress($data['address']);
        }

        $entityManager->flush();

        return $this->json($society);
    }


    #[Route('/api/societies/{id}', name: 'delete_society', methods: ['DELETE'])]
    public function deleteSociety(int $id, EntityManagerInterface $entityManager): Response
    {
        $society = $entityManager->getRepository(Society::class)->find($id);
        if (!$society) {
            return $this->json(['error' => 'Society not found'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($society);
        $entityManager->flush();

        return $this->json(['message' => 'Society deleted'], Response::HTTP_NO_CONTENT);
    }

}
