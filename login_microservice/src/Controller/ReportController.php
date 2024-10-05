<?php
// src/Controller/ReportController.php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TaskRecordRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private TaskRecordRepository $taskRecordRepository;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, TaskRecordRepository $taskRecordRepository, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->taskRecordRepository = $taskRecordRepository;
        $this->userRepository = $userRepository;
    }

    #[Route('/report/agents', name: 'report_agents', methods: ['GET'])]
    public function agentReport(): Response
    {
        // Fetch all agents
        //$agents = $this->userRepository->findAll();
        

        // Fetch all agents (only users with the role 'ROLE_AGENT')
    $agents = $this->userRepository->createQueryBuilder('u')
    ->where('u.roles LIKE :role')
    ->setParameter('role', '%ROLE_AGENT%')
    ->getQuery()
    ->getResult();

        $agentsReports = [];
        foreach ($agents as $agent) {
            
            // Fetch task records for each agent
            $taskRecords = $this->taskRecordRepository->findBy(['agentId' => $agent->getId()]);

            // Calculate report data for each agent
            $taskCount = count($taskRecords);
            $totalTimeSpent = array_sum(array_map(function ($record) {
                return $record->getEndTime()->getTimestamp() - $record->getStartTime()->getTimestamp();
            }, $taskRecords));
            $totalTimeSpentInHours = $totalTimeSpent / 3600; // Convert seconds to hours

            $totalDistanceTraveled = array_sum(array_map(function ($record) {
                return $record->getDistanceTraveled() ?? 0; // Default to 0 if null
            }, $taskRecords));

            $agentsReports[] = [
                'agent' => [
        'firstName' => $agent->getFirstName(),
        'lastName' => $agent->getLastName(),
    ],
                'task_count' => $taskCount,
                'total_time_spent' => $totalTimeSpentInHours,
                'total_distance_traveled' => $totalDistanceTraveled,
            ];
        }

        return $this->render('report/agent_report.html.twig', [
            'agentsReports' => $agentsReports,
        ]);
    }
}
