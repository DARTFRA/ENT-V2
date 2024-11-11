<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        // Vérifie la session pour voir si l'utilisateur est connecté
        $session = $request->getSession();
        $username = $session->get('username');

        if (!$username) {
            // Redirige vers la page de connexion Discord si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('connect_discord');
        }
        $roles = $session->get('current_role'); // Rôle par défaut si aucun rôle n'est trouvé


        // Si l'utilisateur est connecté, afficher la page avec son nom d'utilisateur
        return $this->render('dashboard/index.html.twig', [
            'username' => $username,
            'role' => $roles,
            'controller_name' => 'DashboardController',
        ]);
    }
}
