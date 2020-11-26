<?php

namespace App\Form;

use App\Entity\Techno;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TechnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
                'required' => false
            ])
            ->add('level', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Niveau'
                ]
            ])
            ->add('type', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Type'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Techno::class,
        ]);
    }
}
