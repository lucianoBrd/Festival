<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        for ($i=1; $i <= 4 ; $i++) {
            $category = new Category();
            $category->setName($faker->sentence($nbWords = 6, $variableNbWords = true)) ;
            $manager->persist($category);
    }
    $manager->flush();
}
}