<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Photo
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

   #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imagePath = null;

    /**
     * @Assert\Image(mimeTypes={"image/jpeg", "image/png", "image/gif"})
     */
    private ?File $imageFile = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $createdAt;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(mappedBy: 'photo', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->commentaires = new ArrayCollection();
    }

    /**
     * Cette méthode est appelée avant d'insérer ou de mettre à jour l'entité
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        if ($this->updatedAt === null) {
            $this->updatedAt = new \DateTime();
        }
    }

    /**
     * Si l'image est téléchargée, met à jour le chemin de l'image et le timestamp
     */
    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            // Mettre à jour `updatedAt` si un fichier est téléchargé
            $this->updatedAt = new \DateTime();

            // Définir le chemin de l'image
            $this->imagePath = $this->generateImagePath($imageFile);
        }
    }

    /**
     * Génère un chemin d'image unique en utilisant le nom d'origine du fichier
     */
    private function generateImagePath(File $imageFile): string
    {
        // Générer un nom unique pour l'image
        $safeFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = preg_replace('/[^a-zA-Z0-9]/', '-', $safeFilename); // Nettoyer le nom
        $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

        // Retourner le chemin où le fichier sera déplacé
        return $newFilename;
    }

    /**
     * Déplace le fichier téléchargé dans le répertoire approprié
     */
    public function uploadImage(): void
    {
        if ($this->imageFile) {
            // Déplacer l'image dans un répertoire de stockage
            $this->imageFile->move(
                __DIR__.'/../../public/uploads', // Répertoire où tu souhaites stocker les fichiers
                $this->imagePath // Le nom de fichier généré
            );
        }
    }

    // Getters et setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

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

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setPhoto($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPhoto() === $this) {
                $commentaire->setPhoto(null);
            }
        }

        return $this;
    }
}
