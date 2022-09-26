<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Schedule;
use App\Repository\BranchRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ScheduleFixtures extends Fixture
{
    private $branchRepository;

    public function __construct(BranchRepository $branchRepository){
        $this->branchRepository = $branchRepository;   
    }

    public function load(ObjectManager $manager): void
    {
        $branches=  $this->branchRepository->findAll();
        foreach($branches as $branch){
            for($i=1; $i<6; $i++){
                $schedule = new Schedule();
                $schedule->setBranch($branch);
                $schedule->setType($i);
                $schedule->setOpenTime(new DateTime('13:00:00'));
                $schedule->setCloseTime(new DateTime('20:00:00'));
                $manager->persist($schedule);
            }
            for($i=6; $i<8; $i++){
                $schedule = new Schedule();
                $schedule->setBranch($branch);
                $schedule->setType($i);
                $schedule->setOpenTime(new DateTime('12:00:00'));
                $schedule->setCloseTime(new DateTime('20:00:00'));
                $manager->persist($schedule);
            }
        }
        $manager->flush();
    }
}
