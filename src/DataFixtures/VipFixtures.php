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
        $profession[0] = "realisateur";
        $profession[1] = "acteur";
        $profession[2] = "journaliste";
        $profession[3] = "scenariste";
        $profession[4] = "influenceur";
        $profession[5] = "musicien";
        $profession[6] = "photographe";
        $profession[7] = "media";
        $profession[8] = "compagnon";
        $profession[9] = "membre_equipe";
        $profession[10] = "autre";

        $j = 0;
        for($i=0; $i <= 500 ; $i++){
            $vip = new Vip();
            if($j == 11){
                $j = 0;
            }
            $vip->setName($faker->name())
                ->setProfession($profession[$j])
                ->setJury($faker->boolean)
                ->setInvited($faker->boolean);
            $manager->persist($vip);
            $j++;
        }
       $manager->flush();
   }
}
