<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = array();
        $faker[0] = "Bar";
        $faker[1] = "Restaurant";
        $faker[2] = "Petit-déjeuner";
        $faker[3] = "Sauna";
        $faker[4] = "Salle de sport";
        $faker[5] = "Coiffeur";
        $faker[6] = "Massage";
        $faker[7] = "Pressing";
        $faker[8] = "Spa";

        for ($i=0; $i <= 8 ; $i++) { 
            $service = new Service();

            $service->setType($faker[$i]);

            $manager->persist($service);
        }

        $manager->flush();
    }
}
