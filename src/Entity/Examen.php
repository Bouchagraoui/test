<?php

namespace App\Entity;

use App\Repository\ExamenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExamenRepository::class)]
class Examen
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'examens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Matiere $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'examensEnseignant')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $enseignant = null;

    #[ORM\OneToMany(mappedBy: 'examen', targetEntity: EtudiantExamen::class, orphanRemoval: true)]
    private Collection $etudiantExamens;

    public function __construct()
    {
        $this->etudiantExamens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): static
    {
        $this->matiere = $matiere;
        return $this;
    }

    public function getEnseignant(): ?User
    {
        return $this->enseignant;
    }

    public function setEnseignant(?User $enseignant): static
    {
        $this->enseignant = $enseignant;
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
            $etudiantExamen->setExamen($this);
        }
        return $this;
    }

    public function removeEtudiantExamen(EtudiantExamen $etudiantExamen): static
    {
        if ($this->etudiantExamens->removeElement($etudiantExamen)) {
            if ($etudiantExamen->getExamen() === $this) {
                $etudiantExamen->setExamen(null);
            }
        }
        return $this;
    }
}