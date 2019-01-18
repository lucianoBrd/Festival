<?php

namespace App\DataFixtures;

use App\Entity\Vip;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VipFixtures extends Fixture
{
   public function load(ObjectManager $manager)
   {
       $vip = new Vip();
       $vip->setName("Paulo")
           ->setProfession("Realisateur")
           ->setJury(true)
           ->setInvited(true);
       $manager->persist($vip);

       $manager->flush();
   }
}
