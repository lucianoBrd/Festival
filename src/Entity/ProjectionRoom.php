<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectionRoomRepository")
 */
class ProjectionRoom
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
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(value=0, message="Le nombre de places d'une salle doit être supérieur à 0.")
     */
    private $capacity;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     */
    private $idCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Projection", mappedBy="idProjectionRoom")
     */
    private $idProjection;

    public function __construct()
    {
        $this->idCategory = new ArrayCollection();
        $this->idProjection = new ArrayCollection();
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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }


    /**
     * @return Collection|Category[]
     */
    public function getIdCategory(): Collection
    {
        return $this->idCategory;
    }

    public function addIdCategory(Category $idCategory): self
    {
        if (!$this->idCategory->contains($idCategory)) {
            $this->idCategory[] = $idCategory;
        }

        return $this;
    }

    public function removeIdCategory(Category $idCategory): self
    {
        if ($this->idCategory->contains($idCategory)) {
            $this->idCategory->removeElement($idCategory);
        }

        return $this;
    }

    /**
     * @return Collection|Projection[]
     */
    public function getIdProjection(): Collection
    {
        return $this->idProjection;
    }

    public function addIdProjection(Projection $idProjection): self
    {
        if (!$this->idProjection->contains($idProjection)) {
            $this->idProjection[] = $idProjection;
            $idProjection->setIdProjectionRoom($this);
        }

        return $this;
    }

    public function removeIdProjection(Projection $idProjection): self
    {
        if ($this->idProjection->contains($idProjection)) {
            $this->idProjection->removeElement($idProjection);
            // set the owning side to null (unless already changed)
            if ($idProjection->getIdProjectionRoom() === $this) {
                $idProjection->setIdProjectionRoom(null);
            }
        }

        return $this;
    }
}
