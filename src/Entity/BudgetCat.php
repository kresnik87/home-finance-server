<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\BudgetCatRepository")
 */
class BudgetCat extends Category
{



    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"budgetCat-read","category-read"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Budget", inversedBy="category")
     * @Groups({"budgetCat-read","category-read"})
     */
    private $budget;



    public function __construct()
    {
        parent::__construct();
    }



    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
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

}
