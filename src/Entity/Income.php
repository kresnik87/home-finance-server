<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\IncomeRepository")
 */
class Income extends Category
{

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"income-read"})
     */
    private $frequency;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"income-read"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FinanceStatus", inversedBy="income")
     * @Groups({"income-read"})
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
