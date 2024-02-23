<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 20,
        maxMessage: "Title cannot be longer than 20 characters."
    )]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $content = null;

    #[Assert\NotBlank]
    #[Assert\Regex(
      //pattern: "/^[^\s]+\.[^\s]+$/",
      pattern: "/^[^\s]+\.(png|gif|bmp)$/i",
      message: "The value '{{ value }}' is not a valid file path."
    )
    ]
 
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\OneToMany(targetEntity: ForumCommentaire::class, mappedBy: 'publication', cascade: ['remove'])]

    private Collection $comments;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(ForumCommentaire $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPublication($this);
        }

        return $this;
    }
    public function removeComment(ForumCommentaire $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPublication() === $this) {
                $comment->setPublication(null);
            }
        }

        return $this;
    }

    // Add this method to the Publication entity
    public function getCreatedAt(): ?\DateTimeInterface
    {
        // Assuming you want the createdAt from the first comment, adjust as needed
        if ($this->comments->isEmpty()) {
            return null; // or handle the case when there are no comments
        }
    
        return $this->comments->first()->getCreatedAt();
    }


}
