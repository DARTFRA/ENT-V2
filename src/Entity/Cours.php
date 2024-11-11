<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CoursRepository;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    public const SEMAINE_TOUTES = 'toutes';
    public const SEMAINE_PAIRE = 'paire';
    public const SEMAINE_IMPAIRE = 'impaire';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'cours')]
    private ?Classe $classe = null;

    #[ORM\ManyToOne(targetEntity: Matiere::class)]
    private ?Matiere $matiere = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $jourSemaine = null; // Lundi, Mardi, etc.

    #[ORM\Column(type: 'time')]
    private ?\DateTimeInterface $heure = null;

    #[ORM\Column(type: 'boolean')]
    private bool $repetition = true;

    #[ORM\Column(type: 'string', length: 10)]
    private ?string $semaineType = self::SEMAINE_TOUTES; // Par défaut "toutes"

    #[ORM\ManyToOne(targetEntity: AnneeScolaire::class)]
    private ?AnneeScolaire $anneeScolaire = null;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Presence::class)]
    private Collection $presences;

    public function __construct()
    {
        $this->presences = new ArrayCollection();
    }

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getJourSemaine(): ?string
    {
        return $this->jourSemaine;
    }

    public function setJourSemaine(string $jourSemaine): self
    {
        $this->jourSemaine = $jourSemaine;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function isRepetition(): bool
    {
        return $this->repetition;
    }

    public function setRepetition(bool $repetition): self
    {
        $this->repetition = $repetition;

        return $this;
    }

    public function getSemaineType(): ?string
    {
        return $this->semaineType;
    }

    public function setSemaineType(string $semaineType): self
    {
        if (!in_array($semaineType, [self::SEMAINE_TOUTES, self::SEMAINE_PAIRE, self::SEMAINE_IMPAIRE])) {
            throw new \InvalidArgumentException("Type de semaine invalide");
        }

        $this->semaineType = $semaineType;

        return $this;
    }

    public function getAnneeScolaire(): ?AnneeScolaire
    {
        return $this->anneeScolaire;
    }

    public function setAnneeScolaire(?AnneeScolaire $anneeScolaire): self
    {
        $this->anneeScolaire = $anneeScolaire;

        return $this;
    }

    /**
     * @return Collection|Presence[]
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(Presence $presence): self
    {
        if (!$this->presences->contains($presence)) {
            $this->presences[] = $presence;
            $presence->setCours($this);
        }

        return $this;
    }

    public function removePresence(Presence $presence): self
    {
        if ($this->presences->removeElement($presence)) {
            // Set the owning side to null (unless already changed)
            if ($presence->getCours() === $this) {
                $presence->setCours(null);
            }
        }

        return $this;
    }
}
