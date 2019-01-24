<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HostingRoomBookingRepository")
 */
class HostingRoomBooking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hostingRoom;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Vip", inversedBy="bookings")
     */
    private $vip;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function __construct()
    {
        $this->vip = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHostingRoom(): ?Room
    {
        return $this->hostingRoom;
    }

    public function setHostingRoom(?Room $hostingRoom): self
    {
        $this->hostingRoom = $hostingRoom;

        return $this;
    }

    /**
     * @return Collection|Vip[]
     */
    public function getVip(): Collection
    {
        return $this->vip;
    }

    public function addVip(Vip $vip): self
    {
        if (!$this->vip->contains($vip)) {
            $this->vip[] = $vip;
        }

        return $this;
    }

    public function removeVip(Vip $vip): self
    {
        if ($this->vip->contains($vip)) {
            $this->vip->removeElement($vip);
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
