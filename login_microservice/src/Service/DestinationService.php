<?php
namespace App\Service;

use App\Entity\Destination;
use App\Repository\DestinationRepository;
use Doctrine\ORM\EntityManagerInterface;

class DestinationService
{
    private DestinationRepository $destinationRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(DestinationRepository $destinationRepository, EntityManagerInterface $entityManager)
    {
        $this->destinationRepository = $destinationRepository;
        $this->entityManager = $entityManager;
    }
    public function getAllDestinations(): array
    {
        return $this->destinationRepository->findAll();
    }
    public function addDestination(Destination $destination): void
    {
        $this->entityManager->persist($destination);
        $this->entityManager->flush();
    }

    public function updateDestination(Destination $destination): void
    {
        $this->entityManager->flush();
    }

    public function deleteDestination(Destination $destination): void
    {
        $this->entityManager->remove($destination);
        $this->entityManager->flush();
    }
}
