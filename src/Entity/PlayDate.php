<?php

namespace App\Entity;

use DateTime;
use App\Entity\Branch;
use App\Entity\PlayDateVisitor;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PlayDateRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=PlayDateRepository::class)
 */
class PlayDate
{

    public const INITIAL_STATUS = 0;
    public const PAYMENT_STATUSES = [
        'Falta de pago' => 0,
        'Pago en efectivo' => 1,
        'Pago con tarjeta en sucursal' => 2,
        'Pago con tarjeta en línea' => 3
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
     * @ORM\Column(type="time")
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
}
