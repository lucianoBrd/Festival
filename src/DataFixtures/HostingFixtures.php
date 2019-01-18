<?php

namespace App\DataFixtures;

use App\Entity\Room;
use App\Entity\Type;
use App\Entity\Hosting;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class HostingFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $services = array();
        $services[0] = "Bar";
        $services[1] = "Restaurant";
        $services[2] = "Petit-déjeuner";
        $services[3] = "Sauna";
        $services[4] = "Salle de sport";
        $services[5] = "Coiffeur";
        $services[6] = "Massage";
        $services[7] = "Pressing";
        $services[8] = "Spa";

        $types = array();
        $types[0] = "Hôtel";
        $types[1] = "Villa en location";
        $types[2] = "Maison en location";


        for ($i=0; $i <= 8 ; $i++) { 
            $service = new Service();
            
            if($i <= 2){
                $type = new Type();
                $type->setName($types[$i]);

                $manager->persist($type);
            }

            $service->setType($services[$i]);

            $manager->persist($service);

            for ($j=0; $j <= 8 ; $j++) { 
                $hosting = new Hosting();
                $hosting->setName($faker->sentence())
                        ->setAddress($faker->address())
                        ->addIdService($service)
                        ->setIdType($type);
                $manager->persist($hosting);
                for ($k=0; $k <= mt_rand(50,100) ; $k++) { 
                    $room = new Room();
                    $room->setPlace(mt_rand(1,4))
                        ->setPrice(mt_rand(32,90))
                        ->setRoomNumber($k)
                        ->setIdHosting($hosting);
                    $manager->persist($room);
                }
            }
        }


        $manager->flush();
    }
}
