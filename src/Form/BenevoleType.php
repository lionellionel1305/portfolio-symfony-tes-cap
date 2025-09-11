<?php

namespace App\Form;

use App\Entity\Benevole;
use App\Form\BenevoleEditType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class BenevoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => ['class' => 'form-control'],

            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Âge (facultatif)',
//                'required' => true,
                'attr' => [
                    'min' => 15,
                    'max' => 99,
                ],
        ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => [
                    'F' => 'F',
                    'M' => 'M',
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'sexe_benevole'],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
            ])
            ->add('enfant_suivie', TextType::class, [
                'label' => 'Cadre réservé à l\'association',
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => true,
            ])
            ->add('adresse', TextType::class, [
                'required' => true,
            ])
            ->add('ville', TextType::class, [
                'required' => true,

            ])

            ->add('code_postal', TextType::class, [
                'required' => true,
            ])

            ->add('casierJudiciaire', FileType::class, [
                'label' => 'Casier Judiciaire (obligatoire)',
                'required' => false,
                'mapped' => true,
                'data_class' => null,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['application/pdf'],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier PDF valide.',
                    ]),
                ],
                'attr' => ['accept' => 'application/pdf']
            ])
            ->add('secteur', ChoiceType::class, [
                'choices' => [
                    'Pays Bigouden' => 'Pays Bigouden',
                    'Quimper' => 'Quimper',
                    'Châteaulin' => 'Châteaulin',
                    'Pays Fouesnantais' => 'Pays Fouesnantais'
                ],
                'required' => false,
            ])
            ->add('plagesDistances', ChoiceType::class, [
                'choices' => [
                    '0 à 10 km' => '0-10 km',
                    '10 à 20 km' => '10-20 km',
                    '20 à 30 km' => '20-30 km ',
                ],
                'expanded' => true,
                'multiple' => true,
                'required' => true,
                'label' => 'A combien de Km pourriez-vous vous déplacer ?',
            ])
            ->add('matieresAccompagment', ChoiceType::class, [
                'choices' => [
                    'Français' => 'Francais',
                    'Mathématique' => 'Math',
                    'Histoire/Géographie' => 'Histoire-Geographie',
                    'Sciences et vie de la terre ' => 'SVT',
                    'Physique/Chimie' => 'Physique-Chimie',
                    'Technologie' => 'Technologie',
                    'Philosophie' => 'Philosophie',
                    'Sciences économiques et Sociales' => 'Sciences économiques et Sociales',
                    'Anglais' => 'Anglais',
                    'Allemand' => 'Allemand',
                    'Espagnol' => 'Espagnol'
                    
                ],
                'expanded' => true,
                'multiple' => true,
                'required' => true,
                'label' => 'Dans quelle(s) matière(s) aimeriez-vous accompagner un enfant ?',
            ])
            ->add('niveauAccompagment', ChoiceType::class, [
                 'choices' => [
                    'Primaire' => 'Primaire',
                    'Collège' => 'College',
                    'Lycée' => 'Lycee',
                 ],
                'expanded' => true,
                'multiple' => true,
                'required' => true,
                'label' => 'Auprès d\'enfant de quel(s) niveau(x) pourriez-vous intervenir ?',
            ])
            ->add('informationComplementaire', TextareaType::class, [
                'label' => 'Informations complémentaires',
                'required' => false,
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Vous pouvez ajouter ici toute information utile complémentaire...',
                    'class' => 'form-control',
                ],
            ])

            ->add('connaitretescap', ChoiceType::class, [
                'choices' => [
                    'Internet' => 'Internet',
                    'Forum des associations' => 'Forum associatif',
                    'Article de presse ' => 'Article de presse',
                    'Bouche à oreille ' => 'Bouche a oreille',
                    'Autre ' => 'Autre',
                ],
                'expanded' => true,
                'multiple' => true,
                'required' => true,
                'label' => 'Comment avez-vous connu T\'es Cap?',
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
            ->add('luEtApprouve', CheckboxType::class, [
                'label' => 'J\'ai lu et j\'approuve le règlement intérieur.',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez confirmer que vous avez lu et approuvé le réglement interieur.',
                    ]),
                ],    
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Benevole::class,
            'is_edit' => false,
        ]);

        $resolver->setDefined(['is_edit']);
        $resolver->setAllowedTypes('is_edit', 'bool');
    }
}