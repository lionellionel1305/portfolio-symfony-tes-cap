<?php

namespace App\Form;

use App\Entity\Dys;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('description1', TextareaType::class, [
                'label' => 'Description 1',
                'required' => false,
            ])
            ->add('description2', TextareaType::class, [
                'label' => 'Description 2',
                'required' => false,
            ])
            ->add('description3', TextareaType::class, [
                'label' => 'Description 3',
                'required' => false,
            ])
            ->add('description4', TextareaType::class, [
                'label' => 'Description 4',
                'required' => false,
            ])
            ->add('description5', TextareaType::class, [
                'label' => 'Description 5',
                'required' => false,
            ])
            ->add('editableTitle', TextType::class, [
                'label' => 'Modifier le titre',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dys::class,

        ]);
    }
}
