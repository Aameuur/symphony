<?php


// src/Controller/AgentRegistrationController.php

namespace App\Controller;

use App\Entity\User;
use App\Form\AgentRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AgentRegistrationController extends AbstractController
{
    #[Route('/register-agent', name: 'app_register_agent')]
    public function registerAgent(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(AgentRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Set the role to ROLE_AGENT for agent registration
            $user->setRoles([User::ROLE_AGENT]);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('agent');
        }

        return $this->render('registration/register_agent.html.twig', [
            'AgentRegistrationForm' => $form->createView(),
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
