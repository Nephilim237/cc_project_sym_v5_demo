<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete'  => 'new-password',
                        'class'         =>  'cc-form-control',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Champ obligatoire',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Le mot de passe doit faire au moins {{ limit }} charactères.',
                            // max length allowed by Symfony for security reasons
                            'max' => 32,
                        ]),
                    ],
                    'label' => 'Nouveau mot de passe:',
                    'label_attr'    =>  [
                        'class'     => 'form-label',
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete'  => 'new-password',
                        'class'         =>  'cc-form-control',
                    ],
                    'label' => 'Confirmer le nouveau mot de passe:',
                    'label_attr'    =>  [
                        'class'     => 'form-label',
                    ]
                ],
                'invalid_message' => 'Les deux champs doivent être identiques.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
