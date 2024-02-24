<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]

    #[Assert\NotBlank(message: "Ce champ est obligatoire. Veuillez entrer un sujet.")]
    #[Assert\Length(min : 3,max: 255, minMessage : "Le sujet doit comporter au moins {{ limit }} caractères",
    maxMessage: "Le sujet ne peut pas dépasser {{ limit }} caractères")]
    private ?string $sujet = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]

    #[Assert\NotBlank(message: "Veuillez fournir une description pour cette réclamation.")]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datesoumission = null;
   

    #[ORM\Column(nullable: true)]
    private ?bool $estTraite = false;

    #[ORM\OneToMany(targetEntity: ReclamationCommentaire::class, mappedBy: 'Reclamation', cascade: ['persist', 'remove']    )]
    private Collection $reclamationCommentaires;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    private ?User $user = null;

    public function __construct()
    {
        $this->reclamationCommentaires = new ArrayCollection();
        $this->datesoumission = new \DateTime();

    }

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

    /**
     * @return Collection<int, ReclamationCommentaire>
     */
    public function getReclamationCommentaires(): Collection
    {
        return $this->reclamationCommentaires;
    }

    public function addReclamationCommentaire(ReclamationCommentaire $reclamationCommentaire): static
    {
        if (!$this->reclamationCommentaires->contains($reclamationCommentaire)) {
            $this->reclamationCommentaires->add($reclamationCommentaire);
            $reclamationCommentaire->setReclamation($this);
        }

        return $this;
    }

    public function removeReclamationCommentaire(ReclamationCommentaire $reclamationCommentaire): static
    {
        if ($this->reclamationCommentaires->removeElement($reclamationCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($reclamationCommentaire->getReclamation() === $this) {
                $reclamationCommentaire->setReclamation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return(string)$this->getSujet();
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
