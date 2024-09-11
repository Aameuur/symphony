<?php
// src/Controller/ReportController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/report/agent/{agentId}', name: 'report_agent' , methods:"GET")]
    public function agentReport(int $agentId): Response
    {
        // Simuler les données du rapport pour l'agent
        $report = [
            'task_count' => 50, // Exemple de données
            'total_time_spent' => 36000, // Exemple: 10 heures en secondes
            'total_distance_traveled' => 120, // Exemple: 120 km
        ];

        return $this->render('report/agent_report.html.twig', [
            'report' => $report, // Passer les données à la vue
            'agentId' => $agentId,
        ]);
    }   
}
