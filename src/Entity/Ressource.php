<?php

namespace App\Entity;

use App\Repository\RessourceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RessourceRepository::class)]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeR = null;

    #[ORM\Column(length: 255)]
    private ?string $nomR = null;

    #[ORM\Column(length: 255)]
    private ?string $fileR = null;

    // Ajoutez la nouvelle propriété dureeR
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dureeR = null;  // nullable permet de laisser cette colonne vide si besoin

    // Getters et Setters
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdfressource = null;  // nullable permet de laisser cette colonne vide si besoin


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeR(): ?string
    {
        return $this->typeR;
    }

    public function setTypeR(string $typeR): self
    {
        $this->typeR = $typeR;
        return $this;
    }

    public function getNomR(): ?string
    {
        return $this->nomR;
    }

    public function setNomR(string $nomR): self
    {
        $this->nomR = $nomR;
        return $this;
    }

    public function getFileR(): ?string
    {
        return $this->fileR;
    }

    public function setFileR(string $fileR): self
    {
        $this->fileR = $fileR;
        return $this;
    }

    // Getters et Setters pour dureeR
    public function getDureeR(): ?string
    {
        return $this->dureeR;
    }

    public function setDureeR(?string $dureeR): self
    {
        $this->dureeR = $dureeR;
        return $this;
    }
    
    public function getPdfressource(): ?string
    {
        return $this->pdfressource;
    }

    public function setPdfressource(?string $pdfressource): static
    {
        $this->pdfressource = $pdfressource;

        return $this;
    }
}
