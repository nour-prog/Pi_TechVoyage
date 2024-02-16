<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sujet = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datesoumission = null;

    #[ORM\Column(nullable: true)]
    private ?bool $estTraite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(?string $sujet): static
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDatesoumission(): ?\DateTimeInterface
    {
        return $this->datesoumission;
    }

    public function setDatesoumission(?\DateTimeInterface $datesoumission): static
    {
        $this->datesoumission = $datesoumission;

        return $this;
    }

    public function isEstTraite(): ?bool
    {
        return $this->estTraite;
    }

    public function setEstTraite(?bool $estTraite): static
    {
        $this->estTraite = $estTraite;

        return $this;
    }
}
