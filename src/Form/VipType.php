<?php

namespace App\Form;

use App\Entity\Vip;
use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('profession', ChoiceType::class, [
                'choices'  => [
                    'Réalisateur' => 'realisateur',
                    'Acteur' => 'acteur',
                    'Journaliste' => 'journaliste',
                    'Scénariste' => 'scenariste',
                    'Influenceur' => 'influenceur',
                    'Musicien' => 'musicien',
                    'Photographe' => 'photographe',
                    'Média' => 'media',
                    'Compagnon' => 'compagnon',
                    'Membre d\'équipe' => 'membre_equipe',
                    'Autre' => 'autre',
                ],
            ])
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
