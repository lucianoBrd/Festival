<?php

namespace App\Form;

use App\Entity\Vip;
use App\Entity\Movie;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('length')
            ->add('competing')
            ->add('idDirector', EntityType::class, [
                'class'=>Vip::class,
                'choice_label'=>'name',
                'multiple'=>true
            ])
            ->add('idCategory', EntityType::class, [
                'class'=>Category::class,
                'choice_label'=>'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}