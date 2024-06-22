<?php

// src/Controller/ColiController.php

namespace App\Controller;

use App\Entity\Coli;
use App\Form\ColiType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ColiController extends AbstractController
{
    #[Route('/coli/new', name: 'coli_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $coli = new Coli();
        $form = $this->createForm(ColiType::class, $coli);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($coli);
            $entityManager->flush();

            return $this->redirectToRoute('coli_success');
        }

        return $this->render('coli/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/coli/success', name: 'coli_success')]
    public function success(): Response
    {
        return new Response('<html><body>Coli successfully created!</body></html>');
    }
}
