<?php

namespace App\Form;

use App\Entity\MentionsLegales;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MentionsLegalesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('titre1', TextType::class, [
                'label' => 'Titre1',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,

            ])
            ->add('description2', TextareaType::class, [
                'label' => 'Description2',
                'required' => false,

            ])
            ->add('description3', TextareaType::class, [
                'label' => 'Description3',
                'required' => false,

            ])
            ->add('description4', TextareaType::class, [
                'label' => 'Description4',
                'required' => false,

            ])
            ->add('description5', TextareaType::class, [
                'label' => 'Description5',
                'required' => false,

            ])
            ->add('description6', TextareaType::class, [
                'label' => 'Description6',
                'required' => false,

            ])
            ->add('description7', TextareaType::class, [
                'label' => 'Description7',
                'required' => false,

            ])
            ->add('description8', TextareaType::class, [
                'label' => 'Description8',
                'required' => false,

            ])
            ->add('titre2', TextType::class, [
                'label' => 'Titre2',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description9', TextareaType::class, [
                'label' => 'Description9',
                'required' => false,

            ])
            ->add('description10', TextareaType::class, [
                'label' => 'Description10',
                'required' => false,

            ])
            ->add('description11', TextareaType::class, [
                'label' => 'Description11',
                'required' => false,

            ])
            ->add('titre3', TextType::class, [
                'label' => 'Titre3',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description12', TextareaType::class, [
                'label' => 'Description12',
                'required' => false,

            ])
            ->add('description13', TextareaType::class, [
                'label' => 'Description13',
                'required' => false,

            ])
            ->add('description14', TextareaType::class, [
                'label' => 'Description14',
                'required' => false,

            ])
            ->add('titre4', TextType::class, [
                'label' => 'Titre4',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description15', TextareaType::class, [
                'label' => 'Description15',
                'required' => false,

            ])
            ->add('description16', TextareaType::class, [
                'label' => 'Description6',
                'required' => false,

            ])
            ->add('titre5', TextType::class, [
                'label' => 'Titre5',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description17', TextareaType::class, [
                'label' => 'Description17',
                'required' => false,
            ])
            ->add('titre6', TextType::class, [
                'label' => 'Titre6',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description18', TextareaType::class, [
                'label' => 'Description18',
                'required' => false,
            ])
            ->add('titre7', TextType::class, [
                'label' => 'Titre7',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description19', TextareaType::class, [
                'label' => 'Description19',
                'required' => false,
            ])
            ->add('description20', TextareaType::class, [
                'label' => 'Description20',
                'required' => false,
            ])
            ->add('description21', TextareaType::class, [
                'label' => 'Description21',
                'required' => false,
            ])
            ->add('titre8', TextType::class, [
                'label' => 'Titre8',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description22', TextareaType::class, [
                'label' => 'Description22',
                'required' => false,
            ])
            ->add('titre9', TextType::class, [
                'label' => 'Titre9',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description23', TextareaType::class, [
                'label' => 'Description23',
                'required' => false,
            ]) ->add('description24', TextareaType::class, [
                'label' => 'Description24',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MentionsLegales::class,
        ]);
    }
}
