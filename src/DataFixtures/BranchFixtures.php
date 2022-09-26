<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Branch;

class BranchFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $branch = new Branch();
        $branch->setName('San Pedro');
        $branch->setPhone('81 4050 1519');
        $branch->setAddress('Av. Real San Agustin 66278 San Pedro Garza Garcia, Nuevo León, Mexico');
        $branch->setMaxVisitors('300');
        $manager->persist($branch);

        $branch = new Branch();
        $branch->setName('Cumbres');
        $branch->setPhone('81 1100 9316');
        $branch->setAddress('Av Paseo de los Leones 99, Cumbres Elite 5to. Sector 64100 Monterrey, Nuevo León, Mexico');
        $branch->setMaxVisitors('300');
        $manager->persist($branch);

        $branch = new Branch();
        $branch->setName('Paseo La Fe');
        $branch->setPhone('');
        $branch->setAddress('Avenida Miguel Alemán 200 66473 San Nicolás de los Garza, Nuevo León, Mexico');
        $branch->setMaxVisitors('300');
        $manager->persist($branch);

       
        $manager->flush();
    }
}
