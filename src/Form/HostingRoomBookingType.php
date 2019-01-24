<?php

namespace App\Form;

use App\Entity\Vip;
use App\Entity\Room;
use App\Entity\HostingRoomBooking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HostingRoomBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vip', EntityType::class, [
                'class' => Vip::class,
                'multiple' => true,
                'choice_label' => 'name'
            ])
            ->add('date')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HostingRoomBooking::class,
        ]);
    }
}
