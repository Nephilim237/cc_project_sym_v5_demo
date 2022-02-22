<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactSiteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'cc-form-control',
                    'placeholder'   =>  'Votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'cc-form-control',
                    'placeholder'   =>  'Votre Email'
                ]

            ])
            ->add('subject', TextType::class, [
                'attr' => [
                    'class' => 'cc-form-control',
                    'placeholder'   =>  'Objet du message'
                ]

            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => 'cc-form-control',
                    'placeholder'   =>  'Saisissez un message'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
