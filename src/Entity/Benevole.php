<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\BenevoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

#[ORM\Entity(repositoryClass: BenevoleRepository::class)]

class Benevole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 150)]
    #[Assert\Length(
        min: 3,
        max: 45,
        minMessage: 'Le nom doit contenir au moins {{ limit }} lettres.',
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} lettres.'
    )]
    #[Assert\Regex(
        pattern: '/^[A-Za-zÀ-ÿ\s\-]+$/',  // Vérifie que toute la chaîne est valide
        message: 'Le nom ne peut contenir que des lettres, des espaces ou des tirets.'
    )]
    #[Assert\NotBlank(message: 'Merci de renseigner votre nom.')]
    private ?string $nom = null;
    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Merci de renseigner votre prénom.')]
    #[Assert\Length(
        min: 3,
        max: 45,
        minMessage: 'Le prénom doit contenir au moins {{ limit }} lettres.',
        maxMessage: 'Le prénom ne peut pas dépasser {{ limit }} lettres.'
    )]
    #[Assert\Regex(
        pattern: '/^[A-Za-zÀ-ÿ\s\-]+$/',  // Vérifie que toute la chaîne est valide
        message: 'Le prénom ne peut contenir que des lettres, des espaces ou des tirets.'
    )]
    private ?string $prenom = null;

    #[ORM\Column(type: 'integer', nullable: true)]
//    #[Assert\NotBlank(message: 'Merci de renseigner votre âge.')]
    #[Assert\PositiveOrZero(message: 'L\'âge doit être un nombre au minimun 15 ans.')]
    #[Assert\Range(min: 15,max: 99,notInRangeMessage: 'L\'âge doit être compris entre {{ min }} et {{ max }} ans.')]
    private ?int $age = null;

    #[Assert\NotBlank(message: 'Merci de sélectionner  votre genre.')]
    #[ORM\Column(length: 10)]
    private ?string $sexe = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $enfantSuivie = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Merci de renseigner votre numéro de téléphone.')]
    #[Assert\Length(
        min: 10,
        max: 15,
        minMessage: 'Le numéro de téléphone doit contenir au moins {{ limit }} chiffres.',
        maxMessage: 'Le numéro de téléphone ne peut pas dépasser {{ limit }} chiffres.'
    )]
    #[Assert\Regex(
        pattern: '/^\+?[0-9\s]*$/',
        message: 'Le numéro de téléphone doit être valide et ne contenir que des chiffres.'
    )]

    private ?string $telephone = null;

    #[Assert\NotBlank(message: 'Merci de renseigner votre adresse.')]
    #[ORM\Column(length: 150)]
    private ?string $adresse = null;

    #[Assert\NotBlank(message: 'Merci de renseigner votre ville.')]
    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[Assert\NotBlank(message: 'Merci de renseigner votre code postal.')]
    #[Assert\Length(
        min: 5,
        max: 5,
        exactMessage: 'Le code postal doit contenir exactement {{ limit }} chiffres.'
    )]
    #[Assert\Regex(
        pattern: '/^\+?[0-9]*$/',
        message: 'Le code postal  doit être valide et ne contenir que des chiffres de 0 à 9.'
    )]
    #[ORM\Column(length: 10)]
    private ?string $code_postal = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $secteur = null;

    #[Assert\NotBlank(message: "L'adresse e-mail est obligatoire.")]
    #[Assert\Email(message: "L'adresse e-mail '{{ value }}' n'est pas une adresse valide.")]
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private ?string $email = null;
    #[ORM\Column(type: 'json')]
    private array $matieresAccompagment = [];
    
    #[ORM\Column(type: 'json')]
    private array $niveauAccompagment = [];
    
    #[ORM\Column(type: 'json')]
    private array $connaitretescap = [];
    
    #[ORM\Column(type: 'json')]
    private array $plagesDistances = [];


    #[Assert\NotBlank(message: 'Vous devez confirmer que vous avez lu et approuvé le règlement interieur.')]
    #[ORM\Column(type: 'boolean')]
    private bool $luEtApprouve = false;
    
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $informationComplementaire = null;
    
    public function getInformationComplementaire(): ?string
    {
        return $this->informationComplementaire;
    }
    
    public function setInformationComplementaire(?string $informationComplementaire): self
    {
    $this->informationComplementaire = $informationComplementaire;

    return $this;
    }

    public function getPlagesDistances(): ?array
    {
        return $this->plagesDistances;
    }

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $donLibre = null;
    
    public function getDonLibre(): ?float
    {
        return $this->donLibre;
    }
    
    public function setDonLibre(?float $donLibre): self
    {
        $this->donLibre = $donLibre;
        return $this;
    }
    
    public function setPlagesDistances(?array $plagesDistances): void
    {
        $this->plagesDistances = $plagesDistances;
    }

    public function getMatieresAccompagment(): ?array
    {
        return $this->matieresAccompagment;
    }

    public function getConnaitretescap(): ?array
    {
        return $this->connaitretescap;
    }

    public function setConnaitretescap(?array $connaitretescap): void
    {
        $this->connaitretescap = $connaitretescap;
    }

    public function getNiveauAccompagment(): ?array
    {
        return $this->niveauAccompagment;
    }

    public function setNiveauAccompagment(?array $niveauAccompagment): void
    {
        $this->niveauAccompagment = $niveauAccompagment;
    }

    public function setMatieresAccompagment(?array $matieresAccompagment): void
    {
        $this->matieresAccompagment = $matieresAccompagment;
    }

    #[Assert\NotBlank(message: 'Merci de fournir votre casier judiciaire.')]
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\File(
        maxSize: "2M",
        mimeTypes: ["application/pdf"],
        mimeTypesMessage: "Seuls les fichiers PDF sont acceptés."
    )]
    private ?string $casierJudiciaire = null;


    #[ORM\Column(type: "datetime", nullable: true)]
    private $createdAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCasierJudiciaire(): ?string
    {
        return $this->casierJudiciaire;
    }

   public function setCasierJudiciaire(?string $casierJudiciaire): self
    {
        $this->casierJudiciaire = $casierJudiciaire ?: $this->casierJudiciaire; // Garde l'ancien fichier si null
        return $this;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int // Retourne un entier ou null
    {
        return $this->age;
    }

    public function setAge(?int $age): static // Attend un entier ou null
    {
        $this->age = $age;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getEnfantSuivie(): ?string
    {
        return $this->enfantSuivie;
    }

    public function setEnfantSuivie(?string $enfantSuivie): static
    {
        $this->enfantSuivie = $enfantSuivie;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(?string $secteur): static
    {
        $this->secteur = $secteur;
            return $this;
    }

    public function getLuEtApprouve(): bool
    {
        return $this->luEtApprouve;
    }

    public function setLuEtApprouve(bool $luEtApprouve): self
    {
        $this->luEtApprouve = $luEtApprouve;

        return $this;
    }
}
