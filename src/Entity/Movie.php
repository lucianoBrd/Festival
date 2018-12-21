<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
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
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * @ORM\Column(type="boolean")
     */
    private $competing;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Vip", inversedBy="idMovie")
     */
    private $idDirector;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="idMovie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCategory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projection", inversedBy="idMovie")
     */
    private $idProjection;

    public function __construct()
    {
        $this->idDirector = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getCompeting(): ?bool
    {
        return $this->competing;
    }

    public function setCompeting(bool $competing): self
    {
        $this->competing = $competing;

        return $this;
    }

    /**
     * @return Collection|Vip[]
     */
    public function getIdDirector(): Collection
    {
        return $this->idDirector;
    }

    public function addIdDirector(Vip $idDirector): self
    {
        if (!$this->idDirector->contains($idDirector)) {
            $this->idDirector[] = $idDirector;
        }

        return $this;
    }

    public function removeIdDirector(Vip $idDirector): self
    {
        if ($this->idDirector->contains($idDirector)) {
            $this->idDirector->removeElement($idDirector);
        }

        return $this;
    }

    public function getIdCategory(): ?Category
    {
        return $this->idCategory;
    }

    public function setIdCategory(?Category $idCategory): self
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    public function getIdProjection(): ?Projection
    {
        return $this->idProjection;
    }

    public function setIdProjection(?Projection $idProjection): self
    {
        $this->idProjection = $idProjection;

        return $this;
    }
}
