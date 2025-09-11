<?php
// src/Form/PopupType.php
namespace App\Form;

use App\Entity\Popup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PopupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Texte de la pop-up',
                'attr' => [
                'class' => 'form-control',
                'rows' => 12,
                
            ],
            ])
            
            ->add('isActive', CheckboxType::class, [
                'label' => 'Activer la pop-up ?',
                'required' => false,
                'mapped' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Popup::class,
        ]);
    }
}
