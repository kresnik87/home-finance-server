<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\GroupInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\MaxDepth;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\EntityListeners({"App\EventListener\UserListener"})
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    const ROLE_USER = "ROLE_USER";
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ROLE_DEFAULT = self::ROLE_USER;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"user-read","device-write"})
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    protected $dni;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $surnames;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Groups({"user-read", "user-write"})
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="UserImage", fileNameProperty="image")
     * @var File
     */
    private $imageFile;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $phone;
    

    /*
     * USER  Complete Address
     */
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $country;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $city;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $address;
    
    /*
     *  USER INFO
     */
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $gender;

    /**
     * @ORM\Column(type="date", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $birthDate;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user-read", "user-write"})
     */
    private $civilStatus;
    

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Device", mappedBy="user")
     */
    private $devices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NotificationUser", mappedBy="user")
     * @Groups({"user-read"})
     */
    private $notifications;

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
        parent::__construct();
        $this->devices = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->createdDate = new \dateTime();
        $this->updatedDate = new \dateTime();
    }
    public function __toString()
    {
        return $this->getName() . " " . $this->getSurnames() . " (". $this->getId() . ")";
    }
    public function getId()
    {
        return $this->id;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(?string $dni): self
    {
        $this->dni = $dni;

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

    public function getSurnames(): ?string
    {
        return $this->surnames;
    }

    public function setSurnames(?string $surnames): self
    {
        $this->surnames = $surnames;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    
    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }
    
    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getcity(): ?string
    {
        return $this->city;
    }

    public function setcity(?string $city): self
    {
        $this->city = $city;

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
    public function getCivilStatus(): ?string
    {
        return $this->civilStatus;
    }

    public function setCivilStatus(?string $civilStatus): self
    {
        $this->civilStatus = $civilStatus;

        return $this;
    }
    
    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTime $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }
    /**
     * @param File|UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if (null !== $image)
        {
            $this->setUpdatedDate();
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @Groups({"user-read", "user-write"})
     */
    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @Groups({"user-read", "user-write"})
     */
    public function getEmail()
    {
      return $this->email;
    }

    /**
     * @Groups({"user-read", "user-write"})
     */
    public function getUsername()
    {
      return $this->username;
    }

    /**
     * @Groups({"user-read", "user-write"})
     */
    public function setUsername( $username): self
    {
         $this->username = $username;

        return $this;
    }


    /**
     * @Groups({"user-write"})
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
        return $this;
    }

    /**
     * @Groups({"user-read", "user-write"})
     */
    public function getEnabled()
    {
      return $this->enabled;
    }

    /**
     * @Groups({"user-read", "user-write"})
     */
    public function getLastLogin()
    {
      return $this->lastLogin;
    }

    public function getUserRole(): ?string
    {
        return $this->userRole;
    }

    public function setUserRole(?string $userRole)
    {
        $this->userRole = $userRole;
    }

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
            $device->setUser($this);
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->devices->contains($device)) {
            $this->devices->removeElement($device);
            // set the owning side to null (unless already changed)
            if ($device->getUser() === $this) {
                $device->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NotificationUser[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    /*Stay unmapped
     * @Groups({"user-read"})
     */
    public function getNotificationsUnread(): Collection
    {
        return $this->getNotifications()->filter(
            function($entry)
            {
                return !$entry->getReaded();
            }
        );
    }

    /*Stay unmapped
     * @Groups({"user-read"})
     */
    public function getNotificationsUndeleted(): Collection
    {
        return $this->getNotifications()->filter(
            function($entry)
            {
                return !$entry->getDeleted();
            }
        );
    }

    /*Stay unmapped
     * @Groups({"user-read"})
     */
    public function getNotificationsClean(): Collection
    {
        return $this->getNotifications()->filter(
            function($entry)
            {
                return !$entry->getReaded() && !$entry->getDeleted();
            }
        );
    }

    /**
     * @Groups({"user-read"})
     */
    public function getCountNotification(): int
    {
        return count($this->getNotificationsClean());
    }


    public function addNotification(NotificationUser $notification): self
    {
        if (!$this->notifications->contains($notification))
        {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(NotificationUser $notification): self
    {
        if ($this->notifications->contains($notification))
        {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this)
            {
                $notification->setUser(null);
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

}
