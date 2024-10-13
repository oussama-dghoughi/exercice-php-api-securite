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
        $this->entityManager = $entityManager; // Ajout de l'injection de l'EntityManager
    }

    #[Route('', name: 'get_societies', methods: ['GET'])]
public function getSocieties(): JsonResponse
{
    $societies = $this->societyRepository->findAll();

    // Transformer les sociétés en un tableau JSON
    $societiesArray = [];
    foreach ($societies as $society) {
        $societiesArray[] = [
            'id' => $society->getId(),
            'name' => $society->getName(),
            'siret' => $society->getSiret(),
            'address' => $society->getAddress(),
            'email' => $society->getEmail(), // Ajoutez l'email ici
        ];
    }

    // Retourner les sociétés sous forme de réponse JSON
    return $this->json($societiesArray);
}

    #[Route('/{id}', name: 'get_society', methods: ['GET'])]
    public function getSociety(int $id): JsonResponse
    {
        error_log("Requested Society ID: " . $id);

        $society = $this->societyRepository->find($id);

        if (!$society) {
            return $this->json(['error' => 'Society not found', 'requested_id' => $id], 404);
        }

        return $this->json([
            'id' => $society->getId(),
            'name' => $society->getName(),
            'siret' => $society->getSiret(),
            'address' => $society->getAddress(),
            'email'=>$society->getEmail(),
        ]);
    }

    #[Route('', name: 'add_society', methods: ['POST'])]
    public function addSociety(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'], $data['siret'], $data['address'])) {
            return $this->json(['error' => 'Missing required fields'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $society = new Society();
        $society->setName($data['name']);
        $society->setSiret($data['siret']);
        $society->setAddress($data['address']);

        $this->entityManager->persist($society);
        $this->entityManager->flush();

        return $this->json($society, JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'update_society', methods: ['PUT'])]
    public function updateSociety(int $id, Request $request): JsonResponse
    {
        $society = $this->societyRepository->find($id);
        if (!$society) {
            return $this->json(['error' => 'Society not found'], JsonResponse::HTTP_NOT_FOUND);
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

        $this->entityManager->flush();

        return $this->json([
            'id' => $society->getId(),
            'name' => $society->getName(),
            'siret' => $society->getSiret(),
            'address' => $society->getAddress(),
        ]);
    }

    #[Route('/{id}', name: 'delete_society', methods: ['DELETE'])]
    public function deleteSociety(int $id): JsonResponse
    {
        $society = $this->societyRepository->find($id);
        if (!$society) {
            return $this->json(['error' => 'Society not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($society);
        $this->entityManager->flush();

        return $this->json(['message' => 'Society deleted'], JsonResponse::HTTP_NO_CONTENT);
    }
}
