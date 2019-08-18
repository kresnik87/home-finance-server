<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"category-read","operations-write","operations-read","user-read","budgetCat-read","budgetCat-write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"category-read","category-write","user-read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true,length=255,)
     * @Groups({"category-read","category-write","user-read"})
     */
    private $icon;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"category-read","category-write","user-read"})
     */
    private $type=Operation::OPERATION_TYPE_INCOME;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"category-read","category-write","user-read"})
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Operation", mappedBy="category")
     */
    private $operations;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->getName() . " " . " (". $this->getId() . ")";
    }
    public function getId(): ?int
    {
        return $this->id;
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
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

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
            $operation->setCategory($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getCategory() === $this) {
                $operation->setCategory(null);
            }
        }

        return $this;
    }
}
