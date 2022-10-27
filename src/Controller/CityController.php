<?php

namespace App\Controller;

use Doctrine\ORM\Query;
use App\Repository\CityRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CityController extends AbstractController
{
    private $cityRepository;
    
    public function __construct(CityRepository $cityRepository){        
        $this->cityRepository = $cityRepository;
    }


    /**
     * @Route("/api/cities", name="app_api_get_all_cities")
     */
    public function getAll(): Response
    {
        $query = $this->cityRepository->createQueryBuilder('c')->getQuery();
        $branches = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($branches, Response::HTTP_OK);
    }
}
