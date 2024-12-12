<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'enseignant', targetEntity: Examen::class)]
    private Collection $examensEnseignant;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: EtudiantExamen::class)]
    private Collection $etudiantExamens;

    public function __construct()
    {
        $this->examensEnseignant = new ArrayCollection();
        $this->etudiantExamens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getExamensEnseignant(): Collection
    {
        return $this->examensEnseignant;
    }

    public function addExamenEnseignant(Examen $examen): static
    {
        if (!$this->examensEnseignant->contains($examen)) {
            $this->examensEnseignant->add($examen);
            $examen->setEnseignant($this);
        }
        return $this;
    }

    public function removeExamenEnseignant(Examen $examen): static
    {
        if ($this->examensEnseignant->removeElement($examen)) {
            if ($examen->getEnseignant() === $this) {
                $examen->setEnseignant(null);
            }
        }
        return $this;
    }

    public function getEtudiantExamens(): Collection
    {
        return $this->etudiantExamens;
    }

    public function addEtudiantExamen(EtudiantExamen $etudiantExamen): static
    {
        if (!$this->etudiantExamens->contains($etudiantExamen)) {
            $this->etudiantExamens->add($etudiantExamen);
            $etudiantExamen->setEtudiant($this);
        }
        return $this;
    }

    public function removeEtudiantExamen(EtudiantExamen $etudiantExamen): static
    {
        if ($this->etudiantExamens->removeElement($etudiantExamen)) {
            if ($etudiantExamen->getEtudiant() === $this) {
                $etudiantExamen->setEtudiant(null);
            }
        }
        return $this;
    }

    public function eraseCredentials(): void
    {
    }
}