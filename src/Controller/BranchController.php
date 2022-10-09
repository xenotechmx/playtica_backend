<?php

namespace App\Controller;

use App\Repository\BranchRepository;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BranchController extends AbstractController
{

    private $branchRepository;
    
    public function __construct(BranchRepository $branchRepository){        
        $this->branchRepository = $branchRepository;
    }


    /**
     * @Route("/api/branches", name="app_api_get_all_branches")
     */
    public function getAll(): Response
    {
        $query = $this->branchRepository->createQueryBuilder('c')->getQuery();
        $branches = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($branches, Response::HTTP_OK);
    }
}
