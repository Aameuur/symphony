<?php

namespace App\Service;

use App\Repository\TaskRecordRepository;

class ReportGenerator
{
    private $taskRecordRepository;

    public function __construct(TaskRecordRepository $taskRecordRepository)
    {
        $this->taskRecordRepository = $taskRecordRepository;
    }

    public function generateAgentPerformanceReport(int $agentId): array
    {
        // Fetch tasks based on agent ID
        $completedTasks = $this->taskRecordRepository->findBy(['agentId' => $agentId, 'status' => 'completed']);

        $totalTimeSpent = 0;
        $totalDistanceTraveled = 0;

        foreach ($completedTasks as $task) {
            $totalTimeSpent += $task->getEndTime()->getTimestamp() - $task->getStartTime()->getTimestamp();
            $totalDistanceTraveled += $task->getDistanceTraveled();
        }

        return [
            'total_time_spent' => $totalTimeSpent,
            'total_distance_traveled' => $totalDistanceTraveled,
            'task_count' => count($completedTasks),
        ];
    }
}
