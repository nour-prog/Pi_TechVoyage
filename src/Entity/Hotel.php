<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
#[Broadcast]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le nom doit etre rempli.")]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z]+$/",
        message:"Le nom  ne doit contenir que des lettres."
    )]
    private ?string $nom = null;

    #[ORM\Column]
     #[Assert\GreaterThanOrEqual(value : 0, message : "Le nombre d'étoiles doit être supérieur ou égal à zéro.")]
    #[Assert\LessThanOrEqual(value:5, message:"Le nombre d'étoiles ne peut pas être supérieur à 5.")]
    private ?int $nbretoile = null;

    #[ORM\Column(length: 255)]
    private ?string $emplacement = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max:255, maxMessage:"L'avis ne peut pas dépasser {{ limit }} caractères.")]
    #[Assert\Regex(
         pattern:"/\b(gros_mot_1|gros_mot_2|gros_mot_3)\b/i",
         match:false,
         message:"L'avis ne peut pas contenir de gros mots."
     )]
    #[Assert\NotBlank(message:"L avis doit etre rempli.")]
    private ?string $avis = null;

    #[ORM\ManyToOne(inversedBy: 'reshotel')]
    private ?Reservation $reservation = null;

    #[ORM\ManyToMany(targetEntity: Reservation::class, mappedBy: 'nbnb')]
    private Collection $reservations;

    #[ORM\ManyToOne(inversedBy: 'nbr1')]
    private ?Reservation $Hotel22 = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNbretoile(): ?int
    {
        return $this->nbretoile;
    }

    public function setNbretoile(int $nbretoile): static
    {
        $this->nbretoile = $nbretoile;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): static
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(string $avis): static
    {
        $this->avis = $avis;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->addNbnb($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removeNbnb($this);
        }

        return $this;
    }

    public function getHotel22(): ?Reservation
    {
        return $this->Hotel22;
    }

    public function setHotel22(?Reservation $Hotel22): static
    {
        $this->Hotel22 = $Hotel22;

        return $this;
    }
}
