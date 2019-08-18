<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\BudgetRepository")
 * @ORM\EntityListeners({"App\EventListener\BudgetListener"})
 */
class Budget
{
    const STATUS_PREPARE  = 'prepare';
    const STATUS_CONFIRM= 'confirm';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"budget-read","user-read","budgetCat-write","home-read"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"budget-read","home-read"})
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"budget-read","budget-write"})
     */
    private $dateUpdated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"budget-read","budget-write","home-read"})
     */
    private $status=self::STATUS_PREPARE;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"budget-read","budget-write","home-read"})
     */
    private $coef;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetCat", mappedBy="budget")
     * @Groups({"budget-read","budget-write","home-read"})
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Home", inversedBy="budgets")
     * @Groups({"budget-read","budget-write"})
     */
    private $home;




    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->dateCreated = new \dateTime();
        $this->dateUpdated = new \dateTime();
    }

    public function __toString()
    {
        return "Budget -" .$this->getHome(). " (" . $this->getId() . ")";
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(?\DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCoef(): ?float
    {
        return $this->coef;
    }

    public function setCoef(?float $coef): self
    {
        $this->coef = $coef;

        return $this;
    }

    /**
     * @return Collection|BudgetCat[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(BudgetCat $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
            $category->setBudget($this);
        }

        return $this;
    }

    public function removeCategory(BudgetCat $category): self
    {
        if ($this->category->contains($category)) {
            $this->category->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getBudget() === $this) {
                $category->setBudget(null);
            }
        }

        return $this;
    }

    public function getIncome(): float
    {
        return $this->getHome()->getHomeIncome();
    }

    public function getHome(): ?Home
    {
        return $this->home;
    }

    public function setHome(?Home $home): self
    {
        $this->home = $home;

        return $this;
    }

    /**
     * @Groups({"budget-read","user-read"})
     */
    public function getCoefStatus():float{
        $totalAmount=0;
        $totalIncome=$this->getHome()->getHomeIncome();
        if(count($this->getCategory())>0){
            foreach ($this->getCategory() as $cat){
                $totalAmount+=$cat->getAmount();
            }
            $coef=(100*$totalAmount)/$totalIncome;
            $coef=round($coef,2);
            $this->setCoef($coef);
            return $this->coef;
        }
    }

}
