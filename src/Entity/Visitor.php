<?php

namespace App\Entity;

use App\Repository\VisitorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisitorRepository::class)
 */
class Visitor
{
    public const TYPE_INFANT = 1;
    public const TYPE_ADULT = 2;
    public const INFANT = "Menor";
    public const ADULT = "Adulto";

    public const GENDER_UNDEFINED = 0;
    public const GENDER_FEMALE = 1;
    public const GENDER_MALE = 2;    
    public const UNDEFINED = "No especificado";
    public const FEMALE = "Femenino";
    public const MALE = "Masculino";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $type;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity=PlayDateVisitor::class, mappedBy="visitor", orphanRemoval=true)
     */
    private $playDateVisitors;

    public function __construct()
    {
        $this->playDateVisitors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function __toString()
    {        
        $types = ['',self::INFANT, self::ADULT];
        return $this->firstName.' '.$this->lastName.' - '.$types[$this->type].' ('.date_format($this->birthday,'d/m/Y').')';
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
            $playDateVisitor->setVisitor($this);
        }

        return $this;
    }

    public function removePlayDateVisitor(PlayDateVisitor $playDateVisitor): self
    {
        if ($this->playDateVisitors->removeElement($playDateVisitor)) {
            // set the owning side to null (unless already changed)
            if ($playDateVisitor->getVisitor() === $this) {
                $playDateVisitor->setVisitor(null);
            }
        }

        return $this;
    }

}
