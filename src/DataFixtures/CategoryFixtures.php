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

        // 3 Catégories fakées
        for ($i = 1; $i <= 3; $i++) {
            $category = new Category();
            $category->setName($faker->sentence($nbWords = 3));

            $manager->persist($category);
        }

        $manager->flush();
    }
}