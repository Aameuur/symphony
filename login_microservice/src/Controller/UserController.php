<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/user')]
class UserController extends AbstractController
{
    private $entityManager;
    private $serializer;
    private $validator;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->passwordHasher = $passwordHasher;
    }
 
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();
        $data = $this->serializer->serialize($users, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/new', name: 'app_user_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse('User created successfully', Response::HTTP_CREATED);
        }

        $errors = $this->getFormErrors($form);
        return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): JsonResponse
    {
        $data = $this->serializer->serialize($user, 'json');

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/edit/{id}', name: 'edit_user_form', methods: ['GET'])]
    public function editForm(User $user): Response
    {
        $isAgent = in_array('ROLE_AGENT', $user->getRoles());
        // Render the edit form
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $this->createForm(UserType::class, $user)->createView(),
            'isAgent' => $isAgent,
        ]);
    }
    
    #[Route('/edit/{id}', name: 'edit_user', methods: ['PUT', 'POST', 'GET'])]
public function edit(Request $request, User $user): Response
 {
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $roles = $form->get('roles')->getData();
        if (count($roles) > 1) {
            return new JsonResponse('Only one role can be assigned to a user.', Response::HTTP_BAD_REQUEST);
        }

        $user->setRoles($roles);
        $plainPassword = $form->get('password')->getData();
        if ($plainPassword) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
        }
        $this->entityManager->flush();

        // Redirect to the same page
        return $this->redirectToRoute('app_homepage', ['id' => $user->getId()]);
    }

    $errors = $this->getFormErrors($form);
    return $this->render('home/edit.html.twig', [
        'form' => $form->createView(),
        'errors' => $errors,
    ]);
    }

    
    #[Route('/delete/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function delete(User $user): JsonResponse
    {
        try {
            $this->entityManager->remove($user);
            $this->entityManager->flush();

            return new JsonResponse('User deleted successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse('Error deleting user: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getFormErrors($form)
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }
        return $errors;
    }
}
