<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $couleur = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $energy = null;

    #[ORM\Column]
    private ?int $capacite = null;

    #[ORM\OneToOne(mappedBy: 'voiture', cascade: ['persist', 'remove'])]
    private ?LocationVoiture $locationVoiture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): static
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getEnergy(): ?string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function __toString()
    {
        return $this->getModel() . "(" . $this->getMarque() . ")";
    }

    public function getLocationVoiture(): ?LocationVoiture
    {
        return $this->locationVoiture;
    }

    public function setLocationVoiture(LocationVoiture $locationVoiture): static
    {
        // set the owning side of the relation if necessary
        if ($locationVoiture->getVoiture() !== $this) {
            $locationVoiture->setVoiture($this);
        }

        $this->locationVoiture = $locationVoiture;

        return $this;
    }
}
