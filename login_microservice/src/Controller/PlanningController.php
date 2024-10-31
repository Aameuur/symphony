<?php

// src/Controller/PlanningController.php

namespace App\Controller;

use App\Entity\Planning;
use App\Form\PlanningType;
use App\Entity\Destination;
use App\Entity\Coli;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlanningRepository;
use App\Service\NotificationService; 
use Symfony\Component\HttpFoundation\JsonResponse;
class PlanningController extends AbstractController
{
    private $planningRepository;
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService; // Initialize the notification service
    }

    #[Route('/planning/create', name: 'planning_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
       /*  $locations = [
            'Medina of Tunis' => ['longitude' => 10.1658, 'latitude' => 36.81897],
            'Sidi Bou Said' => ['longitude' => 10.3415, 'latitude' => 36.8687],
            'Carthage' => ['longitude' => 10.3242, 'latitude' => 36.8528],
            'La Marsa' => ['longitude' => 10.3124, 'latitude' => 36.8854],
            'Lac de Tunis' => ['longitude' => 10.2060, 'latitude' => 36.8166],
            'Bardo Museum' => ['longitude' => 10.1356, 'latitude' => 36.8092],
            'Berges du Lac' => ['longitude' => 10.2304, 'latitude' => 36.8340],
            'Gammarth' => ['longitude' => 10.2797, 'latitude' => 36.9486],
            'Manar City' => ['longitude' => 10.1444, 'latitude' => 36.8470],
            'Ariana' => ['longitude' => 10.1936, 'latitude' => 36.8625],
            'El Menzah' => ['longitude' => 10.1461, 'latitude' => 36.8325],
            'Ben Arous' => ['longitude' => 10.2231, 'latitude' => 36.7464],
            'La Goulette' => ['longitude' => 10.3058, 'latitude' => 36.8208],
            'Sidi Hassine' => ['longitude' => 10.0856, 'latitude' => 36.7675],
            'Cité Olympique' => ['longitude' => 10.1780, 'latitude' => 36.8062],
        ];

        // Convert the $locations array for ChoiceType
        $locationChoices = [];
        foreach ($locations as $location => $coords) {
            $locationChoices[$location] = $location;
        } */

        $planning = new Planning();

        // Fetch destinations and colis from the database
        $destinations = $entityManager->getRepository(Destination::class)->findAll();
        $colis = $entityManager->getRepository(Coli::class)->findAll();


        $form = $this->createForm(PlanningType::class, $planning, [
            'destinations' => $destinations,
            'colis' => $colis,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($planning);
            $entityManager->flush();

            return $this->redirectToRoute('show_planning'); // Adjust this to your routing
        }
        /* if ($form->isSubmitted() && $form->isValid()) {
            // Set coordinates based on selected addresses
            $departAddress = $form->get('departAddress')->getData();
            $deliveryAddress = $form->get('deliveryAddress')->getData();

            if (isset($locations[$departAddress])) {
                $planning->setDepartLongitude($locations[$departAddress]['longitude']);
                $planning->setDepartLatitude($locations[$departAddress]['latitude']);
            }

            if (isset($locations[$deliveryAddress])) {
                $planning->setDeliveryLongitude($locations[$deliveryAddress]['longitude']);
                $planning->setDeliveryLatitude($locations[$deliveryAddress]['latitude']);
            }

            $entityManager->persist($planning);
            $entityManager->flush(); */

            // Send notification to the agent's phone number
       /*  if ($planning->getAgent()) { // Check if an agent is associated
            $agentPhoneNumber = $planning->getAgent()->getNumTel(); // Get the agent's phone number
            $message = 'A new planning has been assigned to you: Planning ID ' . $planning->getId(); // Customize your message
            $this->notificationService->sendSms($agentPhoneNumber, $message); // Send SMS to the agent
        }
            $this->addFlash('success', 'Planning created successfully!');

            return $this->redirectToRoute('agent');
        } */

        return $this->render('Planning/Planning.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/planning/edit/{id}', name: 'planning_edit')]
public function edit(Request $request, EntityManagerInterface $entityManager, Planning $planning): Response
{
    // Fetch destinations and colis from the database
    $destinations = $entityManager->getRepository(Destination::class)->findAll();
    $colis = $entityManager->getRepository(Coli::class)->findAll();

    // Create the form with the same parameters as in create method
    $form = $this->createForm(PlanningType::class, $planning, [
        'destinations' => $destinations,
        'colis' => $colis,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($planning);
        $entityManager->flush();

        $this->addFlash('success', 'Planning updated successfully!');
        
        return $this->redirectToRoute('show_planning'); // Adjust this to your route
    }

    return $this->render('Planning/Planning.html.twig', [
        'form' => $form->createView(),
    ]);
}


    #[Route('/planning/list', name: 'show_planning')]
    public function list(Request $request, PlanningRepository $planningRepository): Response
    {
        $plannings = $planningRepository->findAll();

        return $this->render('Planning/show_planning.html.twig', [
            'plannings' => $plannings,
        ]);
    }
    #[Route('/planning/delete/{id}', name: 'delete_planning')]
public function delete(EntityManagerInterface $entityManager, Planning $planning): JsonResponse
{
    try {
        $entityManager->remove($planning);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Planning deleted successfully'], Response::HTTP_OK);
    } catch (\Exception $e) {
        return new JsonResponse(['error' => 'Error deleting planning: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

}
