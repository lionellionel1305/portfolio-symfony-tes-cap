<?php

namespace App\Form;

use App\Entity\EnfantInscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


use Symfony\Component\Form\Extension\Core\Type\{
    ChoiceType,
    CollectionType,
    DateType,
    EmailType,
    SubmitType,
    TelType,
    TextType,
    CheckboxType
};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnfantInscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $matieres = [
            'Français', 'Mathématiques', 'Histoire/Géographie',
            'Sciences et vie de la terre', 'Physique/Chimie', 'Technologie', 'Philosophie',
            'Sciences Économiques et Sociales',
            'Anglais', 'Allemand', 'Espagnol'
        ];

        $builder
            
            // ENFANT
            ->add('nomEnfant', TextType::class, ['label' => "Nom"])
            ->add('prenomEnfant', TextType::class, ['label' => "Prénom"])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
            ])
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => ['Féminin' => 'Féminin', 'Masculin' => 'Masculin'],
                'expanded' => true,
            ])
            ->add('classe', TextType::class, ['label' => "Classe pour l'année 2025/2026"])
            ->add('etablissement', TextType::class)
            ->add('niveau_scolaire', ChoiceType::class, [
            'label' => 'Niveau scolaire',
            'choices' => [
                'Primaire' => 'Primaire',
                'Collège' => 'Collège',
                'Lycée' => 'Lycée',
            ],
            'required' => false,
            'placeholder' => 'Choisir un niveau',
             ])

            // Inscription / Réinscription
            ->add('nouvelleInscription', CheckboxType::class, [
                'label' => 'Nouvelle inscription',
                'required' => false,
            ])
            ->add('reinscription', CheckboxType::class, [
                'label' => 'Réinscription',
                'required' => false,
            ])
            ->add('ancienAccompagnement', TextType::class, [
                'label' => 'Mon enfant était accompagné par :',
                'required' => false,
            ])
            ->add('nombreAnneesSuivies', IntegerType::class, [
            'required' => false,
            'label' => "Nombre d'années suivies",
            ])
            ->add('quotientFamilial', ChoiceType::class, [
            'label' => 'Montant de la cotisation selon votre quotient familial :',
            'choices'  => [
                '20€ : Jusqu’à 750 € du QF' => '20€',
                '40€ : De 751 € à 900 € du QF' => '40€',
                '60€ : De 901 € à 1050 € du QF' => '60€',
                '80€ : Plus de 1050 € du QF' => '80€',
                '20€ par enfant supplémentaire (même famille)' => '20_suppl',
            ],
            'expanded' => true,  // Affiche en boutons radio
            'multiple' => false, // un seul choix possible
            'required' => true,
             ])
             
            ->add('secteur', ChoiceType::class, [
                'label' => 'Secteur',     
                'choices' => [
                    'Pays Bigouden' => 'Pays Bigouden',
                    'Quimper' => 'Quimper',
                    'Châteaulin' => 'Châteaulin',
                    'Pays Fouesnantais' => 'Pays Fouesnantais'
                ],
                'required' => false,
            ])
            ->add('paiment', ChoiceType::class, [
            'label' => 'mode de paiement',
            'choices' => [
                'Espèces' => 'Espèces',
                'Chèque' => 'Chèque',
                'Virement' => 'Virement',
                'CB' => 'CB'
            ],
            'required' => false,
            ])

            // PARENT 1
            ->add('nomParent1', TextType::class, ['label' => 'Nom'])
            ->add('prenomParent1', TextType::class, ['label' => 'Prénom'])
            ->add('adresseParent1', TextType::class, ['label' => 'Adresse'])
            ->add('codePostalParent1', TextType::class, ['label' => 'Code postal'])
            ->add('villeParent1', TextType::class, ['label' => 'Ville'])
            ->add('professionParent1', TextType::class, ['label' => 'Profession'])
            ->add('telephoneParent1', TelType::class, ['label' => 'Téléphone'])
            ->add('emailParent1', EmailType::class, ['label' => 'Email'])

            // PARENT 2 (optionnel)
            ->add('nomParent2', TextType::class, ['required' => false, 'label' => 'Nom'])
            ->add('prenomParent2', TextType::class, ['required' => false, 'label' => 'Prénom'])
            ->add('adresseParent2', TextType::class, ['required' => false, 'label' => 'Adresse'])
            ->add('codePostalParent2', TextType::class, ['required' => false, 'label' => 'Code postal'])
            ->add('villeParent2', TextType::class, ['required' => false, 'label' => 'Ville'])
            ->add('professionParent2', TextType::class, ['required' => false, 'label' => 'Profession'])
            ->add('telephoneParent2', TelType::class, ['required' => false, 'label' => 'Téléphone'])
            ->add('emailParent2', EmailType::class, ['required' => false, 'label' => 'Email'])

            // Matières
            ->add('matieresSouhaitees', ChoiceType::class, [
                'label' => 'Matières souhaitées',
                'choices' => array_combine($matieres, $matieres),
                'multiple' => true,
                'expanded' => true,
            ])

            // Diagnostic
            ->add('diagnosticEtabli', ChoiceType::class, [
                'label' => 'Diagnostic établi par un professionnel de santé ?',
                'choices' => ['Oui' => true, 'Non' => false],
                'expanded' => true,
            ])
            ->add('protocole', ChoiceType::class, [
                'label' => 'Protocole signé ?',
                'choices' => ['Non renseigné' => null,'Oui' => true, 'Non' => false],
                
                
            ])
            ->add('informationsComplementaires', TextareaType::class, [
            'label' => 'Informations complémentaires',
            'required' => false,
            'attr' => [
                'rows' => 5,
                'placeholder' => 'Indiquez ici toute information utile concernant votre enfant (situation particulière, remarques, etc.)',
                'class' => 'form-control',
            ],
             ])
            ->add('donLibre', NumberType::class, [
            'label' => 'Soutenez notre association avec un don (montant libre)',
            'required' => false,
            'attr' => [
                'placeholder' => 'Un petit don pour vous, un grand pas pour notre asso 🚀 Merci d’avance! 🙏',
                'class' => 'form-control',
                'min' => 0, // empêche les valeurs négatives
                'step' => '0.01' // permet les décimales
            ],
            ]) 
            // Activité culturelle
            ->add('accepteActivitesCulturelles', ChoiceType::class, [
                'label' => 'Votre enfant peut-il participer à des activités culturelles ?',
                'choices' => ['Oui' => true, 'Non' => false],
                'expanded' => true,
            ])
       
            ->add('quotientFamilialPdf', FileType::class, [
            'label' => 'Quotient familial (PDF, JPEG, PNG , JPG)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new \Symfony\Component\Validator\Constraints\File([
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'application/pdf',
                        'image/jpeg',
                        'image/jpg', 
                        'image/png',
                        'image/webp',
                        'image/heic',
                        'image/heif',
                    ],
            'mimeTypesMessage' => 'Seuls les fichiers PDF, JPEG, PNG, WEBP et HEIC sont acceptés.',
        ]),
    ],
        ]);

            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EnfantInscription::class,
        ]);
    }
}
