<?php

namespace App\Entity;

use App\Repository\OffresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\OfferReview;

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

    #[ORM\OneToMany(targetEntity: OffreCommentaire::class, mappedBy: 'offres', orphanRemoval: true)]
    private Collection $offreCommentaires;

   

    #[ORM\OneToMany(targetEntity: OfferReview::class, mappedBy: 'OfferList')]
    private Collection $offerReviews;



   
   public function hasUserReviewed($id): bool
   {
    foreach ($this->offerReviews as $review) {
        // Assuming getUserId() method exists on OfferReview entity to get the user ID
        if ($review->getUserId() == $id) {
            return true; // User has reviewed
        }
    }
       return false;
   }
   public function getTotalReview(): int
   {
       return $this->offerReviews->count();
   }

   public function getReviewByUserId($Userid): int
   {
    $reviewval=0;
    foreach ($this->offerReviews as $review) {
        if ($review->getUserId() == $Userid) {
$reviewval=$review->getValue();
        }

    }
       return $reviewval;
   }

   public function getValueReview(): string{
    $totalValue = 0;
    $totalReviews = $this->offerReviews->count();

    // Calculate the total value of reviews
    foreach ($this->offerReviews as $review) {
        // Assuming getValue() method exists on OfferReview entity to get the value of each review
        $totalValue += $review->getValue();
    }

    // Calculate the average value
    if ($totalReviews > 0) {
        $averageValue = ($totalReviews > 0) ? $totalValue / $totalReviews : 0;

        // Format the average value with a comma as thousand separator
        return number_format($averageValue, 2, '.', ',');
    } else {
        return 0; // Return 0 if there are no reviews
    }
   }
   public function addReview($id,$value,$entityManager): self
    {
        if (!$this->hasUserReviewed($id)) {
            $newReview = new OfferReview(); // Assuming OfferReview is the entity for user reviews
            $newReview->setUserId($id); // Assuming the entity is self-referencing
            $newReview->setValue($value);
            $newReview->setOfferList($this);
       
            // Add the new review to the collection
            $this->offerReviews[] = $newReview;
            
            $entityManager->persist($newReview);
            $entityManager->flush();
            $entityManager->persist($this);
            $entityManager->flush();
        }else{

            foreach ($this->offerReviews as $review) {
                // Assuming getUserId() method exists on OfferReview entity to get the user ID
                if ($review->getUserId() == $id) {
                    $newReview = $review; // Assuming OfferReview is the entity for user reviews
                    $newReview->setUserId($id); // Assuming the entity is self-referencing
                    $newReview->setValue($value);
              
               
                    // Add the new review to the collection
                    $this->offerReviews[] = $newReview;
                    
                  
                    $entityManager->persist($newReview);
                    $entityManager->flush();
                    $entityManager->persist($this);
                    $entityManager->flush();

                }
            }
          
        }
        return $this;
    }


    public function __construct(?DateTimeImmutable $createdAt = null) {
        if ($createdAt === null) {
            $createdAt = new \DateTimeImmutable();
        }
        $this->createdAt = $createdAt;
        $this->offreCommentaires = new ArrayCollection();
        $this->offerReviews = new ArrayCollection();
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

    /**
     * @return Collection<int, OffreCommentaire>
     */
    public function getOffreCommentaires(): Collection
    {
        return $this->offreCommentaires;
    }

    public function addOffreCommentaire(OffreCommentaire $offreCommentaire): static
    {
        if (!$this->offreCommentaires->contains($offreCommentaire)) {
            $this->offreCommentaires->add($offreCommentaire);
            $offreCommentaire->setOffres($this);
        }

        return $this;
    }

    public function removeOffreCommentaire(OffreCommentaire $offreCommentaire): static
    {
        if ($this->offreCommentaires->removeElement($offreCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($offreCommentaire->getOffres() === $this) {
                $offreCommentaire->setOffres(null);
            }
        }

        return $this;
    }

    public function getReviewTotal(): ?int
    {
        return $this->ReviewTotal;
    }

    public function setReviewTotal(?int $ReviewTotal): static
    {
        $this->ReviewTotal = $ReviewTotal;

        return $this;
    }

    public function getReviewValue(): ?float
    {
        return $this->ReviewValue;
    }

    public function setReviewValue(?float $ReviewValue): static
    {
        $this->ReviewValue = $ReviewValue;

        return $this;
    }

    /**
     * @return Collection<int, OfferReview>
     */
    public function getOfferReviews(): Collection
    {
        return $this->offerReviews;
    }

    public function addOfferReview(OfferReview $offerReview): static
    {
        if (!$this->offerReviews->contains($offerReview)) {
            $this->offerReviews->add($offerReview);
            $offerReview->setOfferList($this);
        }

        return $this;
    }

    public function removeOfferReview(OfferReview $offerReview): static
    {
        if ($this->offerReviews->removeElement($offerReview)) {
            // set the owning side to null (unless already changed)
            if ($offerReview->getOfferList() === $this) {
                $offerReview->setOfferList(null);
            }
        }

        return $this;
    }
}
