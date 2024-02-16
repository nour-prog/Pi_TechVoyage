<?php

namespace App\Entity;

use App\Repository\PromoVolsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoVolsRepository::class)]
class PromoVols
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $pourcentage = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebutPromo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFinPromo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPourcentage(): ?float
    {
        return $this->pourcentage;
    }

    public function setPourcentage(float $pourcentage): static
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getDateDebutPromo(): ?\DateTimeInterface
    {
        return $this->dateDebutPromo;
    }

    public function setDateDebutPromo(\DateTimeInterface $dateDebutPromo): static
    {
        $this->dateDebutPromo = $dateDebutPromo;

        return $this;
    }

    public function getDateFinPromo(): ?\DateTimeInterface
    {
        return $this->dateFinPromo;
    }

    public function setDateFinPromo(\DateTimeInterface $dateFinPromo): static
    {
        $this->dateFinPromo = $dateFinPromo;

        return $this;
    }
}
