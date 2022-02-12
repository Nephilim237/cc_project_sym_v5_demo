<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Cour;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label_attr' => [
                    'class'     =>      'form-label'
                ],
                'label'     =>  'Titre du cour',
                'attr'      =>  [
                    'class'     =>  'form-control'
                ]
            ])
            ->add('banner', TextType::class, [
                'label_attr' => [
                    'class'     =>      'form-label'
                ],
                'label'     =>  'Image illustrative',
                'attr'      =>  [
                    'class'     =>  'form-control'
                ]
            ])
            ->add('price', TextType::class, [
                'label_attr' => [
                    'class'     =>      'form-label'
                ],
                'label'     =>  'Prix du cour',
                'attr'      =>  [
                    'class'     =>  'form-control'
                ]
            ])
            ->add('description', CKEditorType::class, [
                'label'     =>  'Décrivez votre cour',
            ])
            ->add('category', EntityType::class, [
               'class'     => Category::class,
                'label_attr' => [
                    'class'     =>      'input-group-text'
                ],
                'label'     =>  'Catégorie',
                'attr'      =>  [
                    'class'     =>      'form-select'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cour::class,
        ]);
    }
}
