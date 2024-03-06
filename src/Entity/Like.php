<?php

namespace App\Entity;
use App\Repository\PublicationRepository;
use App\Repository\LikeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeRepository::class)]
#[ORM\Table(name: '`like`')]
class Like
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Publication::class, mappedBy: 'likee')]
    private Collection $publication;

    #[ORM\Column]
    private ?int $likes = null;

    public function __construct()
    {
        $this->publication = new ArrayCollection();
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

    /**
     * @return Collection<int, Publication>
     */
    public function getPublication(): Collection
    {
        return $this->publication;
    }

    public function addPublication(Publication $publication): static
    {
        if (!$this->publication->contains($publication)) {
            $this->publication->add($publication);
            $publication->setLikee($this);
        }
        return $this;
    }
    

    public function removePublication(Publication $publication): static
    {
        if ($this->publication->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getLikee() === $this) {
                $publication->setLikee(null);
            }
        }

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }
    

}
