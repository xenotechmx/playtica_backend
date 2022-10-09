<?php

namespace App\DataFixtures;

use App\Entity\Visitor;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VisitorFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {        
        $this->faker = Factory::create();
        
        for ($i=0;$i<1000;$i++){
            $visitor = new Visitor;
            $visitor->setBirthday( $this->faker->dateTimeInInterval($startDate = '-30 years', $interval = '+ 90 days', $timezone = null) );
            $visitor->setFirstName( $this->faker->firstName );
            $visitor->setLastName( $this->faker->lastName );
            $visitor->setType(rand(1,2));
            $visitor->setGender(rand(0,2));
            $manager->persist($visitor);
            $manager->flush();
        }
    }
}
