<?php

namespace App\Entity;

use App\Repository\BranchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BranchRepository::class)
 */
class Branch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxVisitors;

    /**
     * @ORM\OneToMany(targetEntity=PlayDate::class, mappedBy="branch", cascade={"persist"})
     */
    private $playDates;

    /**
     * @ORM\OneToMany(targetEntity=Schedule::class, mappedBy="branch", orphanRemoval=true)
     */
    private $schedules;

    /**
     * @ORM\OneToMany(targetEntity=Fare::class, mappedBy="branch", orphanRemoval=true, cascade={"persist"})
     */
    private $fares;

    /**
     * @ORM\OneToMany(targetEntity=AdultFare::class, mappedBy="branch", orphanRemoval=true, cascade={"persist"})
     */
    private $adultFares;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="branch", orphanRemoval=true)
     */
    private $products;

    public function __construct()
    {
        $this->playDates = new ArrayCollection();
        $this->schedules = new ArrayCollection();
        $this->fares = new ArrayCollection();
        $this->adultFares = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getMaxVisitors(): ?int
    {
        return $this->maxVisitors;
    }

    public function setMaxVisitors(int $maxVisitors): self
    {
        $this->maxVisitors = $maxVisitors;

        return $this;
    }

    /**
     * @return Collection<int, PlayDate>
     */
    public function getPlayDates(): Collection
    {
        return $this->playDates;
    }

    public function addPlayDate(PlayDate $playDate): self
    {
        if (!$this->playDates->contains($playDate)) {
            $this->playDates[] = $playDate;
            $playDate->setBranch($this);
        }

        return $this;
    }

    public function removePlayDate(PlayDate $playDate): self
    {
        if ($this->playDates->removeElement($playDate)) {
            // set the owning side to null (unless already changed)
            if ($playDate->getBranch() === $this) {
                $playDate->setBranch(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Schedule>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedule $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
            $schedule->setBranch($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getBranch() === $this) {
                $schedule->setBranch(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Fare>
     */
    public function getFares(): Collection
    {
        return $this->fares;
    }

    public function addFare(Fare $fare): self
    {
        if (!$this->fares->contains($fare)) {
            $this->fares[] = $fare;
            $fare->setBranch($this);
        }

        return $this;
    }

    public function removeFare(Fare $fare): self
    {
        if ($this->fares->removeElement($fare)) {
            // set the owning side to null (unless already changed)
            if ($fare->getBranch() === $this) {
                $fare->setBranch(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AdultFare>
     */
    public function getAdultFares(): Collection
    {
        return $this->adultFares;
    }

    public function addAdultFare(AdultFare $adultFare): self
    {
        if (!$this->adultFares->contains($adultFare)) {
            $this->adultFares[] = $adultFare;
            $adultFare->setBranch($this);
        }

        return $this;
    }

    public function removeAdultFare(AdultFare $adultFare): self
    {
        if ($this->adultFares->removeElement($adultFare)) {
            // set the owning side to null (unless already changed)
            if ($adultFare->getBranch() === $this) {
                $adultFare->setBranch(null);
            }
        }

        return $this;
    }    

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setBranch($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBranch() === $this) {
                $product->setBranch(null);
            }
        }

        return $this;
    }

}
