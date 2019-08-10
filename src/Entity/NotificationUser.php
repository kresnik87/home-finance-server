<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationUserRepository")
 * @ORM\EntityListeners({"App\EventListener\NotificationUserListener"})
 */
class NotificationUser
{

    const NOTIFICATION_TYPE_ANSWER  = 'answer';
    const NOTIFICATION_TYPE_READ      = 'read';
    const NOTIFICATION_SOURCE_DEFAULT='default';
    const NOTIFICATION_SOURCE_PUSH='push';
    const NOTIFICATION_SOURCE_EMAIL='email';

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
     * @Groups({"notification","home-read"})
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user-read", "notification","home-read"})
     */
    private $readed = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user-read", "notification"})
     */
    private $deleted = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"user-read", "notification","home-read"})
     */
    private $acepted = false;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user-read", "notification","home-read"})
     */
    private $createdDate;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write","home-read"})
     */
    private $type= self::NOTIFICATION_TYPE_READ;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write","home-read"})
     */
    private $source= self::NOTIFICATION_SOURCE_DEFAULT;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Home", inversedBy="requestNotif")
     * @Groups({"home-read"})
     */
    private $home;

    
    public function __construct()
    {
        $this->createdDate = new \dateTime();
        $this->updatedDate = new \dateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->user . " " . " (". $this->getId() . ")";
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
    public function getAcepted(): ?bool
    {
        return $this->acepted;
    }

    public function setAcepted(?bool $acepted): self
    {
        $this->acepted = $acepted;

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
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type= $type;

        return $this;
    }
    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source= $source;

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
