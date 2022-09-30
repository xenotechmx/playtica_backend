<?php

namespace App\Entity;

use App\Repository\PlayDateProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayDateProductRepository::class)
 */
class PlayDateProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=PlayDate::class, inversedBy="playDateProducts", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $playDate;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function __toString()
    {
        return $this->getProduct()->getName().'( '.$this->getQuantity().' )';
    }
}
