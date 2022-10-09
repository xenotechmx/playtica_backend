<?php

namespace App\Controller;

use Doctrine\ORM\Query;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    private $productRepository;
    
    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;        
    }


    /**
     * @Route("/api/products/by_branch/{branchId}", name="api_get_product_by_branch", methods={"GET"})
     */
    public function getByBranch($branchId): JsonResponse
    {
        $query = $this->productRepository->createQueryBuilder('p')
                ->where('p.branch = :branchId')
                ->andWhere('p.active = :active')
                ->setParameter('branchId', $branchId)
                ->setParameter('active', true)
                ->getQuery();
        $products = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($products, Response::HTTP_OK);
    }
}
