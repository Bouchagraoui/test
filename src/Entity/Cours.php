<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomC = null;

    #[ORM\Column]
    private ?int $dureeC = null;

    #[ORM\Column(length: 255)]
    private ?int $periodeC = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionC = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomC(): ?string
    {
        return $this->nomC;
    }

    public function setNomC(string $nomC): static
    {
        $this->nomC = $nomC;

        return $this;
    }

    public function getDureeC(): ?int
    {
        return $this->dureeC;
    }

    public function setDureeC(int $dureeC): static
    {
        $this->dureeC = $dureeC;

        return $this;
    }

    public function getPeriodeC(): ?int
    {
        return $this->periodeC;
    }

    public function setPeriodeC(int $periodeC): static
    {
        $this->periodeC = $periodeC;

        return $this;
    }

    public function getDescriptionC(): ?string
    {
        return $this->descriptionC;
    }

    public function setDescriptionC(string $descriptionC): static
    {
        $this->descriptionC = $descriptionC;

        return $this;
    }
}
