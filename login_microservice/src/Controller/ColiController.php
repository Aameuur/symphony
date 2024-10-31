<?php

namespace App\Controller;

use App\Entity\Coli;
use App\Form\ColiType;
use App\Repository\ColiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ColiController extends AbstractController
{
    private $coliRepository;
    private $entityManager;

    public function __construct(ColiRepository $coliRepository, EntityManagerInterface $entityManager)
    {
        $this->coliRepository = $coliRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/coli', name: 'coli_index')]
    public function index(): Response
    {
        $colis = $this->coliRepository->findAll();

        return $this->render('coli/index.html.twig', [
            'colis' => $colis,
        ]);
    }

    #[Route('/coli/new', name: 'coli_new')]
    public function new(Request $request): Response
    {
        $coli = new Coli();
        $form = $this->createForm(ColiType::class, $coli);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($coli);
            $this->entityManager->flush();

            return $this->redirectToRoute('coli_index');
        }

        return $this->render('coli/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/coli/{id}/edit', name: 'coli_edit')]
    public function edit(Request $request, Coli $coli): Response
    {
        $form = $this->createForm(ColiType::class, $coli);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('coli_index');
        }

        return $this->render('coli/edit.html.twig', [
            'form' => $form->createView(),
            'coli' => $coli,
        ]);
    }

    #[Route('/coli/{id}/delete', name: 'coli_delete')]
    public function delete(Coli $coli): Response
    {
        $this->entityManager->remove($coli);
        $this->entityManager->flush();

        return $this->redirectToRoute('coli_index');
    }
}
