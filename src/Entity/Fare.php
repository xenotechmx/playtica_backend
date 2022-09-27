<?php

namespace App\Entity;

use App\Repository\FareRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FareRepository::class)
 */
class Fare
{

    public const TIMES = [
        '1 Hora' => 1,
        '2 Horas' => 2,
        'Todo el día' => 3,
        '10 min. extra' => 4,
        'Adulto' => 5,
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
     * @ORM\Column(type="integer")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=Branch::class, inversedBy="fares", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $branch;

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

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

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

    public function __toString()
    {
        $times = array_flip(self::TIMES);
        $days = array_flip(self::DAYS);

        return  '$'.$this->getPrice().' ('.$times[$this->getTime()].' - '.$days[$this->getDays()].')';
    }

}
