<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
     
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'users' => $users,
        ]);
    }
    #[Route('/some-feature', name: 'some_feature')]
    public function someFeature(): Response
    {
        return new Response('<html><body>Some Feature</body></html>');
    }

    #[Route('/another-feature', name: 'another_feature')]
    public function anotherFeature(): Response
    {
        return new Response('<html><body>Another Feature</body></html>');
    }
}
