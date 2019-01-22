<?php

namespace App\DataFixtures;

use App\Entity\Vip;
use App\Entity\Movie;
use App\Entity\Category;
use App\Entity\ProjectionRoom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $name = array();
        $cate = array();
        $nameR = array();
        $capacity = array();
        $name[0] = "Courts Métrages";
        $name[1] = "Longs Métrages";
        $name[2] = "Un Certain Regard";
        
        $nameR[] = "Grand Théâtre Lumière";
        $capacity[] = 2400;
        $nameR[] = "Salle Debussy";
        $capacity[] = 1000;
        $nameR[] = "Salle Buñuel";
        $capacity[] = 500;
        $nameR[] = "Salle du Soixantième";
        $capacity[] = 1000;
        $nameR[] = "Salle Bazin";
        $capacity[] = 500;

        for ($j=0; $j <= 2 ; $j++) { 
            $category = new Category();
            $category->setName($name[$j]);
            $manager->persist($category);  
            $cate[] =  $category;
        }

        $j = 0;
        for ($i=0; $i <= 4 ; $i++) { 
            $room = new ProjectionRoom();
            if($j == 3){
                $j = 0;
            }
            $room->setName($nameR[$i])
                ->setCapacity($capacity[$i])
                ->addIdCategory($cate[$j]);
            $manager->persist($room);  
        }

        
        $faker = \Faker\Factory::create('fr_FR');
        $j = 0;
        for ($i=1; $i <= 20 ; $i++) { 
            $movie = new Movie();
            $vip = new Vip();
            $vip->setName($faker->name())
                ->setProfession("realisateur")
                ->setJury($faker->boolean)
                ->setInvited($faker->boolean);
            $manager->persist($vip);
            if($j == 3){
                $j = 0;
            }
            $movie->setTitle($faker->company())
            ->setLength(mt_rand(50,150))
            ->setCompeting($i%2 == 0)
            ->setIdCategory($cate[$j])
            ->addIdDirector($vip);
            
            $j++;
            $manager->persist($movie);
        }

        $manager->flush();
    }
}
