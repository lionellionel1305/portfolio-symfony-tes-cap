<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\EnfantInscriptionRepository;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

#[ORM\Entity(repositoryClass: EnfantInscriptionRepository::class)]
class EnfantInscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // ENFANT
    #[Assert\NotBlank(message: 'Merci de renseigner le nom de votre enfant.')]
    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min: 3,
        max: 45,
        minMessage: 'Le nom doit contenir au moins {{ limit }} lettres.',
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} lettres.'
    )]
    private ?string $nomEnfant = null;

    #[Assert\NotBlank(message: 'Merci de renseigner le prénom de votre enfant.')]
    #[ORM\Column(length: 100)]
    #[Assert\Length(
        min: 3,
        max: 45,
        minMessage: 'Le prénom doit contenir au moins {{ limit }} lettres.',
        maxMessage: 'Le prénom ne peut pas dépasser {{ limit }} lettres.'
    )]
    private ?string $prenomEnfant = null;

    #[Assert\NotBlank(message: "Merci de renseigner l'âge de votre enfant.")]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\LessThan('today', message: 'La date de naissance doit être dans le passé.')]
    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateNaissance = null;



    #[Assert\NotBlank(message: 'Merci de sélectionner  votre genre.')]
    #[ORM\Column(length: 10)]
    private ?string $genre = null;

    #[Assert\NotBlank(message: "Merci de renseigner la classe de votre enfant.")]
    #[ORM\Column(length: 100)]
    private ?string $classe = null;

    #[Assert\NotBlank(message: "Merci de renseigner l'établissement ou va votre enfant.")]
    #[ORM\Column(length: 150)]
    private ?string $etablissement = null;

    #[ORM\Column(type: 'boolean')]
    private bool $nouvelleInscription = false;

    #[ORM\Column(type: 'boolean')]
    private bool $reinscription = false;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $ancienAccompagnement = null;
    
    
    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $protocole = null;
    
    public function getProtocole(): ?bool
    {
        return $this->protocole;
    }
    
    public function setProtocole(?bool $protocole): self
    {
        $this->protocole = $protocole;
        return $this;
    }

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveau_scolaire = null;

    public function getNiveauScolaire(): ?string
{
    return $this->niveau_scolaire;
    }
    
    public function setNiveauScolaire(?string $niveau_scolaire): self
    {
        $this->niveau_scolaire = $niveau_scolaire;
    
        return $this;
    }

    // PARENT 1 (OBLIGATOIRE)
    #[ORM\Column(length: 150)]
    #[Assert\Regex(
        pattern: '/^[A-Za-zÀ-ÿ\s\-]+$/',  // Vérifie que toute la chaîne est valide
        message: 'Le nom ne peut contenir que des lettres, des espaces ou des tirets.'
    )]
    #[Assert\NotBlank(message: 'Merci de renseigner votre nom.')]
    private ?string $nomParent1 = null;

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
    private ?string $prenomParent1 = null;

    #[Assert\NotBlank(message: 'Merci de renseigner votre adresse.')]
    #[ORM\Column(length: 150)]
    private ?string $adresseParent1 = null;

    #[Assert\NotBlank(message: 'Merci de renseigner votre code postal.')]
    #[Assert\Length(
        min: 5,
        max: 5,
        exactMessage: 'Le code postal doit contenir exactement {{ limit }} chiffres.'
    )]
    #[Assert\Regex(
        pattern: '/^\d{5}$/',  // Plus précis : exactement 5 chiffres
        message: 'Le code postal doit contenir exactement 5 chiffres.'
    )]
    #[ORM\Column(length: 5)]
    private ?string $codePostalParent1 = null;

    #[Assert\NotBlank(message: 'Merci de renseigner votre ville.')]
    #[ORM\Column(length: 100)]
    private ?string $villeParent1 = null;

    #[Assert\NotBlank(message: 'Merci de renseigner votre profession')]
    #[ORM\Column(length: 100)]
    private ?string $professionParent1 = null;

    #[ORM\Column(length: 20, nullable: false)]
    #[Assert\NotBlank(message: 'Merci de renseigner votre numéro de téléphone.')]
    #[Assert\Regex(
    pattern: '/^\+?[0-9\s\-\.]*$/',
    message: 'Le numéro de téléphone doit être valide (chiffres, espaces, tirets et points autorisés).'
    )]
    private ?string $telephoneParent1 = null;

    #[Assert\NotBlank(message: "L'adresse e-mail est obligatoire.")]
    #[Assert\Email(message: "L'adresse e-mail '{{ value }}' n'est pas une adresse valide.")]
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private ?string $emailParent1 = null;

    // PARENT 2 (OPTIONNEL)
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nomParent2 = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $prenomParent2 = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $adresseParent2 = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $codePostalParent2 = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $villeParent2 = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $professionParent2 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephoneParent2 = null;

    #[Assert\Email]
    #[ORM\Column(length: 150, nullable: true)]
    private ?string $emailParent2 = null;

    // AUTRES INFOS
    #[Assert\NotBlank(message: "Merci d’indiquer dans quelle matière votre enfant a besoin d’aide.")]
    #[ORM\Column(type: 'json')]
    private array $matieresSouhaitees = [];

    #[ORM\Column(type: 'boolean')]
    private bool $diagnosticEtabli = false;

    #[ORM\Column(type: 'boolean')]
    private bool $accepteActivitesCulturelles = false;
    
    #[ORM\Column(type: 'boolean')]
    private bool $cotisationValidee = false;
    
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $secteur = null;
    
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $informationsComplementaires = null;
    
    public function getInformationsComplementaires(): ?string
    {
        return $this->informationsComplementaires;
    }
    
    public function setInformationsComplementaires(?string $informationsComplementaires): self
    {
    $this->informationsComplementaires = $informationsComplementaires;

    return $this;
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

    
     public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(?string $secteur): static
    {
        $this->secteur = $secteur;
            return $this;
    }
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $paiment = null;
    
     public function getPaiment(): ?string
    {
        return $this->paiment;
    }

    public function setPaiment(?string $paiment): static
    {
        $this->paiment = $paiment;
            return $this;
    }
    
   #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $quotientFamilial = null;
   public function getQuotientFamilial(): ?string
    {
        return $this->quotientFamilial;
    }
    
    public function setQuotientFamilial(?string $quotientFamilial): self
    {
        $this->quotientFamilial = $quotientFamilial;
        return $this;
    }

    public function isCotisationValidee(): bool
    {
        return $this->cotisationValidee;
    }
    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $quotientFamilialPdf = null;
    public function getQuotientFamilialPdf(): ?string
    {
        return $this->quotientFamilialPdf;
    }
    public function setQuotientFamilialPdf(?string $quotientFamilialPdf): self
    {
        $this->quotientFamilialPdf = $quotientFamilialPdf;
    
        return $this;
    }
    public function setCotisationValidee(bool $cotisationValidee): void
    {
    $this->cotisationValidee = $cotisationValidee;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNomEnfant(): ?string
    {
        return $this->nomEnfant;
    }

    public function setNomEnfant(?string $nomEnfant): void
    {
        $this->nomEnfant = $nomEnfant;
    }

    public function getPrenomEnfant(): ?string
    {
        return $this->prenomEnfant;
    }

    public function setPrenomEnfant(?string $prenomEnfant): void
    {
        $this->prenomEnfant = $prenomEnfant;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): void
    {
        $this->dateNaissance = $dateNaissance;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): void
    {
        $this->genre = $genre;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(?string $classe): void
    {
        $this->classe = $classe;
    }

    public function getEtablissement(): ?string
    {
        return $this->etablissement;
    }

    public function setEtablissement(?string $etablissement): void
    {
        $this->etablissement = $etablissement;
    }

    public function isNouvelleInscription(): bool
    {
        return $this->nouvelleInscription;
    }

    public function setNouvelleInscription(bool $nouvelleInscription): void
    {
        $this->nouvelleInscription = $nouvelleInscription;
    }

    public function isReinscription(): bool
    {
        return $this->reinscription;
    }

    public function setReinscription(bool $reinscription): void
    {
        $this->reinscription = $reinscription;
    }

    public function getAncienAccompagnement(): ?string
    {
        return $this->ancienAccompagnement;
    }
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $nombreAnneesSuivies = null;
    
    public function getNombreAnneesSuivies(): ?int
    {
        return $this->nombreAnneesSuivies;
    }
    
    public function setNombreAnneesSuivies(?int $val): void
    {
        $this->nombreAnneesSuivies = $val;
    }
    public function setAncienAccompagnement(?string $ancienAccompagnement): void
    {
        $this->ancienAccompagnement = $ancienAccompagnement;
    }

    public function getNomParent1(): ?string
    {
        return $this->nomParent1;
    }

    public function setNomParent1(?string $nomParent1): void
    {
        $this->nomParent1 = $nomParent1;
    }

    public function getPrenomParent1(): ?string
    {
        return $this->prenomParent1;
    }

    public function setPrenomParent1(?string $prenomParent1): void
    {
        $this->prenomParent1 = $prenomParent1;
    }

    public function getAdresseParent1(): ?string
    {
        return $this->adresseParent1;
    }

    public function setAdresseParent1(?string $adresseParent1): void
    {
        $this->adresseParent1 = $adresseParent1;
    }

    public function getCodePostalParent1(): ?string
    {
        return $this->codePostalParent1;
    }

    public function setCodePostalParent1(?string $codePostalParent1): void
    {
        $this->codePostalParent1 = $codePostalParent1;
    }

    public function getVilleParent1(): ?string
    {
        return $this->villeParent1;
    }

    public function setVilleParent1(?string $villeParent1): void
    {
        $this->villeParent1 = $villeParent1;
    }

    public function getProfessionParent1(): ?string
    {
        return $this->professionParent1;
    }

    public function setProfessionParent1(?string $professionParent1): void
    {
        $this->professionParent1 = $professionParent1;
    }

    public function getTelephoneParent1(): ?string
    {
        return $this->telephoneParent1;
    }

    public function setTelephoneParent1(?string $telephoneParent1): void
    {
        $this->telephoneParent1 = $telephoneParent1;
    }

    public function getEmailParent1(): ?string
    {
        return $this->emailParent1;
    }

    public function setEmailParent1(?string $emailParent1): void
    {
        $this->emailParent1 = $emailParent1;
    }

    public function getNomParent2(): ?string
    {
        return $this->nomParent2;
    }

    public function setNomParent2(?string $nomParent2): void
    {
        $this->nomParent2 = $nomParent2;
    }

    public function getPrenomParent2(): ?string
    {
        return $this->prenomParent2;
    }

    public function setPrenomParent2(?string $prenomParent2): void
    {
        $this->prenomParent2 = $prenomParent2;
    }

    public function getAdresseParent2(): ?string
    {
        return $this->adresseParent2;
    }

    public function setAdresseParent2(?string $adresseParent2): void
    {
        $this->adresseParent2 = $adresseParent2;
    }

    public function getCodePostalParent2(): ?string
    {
        return $this->codePostalParent2;
    }

    public function setCodePostalParent2(?string $codePostalParent2): void
    {
        $this->codePostalParent2 = $codePostalParent2;
    }

    public function getVilleParent2(): ?string
    {
        return $this->villeParent2;
    }

    public function setVilleParent2(?string $villeParent2): void
    {
        $this->villeParent2 = $villeParent2;
    }

    public function getProfessionParent2(): ?string
    {
        return $this->professionParent2;
    }

    public function setProfessionParent2(?string $professionParent2): void
    {
        $this->professionParent2 = $professionParent2;
    }

    public function getTelephoneParent2(): ?string
    {
        return $this->telephoneParent2;
    }

    public function setTelephoneParent2(?string $telephoneParent2): void
    {
        $this->telephoneParent2 = $telephoneParent2;
    }

    public function getEmailParent2(): ?string
    {
        return $this->emailParent2;
    }

    public function setEmailParent2(?string $emailParent2): void
    {
        $this->emailParent2 = $emailParent2;
    }

    public function getMatieresSouhaitees(): array
    {
        return $this->matieresSouhaitees;
    }

    public function setMatieresSouhaitees(array $matieresSouhaitees): void
    {
        $this->matieresSouhaitees = $matieresSouhaitees;
    }

    public function isDiagnosticEtabli(): bool
    {
        return $this->diagnosticEtabli;
    }

    public function setDiagnosticEtabli(bool $diagnosticEtabli): void
    {
        $this->diagnosticEtabli = $diagnosticEtabli;
    }

    public function isAccepteActivitesCulturelles(): bool
    {
        return $this->accepteActivitesCulturelles;
    }

    public function setAccepteActivitesCulturelles(bool $accepteActivitesCulturelles): void
    {
        $this->accepteActivitesCulturelles = $accepteActivitesCulturelles;
    }

    
}