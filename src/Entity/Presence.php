<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
class Presence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Cours::class, inversedBy: 'presences')]
    private ?Cours $cours = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $eleve = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: 'boolean')]
    private bool $present = false;

    // Getters and Setters
}
