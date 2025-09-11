<?php

namespace App\Entity;

use App\Repository\ChargerMissionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChargerMissionRepository::class)]
class ChargerMission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $information1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $information2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $information3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $information4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $information5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $information6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $information7 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $information8 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getInformation1(): ?string
    {
        return $this->information1;
    }

    public function setInformation1(string $information1): static
    {
        $this->information1 = $information1;

        return $this;
    }

    public function getInformation2(): ?string
    {
        return $this->information2;
    }

    public function setInformation2(?string $information2): static
    {
        $this->information2 = $information2;

        return $this;
    }

    public function getInformation3(): ?string
    {
        return $this->information3;
    }

    public function setInformation3(?string $information3): static
    {
        $this->information3 = $information3;

        return $this;
    }

    public function getInformation4(): ?string
    {
        return $this->information4;
    }

    public function setInformation4(?string $information4): static
    {
        $this->information4 = $information4;

        return $this;
    }

    public function getInformation5(): ?string
    {
        return $this->information5;
    }

    public function setInformation5(?string $information5): static
    {
        $this->information5 = $information5;

        return $this;
    }

    public function getInformation6(): ?string
    {
        return $this->information6;
    }

    public function setInformation6(?string $information6): static
    {
        $this->information6 = $information6;

        return $this;
    }

    public function getInformation7(): ?string
    {
        return $this->information7;
    }

    public function setInformation7(?string $information7): static
    {
        $this->information7 = $information7;

        return $this;
    }

    public function getInformation8(): ?string
    {
        return $this->information8;
    }

    public function setInformation8(?string $information8): static
    {
        $this->information8 = $information8;

        return $this;
    }
}
