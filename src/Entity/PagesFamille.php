<?php

namespace App\Entity;

use App\Repository\PagesFamilleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagesFamilleRepository::class)]

class PagesFamille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $information1 = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $information2 = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $information3 = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $information4 = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $information5 = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $information6 = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $information7 = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $information8 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function getInformation1(): ?string
    {
        return $this->information1;
    }

    public function setInformation1(?string $info): self
    {
        $this->information1 = $info;
        return $this;
    }

    public function getInformation2(): ?string
    {
        return $this->information2;
    }

    public function setInformation2(?string $info): self
    {
        $this->information2 = $info;
        return $this;
    }

    public function getInformation3(): ?string
    {
        return $this->information3;
    }

    public function setInformation3(?string $info): self
    {
        $this->information3 = $info;
        return $this;
    }

    public function getInformation4(): ?string
    {
        return $this->information4;
    }

    public function setInformation4(?string $info): self
    {
        $this->information4 = $info;
        return $this;
    }

    public function getInformation5(): ?string
    {
        return $this->information5;
    }

    public function setInformation5(?string $info): self
    {
        $this->information5 = $info;
        return $this;
    }

    public function getInformation6(): ?string
    {
        return $this->information6;
    }

    public function setInformation6(?string $info): self
    {
        $this->information6 = $info;
        return $this;
    }

    public function getInformation7(): ?string
    {
        return $this->information7;
    }

    public function setInformation7(?string $info): self
    {
        $this->information7 = $info;
        return $this;
    }

    public function getInformation8(): ?string
    {
        return $this->information8;
    }

    public function setInformation8(?string $info): self
    {
        $this->information8 = $info;
        return $this;
    }
}