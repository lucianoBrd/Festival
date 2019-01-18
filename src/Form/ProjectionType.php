<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\Projection;
use App\Entity\ProjectionRoom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ProjectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class, [
                'format' => 'dd-MM-yyyy'
            ])
            ->add('idMovie', EntityType::class, [
                'class' => Movie::class,
                'choice_label' => 'name'
            ])
            ->add('idProjectionRoom', EntityType::class, [
                'class' => ProjectionRoom::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projection::class,
        ]);
    }
}
