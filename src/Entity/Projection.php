<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectionRepository")
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Movie", mappedBy="idProjection")
     * @Assert\NotNull(message="Sélectionner un film.")
     */
    private $idMovie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProjectionRoom", inversedBy="idProjection")
     */
    private $idProjectionRoom;

    public function __construct()
    {
        $this->idMovie = new ArrayCollection();
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
}
