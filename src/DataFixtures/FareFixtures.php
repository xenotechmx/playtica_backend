<?php

namespace App\DataFixtures;

use App\Entity\Fare;
use App\Entity\AdultFare;
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
            if($branch->getName() == 'San Pedro'){
                $fares = [
                    [ 'time' => 1, 'days' => 1, 'price' => 195],
                    [ 'time' => 2, 'days' => 1, 'price' => 295],
                    [ 'time' => 3, 'days' => 1, 'price' => 445],
                    [ 'time' => 4, 'days' => 1, 'price' => 35],
                    [ 'time' => 1, 'days' => 2, 'price' => 255],
                    [ 'time' => 2, 'days' => 2, 'price' => 385],
                    [ 'time' => 3, 'days' => 2, 'price' => 580],
                    [ 'time' => 4, 'days' => 2, 'price' => 45],
                ];

                $adultFares = [
                    [ 'adultType' => 1, 'days' => 1, 'price' => 80],
                    [ 'adultType' => 2, 'days' => 1, 'price' => 100],
                    [ 'adultType' => 3, 'days' => 1, 'price' => 130],
                    [ 'adultType' => 4, 'days' => 1, 'price' => 170],
                    [ 'adultType' => 5, 'days' => 1, 'price' => 220],
                    [ 'adultType' => 1, 'days' => 2, 'price' => 100],
                    [ 'adultType' => 2, 'days' => 2, 'price' => 130],
                    [ 'adultType' => 3, 'days' => 2, 'price' => 170],
                    [ 'adultType' => 4, 'days' => 2, 'price' => 220],
                    [ 'adultType' => 5, 'days' => 2, 'price' => 285],
                ];
            }

            if($branch->getName() == 'Cumbres'){
                $fares = [
                    [ 'time' => 1, 'days' => 1, 'price' => 160],
                    [ 'time' => 2, 'days' => 1, 'price' => 239],
                    [ 'time' => 3, 'days' => 1, 'price' => 359],
                    [ 'time' => 4, 'days' => 1, 'price' => 30],
                    [ 'time' => 1, 'days' => 2, 'price' => 195],
                    [ 'time' => 2, 'days' => 2, 'price' => 299],
                    [ 'time' => 3, 'days' => 2, 'price' => 449],
                    [ 'time' => 4, 'days' => 2, 'price' => 35],
                ];

                $adultFares = [
                    [ 'adultType' => 1, 'days' => 1, 'price' => 59],
                    [ 'adultType' => 2, 'days' => 1, 'price' => 70],
                    [ 'adultType' => 3, 'days' => 1, 'price' => 90],
                    [ 'adultType' => 4, 'days' => 1, 'price' => 120],
                    [ 'adultType' => 5, 'days' => 1, 'price' => 160],
                    [ 'adultType' => 1, 'days' => 2, 'price' => 79],
                    [ 'adultType' => 2, 'days' => 2, 'price' => 90],
                    [ 'adultType' => 3, 'days' => 2, 'price' => 120],
                    [ 'adultType' => 4, 'days' => 2, 'price' => 160],
                    [ 'adultType' => 5, 'days' => 2, 'price' => 210],
                ];
            }

            if($branch->getName() == 'Apodaca'){
                $fares = [
                    [ 'time' => 1, 'days' => 1, 'price' => 160],
                    [ 'time' => 2, 'days' => 1, 'price' => 239],
                    [ 'time' => 3, 'days' => 1, 'price' => 359],
                    [ 'time' => 4, 'days' => 1, 'price' => 30],
                    [ 'time' => 1, 'days' => 2, 'price' => 195],
                    [ 'time' => 2, 'days' => 2, 'price' => 299],
                    [ 'time' => 3, 'days' => 2, 'price' => 449],
                    [ 'time' => 4, 'days' => 2, 'price' => 35],
                ];
                $adultFares = [
                    [ 'adultType' => 1, 'days' => 1, 'price' => 59],
                    [ 'adultType' => 2, 'days' => 1, 'price' => 70],
                    [ 'adultType' => 3, 'days' => 1, 'price' => 90],
                    [ 'adultType' => 4, 'days' => 1, 'price' => 120],
                    [ 'adultType' => 5, 'days' => 1, 'price' => 160],
                    [ 'adultType' => 1, 'days' => 2, 'price' => 79],
                    [ 'adultType' => 2, 'days' => 2, 'price' => 90],
                    [ 'adultType' => 3, 'days' => 2, 'price' => 120],
                    [ 'adultType' => 4, 'days' => 2, 'price' => 160],
                    [ 'adultType' => 5, 'days' => 2, 'price' => 210],
                ];
            }

            foreach($fares as $fare){
                $fareEntity = new Fare;
                $fareEntity->setBranch($branch);
                $fareEntity->setPrice($fare['price']);
                $fareEntity->setDays($fare['days']);
                $fareEntity->setTime($fare['time']);
                $manager->persist($fareEntity);
            }
            foreach($adultFares as $adultFare){
                $adultFareEntity = new AdultFare;
                $adultFareEntity->setBranch($branch);
                $adultFareEntity->setPrice($adultFare['price']);
                $adultFareEntity->setDays($adultFare['days']);
                $adultFareEntity->setAdults($adultFare['adultType']);
                $manager->persist($adultFareEntity);
            }
            $manager->flush();
        }
    }
}
