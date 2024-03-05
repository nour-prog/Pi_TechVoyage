<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "Ce champ est obligatoire. Veuillez entrer votre mail.")]
    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Ce champ est obligatoire. Veuillez entrer votre nom.")]
    #[Assert\Length(min : 3,max: 255, minMessage : "Le nom doit comporter au moins {{ limit }} caractères",
    maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères")]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Ce champ est obligatoire. Veuillez entrer votre prenom.")]
    #[Assert\Length(min : 3,max: 255, minMessage : "Le prenom doit comporter au moins {{ limit }} caractères",
    maxMessage: "Le prenom ne peut pas dépasser {{ limit }} caractères")]
    private ?string $prenom = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Ce champ est obligatoire. Veuillez entrer votre numéro de téléphone.")]
    #[Assert\Length(min : 8,max: 13, minMessage : "Le numéro de téléphone doit comporter au moins {{ limit }} chiffres",
    maxMessage: "Le numéro de téléphone ne peut pas dépasser {{ limit }} chiffres")]
    private ?int $num_tel = null;

    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'user')]
    private Collection $reclamations;

    #[ORM\OneToMany(targetEntity: ReclamationCommentaire::class, mappedBy: 'User')]
    private Collection $reclamationCommentaires;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagefilename = null;

    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
        $this->reclamationCommentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    
    public function isAdmin(): bool
      {
      return in_array("ROLE_ADMIN", $this->getRoles());
      }

      public function __ToString()
    {
        return(string)$this->getRoles();

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

      public function getPrenom(): ?string
      {
          return $this->prenom;
      }

      public function setPrenom(string $prenom): static
      {
          $this->prenom = $prenom;

          return $this;
      }

      public function getNumTel(): ?int
      {
          return $this->num_tel;
      }

      public function setNumTel(int $num_tel): static
      {
          $this->num_tel = $num_tel;

          return $this;
      }

      /**
       * @return Collection<int, Reclamation>
       */
      public function getReclamations(): Collection
      {
          return $this->reclamations;
      }

      public function addReclamation(Reclamation $reclamation): static
      {
          if (!$this->reclamations->contains($reclamation)) {
              $this->reclamations->add($reclamation);
              $reclamation->setUser($this);
          }

          return $this;
      }

      public function removeReclamation(Reclamation $reclamation): static
      {
          if ($this->reclamations->removeElement($reclamation)) {
              // set the owning side to null (unless already changed)
              if ($reclamation->getUser() === $this) {
                  $reclamation->setUser(null);
              }
          }

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
              $reclamationCommentaire->setUser($this);
          }

          return $this;
      }

      public function removeReclamationCommentaire(ReclamationCommentaire $reclamationCommentaire): static
      {
          if ($this->reclamationCommentaires->removeElement($reclamationCommentaire)) {
              // set the owning side to null (unless already changed)
              if ($reclamationCommentaire->getUser() === $this) {
                  $reclamationCommentaire->setUser(null);
              }
          }

          return $this;
      }
      
      public function getImagefilename(): ?string
      {
          return $this->imagefilename;
      }

      public function setImagefilename(?string $imagefilename): static
      {
          $this->imagefilename = $imagefilename;

          return $this;
      }
}    
