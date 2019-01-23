<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeviceRepository")
 */
class Device
{
    
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=255)
     * @Groups({"device-read","device-write"})
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"device-write"})
     */
    private $cordova;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"device-write"})
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
    * @Groups({"device-write"})
     */
    private $platform;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"device-write"})
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"device-read","device-write"})
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"device-write"})
     */
    private $lang;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"device-write"})
     */
    private $version;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="devices")
     * @Groups({"device-write"})
     */
    private $user;
    
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

    public function __toString()
    {
        return $this->getModel() . " (" . $this->getUuid() . ")";
    }
    public function getId()
    {
        return $this->uuid;
    }
    public function getUuid()
    {
        return $this->uuid;
    }
    
    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getCordova(): ?string
    {
        return $this->cordova;
    }

    public function setCordova(?string $cordova): self
    {
        $this->cordova = $cordova;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(?string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(?string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }
    
    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;
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
