<?php

namespace App\Entity;

use App\Repository\VolsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VolsRepository::class)]
class Vols
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duree = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datedepart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datearrive = null;

    #[ORM\Column]
    private ?int $nbrescale = null;

    #[ORM\Column]
    private ?int $nbrplace = null;

    #[ORM\Column(length: 255)]
    private ?string $classe = null;

    #[ORM\Column(length: 255)]
    private ?string $destination = null;

    #[ORM\Column(length: 255)]
    private ?string $pointdepart = null;

    #[ORM\Column]
    private ?float $prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(\DateTimeInterface $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDatedepart(): ?\DateTimeInterface
    {
        return $this->datedepart;
    }

    public function setDatedepart(\DateTimeInterface $datedepart): static
    {
        $this->datedepart = $datedepart;

        return $this;
    }

    public function getDatearrive(): ?\DateTimeInterface
    {
        return $this->datearrive;
    }

    public function setDatearrive(\DateTimeInterface $datearrive): static
    {
        $this->datearrive = $datearrive;

        return $this;
    }

    public function getNbrescale(): ?int
    {
        return $this->nbrescale;
    }

    public function setNbrescale(int $nbrescale): static
    {
        $this->nbrescale = $nbrescale;

        return $this;
    }

    public function getNbrplace(): ?int
    {
        return $this->nbrplace;
    }

    public function setNbrplace(int $nbrplace): static
    {
        $this->nbrplace = $nbrplace;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getPointdepart(): ?string
    {
        return $this->pointdepart;
    }

    public function setPointdepart(string $pointdepart): static
    {
        $this->pointdepart = $pointdepart;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }
}
