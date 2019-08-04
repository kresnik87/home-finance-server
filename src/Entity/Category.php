<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"budget" = "BudgetCat", "income" = "Income","expense"="Expenses"})
 */
abstract  class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"category-read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"category-read"})
     */
    private $concept;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"category-read"})
     */
    private $amount;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcept(): ?string
    {
        return $this->concept;
    }

    public function setConcept(?string $concept): self
    {
        $this->concept = $concept;

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
}
