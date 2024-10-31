<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Form\DestinationType;
use App\Service\DestinationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/destination')]
class DestinationController extends AbstractController
{
    private DestinationService $destinationService;

    public function __construct(DestinationService $destinationService)
    {
        $this->destinationService = $destinationService;
    }

    #[Route('/', name: 'destination_index', methods: ['GET'])]
    public function index(): Response
    {
        $destinations = $this->destinationService->getAllDestinations();
        return $this->render('destination/index.html.twig', [
            'destinations' => $destinations,
        ]);
    }

    #[Route('/new', name: 'destination_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $destination = new Destination();
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->destinationService->addDestination($destination);
            return $this->redirectToRoute('destination_index');
        }

        return $this->render('destination/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'destination_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Destination $destination): Response
    {
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->destinationService->updateDestination($destination);
            return $this->redirectToRoute('destination_index');
        }

        return $this->render('destination/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'destination_delete', methods: ['POST'])]
    public function delete(Request $request, Destination $destination): Response
    {
        if ($this->isCsrfTokenValid('delete'.$destination->getId(), $request->request->get('_token'))) {
            $this->destinationService->deleteDestination($destination);
        }

        return $this->redirectToRoute('destination_index');
    }
}
