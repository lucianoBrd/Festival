<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\OneToMany(targetEntity="App\Entity\Movie", mappedBy="idCategory")
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
            $idMovie->setIdCategory($this);
        }

        return $this;
    }

    public function removeIdMovie(Movie $idMovie): self
    {
        if ($this->idMovie->contains($idMovie)) {
            $this->idMovie->removeElement($idMovie);
            // set the owning side to null (unless already changed)
            if ($idMovie->getIdCategory() === $this) {
                $idMovie->setIdCategory(null);
            }
        }

        return $this;
    }
}
