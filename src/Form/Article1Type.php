<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Ingredient;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Article1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('photo')
            ->add('date')
            ->add('category', EntityType::class, [
                'class' => Category::class,
'choice_label' => 'id',
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
'choice_label' => 'id',
'multiple' => true,
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
