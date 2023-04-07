<?php

namespace App\Entity;

use App\Entity\Fare;
use App\Entity\Visitor;
use App\Repository\VisitorRepository;

use DateTime;
use App\Entity\Branch;
use App\Entity\PlayDateVisitor;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlayDateRepository;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity(repositoryClass=PlayDateRepository::class)
 */
class PlayDate
{    
    public const INITIAL_STATUS = 0;
    public const PAYMENT_STATUSES = [
        'Pendiente de pago' => 0,
        'Pago en efectivo' => 1,
        'Pago con tarjeta en sucursal' => 2
    ];
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $startsAt;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $endsAt;

    /**
     * @ORM\ManyToOne(targetEntity=Branch::class, inversedBy="playDates", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $branch;

    /**
     * @ORM\OneToMany(targetEntity=PlayDateVisitor::class, mappedBy="playDate", orphanRemoval=true, cascade={"persist"})
     */
    private $playDateVisitors;
        
    /**
     * @ORM\Column(type="integer")
     */
    private $paymentStatus;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=PlayDateProduct::class, mappedBy="playDate", orphanRemoval=true, cascade={"persist"})
     */
    private $playDateProducts;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $hours;
   
    public function __construct()
    {        
        $this->playDateVisitors = new ArrayCollection();
        $this->playDateProducts = new ArrayCollection();        
    }
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartsAt(): ?DateTime
    {
        return $this->startsAt;
    }

    public function setStartsAt(\DateTime $startsAt): self
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    public function getEndsAt(): ?\DateTime
    {
        return $this->endsAt;
    }

    public function setEndsAt(\DateTime $endsAt): self
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    public function setBranch(?Branch $branch): self
    {
        $this->branch = $branch;

        return $this;
    }
      
    /**
     * @return Collection<int, PlayDateVisitor>
     */
    public function getPlayDateVisitors(): Collection
    {
        return $this->playDateVisitors;
    }
    
    public function addPlayDateVisitor(PlayDateVisitor $playDateVisitor): self
    {
        if (!$this->playDateVisitors->contains($playDateVisitor)) {
            $this->playDateVisitors[] = $playDateVisitor;
            $playDateVisitor->setPlayDate($this);
        }

        return $this;
    }

    public function removePlayDateVisitor(PlayDateVisitor $playDateVisitor): self
    {
        if ($this->playDateVisitors->removeElement($playDateVisitor)) {
            // set the owning side to null (unless already changed)
            if ($playDateVisitor->getPlayDate() === $this) {
                $playDateVisitor->setPlayDate(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return 'Folio: '.$this->getId();
    }

    public function getPaymentStatus(): ?int
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(int $paymentStatus): self
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, PlayDateProduct>
     */
    public function getPlayDateProducts(): Collection
    {
        return $this->playDateProducts;
    }

    public function addPlayDateProduct(PlayDateProduct $playDateProduct): self
    {
        if (!$this->playDateProducts->contains($playDateProduct)) {
            $this->playDateProducts[] = $playDateProduct;
            $playDateProduct->setPlayDate($this);
        }

        return $this;
    }

    public function removePlayDateProduct(PlayDateProduct $playDateProduct): self
    {
        if ($this->playDateProducts->removeElement($playDateProduct)) {
            // set the owning side to null (unless already changed)
            if ($playDateProduct->getPlayDate() === $this) {
                $playDateProduct->setPlayDate(null);
            }
        }

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function calculatePrice()
    {
        $dayFare = ($this->getDate()->format('N') >= 1 && $this->getDate()->format('N') <= 4) ? 1 : 2 ; // 1 -> mon to thur, 2 -> fri to sun        
        $hours = $this->getHours(); //rounding to up time
        $timeFare = ($hours == 0) ? 3 : $hours ;
                
        $enfantFares = $this->getBranch()->getFares();
        $enfantCriteria = Criteria::create()
            ->where(Criteria::expr()->eq("days", $dayFare))
            ->andWhere(Criteria::expr()->eq("time", $timeFare))
            ->setMaxResults(1);
        $enfantFare = $enfantFares->matching($enfantCriteria);
        $enfantFare = $enfantFare->toArray()[0];

        $adultFares = $this->getBranch()->getAdultFares();

        $adultQty = 0;
        $totalPrice = 0;
        foreach($this->getPlayDateVisitors() as $playDateVisitor){
            if($playDateVisitor->getVisitor()->getType() == Visitor::TYPE_INFANT){
                $playDateVisitor->setPrice($enfantFare->getPrice());
                $totalPrice += $enfantFare->getPrice();
            }
            else{
                $adultQty++;
                $adultsType = ceil($adultQty/2);

                $adultCriteria = Criteria::create()
                    ->where(Criteria::expr()->eq("days", $dayFare))
                    ->andWhere(Criteria::expr()->eq("adults", $adultsType));

                $adultFare = $adultFares->matching($adultCriteria);
                $adultFare = $adultFare->toArray()[0];
                $playDateVisitor->setPrice($adultFare->getPrice());
                $totalPrice += $adultFare->getPrice();
            }
        }

        $productsPrice = 0;
        foreach($this->playDateProducts as $product){
            $productsPrice += $product->getPrice()/100 * $product->getQuantity();
        }

        $totalPrice += $productsPrice;

        $this->setPrice($totalPrice);
    }

    public function getHours()
    {       
        return $this->hours;
    }

    public function setHours(?int $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function binPlayDateVisitor(PlayDate $playDate, $request, VisitorRepository $visitorRepository): array{
        foreach ($playDate->getPlayDateProducts() as $playDateProduct){
            $playDateProduct->setPrice( $playDateProduct->getProduct()->getPrice() );
        }

        foreach ($playDate->getPlayDateVisitors() as $playDateVisitor){
            $playDate->removePlayDateVisitor($playDateVisitor);
        }
        
        if(empty($request['PlayDate']['playDateVisitors'])){
            return array(
                'type' => 'error',
                'message' => 'Debe agregar al menos dos visitantes a la cita'
            );
        }

        $visitors = $request['PlayDate']['playDateVisitors'];
        foreach($visitors as $v){
            $visitor = $visitorRepository->findByMobilePhone($v['mobilePhone']);
            if(empty($visitor)){
                $visitor = new Visitor;                
            }
            $visitor->setType($v['type']);
            $visitor->setMobilePhone($v['mobilePhone']);
            $visitor->setFirstName($v['firstName']);
            $visitor->setLastName($v['lastName']);
            $visitor->setGender($v['gender']);
            $birthday = DateTime::createFromFormat('Y-m-d', $v['birthday']);
            $visitor->setBirthday($birthday);

            $playDateVisitor = new PlayDateVisitor;
            $playDateVisitor->setVisitor($visitor);
            $playDateVisitor->setPlayDate($playDate);                        
            $playDate->addPlayDateVisitor($playDateVisitor);
        }
        $playDate->calculatePrice();

        return array(
            'type' => 'success',
            'message' => 'Cita guardada con éxito'
        );
    }
}
