<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\PagesFamille;

#[ORM\Entity(repositoryClass: PagesFamilleRepository::class)]

class PagesFamilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('information1', TextareaType::class, [
                'label' => 'Information 1',
                'attr' => ['rows' => 5, 'class' => 'form-control']
            ])
            ->add('information2', TextareaType::class, [
                'label' => 'Information 2',
                'required' => false,
            ])
            ->add('information3', TextType::class, [
                'label' => 'Information 3',
            ])
            ->add('information4', TextType::class, [
                'label' => 'Information 4',
            ])
            ->add('information5', TextType::class, [
                'label' => 'Information 5',
            ])
            ->add('information6', TextType::class, [
                'label' => 'Information 6',
            ])
            ->add('information7', TextType::class, [
                'label' => 'Information 7',
            ])
            ->add('information8', TextType::class, [
                'label' => 'Information 8',
            ]);
            }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PagesFamille::class,
        ]);
    }
}