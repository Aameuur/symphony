<?php
// src/Controller/HomeController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DeliveryFormType;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(DeliveryFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Process the data, optimize the route, etc.
            // For now, just dump the data
            dump($data);
            // You can redirect or render a response
            // return $this->redirectToRoute('some_route');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new-home', name: 'app_new_home')]
    public function newHome(): Response
    {
        $form = $this->createForm(DeliveryFormType::class);
        return $this->render('home/Delivery.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
        ]);
    }
}
