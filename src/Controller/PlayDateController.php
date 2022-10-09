<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Entity\PlayDate;
use App\Entity\PlayDateProduct;
use App\Entity\PlayDateVisitor;
use App\Repository\BranchRepository;
use App\Repository\ProductRepository;
use App\Repository\VisitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlayDateController extends AbstractController
{
    private $branchRepository;
    private $productRepository;    
    private $visitor;
    private $manager;

    public function __construct(BranchRepository $branchRepository, ProductRepository $productRepository, VisitorRepository $visitor, EntityManagerInterface $manager)
    {
        $this->branchRepository = $branchRepository;
        $this->productRepository = $productRepository;        
        $this->visitor = $visitor;
        $this->manager = $manager;
    }

    /**
     * @Route("/api/play-date/", name="api_save_playdate", methods={"POST"})
     */
    public function savePlayDate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $branch = $this->branchRepository->find($data['branch']);

        $newPlayDate = new PlayDate;
        $newPlayDate->setBranch($branch);
        $newPlayDate->setDate( \DateTime::createFromFormat('d/m/Y',$data['date']) ); 
        $newPlayDate->setStartsAt( \DateTime::createFromFormat('H:i',$data['start']) ) ;
        $newPlayDate->setEndsAt( \DateTime::createFromFormat('H:i',$data['end']) ) ;
        $newPlayDate->setPaymentStatus(PlayDate::INITIAL_STATUS);
        $this->manager->persist($newPlayDate);

        foreach($data['products'] as $productJson){
            $product =  $this->productRepository->find($productJson['productId']) ;
            $newPlayDateProduct = new PlayDateProduct;
            $newPlayDateProduct->setPlayDate($newPlayDate);
            $newPlayDateProduct->setProduct($product);
            $newPlayDateProduct->setPrice($product->getPrice());
            $newPlayDateProduct->setQuantity($productJson['quantity']);            
            $this->manager->persist($newPlayDateProduct);
        }

        foreach($data['visitors'] as $visitorJson){
            if(!empty($visitorJson['id'])){
                $visitor = $this->visitor->find($visitorJson['id']); //to do validate if really don't exist another user with same data
            }
            else{
                $birthDay = \DateTime::createFromFormat('Y-m-d',$visitorJson['birthday']);
                $now = new \DateTime();
                $age = $now->diff($birthDay);
                $age = $age->y;
                $visitorType = $age<13 ? Visitor::TYPE_INFANT : Visitor::TYPE_ADULT ;

                $visitor = new Visitor;
                $visitor->setFirstName($visitorJson['firstName']);
                $visitor->setLastName($visitorJson['lastName']);
                $visitor->setGender(Visitor::GENDER_UNDEFINED);
                $visitor->setType($visitorType);
                $visitor->setBirthday( $birthDay );
                $this->manager->persist($visitor);
            }            
            $newPlayDateVisitor = new PlayDateVisitor;
            $newPlayDateVisitor->setPlayDate($newPlayDate);
            $newPlayDateVisitor->setVisitor($visitor);
            $newPlayDateVisitor->setPrice(0); // temporal price
            $this->manager->persist($newPlayDateVisitor);
        }

        $this->manager->flush();

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
