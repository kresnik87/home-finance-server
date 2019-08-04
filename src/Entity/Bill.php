<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\BillRepository")
 * @Vich\Uploadable
 */
class Bill
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"bill-read"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"bill-read"})
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"bill-read"})
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"bill-read"})
     */
    private $dateCreated;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\BudgetCat", cascade={"persist", "remove"})
     * @Groups({"bill-read"})
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Home", inversedBy="bills")
     * @Groups({"bill-read"})
     */
    private $home;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getCategory(): ?BudgetCat
    {
        return $this->category;
    }

    public function setCategory(?BudgetCat $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getHome(): ?Home
    {
        return $this->home;
    }

    public function setHome(?Home $home): self
    {
        $this->home = $home;

        return $this;
    }
}
