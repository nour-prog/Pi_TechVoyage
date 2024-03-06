<?php

namespace App\Entity;

use App\Repository\OfferReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfferReviewRepository::class)]
class OfferReview
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Value = null;

    #[ORM\Column(length: 255)]
    private ?string $UserId = null;

    #[ORM\ManyToOne(inversedBy: 'offerReviews')]
    private ?Offres $OfferList = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->Value;
    }

    public function setValue(int $Value): static
    {
        $this->Value = $Value;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->UserId;
    }

    public function setUserId(string $UserId): static
    {
        $this->UserId = $UserId;

        return $this;
    }

    public function getOfferList(): ?Offres
    {
        return $this->OfferList;
    }

    public function setOfferList(?Offres $OfferList): static
    {
        $this->OfferList = $OfferList;

        return $this;
    }
}
