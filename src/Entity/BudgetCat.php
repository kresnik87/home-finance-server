<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\BudgetCatRepository")
 * @ORM\EntityListeners({"App\EventListener\BudgetCatListener"})
 */
class BudgetCat
{

    const FRECUENCY_DAILY = "daily";
    const FRECUENCY_WEEKLY = "weekly";
    const FRECUENCY_BIWEEKLY = "biweekly";
    const FRECUENCY_MONTHLY = "monthly";
    const FRECUENCY_YEARLY = "yearly";


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"budgetCat-read", "budget-read","home-read"})
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"budgetCat-read","budgetCat-write","budget-read","home-read"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Budget", inversedBy="category")
     * @Groups({"budgetCat-read","budgetCat-write"})
     */
    private $budget;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"budgetCat-read","budgetCat-write","budget-read","home-read"})
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"budgetCat-read","budgetCat-write","budget-read","home-read"})
     */
    private $frecuency;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"budgetCat-read","budgetCat-write","budget-read","home-read"})
     */
    private $startDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"budgetCat-read","budgetCat-write","budget-read"})
     */
    private $activeNotif=true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @Groups({"budgetCat-read","budgetCat-write","budget-read","home-read"})
     */
    private $category;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"budgetCat-read","budgetCat-write","budget-read"})
     */
    private $automatic;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"budgetCat-read","budgetCat-write","budget-read","home-read"})
     */
    private $endDate;


    public function __toString()
    {
        return $this->getName() . " " . " (". $this->getId() . ")";
    }
    public function getId(): ?int
    {
        return $this->id;
    }


    public function getBudget(): ?Budget
    {
        return $this->budget;
    }

    public function setBudget(?Budget $budget): self
    {
        $this->budget = $budget;

        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getFrecuency(): ?string
    {
        return $this->frecuency;
    }

    public function setFrecuency(?string $frecuency): self
    {
        $this->frecuency = $frecuency;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getActiveNotif(): ?bool
    {
        return $this->activeNotif;
    }

    public function setActiveNotif(?bool $activeNotif): self
    {
        $this->activeNotif = $activeNotif;

        return $this;
    }

    public function  getFrecuencyToTime()
    {
        switch ($this->getFrecuency())
        {
            case self::FRECUENCY_DAILY:
                return"+1 day";
                break;
            case self::FRECUENCY_WEEKLY:
                return"+1 week";
                break;
            case self::FRECUENCY_MONTHLY:
                return "+1 month";
                break;
            case self::FRECUENCY_YEARLY:
                return "+1 year";
                break;
            case self::FRECUENCY_BIWEEKLY:
            default:
                return "+15 day";
                break;
        }
    }

    public function  getFrecuencyToString()
    {
        switch ($this->getFrecuency())
        {
            case self::FRECUENCY_DAILY:
                return ["label" => "day", "value" => 1];
                break;
            case self::FRECUENCY_WEEKLY:
                return ["label" => "week", "value" => 1];
                break;
            case self::FRECUENCY_MONTHLY:
                return ["label" => "month", "value" => 1];
                break;
            case self::FRECUENCY_YEARLY:
                return ["label" => "year", "value" => 1];
                break;
            case self::FRECUENCY_BIWEEKLY:
            default:
                return ["label" => "days", "value" => 15];
                break;
        }
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAutomatic(): ?bool
    {
        return $this->automatic;
    }

    public function setAutomatic(?bool $automatic): self
    {
        $this->automatic = $automatic;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

}
