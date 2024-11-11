<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LoginAuthenticator
{
    private TokenStorageInterface $tokenStorage;
    private UserCheckerInterface $userChecker;

    public function __construct(TokenStorageInterface $tokenStorage, UserCheckerInterface $userChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->userChecker = $userChecker;
    }

    public function authenticateUser(UserInterface $user): void
    {
        $this->userChecker->checkPreAuth($user);

        $token = new UsernamePasswordToken($user, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);
    }
}
