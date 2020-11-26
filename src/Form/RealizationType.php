<?php

namespace App\Form;

use App\Entity\Techno;
use App\Form\SkillType;
use App\Entity\Realization;
use App\Form\ExpectationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RealizationType extends AbstractType
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
            ->add('shortDesc', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Courte description'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description',
                    'rows' => 8
                ]
            ])
            ->add('context', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Contexte'
                ]
            ])
            ->add('github', UrlType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Lien github'
                ]
            ])
            ->add('url', UrlType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Lien site'
                ]
            ])
            ->add('defense', UrlType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Lien soutenance'
                ]
            ])
            ->add('createdAt', DateType::class, [
                'label' => false,
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image principale',
                'required' => false
            ])
            ->add('skills', CollectionType::class, [
                'entry_type' => SkillType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'label' => false,
                'by_reference' => false            
                ])
            ->add('expectations', CollectionType::class, [
                'entry_type' => ExpectationType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'label' => false,
                'by_reference' => false            
                ])
            ->add('technos', EntityType::class, [
                'class' => Techno::class,
                'label' => false,
                'choice_label' => 'title',
                'multiple' => true
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Realization::class,
        ]);
    }
}
