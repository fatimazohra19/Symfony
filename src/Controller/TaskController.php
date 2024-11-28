<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route(path: '/tache',name:'tache')]

    public function showTask(): Response
    {
        // Exemple de données de tâche
        $task = [
            'dueDate' => new \DateTime('2024-12-01'),
            'description' => 'Ceci est une description très longue qui sera tronquée.',
            'priority' => 'high', // ou 'normal'
        ];

        return $this->render('exemple.html.twig', [
            'task' => $task,
        ]);
    }
}
