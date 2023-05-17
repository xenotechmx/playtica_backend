<?php

namespace App\Controller;

use App\Repository\BranchRepository;
use App\Repository\ScheduleRepository;
use DateTime;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BranchController extends AbstractController
{

    private $branchRepository;
    private $scheduleRepository;
    
    public function __construct(BranchRepository $branchRepository, ScheduleRepository $scheduleRepository){        
        $this->branchRepository = $branchRepository;
        $this->scheduleRepository = $scheduleRepository;
    }


    /**
     * @Route("/api/branches", name="app_api_get_all_branches")
     */
    public function getAll(): Response
    {
        //$query = $this->branchRepository->createQueryBuilder('c')->getQuery();
        $query = $this->branchRepository->createQueryBuilder('c') //remove this query and restore the above to release all branches
                ->where('c.name = :name')
                ->setParameter('name', 'Cumbres')
                ->setMaxResults(1)
                ->getQuery();

        $branches = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($branches, Response::HTTP_OK);
    }

    /**
     * @Route("/api/branch/schedule/{branchId}", name="app_api_get_branch_schedule")
     */
    public function getBranchSchedule($branchId): Response
    {
        $query = $this->scheduleRepository->createQueryBuilder('s')
                ->where('s.branch = :branchId')                
                ->setParameter('branchId', $branchId)                
                ->getQuery();
        $schedules = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($schedules, Response::HTTP_OK);
    }

    /**
     * @Route("/api/branch/schedule/{branchId}/{date}", name="app_api_get_branch_schedule_date")
     */
    public function getBranchScheduleDate($branchId, $date): Response
    {
        $formatedDate = DateTime::createFromFormat('dmY H:i', $date." 00:00");
        $dayOfWeek = $formatedDate->format('N'); // 1 for monday through 7 for sunday

        //looking if exists a special schedule for this date
        $query = $this->scheduleRepository->createQueryBuilder('s')
                ->where('s.branch = :branchId')
                ->andWhere('s.startsAt <= :date')
                ->andwhere('s.endsAt >= :date')
                ->setParameter('branchId', $branchId)
                ->setParameter('date', $formatedDate)
                ->getQuery();
        $schedules = $query->getResult(Query::HYDRATE_ARRAY);
        if(!empty($schedules)){
            return new JsonResponse($schedules, Response::HTTP_OK);    
        }

        $query = $this->scheduleRepository->createQueryBuilder('s')
                ->where('s.branch = :branchId')
                ->andWhere('s.type = :dayOfWeek')                
                ->setParameter('branchId', $branchId)
                ->setParameter('dayOfWeek', $dayOfWeek)
                ->getQuery();
        $schedules = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($schedules, Response::HTTP_OK);
    }
}
