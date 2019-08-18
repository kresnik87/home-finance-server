<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\HomeRepository")
 * @ORM\EntityListeners({"App\EventListener\HomeListener"})
 */
class Home
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"home-read","user-read","budget-read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="home")
     * @Groups({"home-read"})
     */
    private $members;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bill", mappedBy="home")
     * @Groups({"home-read","user-read"})
     */
    private $bills;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"home-read","user-read"})
     */
    private $createDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"home-read","user-read"})
     */
    private $updatedDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"home-read","home-write","user-read"})
     */
    private $address;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"home-read","home-write"})
     */
    private $lat;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"home-read","home-write"})
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"home-read","home-write"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"home-read","home-write","user-read"})
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist"})
     * @Groups({"home-read","home-write"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NotificationUser", mappedBy="home")
     * @Groups({"home-read","home-write"})
     */
    private $requestNotif;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Budget", mappedBy="home")
     * @Groups({"home-read","user-read"})
     */
    private $budgets;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->bills = new ArrayCollection();
        $this->createDate = new \dateTime();
        $this->updatedDate = new \dateTime();
        $this->requestNotif = new ArrayCollection();
        $this->budgets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->getName() . " " . " (" . $this->getId() . ")";
    }

    /**
     * @return Collection|User[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(User $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setHome($this);
        }

        return $this;
    }

    public function removeMember(User $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getHome() === $this) {
                $member->setHome(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bill[]
     */
    public function getBills(): Collection
    {
        return $this->bills;
    }

    public function addBill(Bill $bill): self
    {
        if (!$this->bills->contains($bill)) {
            $this->bills[] = $bill;
            $bill->setHome($this);
        }

        return $this;
    }

    public function removeBill(Bill $bill): self
    {
        if ($this->bills->contains($bill)) {
            $this->bills->removeElement($bill);
            // set the owning side to null (unless already changed)
            if ($bill->getHome() === $this) {
                $bill->setHome(null);
            }
        }

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreatedDate(?\dateTime $createdDate = null): self
    {
        $this->createDate = $createdDate ? $createdDate : new \dateTime();
        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updatedDate;
    }

    public function setUpdatedDate(?\dateTime $updatedDate = null): self
    {
        $this->updatedDate = $updatedDate ? $updatedDate : new \dateTime();
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(?float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|NotificationUser[]
     */
    public function getRequestNotif(): Collection
    {
        return $this->requestNotif;
    }

    public function addRequestNotif(NotificationUser $requestNotif): self
    {
        if (!$this->requestNotif->contains($requestNotif)) {
            $this->requestNotif[] = $requestNotif;
            $requestNotif->setHome($this);
        }

        return $this;
    }

    public function removeRequestNotif(NotificationUser $requestNotif): self
    {
        if ($this->requestNotif->contains($requestNotif)) {
            $this->requestNotif->removeElement($requestNotif);
            // set the owning side to null (unless already changed)
            if ($requestNotif->getHome() === $this) {
                $requestNotif->setHome(null);
            }
        }

        return $this;
    }



    /**
     * @Groups({"home-read","user-read"})
     */
    public function getHomeIncome(): ?float
    {
        $amountIncome = 0;
        if (count($this->getMembers()) > 0) {
            foreach ($this->getMembers() as $member) {
                if ($member->getFinanceStatus()) {
                    foreach ($member->getFinanceStatus()->getOperations() as $oper) {
                        if($oper->isIncome()){
                            $amountIncome += $oper->getAmount();
                        }

                    }
                }
            }
        }
        return $amountIncome;

    }
    /**
     * @Groups({"home-read","user-read"})
     */
    public function getHomeExpense(): ?float
    {
        $amountExpense = 0;
        if (count($this->getMembers()) > 0) {
            foreach ($this->getMembers() as $member) {
                if ($member->getFinanceStatus()) {
                    foreach ($member->getFinanceStatus()->getOperations() as $oper) {
                        if(!$oper->isIncome()){
                            $amountExpense+= $oper->getAmount();
                        }

                    }
                }
            }
        }
        return $amountExpense;

    }

    /**
     * @return Collection|Budget[]
     */
    public function getBudgets(): Collection
    {
        return $this->budgets;
    }

    public function addBudget(Budget $budget): self
    {
        if (!$this->budgets->contains($budget)) {
            $this->budgets[] = $budget;
            $budget->setHome($this);
        }

        return $this;
    }

    public function removeBudget(Budget $budget): self
    {
        if ($this->budgets->contains($budget)) {
            $this->budgets->removeElement($budget);
            // set the owning side to null (unless already changed)
            if ($budget->getHome() === $this) {
                $budget->setHome(null);
            }
        }

        return $this;
    }

    public function isUserOwner(User $user){
        return $this->getOwner()->getId()===$user->getId();
    }

}
