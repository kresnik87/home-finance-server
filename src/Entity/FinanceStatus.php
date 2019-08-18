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
     * @Groups({"finance-read","user-read","finance-write","user-write","operation-write"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"finance-read","finance-write","user-read","user-write"})
     */
    private $amount;



    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     * @Groups({"finance-read","finance-write"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Operation", mappedBy="finance")
     * @Groups({"finance-read","user-read"})
     */
    private $operations;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
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
     * @Groups({"finance-read","user-read"})
     */
    public function getAmountStatus(): ?float
    {
        $amountIncome = 0;
        $amountExpense = 0;
        if(count($this->getOperations())>0){
            foreach ($this->getOperations() as $oper){
                if($oper->isIncome()){
                    $amountIncome+=$oper->getAmount();
                }else{
                    $amountExpense+=$oper->getAmount();
                }
            }
            $this->setAmount($amountIncome-$amountExpense);
            return $this->amount;
        }
        return null;

    }



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newFinanceStatus = $user === null ? null : $this;
        if ($newFinanceStatus !== $user->getFinanceStatus()) {
            $user->setFinanceStatus($newFinanceStatus);
        }

        return $this;
    }

    /**
     * @return Collection|Operation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setFinance($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getFinance() === $this) {
                $operation->setFinance(null);
            }
        }

        return $this;
    }


}
