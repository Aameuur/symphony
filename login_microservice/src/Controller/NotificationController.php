<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Form\NotificationType;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    #[Route('/notifications', name: 'notification_index')]
    public function index(NotificationRepository $notificationRepository): Response
    {
        $notifications = $notificationRepository->findAll();

        return $this->render('notification/index.html.twig', [
            'notifications' => $notifications,
            'user' => $this->getUser(), // Pass the user object to the template
        ]);
    }

    #[Route('/notification/new', name: 'notification_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $notification = new Notification();
        $form = $this->createForm(NotificationType::class, $notification);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($notification);
            $entityManager->flush();

            $this->addFlash('success', 'Notification created successfully!');

            return $this->redirectToRoute('notification_index');
        }

        return $this->render('notification/create.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(), // Pass the user object to the template
        ]);
    }

    #[Route('/notification/edit/{id}', name: 'notification_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Notification $notification): Response
    {
        $form = $this->createForm(NotificationType::class, $notification);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($notification);
            $entityManager->flush();

            $this->addFlash('success', 'Notification updated successfully!');

            return $this->redirectToRoute('notification_index');
        }

        return $this->render('notification/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(), // Pass the user object to the template
        ]);
    }

    #[Route('/notification/delete/{id}', name: 'notification_delete')]
    public function delete(EntityManagerInterface $entityManager, Notification $notification): Response
    {
        $entityManager->remove($notification);
        $entityManager->flush();

        $this->addFlash('success', 'Notification deleted successfully!');

        return $this->redirectToRoute('notification_index');
    }
}
