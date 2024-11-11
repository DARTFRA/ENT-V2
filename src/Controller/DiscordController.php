<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Security\LoginAuthenticator;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscordController extends AbstractController
{
    private UserRepository $userRepository;
    private LoginAuthenticator $loginAuthenticator;

    public function __construct(UserRepository $userRepository, LoginAuthenticator $loginAuthenticator)
    {
        $this->userRepository = $userRepository;
        $this->loginAuthenticator = $loginAuthenticator;
    }

    #[Route('/connect/discord', name: 'connect_discord')]
    public function connect(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry->getClient('discord')->redirect(['identify email']);
    }

    #[Route('/discord/callback', name: 'discord_callback')]
    public function callback(ClientRegistry $clientRegistry, Request $request): Response
    {
        $discordUser = $clientRegistry->getClient('discord')->fetchUser();
        $discordId = $discordUser->getId();

        // Rechercher l'utilisateur dans la base de données avec son ID Discord
        $user = $this->userRepository->findOneBy(['discordId' => $discordId]);

        if (!$user) {
            return $this->redirectToRoute('user_not_found');
        }

        // Authentifie l'utilisateur dans Symfony
        $this->loginAuthenticator->authenticateUser($user);

        // Stocke les informations utilisateur dans la session
        $session = $request->getSession();
        $session->set('username', $user->getUsername());

        // Redirection en fonction du nombre de rôles
        if (count($user->getRoles()) > 1) {
            return $this->redirectToRoute('select_role');
        }

        // Si un seul rôle, définissez-le pour la session
        $session->set('current_role', $user->getRoles()[0]);

        return $this->redirectToRoute('home');
    }
}
