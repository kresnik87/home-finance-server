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
 */
class Budget
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"budget-read"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"budget-read"})
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"budget-read"})
     */
    private $dateUpdated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"budget-read"})
     */
    private $status;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"budget-read"})
     */
    private $coef;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetCat", mappedBy="budget")
     * @Groups({"budget-read"})
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Income", cascade={"persist", "remove"})
     * @Groups({"budget-read"})
     */
    private $income;

    public function __construct()
    {
        $this->category = new ArrayCollection();
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

    public function getIncome(): ?Income
    {
        return $this->income;
    }

    public function setIncome(?Income $income): self
    {
        $this->income = $income;

        return $this;
    }
}
