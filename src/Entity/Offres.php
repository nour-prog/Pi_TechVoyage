<?php

namespace App\Entity;

use App\Repository\OffresRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: OffresRepository::class)]
#[Broadcast]
class Offres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    
    // #[Assert\NotBlank(message:"ce champs est obligatoire")]
    // #[Assert\Length(min:5,max:10,minMessage:"le titre doit comporter au moins{{limit}} caractére",
    // maxMessage:"le titre ne peut pas depasser {{limit}} caractére")]

    private ?string $title = null;


    // #[Assert\NotBlank(message:"ce champs est obligatoire")]
    // #[Assert\Length(min:10,max:255,minMessage:"la description doit comporter au moins{{limit}} caractére",
    // maxMessage:"la description ne peut pas depasser {{limit}} caractére")]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $published = null;
   
      
    // #[Assert\NotBlank(message:"ce champs est obligatoire")]
    // #[Assert\Range(min:0.0,max:100.0,minMessage:"La valeur doit être supérieure ou égale à {{ limit }}",
    // maxMessage:"La valeur doit être inférieure ou égale à {{ limit }}")]

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;


    // #[Assert\NotBlank(message:"ce champs est obligatoire")]
    // #[Assert\Length(min:10,max:20,minMessage:"le titre doit comporter au moins{{limit}} caractére",
    // maxMessage:"le lieu ne peut pas depasser {{limit}} caractére")]

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;
    public function __construct(?DateTimeImmutable $createdAt = null) {
        if ($createdAt === null) {
            $createdAt = new \DateTimeImmutable();
        }
        $this->createdAt = $createdAt;
    }
    



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

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

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
