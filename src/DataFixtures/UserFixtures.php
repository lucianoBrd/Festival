<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $j=0;
        for ($i=1; $i <= 20 ; $i++) { 
            $user = new User();

            $user->setPassword('abc');
            $hash = $this->encoder->encodePassword($user, $user->getPassword());
            if($j > 2){
                $j=0;
            }
            $user->setUsername($faker->firstName())
            ->setPassword($hash)
            ->setEmail($faker->freeEmail())
            ->setName($faker->name())
            ->setRole($user->getConstRole()[$j]);

            $manager->persist($user);
            $j++;
        }
        // Compte admin
        $user = new User();
        $user->setPassword('abc');
        $hash = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setUsername("Luciano")
            ->setPassword($hash)
            ->setEmail("lucien.burdet@gmail.com")
            ->setName("Luciano Brd")
            ->setRole($user->getConstRole()[0]);
        $manager->persist($user);

        $manager->flush();
    }
}
