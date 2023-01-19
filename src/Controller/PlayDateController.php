<?php

namespace App\Controller;

use DateInterval;

use App\Entity\Visitor;
use Doctrine\ORM\Query;
use App\Entity\PlayDate;
use App\Entity\PlayDateProduct;
use App\Entity\PlayDateVisitor;
use App\Repository\CityRepository;
use App\Repository\BranchRepository;
use App\Repository\ProductRepository;
use App\Repository\VisitorRepository;
use App\Repository\PlayDateRepository;
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
     * @Route("/api/get_price", name="api_get_price", methods={"POST"})
     */
    public function getPrice(Request $request): JsonResponse
    {
        $response = $this->savePlayDate($request, false);
        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * @Route("/api/save_play_date", name="api_save_playdate", methods={"POST"})
     */
    public function savePlayDate(Request $request, $save=true)
    {
        $data = json_decode($request->getContent(), true);
        $branch = $this->branchRepository->find($data['branch']);
        $startDate = \DateTime::createFromFormat('Y-m-d',$data['date']);
        $startsAt = \DateTime::createFromFormat('H:i', $data['start']);
        $hours = ($data['hours'] > 0 && $data['hours']<=2) ? $data['hours'] : 0 ;
        
        $newPlayDate = new PlayDate;
        $newPlayDate->setBranch($branch);
        $newPlayDate->setDate($startDate); 
        $newPlayDate->setHours($hours); 
        $newPlayDate->setStartsAt($startsAt);
        if($hours > 0){
            $endsAt = \DateTime::createFromFormat('H:i', $data['start']);
            $endsAt->add(new DateInterval('PT'.$hours.'H'));
            $newPlayDate->setEndsAt($endsAt);
        }

        $newPlayDate->setPaymentStatus(PlayDate::INITIAL_STATUS);

        //TODO validate if branch has capacity allowed        
        //TODO validate if branch has availabilty on the date
        //TODO validate if number of adults is allowd according to enfants number        
        
        if(!empty($data['products'])){
            foreach($data['products'] as $productJson){
                $product =  $this->productRepository->find($productJson['productId']);
                if(!empty($product)){
                    $newPlayDateProduct = new PlayDateProduct;
                    $newPlayDateProduct->setPlayDate($newPlayDate);
                    $newPlayDateProduct->setProduct($product);
                    $newPlayDateProduct->setPrice($product->getPrice());
                    $newPlayDateProduct->setQuantity($productJson['quantity']);
                }
            }
        }

        foreach($data['visitors'] as $visitorJson){
            $birthDay = \DateTime::createFromFormat('Y-m-d',$visitorJson['birthday']);
            $birthDay->setTime(0, 0, 0);
            $now = new \DateTime();
            $age = $now->diff($birthDay);
            $age = $age->y;
            
            $visitorType = ($age < Visitor::AGE_LIMIT) ? Visitor::TYPE_INFANT : Visitor::TYPE_ADULT;
            
            // validating if exist the user
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

            if(empty($visitor)){                    
                $visitor = new Visitor;
                $visitor->setFirstName(ucfirst(trim($visitorJson['firstName'])));
                $visitor->setLastName(ucfirst(trim($visitorJson['lastName'])));
                $visitor->setGender(Visitor::GENDER_UNDEFINED);
                $visitor->setBirthday( $birthDay );
            }            

            if($visitorType == Visitor::TYPE_ADULT){
                $city = $this->cityRepository->find($visitorJson['city']);
                $visitor->setMobilePhone($visitorJson['mobilePhone']);
                $visitor->setEmail($visitorJson['email']);
                if(!empty($city))
                    $visitor->setCity($city);
            } else{
                $visitor->setMobilePhone(null);
                $visitor->setEmail(null);
                $visitor->setCity(null);
            }

            $visitor->setType($visitorType);

            if($save === true)
                $this->manager->persist($visitor);

            $newPlayDateVisitor = new PlayDateVisitor;
            $newPlayDateVisitor->setPlayDate($newPlayDate);
            $newPlayDateVisitor->setVisitor($visitor);        

            $newPlayDateVisitor->setPrice(0); //temporal price

            if($save === true)
                $this->manager->persist($newPlayDateVisitor);

            $newPlayDate->addPlayDateVisitor($newPlayDateVisitor);
        }

        if($save === true)
            $this->manager->persist($newPlayDate);

        if(!empty($newPlayDateProduct) && $save === true){
            $this->manager->persist($newPlayDateProduct);
        }
        
        $newPlayDate->calculatePrice();

        if($save === true)
            $this->manager->persist($newPlayDate);

        if($save === true)
            $this->manager->flush();

        $response = [];        
        $response['price'] = number_format($newPlayDate->getPrice(),2);
        $response['playdate_id'] = $newPlayDate->getId();

        $response['success'] = (!empty($response['price'])) ? true : false;

        if($save === false)
            return $response;

        return new JsonResponse($response, Response::HTTP_OK);
    }
}
