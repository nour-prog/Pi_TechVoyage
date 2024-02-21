<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Datedepart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]

    private ?\DateTimeInterface $Dateretour = null;

    #[ORM\Column(length: 255)]
    private ?string $Classe = null;

    #[ORM\Column(length: 255)]
    private ?string $Destinationdepart = null;

    #[ORM\Column(length: 255)]
    private ?string $Destinationretour = null;

    #[ORM\Column]

    #[Assert\Range(
        min: 0,
        notInRangeMessage: ""
    )]
    private ?int $Nbrdepersonne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatedepart(): ?\DateTimeInterface
    {
        return $this->Datedepart;
    }

    public function setDatedepart(\DateTimeInterface $Datedepart): static
    {
        $this->Datedepart = $Datedepart;

        return $this;
    }

    public function getDateretour(): ?\DateTimeInterface
    {
        return $this->Dateretour;
    }

    public function setDateretour(\DateTimeInterface $Dateretour): static
    {
        $this->Dateretour = $Dateretour;

        return $this;
    }

    public function getClasse(): ?string
    {
        return $this->Classe;
    }

    public function setClasse(string $Classe): static
    {
        $this->Classe = $Classe;

        return $this;
    }

    public function getDestinationdepart(): ?string
    {
        return $this->Destinationdepart;
    }

    public function setDestinationdepart(string $Destinationdepart): static
    {
        $this->Destinationdepart = $Destinationdepart;

        return $this;
    }

    public function getDestinationretour(): ?string
    {
        return $this->Destinationretour;
    }

    public function setDestinationretour(string $Destinationretour): static
    {
        $this->Destinationretour = $Destinationretour;

        return $this;
    }

    public function getNbrdepersonne(): ?int
    {
        return $this->Nbrdepersonne;
    }

    public function setNbrdepersonne(int $Nbrdepersonne): static
    {
        $this->Nbrdepersonne = $Nbrdepersonne;

        return $this;
    }
}