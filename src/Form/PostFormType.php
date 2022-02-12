<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
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
            ->add('content', CKEditorType::class, [
                'label'     =>  'Contenu du post',
            ])
            ->add('category', EntityType::class, [
                'class'     => Category::class,
                'label_attr' => [
                    'class'     =>      'input-group-text'
                ],
                'label'     =>  'Catégorie',
                'attr'      =>  [
                    'class'     =>      'form-select'
                ],
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
