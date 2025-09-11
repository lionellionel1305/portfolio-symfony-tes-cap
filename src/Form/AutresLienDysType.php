<?php

namespace App\Form;

use App\Entity\AutresLienDys;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutresLienDysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextareaType::class, [
                'attr' => ['rows' => 6, 'class' => 'form-control'],
                'required' => false, // Le champ est facultatif
                'empty_data' => '', // Remplacer null par une chaîne vide
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['rows' => 6, 'class' => 'form-control'],
                'required' => false, // Le champ est facultatif
                'empty_data' => '', // Remplacer null par une chaîne vide
            ])
            ->add('description1', TextareaType::class, [
                'attr' => ['rows' => 6, 'class' => 'form-control'],
                'required' => false,
                'empty_data' => '',
            ])
            ->add('description2', TextareaType::class, [
                'attr' => ['rows' => 6, 'class' => 'form-control'],
                'required' => false,
                'empty_data' => '',
            ])
            ->add('description3', TextareaType::class, [
                'attr' => ['rows' => 6, 'class' => 'form-control'],
                'required' => false,
                'empty_data' => '',
            ])
            ->add('description4', TextareaType::class, [
                'attr' => ['rows' => 6, 'class' => 'form-control'],
                'required' => false,
                'empty_data' => '',
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AutresLienDys::class,
        ]);
    }
}
