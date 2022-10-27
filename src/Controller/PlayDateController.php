<?php

namespace App\Controller;

use Doctrine\ORM\Query;

use App\Entity\Visitor;
use App\Entity\PlayDate;
use App\Entity\PlayDateProduct;
use App\Entity\PlayDateVisitor;
use App\Repository\BranchRepository;
use App\Repository\CityRepository;
use App\Repository\PlayDateRepository;
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
    private $visitorRepository;
    private $cityRepository;
    private $playDateRepository;
    private $manager;

    public function __construct(BranchRepository $branchRepository, ProductRepository $productRepository, VisitorRepository $visitorRepository, CityRepository $cityRepository, PlayDateRepository $playDateRepository, EntityManagerInterface $manager)
    {
        $this->branchRepository = $branchRepository;
        $this->productRepository = $productRepository;        
        $this->visitorRepository = $visitorRepository;
        $this->cityRepository = $cityRepository;
        $this->playDateRepository = $playDateRepository;
        $this->manager = $manager;
    }

    /**
     * @Route("/api/play_date/{id}", name="api_get_playdate", methods={"GET"})
     */
    public function get($id): JsonResponse
    {        
        $query = $this->playDateRepository->createQueryBuilder('p')
                ->select('p','b')
                ->leftJoin('p.branch','b')                
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery();
        $playdate = $query->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse($playdate[0], Response::HTTP_OK);
    }


    /**
     * @Route("/api/save_play_date", name="api_save_playdate", methods={"POST"})
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

        //TODO validate if branch has capacity allowed
        //TODO validate if responsable is an adult
        //TODO validate if branch hast availabilty on the date
        //TODO validate if number of adults is allowd according to enfants number
        //TODO validate if at least exist one responsable and is adult
        
        if(!empty($data['products'])){
            foreach($data['products'] as $productJson){
                $product =  $this->productRepository->find($productJson['productId']);
                $newPlayDateProduct = new PlayDateProduct;
                $newPlayDateProduct->setPlayDate($newPlayDate);
                $newPlayDateProduct->setProduct($product);
                $newPlayDateProduct->setPrice($product->getPrice());
                $newPlayDateProduct->setQuantity($productJson['quantity']);
            }
        }

        foreach($data['visitors'] as $visitorJson){
            $birthDay = \DateTime::createFromFormat('Y-m-d',$visitorJson['birthday']);
            $birthDay->setTime(0, 0, 0);
            $now = new \DateTime();
            $age = $now->diff($birthDay);
            $age = $age->y;
            
            $visitorType = ($age < Visitor::AGE_LIMIT) ? Visitor::TYPE_INFANT : Visitor::TYPE_ADULT;

            if(empty($visitorJson['id'])){
                // validating if really don't exist another user with same data 
                $query = $this->visitorRepository->createQueryBuilder('v')
                    ->select('v')
                    ->where('v.birthday = :dob')
                    ->andWhere('v.firstName = :firstName')
                    ->andWhere('v.lastName = :lastName')
                    ->setParameter('dob', $birthDay)
                    ->setParameter('firstName', trim($visitorJson['firstName']))
                    ->setParameter('lastName', trim($visitorJson['lastName']))
                    ->getQuery();
                $visitor = $query->getOneOrNullResult();
                // end of validating if really don't exist another user with same data 

                if(empty($visitor)){                    
                    $visitor = new Visitor;
                    $visitor->setFirstName(ucfirst(trim($visitorJson['firstName'])));
                    $visitor->setLastName(ucfirst(trim($visitorJson['lastName'])));
                    $visitor->setGender(Visitor::GENDER_UNDEFINED);                    
                    $visitor->setBirthday( $birthDay );                    
                }
            }
            else{                
                $visitor = $this->visitorRepository->find($visitorJson['id']);
            }

            if(!empty($visitorJson['responsable']) && $visitorJson['responsable'] == true){
                $city = $this->cityRepository->find($visitorJson['city']);
                $visitor->setMobilePhone($visitorJson['mobilePhone']);
                $visitor->setEmail($visitorJson['email']);
                if(!empty($city))
                    $visitor->setCity($city);
            }

            $visitor->setType($visitorType);
            $this->manager->persist($visitor);

            $newPlayDateVisitor = new PlayDateVisitor;
            $newPlayDateVisitor->setPlayDate($newPlayDate);
            $newPlayDateVisitor->setVisitor($visitor);
            
            if(!empty($visitorJson['responsable']) && $visitorJson['responsable'] == true)
                $newPlayDateVisitor->setResponsable(true);
            else
                $newPlayDateVisitor->setResponsable(false);

            $newPlayDateVisitor->setPrice(0); //temporal price
            $this->manager->persist($newPlayDateVisitor);

            $newPlayDate->addPlayDateVisitor($newPlayDateVisitor);
        }

        $this->manager->persist($newPlayDate);
        $this->manager->persist($newPlayDateProduct);
        
        $newPlayDate->calculatePrice();
        $this->manager->persist($newPlayDate);
        $this->manager->flush();

        $response = [];        
        $response['price'] = number_format($newPlayDate->getPrice(),2);
        $response['playdate_id'] = $newPlayDate->getId();

        $response['success'] = (!empty($response['price'])) ? true : false;

        return new JsonResponse($response, Response::HTTP_OK);
    }
}
