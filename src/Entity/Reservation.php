<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="dateinterval")
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vip")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idVip;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hosting")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idHosting;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDuration(): ?\DateInterval
    {
        return $this->duration;
    }

    public function setDuration(\DateInterval $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getIdVip(): ?Vip
    {
        return $this->idVip;
    }

    public function setIdVip(?Vip $idVip): self
    {
        $this->idVip = $idVip;

        return $this;
    }

    public function getIdHosting(): ?Hosting
    {
        return $this->idHosting;
    }

    public function setIdHosting(?Hosting $idHosting): self
    {
        $this->idHosting = $idHosting;

        return $this;
    }
}
