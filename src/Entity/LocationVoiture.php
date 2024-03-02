<?php

namespace App\Entity;

use App\Repository\LocationVoitureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationVoitureRepository::class)]
class LocationVoiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datefin = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $status = "disponible";

    #[ORM\OneToOne(inversedBy: 'locationVoiture', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Voiture $voiture = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): static
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(Voiture $voiture): static
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getObject()
    {
        return [
            "prix" => $this->getPrix(),
            "dateDebut" => $this->getDateDebut(),
            "datefin" => $this->getDatefin(),
            "type" => $this->getType(),
            "status" => $this->getStatus(),
            "voiture" => $this->getVoiture()->__toString(),
        ];
    }

    public function __toString()
    {
        return $this->getStatus();
    }
}
