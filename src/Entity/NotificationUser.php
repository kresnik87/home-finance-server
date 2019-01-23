<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationUserRepository")
 */
class NotificationUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user-read", "notification"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Notification", inversedBy="users")
     * @Groups({"user-read", "notification"})
     */
    private $notification;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notifications")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user-read", "notification"})
     */
    private $readed = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user-read", "notification"})
     */
    private $deleted = false;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdDate;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedDate;

    
    public function __construct()
    {
        $this->createdDate = new \dateTime();
        $this->updatedDate = new \dateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotification(): ?Notification
    {
        return $this->notification;
    }

    public function setNotification(?Notification $notification): self
    {
        $this->notification = $notification;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getReaded(): ?bool
    {
        return $this->readed;
    }

    public function setReaded(?bool $readed): self
    {
        $this->readed = $readed;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
    
    public function getCreatedDate(): ?\dateTime
    {
        return $this->createdDate;
    }
    public function setCreatedDate(?\dateTime $createdDate = null): self
    {
        $this->createdDate = $createdDate? $createdDate: new \dateTime();
        return $this;
    }
    public function getUpdatedDate(): ?\dateTime
    {
        return $this->updatedDate;
    }
    public function setUpdatedDate(?\dateTime $updatedDate = null): self
    {
        $this->updatedDate = $updatedDate? $updatedDate: new \dateTime();
        return $this;
    }
}
