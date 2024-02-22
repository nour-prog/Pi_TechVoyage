<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\OffreCommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreCommentaireRepository::class)]
class OffreCommentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(message:"ce champs est obligatoire")]
    #[Assert\Length(min:3,max:255,minMessage:"le commantaire doit comporter au moins{{limit}} caractére",
    maxMessage:"le commantaire ne peut pas depasser {{limit}} caractére")]

    private ?string $avis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(?string $avis): static
    {
        $this->avis = $avis;

        return $this;
    }
}
