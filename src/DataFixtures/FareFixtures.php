<?php

namespace App\DataFixtures;

use App\Entity\Fare;
use App\Repository\BranchRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class FareFixtures extends Fixture
{
    private $branchRepository;

    public function __construct(BranchRepository $branchRepository){
        $this->branchRepository = $branchRepository;   
    }


    public function load(ObjectManager $manager): void
    {
        $branches=  $this->branchRepository->findAll();
        foreach($branches as $branch){
            $fare = new Fare;
            $fare->setBranch($branch);
            $fare->setPrice(160);
            $fare->setDays(1);
            $fare->setTime(1);
            $manager->persist($fare);

            $fare = new Fare;
            $fare->setBranch($branch);
            $fare->setPrice(195);
            $fare->setDays(2);
            $fare->setTime(1);
            $manager->persist($fare);

            $fare = new Fare;
            $fare->setBranch($branch);
            $fare->setPrice(239);
            $fare->setDays(1);
            $fare->setTime(2);
            $manager->persist($fare);

            $fare = new Fare;
            $fare->setBranch($branch);
            $fare->setPrice(299);
            $fare->setDays(2);
            $fare->setTime(2);
            $manager->persist($fare);

            $fare = new Fare;
            $fare->setBranch($branch);
            $fare->setPrice(359);
            $fare->setDays(1);
            $fare->setTime(3);
            $manager->persist($fare);

            $fare = new Fare;
            $fare->setBranch($branch);
            $fare->setPrice(449);
            $fare->setDays(2);
            $fare->setTime(3);
            $manager->persist($fare);

            $fare = new Fare;
            $fare->setBranch($branch);
            $fare->setPrice(30);
            $fare->setDays(1);
            $fare->setTime(4);
            $manager->persist($fare);

            $fare = new Fare;
            $fare->setBranch($branch);
            $fare->setPrice(35);
            $fare->setDays(2);
            $fare->setTime(4);
            $manager->persist($fare);

            $fare = new Fare;
            $fare->setBranch($branch);
            $fare->setPrice(59);
            $fare->setDays(1);
            $fare->setTime(5);
            $manager->persist($fare);

            $fare = new Fare;
            $fare->setBranch($branch);
            $fare->setPrice(79);
            $fare->setDays(2);
            $fare->setTime(5);
            $manager->persist($fare);

        }

        $manager->flush();
    }
}
