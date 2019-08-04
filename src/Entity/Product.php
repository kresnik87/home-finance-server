<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"product-read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="ShoppingList", inversedBy="products")
     * @Groups({"product-read"})
     */
    private $shoopingList;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"product-read"})
     */
    private $checked;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShoopingList(): ?ShoppingList
    {
        return $this->shoopingList;
    }

    public function setShoopingList(?ShoppingList $shoopingList): self
    {
        $this->shoopingList = $shoopingList;

        return $this;
    }

    public function getChecked(): ?bool
    {
        return $this->checked;
    }

    public function setChecked(?bool $checked): self
    {
        $this->checked = $checked;

        return $this;
    }
}
