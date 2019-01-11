<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category1 = new Category();
        $category1->setName("Courts Métrages");
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName("Longs Métrages");
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName("Un Certain Regard");
        $manager->persist($category3);


        $manager->flush();
    }
}