<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleSelectionController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/role/selection', name: 'select_role')]
    public function selectRole(): Response
    {



        // dd($this->getUser()); // Vérifie si l'utilisateur est bien authentifié

        // Récupère l'utilisateur connecté
        /** @var User|null $user */
        $user = $this->getUser();

        // Vérifie si l'utilisateur est bien connecté
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à cette page.');
            return $this->redirectToRoute('connect_discord'); // Remplacez 'login' par la route de connexion appropriée
        }

        // Récupère les rôles associés à l'utilisateur depuis la base de données
        $roles = $user->getRoles(); // Cette méthode retourne les noms des rôles, ex: ["ROLE_PROFESSEUR"]

        // Vérifie si l'utilisateur n'a qu'un seul rôle
        if (count($roles) < 2) {
            // Si un seul rôle, le définit directement dans la session
            $this->get('session')->set('current_role', $roles[0]);
            return $this->redirectToRoute('dashboard');
        }

        // Affiche la vue de sélection des rôles
        return $this->render('role_selection/index.html.twig', [
            'roles' => $roles,
        ]);
    }

    #[Route('/set-role', name: 'set_role')]
    public function setRole(Request $request): Response
    {
        $session = $request->getSession();
        $selectedRole = $request->query->get('role');

        // Récupère l'utilisateur connecté
        /** @var User|null $user */
        $user = $this->getUser();
        
        // Vérifie si l'utilisateur est bien connecté
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour définir un rôle.');
            return $this->redirectToRoute('login'); // Remplacez 'login' par la route de connexion appropriée
        }
        
        // Vérifie si le rôle choisi est valide pour cet utilisateur
        $roles = $user->getRoles();
        if (!in_array($selectedRole, $roles)) {
            $this->addFlash('error', 'Rôle sélectionné invalide ou non attribué à votre profil.');
            return $this->redirectToRoute('select_role');
        }

        // Définit le rôle actuel pour la session
        $session->set('current_role', $selectedRole);
        $this->addFlash('success', 'Rôle défini avec succès : ' . $selectedRole);

        return $this->redirectToRoute('home');
    }
}
