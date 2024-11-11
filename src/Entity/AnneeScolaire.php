<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnneeScolaireRepository::class)]
class AnneeScolaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null; // Exemple: "2023-2024"

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $debut = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $fin = null;

    // Getters and Setters
}
