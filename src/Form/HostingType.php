<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Hosting;
use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HostingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('idType', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name'
            ])
            ->add('address')
            ->add('nbPlace')
            ->add('idService', EntityType::class, [
                'class' => Service::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'type'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hosting::class,
        ]);
    }
}
