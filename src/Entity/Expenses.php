<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ExpensesRepository")
 */
class Expenses extends Category
{


    const EXPENSES_TYPE_DAILY = "daily";
    const EXPENSES_TYPE_WEEKLY = "weekly";
    const EXPENSES_TYPE_BIWEEKLY = "biweekly";
    const EXPENSES_TYPE_MONTHLY = "monthly";
    const EXPENSES_TYPE_YEARLY = "yearly";
    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"expense-read"})
     */
    private $frequency;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"expense-read"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FinanceStatus", inversedBy="expenses")
     * @Groups({"expense-read"})
     */
    private $financeStatus;

    public function __construct()
    {
        parent::__construct();
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function setFrequency(?int $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFinanceStatus(): ?FinanceStatus
    {
        return $this->financeStatus;
    }

    public function setFinanceStatus(?FinanceStatus $financeStatus): self
    {
        $this->financeStatus = $financeStatus;

        return $this;
    }


}
