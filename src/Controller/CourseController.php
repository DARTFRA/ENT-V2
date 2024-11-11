<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('/cours', name: 'courses')]
    public function index(): Response
    {
        // Ici, tu pourrais récupérer une liste de cours depuis une base de données, par exemple.
        $courses = [
            ['title' => 'Mathématiques', 'description' => 'Cours de mathématiques de niveau avancé'],
            ['title' => 'Physique', 'description' => 'Cours de physique pour les débutants'],
            ['title' => 'Histoire', 'description' => 'Cours d’histoire moderne'],
        ];

        return $this->render('course/index.html.twig', [
            'courses' => $courses,
        ]);
    }
}
