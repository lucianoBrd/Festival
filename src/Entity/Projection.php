<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectionRepository")
 * @UniqueEntity(
 *  fields={"date", "idProjectionRoom"},
 *  message="Date deja prise")
 */
class Projection
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movie", mappedBy="idProjection")
     */
    private $idMovie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProjectionRoom", inversedBy="idProjection")
     */
    private $idProjectionRoom;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Vip", inversedBy="projections")
     */
    private $idVip;

    public function __construct()
    {
        $this->idMovie = new ArrayCollection();
        $this->idVip = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getIdMovie(): Collection
    {
        return $this->idMovie;
    }

    public function addIdMovie(Movie $idMovie): self
    {
        if (!$this->idMovie->contains($idMovie)) {
            $this->idMovie[] = $idMovie;
            $idMovie->setIdProjection($this);
        }

        return $this;
    }

    public function removeIdMovie(Movie $idMovie): self
    {
        if ($this->idMovie->contains($idMovie)) {
            $this->idMovie->removeElement($idMovie);
            // set the owning side to null (unless already changed)
            if ($idMovie->getIdProjection() === $this) {
                $idMovie->setIdProjection(null);
            }
        }

        return $this;
    }

    public function getIdProjectionRoom(): ?ProjectionRoom
    {
        return $this->idProjectionRoom;
    }

    public function setIdProjectionRoom(?ProjectionRoom $idProjectionRoom): self
    {
        $this->idProjectionRoom = $idProjectionRoom;

        return $this;
    }

    /**
     * @return Collection|Vip[]
     */
    public function getIdVip(): Collection
    {
        return $this->idVip;
    }

    public function addIdVip(Vip $idVip): self
    {
        if (!$this->idVip->contains($idVip)) {
            $this->idVip[] = $idVip;
        }

        return $this;
    }

    public function removeIdVip(Vip $idVip): self
    {
        if ($this->idVip->contains($idVip)) {
            $this->idVip->removeElement($idVip);
        }

        return $this;
    }
}
