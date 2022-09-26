<?php

namespace App\Entity;

use App\Repository\PlayDateVisitorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayDateVisitorRepository::class)
 */
class PlayDateVisitor
{
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
     * @ORM\ManyToOne(targetEntity=PlayDate::class, inversedBy="playDateVisitors", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $playDate;

    /**
     * @ORM\ManyToOne(targetEntity=Visitor::class, inversedBy="playDateVisitors", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $visitor;

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

    public function getPlayDate(): ?PlayDate
    {
        return $this->playDate;
    }

    public function setPlayDate(?PlayDate $playDate): self
    {
        $this->playDate = $playDate;

        return $this;
    }

    public function getVisitor(): ?Visitor
    {
        return $this->visitor;
    }

    public function setVisitor(?Visitor $visitor): self
    {
        $this->visitor = $visitor;

        return $this;
    }

    public function __toString()
    {
        return $this->getVisitor()->getFirstName().' '.$this->getVisitor()->getLastName();
    }

}
