<?php
namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('imageFile', FileType::class, [
    'label' => 'Image (JPEG, PNG, GIF, PDF)',
    'mapped' => false, // Ne correspond pas directement à une propriété de l'entité
    'required' => true, // Empêche l'envoi sans fichier
    'constraints' => [
        new Assert\Image([
            'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif','image/pdf'],
            'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG, GIF).',
        ])
    ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
