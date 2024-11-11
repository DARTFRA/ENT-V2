<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $discordId = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $username = null;


    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'users')]
    private ?Classe $classe = null;

    #[ORM\ManyToMany(targetEntity: Role::class, inversedBy: 'users')]
    #[ORM\JoinTable(name: 'user_roles')]
    private Collection $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscordId(): ?string
    {
        return $this->discordId;
    }

    public function setDiscordId(string $discordId): self
    {
        $this->discordId = $discordId;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Retourne un tableau de noms de rôles compréhensibles par Symfony Security
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles->map(fn($role) => 'ROLE_' . strtoupper($role->getName()))->toArray();
        
        // Ajoute ROLE_USER par défaut
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        $this->roles->removeElement($role);

        return $this;
    }

    /**
     * Méthode requise par UserInterface, ici on peut retourner null car pas de mot de passe
     */
    public function getPassword(): ?string
    {
        return null;
    }

    /**
     * Méthode requise par UserInterface, ici on retourne `discordId` comme identifiant unique
     */
    public function getUserIdentifier(): string
    {
        return $this->discordId;
    }

    /**
     * Méthode requise par UserInterface, peut être vide
     */
    public function eraseCredentials(): void
    {
        // Si tu stockais des informations sensibles, tu pourrais les effacer ici
    }


    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }
}
