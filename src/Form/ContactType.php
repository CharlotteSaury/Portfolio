<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
            ])
            ->add('subject', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                ]
            ])
            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'minlength' => 10,
                    'maxlength' => 2000,
                ]
            ])
            ->add('personalData', CheckboxType::class, [
                'required' => true,
                'label' => 'J\'accepte que mes données personnelles saisies dans ce formulaire soient utilisées dans le cadre d\'une prise de contact.*',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class
        ]);
    }
}
