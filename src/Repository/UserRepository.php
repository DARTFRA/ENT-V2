<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Trouver un utilisateur par son discordId.
     */
    public function findOneByDiscordId(string $discordId): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.discordId = :discordId')
            ->setParameter('discordId', $discordId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Trouver les utilisateurs ayant un rôle spécifique.
     */
    public function findByRole(string $roleName): array
    {
        return $this->createQueryBuilder('u')
            ->join('u.roles', 'r')
            ->andWhere('r.name = :roleName')
            ->setParameter('roleName', $roleName)
            ->getQuery()
            ->getResult();
    }
}
