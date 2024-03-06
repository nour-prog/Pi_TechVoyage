<?php

namespace App\Entity;

use App\Repository\ReclamationCommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ReclamationCommentaireRepository::class)]
class ReclamationCommentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(message: "Le contenu ne peut pas être vide.")]
    #[Assert\Length(min : 3,max: 255, minMessage : "Le contenu doit comporter au moins {{ limit }} caractères",
    maxMessage: "Le contenu ne peut pas dépasser {{ limit }} caractères")]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'reclamationCommentaires')]
    private ?Reclamation $Reclamation = null;

    #[ORM\ManyToOne(inversedBy: 'reclamationCommentaires')]
    private ?User $User = null;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getReclamation(): ?Reclamation
    {
        return $this->Reclamation;
    }

    public function setReclamation(?Reclamation $Reclamation): static
    {
        $this->Reclamation = $Reclamation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
