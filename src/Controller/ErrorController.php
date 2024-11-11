<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/user-not-found', name: 'user_not_found')]
    public function userNotFound(): Response
    {
        return $this->render('error/user_not_found.html.twig');
    }
}
