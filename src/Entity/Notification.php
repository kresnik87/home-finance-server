<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user-read", "notification"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "notification"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "notification"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=2500, nullable=true)
     * @Groups({"user-read", "notification"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NotificationUser", mappedBy="notification")
     */
    private $users;
    
    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"user-read", "notification"})
     */
    private $params;

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
        $this->users = new ArrayCollection();
        $this->createdDate = new \dateTime();
        $this->updatedDate = new \dateTime();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|NotificationUser[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(NotificationUser $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setNotification($this);
        }

        return $this;
    }

    public function removeUser(NotificationUser $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getNotification() === $this) {
                $user->setNotification(null);
            }
        }

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
    
    public function getParams(): ?array
    {
        return $this->params;
    }

    public function setParams(?array $params): self
    {
        $this->params = $params;
        return $this;
    }
}
