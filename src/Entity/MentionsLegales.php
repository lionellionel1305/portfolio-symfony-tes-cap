<?php

namespace App\Entity;

use App\Repository\MentionsLegalesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MentionsLegalesRepository::class)]
class MentionsLegales
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;
    #[ORM\Column(length: 255)]
    private ?string $titre1 = null;
    #[ORM\Column(length: 255)]
    private ?string $titre2 = null;
    #[ORM\Column(length: 255)]
    private ?string $titre3 = null;
    #[ORM\Column(length: 255)]
    private ?string $titre4 = null;
    #[ORM\Column(length: 255)]
    private ?string $titre5 = null;
    #[ORM\Column(length: 255)]
    private ?string $titre6 = null;
    #[ORM\Column(length: 255)]
    private ?string $titre7 = null;
    #[ORM\Column(length: 255)]
    private ?string $titre8 = null;
    #[ORM\Column(length: 255)]
    private ?string $titre9 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description2 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description3 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description4 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description5 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description6 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description7 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description8 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description9 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description10 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description11 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description12 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description13 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description14 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description15 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description16 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description17 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description18 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description19 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description20 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description21 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description22 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description23 = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description24 = null;

    public function getTitre1(): ?string
    {
        return $this->titre1;
    }

    public function setTitre1(?string $titre1): void
    {
        $this->titre1 = $titre1;
    }

    public function getTitre2(): ?string
    {
        return $this->titre2;
    }

    public function setTitre2(?string $titre2): void
    {
        $this->titre2 = $titre2;
    }

    public function getTitre3(): ?string
    {
        return $this->titre3;
    }

    public function setTitre3(?string $titre3): void
    {
        $this->titre3 = $titre3;
    }

    public function getTitre4(): ?string
    {
        return $this->titre4;
    }

    public function setTitre4(?string $titre4): void
    {
        $this->titre4 = $titre4;
    }

    public function getTitre5(): ?string
    {
        return $this->titre5;
    }

    public function setTitre5(?string $titre5): void
    {
        $this->titre5 = $titre5;
    }

    public function getTitre6(): ?string
    {
        return $this->titre6;
    }

    public function setTitre6(?string $titre6): void
    {
        $this->titre6 = $titre6;
    }

    public function getTitre7(): ?string
    {
        return $this->titre7;
    }

    public function setTitre7(?string $titre7): void
    {
        $this->titre7 = $titre7;
    }

    public function getTitre8(): ?string
    {
        return $this->titre8;
    }

    public function setTitre8(?string $titre8): void
    {
        $this->titre8 = $titre8;
    }

    public function getTitre9(): ?string
    {
        return $this->titre9;
    }

    public function setTitre9(?string $titre9): void
    {
        $this->titre9 = $titre9;
    }

    public function getDescription2(): ?string
    {
        return $this->description2;
    }

    public function setDescription2(?string $description2): void
    {
        $this->description2 = $description2;
    }

    public function getDescription3(): ?string
    {
        return $this->description3;
    }

    public function setDescription3(?string $description3): void
    {
        $this->description3 = $description3;
    }

    public function getDescription4(): ?string
    {
        return $this->description4;
    }

    public function setDescription4(?string $description4): void
    {
        $this->description4 = $description4;
    }

    public function getDescription5(): ?string
    {
        return $this->description5;
    }

    public function setDescription5(?string $description5): void
    {
        $this->description5 = $description5;
    }

    public function getDescription6(): ?string
    {
        return $this->description6;
    }

    public function setDescription6(?string $description6): void
    {
        $this->description6 = $description6;
    }

    public function getDescription7(): ?string
    {
        return $this->description7;
    }

    public function setDescription7(?string $description7): void
    {
        $this->description7 = $description7;
    }

    public function getDescription8(): ?string
    {
        return $this->description8;
    }

    public function setDescription8(?string $description8): void
    {
        $this->description8 = $description8;
    }

    public function getDescription9(): ?string
    {
        return $this->description9;
    }

    public function setDescription9(?string $description9): void
    {
        $this->description9 = $description9;
    }

    public function getDescription10(): ?string
    {
        return $this->description10;
    }

    public function setDescription10(?string $description10): void
    {
        $this->description10 = $description10;
    }

    public function getDescription11(): ?string
    {
        return $this->description11;
    }

    public function setDescription11(?string $description11): void
    {
        $this->description11 = $description11;
    }

    public function getDescription12(): ?string
    {
        return $this->description12;
    }

    public function setDescription12(?string $description12): void
    {
        $this->description12 = $description12;
    }

    public function getDescription13(): ?string
    {
        return $this->description13;
    }

    public function setDescription13(?string $description13): void
    {
        $this->description13 = $description13;
    }

    public function getDescription15(): ?string
    {
        return $this->description15;
    }

    public function setDescription15(?string $description15): void
    {
        $this->description15 = $description15;
    }

    public function getDescription14(): ?string
    {
        return $this->description14;
    }

    public function setDescription14(?string $description14): void
    {
        $this->description14 = $description14;
    }

    public function getDescription16(): ?string
    {
        return $this->description16;
    }

    public function setDescription16(?string $description16): void
    {
        $this->description16 = $description16;
    }

    public function getDescription17(): ?string
    {
        return $this->description17;
    }

    public function setDescription17(?string $description17): void
    {
        $this->description17 = $description17;
    }

    public function getDescription18(): ?string
    {
        return $this->description18;
    }

    public function setDescription18(?string $description18): void
    {
        $this->description18 = $description18;
    }

    public function getDescription19(): ?string
    {
        return $this->description19;
    }

    public function setDescription19(?string $description19): void
    {
        $this->description19 = $description19;
    }

    public function getDescription20(): ?string
    {
        return $this->description20;
    }

    public function setDescription20(?string $description20): void
    {
        $this->description20 = $description20;
    }

    public function getDescription21(): ?string
    {
        return $this->description21;
    }

    public function setDescription21(?string $description21): void
    {
        $this->description21 = $description21;
    }

    public function getDescription22(): ?string
    {
        return $this->description22;
    }

    public function setDescription22(?string $description22): void
    {
        $this->description22 = $description22;
    }

    public function getDescription23(): ?string
    {
        return $this->description23;
    }

    public function setDescription23(?string $description23): void
    {
        $this->description23 = $description23;
    }

    public function getDescription24(): ?string
    {
        return $this->description24;
    }

    public function setDescription24(?string $description24): void
    {
        $this->description24 = $description24;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
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
}