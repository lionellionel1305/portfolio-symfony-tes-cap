<?php

namespace App\Entity;

use App\Repository\DysRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DysRepository::class)]
class Dys
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $typeDys = null;

    public function getTypeDys(): ?string
    {
        return $this->typeDys;
    }

    public function setTypeDys(?string $typeDys): void
    {
        $this->typeDys = $typeDys;
    }

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $editableTitle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description1 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description3 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description4 = null;

    public function getEditableTitle(): ?string
    {
        return $this->editableTitle;
    }

    public function setEditableTitle(?string $editableTitle): void
    {
        $this->editableTitle = $editableTitle;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description5 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription1(): ?string
    {
        return $this->description1;
    }

    public function setDescription1(?string $description1): static
    {
        $this->description1 = $description1;

        return $this;
    }

    public function getDescription2(): ?string
    {
        return $this->description2;
    }

    public function setDescription2(?string $description2): static
    {
        $this->description2 = $description2;

        return $this;
    }

    public function getDescription3(): ?string
    {
        return $this->description3;
    }

    public function setDescription3(?string $description3): static
    {
        $this->description3 = $description3;

        return $this;
    }

    public function getDescription4(): ?string
    {
        return $this->description4;
    }

    public function setDescription4(?string $description4): static
    {
        $this->description4 = $description4;

        return $this;
    }

    public function getDescription5(): ?string
    {
        return $this->description5;
    }

    public function setDescription5(?string $description5): static
    {
        $this->description5 = $description5;

        return $this;
    }
}
