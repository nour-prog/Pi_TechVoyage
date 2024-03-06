<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    //#[Assert\GreaterThan(propertyPath:"Datededepart", message:"La date de retour doit être postérieure à la date de départ.")]

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

    #[ORM\OneToMany(targetEntity: Hotel::class, mappedBy: 'reservation')]
    private Collection $reshotel;

    #[ORM\ManyToMany(targetEntity: Hotel::class, inversedBy: 'reservations')]
    private Collection $nbnb;

    #[ORM\OneToMany(targetEntity: Hotel::class, mappedBy: 'Hotel22')]
    private Collection $nbr1;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $user = null;

    public function __construct()
    {
        $this->reshotel = new ArrayCollection();
        $this->nbnb = new ArrayCollection();
        $this->nbr1 = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Hotel>
     */
    public function getReshotel(): Collection
    {
        return $this->reshotel;
    }

    public function addReshotel(Hotel $reshotel): static
    {
        if (!$this->reshotel->contains($reshotel)) {
            $this->reshotel->add($reshotel);
            $reshotel->setReservation($this);
        }

        return $this;
    }

    public function removeReshotel(Hotel $reshotel): static
    {
        if ($this->reshotel->removeElement($reshotel)) {
            // set the owning side to null (unless already changed)
            if ($reshotel->getReservation() === $this) {
                $reshotel->setReservation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hotel>
     */
    public function getNbnb(): Collection
    {
        return $this->nbnb;
    }

    public function addNbnb(Hotel $nbnb): static
    {
        if (!$this->nbnb->contains($nbnb)) {
            $this->nbnb->add($nbnb);
        }

        return $this;
    }

    public function removeNbnb(Hotel $nbnb): static
    {
        $this->nbnb->removeElement($nbnb);

        return $this;
    }

    /**
     * @return Collection<int, Hotel>
     */
    public function getNbr1(): Collection
    {
        return $this->nbr1;
    }

    public function addNbr1(Hotel $nbr1): static
    {
        if (!$this->nbr1->contains($nbr1)) {
            $this->nbr1->add($nbr1);
            $nbr1->setHotel22($this);
        }

        return $this;
    }

    public function removeNbr1(Hotel $nbr1): static
    {
        if ($this->nbr1->removeElement($nbr1)) {
            // set the owning side to null (unless already changed)
            if ($nbr1->getHotel22() === $this) {
                $nbr1->setHotel22(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}