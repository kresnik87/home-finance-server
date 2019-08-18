<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\OperationRepository")
 * @ORM\EntityListeners({"App\EventListener\OperationListener"})
 */
class Operation
{
    const OPERATION_TYPE_INCOME  = 'income';
    const OPERATION_TYPE_EXPENSE= 'expense';
    const OPERATION_FRECUENCY_DAILY = "daily";
    const OPERATION_FRECUENCY_WEEKLY = "weekly";
    const OPERATION_FRECUENCY_BIWEEKLY = "biweekly";
    const OPERATION_FRECUENCY_MONTHLY = "monthly";
    const OPERATION_FRECUENCY_YEARLY = "yearly";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"operation-read","user-read"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"operation-read","operation-write","user-read"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"operation-read","operation-write","user-read"})
     */
    private $frecuency;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"operation-read","operation-write","user-read"})
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"operation-read","operation-write","user-read"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FinanceStatus", inversedBy="operations")
     * @Groups({"operation-read","operation-write"})
     */
    private $finance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @Groups({"operation-read","operation-write","user-read"})
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return "Operations -(" . $this->getId() . ")";
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

    public function getFrecuency(): ?string
    {
        return $this->frecuency;
    }

    public function setFrecuency(?string $frecuency): self
    {
        $this->frecuency = $frecuency;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFinance(): ?FinanceStatus
    {
        return $this->finance;
    }

    public function setFinance(?FinanceStatus $finance): self
    {
        $this->finance = $finance;

        return $this;
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
    public function  getFrecuencyToTime()
    {
        switch ($this->getFrecuency())
        {
            case self::OPERATION_FRECUENCY_DAILY:
                return"+1 day";
                break;
            case self::OPERATION_FRECUENCY_WEEKLY:
                return"+1 week";
                break;
            case self::OPERATION_FRECUENCY_MONTHLY:
                return "+1 month";
                break;
            case self::OPERATION_FRECUENCY_YEARLY:
                return "+1 year";
                break;
            case self::OPERATION_FRECUENCY_BIWEEKLY:
            default:
                return "+15 day";
                break;
        }
    }

    public function  getFrecuencyToString()
    {
        switch ($this->getFrecuency())
        {
            case self::OPERATION_FRECUENCY_DAILY:
                return ["label" => "day", "value" => 1];
                break;
            case self::OPERATION_FRECUENCY_WEEKLY:
                return ["label" => "week", "value" => 1];
                break;
            case self::OPERATION_FRECUENCY_MONTHLY:
                return ["label" => "month", "value" => 1];
                break;
            case self::OPERATION_FRECUENCY_YEARLY:
                return ["label" => "year", "value" => 1];
                break;
            case self::OPERATION_FRECUENCY_BIWEEKLY:
            default:
                return ["label" => "days", "value" => 15];
                break;
        }
    }

    public function isIncome(){
        return $this->type==self::OPERATION_TYPE_INCOME;
    }


}
