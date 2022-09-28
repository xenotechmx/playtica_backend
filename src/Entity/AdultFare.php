<?php

namespace App\Entity;

use App\Repository\AdultFareRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdultFareRepository::class)
 */
class AdultFare
{
    public const ADULTS_TYPE = [
        'Adultos (1 y 2)' => 1,
        'Adultos (3 y 4)' => 2,
        'Adultos (5 y 6)' => 3,
        'Adultos (7 y 8)' => 4,
        'Adultos (9 y 10)' => 5
    ];

    public const DAYS = [
        'Lunes a Jueves' => 1,
        'Viernes a Domingo' => 2
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $days;

    /**
     * @ORM\ManyToOne(targetEntity=Branch::class, inversedBy="adultFares", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $branch;

    /**
     * @ORM\Column(type="integer")
     */
    private $adults;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }

    public function setDays(int $days): self
    {
        $this->days = $days;

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

    public function getAdults(): ?int
    {
        return $this->adults;
    }

    public function setAdults(int $adults): self
    {
        $this->adults = $adults;

        return $this;
    }

    public function __toString()
    {
        $days = array_flip(self::DAYS);
        $adultsType = array_flip(self::ADULTS_TYPE);

        return  '$'.number_format($this->getPrice(),2).' ( '.$adultsType[$this->getAdults()].' - '.$days[$this->getDays()].')';
    }

}
