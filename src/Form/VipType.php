<?php

namespace App\Form;

use App\Entity\Vip;
use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('profession')
            ->add('jury')
            ->add('invited')
            ->add('idMovie', EntityType::class, [
                'class'=>Movie::class,
                'choice_label'=>'title',
                'multiple'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vip::class,
        ]);
    }
}
