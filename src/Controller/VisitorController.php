<?php

namespace App\Controller;

use Doctrine\ORM\Query;

use App\Repository\VisitorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VisitorController extends AbstractController
{
    private $visitorRepository;

    public function __construct(VisitorRepository $visitorRepository)
    {
        $this->visitorRepository = $visitorRepository;
    }

    
    /**
     * @Route("/api/visitors/{id}", name="api_get_visitor", methods={"GET"})
     */
    public function get($id): JsonResponse
    {        
        $query = $this->visitorRepository->createQueryBuilder('v')
                ->select('v','c')
                ->where('v.id = :id')
                ->andWhere('v.firstName LIKE :firstName')
                ->andWhere('v.lastName LIKE :lastName')
                ->leftJoin('v.city','c')
                ->setParameter('id', $id)
                ->getQuery();
        $visitors = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($visitors, Response::HTTP_OK);
    }

    /**
     * @Route("/api/visitors", name="api_get_all_visitors", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $query = $this->visitorRepository->createQueryBuilder('v')
                ->select('v','c')                
                ->leftJoin('v.city','c')                
                ->getQuery();
        $visitors = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($visitors, Response::HTTP_OK);
    }

    /**
     * @Route("/api/find_visitor", name="api_find_visitor", methods={"POST"})
     */
    public function findVisitor(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
       
        $query = $this->visitorRepository->createQueryBuilder('v')
                ->select('v','c')
                ->where('v.birthday = :dob')
                ->andWhere('v.firstName LIKE :firstName')
                ->andWhere('v.lastName LIKE :lastName')
                ->leftJoin('v.city','c')
                ->setParameter('dob', $data['birthday'])
                ->setParameter('firstName', '%'.$data['firstName'].'%')
                ->setParameter('lastName', '%'.$data['lastName'].'%')
                ->getQuery();
        $visitors = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($visitors, Response::HTTP_OK);
    }

    /**
     * @Route("/api/find_visitor_mobile", name="api_find_visitor_mobile", methods={"POST"})
     */
    public function findVisitorMobile(Request $request): JsonResponse
    {
        $data = $request->request->all(); //TODO, clear mobilePhone, remove spaces, dashes, etc.

        $query = $this->visitorRepository->createQueryBuilder('v')
                ->select('v','c')
                ->where('v.mobilePhone LIKE :mobilePhone')
                ->leftJoin('v.city','c')
                ->setParameter('mobilePhone', '%'.$data['mobilePhone'].'%')
                ->getQuery();
        $visitors = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($visitors, Response::HTTP_OK);
    }
    
}
