<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FinanceStatusRepository")
 */
class FinanceStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"finance-read"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"finance-read"})
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Income", mappedBy="financeStatus")\
     * @Groups({"finance-read"})
     */
    private $income;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Expenses", mappedBy="financeStatus")
     * @Groups({"finance-read"})
     */
    private $expenses;

    public function __construct()
    {
        $this->income = new ArrayCollection();
        $this->expenses = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Collection|Income[]
     */
    public function getIncome(): Collection
    {
        return $this->income;
    }

    public function addIncome(Income $income): self
    {
        if (!$this->income->contains($income)) {
            $this->income[] = $income;
            $income->setFinanceStatus($this);
        }

        return $this;
    }

    public function removeIncome(Income $income): self
    {
        if ($this->income->contains($income)) {
            $this->income->removeElement($income);
            // set the owning side to null (unless already changed)
            if ($income->getFinanceStatus() === $this) {
                $income->setFinanceStatus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Expenses[]
     */
    public function getExpenses(): Collection
    {
        return $this->expenses;
    }

    public function addExpense(Expenses $expense): self
    {
        if (!$this->expenses->contains($expense)) {
            $this->expenses[] = $expense;
            $expense->setFinanceStatus($this);
        }

        return $this;
    }

    public function removeExpense(Expenses $expense): self
    {
        if ($this->expenses->contains($expense)) {
            $this->expenses->removeElement($expense);
            // set the owning side to null (unless already changed)
            if ($expense->getFinanceStatus() === $this) {
                $expense->setFinanceStatus(null);
            }
        }

        return $this;
    }


}
