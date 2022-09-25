<?php

namespace App\Entity;

use App\Repository\PlayDateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayDateRepository::class)
 */
class PlayDate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $endAt;

    /**
     * @ORM\ManyToOne(targetEntity=Branch::class, inversedBy="playDates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $branch;

    /**
     * @ORM\OneToMany(targetEntity=PlayDateVisitor::class, mappedBy="playDate", orphanRemoval=true)
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

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;

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
        return 'PLAYDATE';
    }
}
