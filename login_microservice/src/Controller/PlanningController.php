<?php
// src/Controller/PlanningController.php

namespace App\Controller;
use App\Entity\User;
use App\Entity\UserType;
use App\Entity\Planning;
use App\Form\PlanningType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlanningController extends AbstractController
{
    #[Route('/planning/create', name: 'planning_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($planning);
            $entityManager->flush();
            
            $this->addFlash('success', 'Planning created successfully!');
            
            return $this->redirectToRoute('agent');
        }
        
        return $this->render('Planning/Planning.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/planning/edit/{id}', name: 'planning_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Planning $planning): Response
    {
        $form = $this->createForm(PlanningType::class, $planning);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('success', 'Planning updated successfully!');
            
            return $this->redirectToRoute('agent');
        }
        
        return $this->render('Planning/Planning.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
