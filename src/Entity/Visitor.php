<?php

namespace App\Entity;

use App\Repository\VisitorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisitorRepository::class)
 */
class Visitor
{
    public const AGE_LIMIT = 13;

    public const TYPE_INFANT = 1;
    public const TYPE_ADULT = 2;
    public const INFANT = "Menor";
    public const ADULT = "Adulto";

    public const TYPE_MARITAL_STATUS_MARRIED = 1;
    public const TYPE_MARITAL_STATUS_SINGLE = 2;
    public const TYPE_MARITAL_STATUS_OTHER = 3;
    public const OTHER = "Otro";
    public const MARRIED = "Casado";
    public const SINGLE = "Soltero";

    public const GENDER_UNDEFINED = 0;
    public const GENDER_FEMALE = 1;
    public const GENDER_MALE = 2;    
    public const UNDEFINED = "No especificado";
    public const FEMALE = "Femenino";
    public const MALE = "Masculino";

    private $visitorRepository;

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
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    private $gender;

    /**
     * @ORM\OneToMany(targetEntity=PlayDateVisitor::class, mappedBy="visitor", orphanRemoval=true)
     */
    private $playDateVisitors;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maritalStatus;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $mobilePhone;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="visitors")
     */
    private $city;

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

    public function getTypeLabel($length = 'long'): ?string
    {
        if($this->type == $this::TYPE_INFANT){
            if($length == 'short')
                return 'M';
            return $this::INFANT;
        }
        else if($this->type == $this::TYPE_ADULT){
            if($length == 'short')
                return 'A';
            return $this::ADULT;            
        }
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
        // $types = ['',self::INFANT, self::ADULT];
        // return $this->firstName.' '.$this->lastName.' - '.$types[$this->type].' ('.date_format($this->birthday,'d/m/Y').')';

        return $this->firstName.' '.$this->lastName;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMaritalStatus(): ?int
    {
        return $this->maritalStatus;
    }

    public function setMaritalStatus(?int $maritalStatus): self
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone(?string $mobilePhone): self
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
    
}
