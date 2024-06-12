<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class HomeController extends AbstractController
{
    #[Route('/homes', name: 'app_home')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(DeliveryFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dump($data);
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

    #[Route('/home', name: 'agent')]
    public function MAgent(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $agents = array_filter($users, function($user) {
            return in_array('ROLE_AGENT', $user->getRoles());
        });

        return $this->render('home/agents/index.html.twig', [
            'users' => $agents,
        ]);
    }
}
