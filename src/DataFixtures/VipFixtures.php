<?php

namespace App\DataFixtures;

use App\Entity\Vip;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VipFixtures extends Fixture
{
   public function load(ObjectManager $manager)
   {
    $faker = \Faker\Factory::create('fr_FR');
    $profession = array();
        $profession[0] = "Réalisateur";
        $profession[1] = "Acteur";
        $profession[2] = "Scénariste";
        $profession[3] = "Influenceur";
        $profession[4] = "Musicien";
        $profession[5] = "Photographe";
        $profession[6] = "Média";
        $profession[7] = "Compagnon";
        $profession[8] = "Membre d'équipe";
    for($i=0; $i <= 8 ; $i++){
       $vip = new Vip();
       $vip->setName($faker->name())
           ->setProfession($profession[$i])
           ->setJury($faker->boolean)
           ->setInvited($faker->boolean);
       $manager->persist($vip);
    }
       $manager->flush();
   }
}
