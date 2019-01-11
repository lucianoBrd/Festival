<?php

namespace App\DataFixtures;

use App\Entity\ProjectionRoom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProjectionRoomFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $room1 = new ProjectionRoom();
        $room1->setName("Grand Théâtre Lumière");
        $room1->setCapacity(2400);
        $manager->persist($room1);

        $room2 = new ProjectionRoom();
        $room2->setName("Salle Debussy");
        $room2->setCapacity(1000);
        $manager->persist($room2);

        $room3 = new ProjectionRoom();
        $room3->setName("Salle Buñuel");
        $room3->setCapacity(500);
        $manager->persist($room3);

        $room4 = new ProjectionRoom();
        $room4->setName("Salle du Soixantième");
        $room4->setCapacity(1000);
        $manager->persist($room4);

        $room5 = new ProjectionRoom();
        $room5->setName("Salle Bazin");
        $room5->setCapacity(500);
        $manager->persist($room5);

        $manager->flush();

    }
}
