<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = array();
        $faker[0] = "Hôtel";
        $faker[1] = "Villa en location";
        $faker[2] = "Maison en location";

        for ($i=0; $i <= 2 ; $i++) { 
            $type = new Type();

            $type->setName($faker[$i]);

            $manager->persist($type);
        }

        $manager->flush();
    }
}
