<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VipRepository")
 */
class Vip
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $profession;

    /**
     * @ORM\Column(type="boolean")
     */
    private $jury;

    /**
     * @ORM\Column(type="boolean")
     */
    private $invited;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", mappedBy="idDirector")
     */
    private $idMovie;

    public function __construct()
    {
        $this->idMovie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getJury(): ?bool
    {
        return $this->jury;
    }

    public function setJury(bool $jury): self
    {
        $this->jury = $jury;

        return $this;
    }

    public function getInvited(): ?bool
    {
        return $this->invited;
    }

    public function setInvited(bool $invited): self
    {
        $this->invited = $invited;

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
            $idMovie->addIdDirector($this);
        }

        return $this;
    }

    public function removeIdMovie(Movie $idMovie): self
    {
        if ($this->idMovie->contains($idMovie)) {
            $this->idMovie->removeElement($idMovie);
            $idMovie->removeIdDirector($this);
        }

        return $this;
    }
}
