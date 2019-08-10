<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\IncomeRepository")
 * @ORM\EntityListeners({"App\EventListener\IncomeListener"})
 */
class Income extends Category
{

    const INCOME_TYPE_DAILY = "daily";
    const INCOME_TYPE_WEEKLY = "weekly";
    const INCOME_TYPE_BIWEEKLY = "biweekly";
    const INCOME_TYPE_MONTHLY = "monthly";
    const INCOME_TYPE_YEARLY = "yearly";

    /**
     * @ORM\Column(type="string", length=200)
     * @Groups({"income-read","income-write","user-read"})
     */
    private $frequency;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"income-read","income-write","user-read"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FinanceStatus", inversedBy="income")
     * @Groups({"income-read"})
     */
    private $financeStatus;

    public function __construct()
    {

    }

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(?string $frequency): self
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

    public function  getFrequencyToTime()
    {
        switch ($this->getFrequency())
        {
            case self::INCOME_TYPE_DAILY:
                return"+1 day";
                break;
            case self::INCOME_TYPE_WEEKLY:
                return"+1 week";
                break;
            case self::INCOME_TYPE_MONTHLY:
                return "+1 month";
                break;
            case self::INCOME_TYPE_YEARLY:
                return "+1 year";
                break;
            case self::INCOME_TYPE_BIWEEKLY:
            default:
                return "+15 day";
                break;
        }
    }

    public function  getFrequencyToString()
    {
        switch ($this->getFrequency())
        {
            case self::INCOME_TYPE_DAILY:
                return ["label" => "day", "value" => 1];
                break;
            case self::INCOME_TYPE_WEEKLY:
                return ["label" => "week", "value" => 1];
                break;
            case self::INCOME_TYPE_MONTHLY:
                return ["label" => "month", "value" => 1];
                break;
            case self::INCOME_TYPE_YEARLY:
                return ["label" => "year", "value" => 1];
                break;
            case self::INCOME_TYPE_BIWEEKLY:
            default:
                return ["label" => "days", "value" => 15];
                break;
        }
    }

}
