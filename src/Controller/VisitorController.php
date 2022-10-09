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
        $visitor = $this->visitorRepository->findOneBy(['id' => $id]);

        $data = [
            'firstName' => $visitor->getFirstName(),
            'lastName' => $visitor->getLastName(),
            'birthday' => $visitor->getBirthday(),
            'type' => $visitor->getType(),
            'gender' => $visitor->getGender(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/visitors", name="api_get_all_visitors", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {    
        $query = $this->visitorRepository->createQueryBuilder('v')->getQuery();
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
                ->where('v.birthday = :dob')
                ->andWhere('v.firstName LIKE :firstName')
                ->andWhere('v.lastName LIKE :lastName')
                ->setParameter('dob', $data['birthday'])
                ->setParameter('firstName', '%'.$data['firstName'].'%')
                ->setParameter('lastName', '%'.$data['lastName'].'%')
                ->getQuery();
        $visitors = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($visitors, Response::HTTP_OK);
    }
    
}
