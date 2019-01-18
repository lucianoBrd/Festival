<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HostingRepository")
 */
class Hosting
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
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Service")
     */
    private $idService;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="idHosting", orphanRemoval=true)
     */
    private $idRoom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idType;

    public function __construct()
    {
        $this->idService = new ArrayCollection();
        $this->idRoom = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getIdService(): Collection
    {
        return $this->idService;
    }

    public function addIdService(Service $idService): self
    {
        if (!$this->idService->contains($idService)) {
            $this->idService[] = $idService;
        }

        return $this;
    }

    public function removeIdService(Service $idService): self
    {
        if ($this->idService->contains($idService)) {
            $this->idService->removeElement($idService);
        }

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getIdRoom(): Collection
    {
        return $this->idRoom;
    }

    public function addIdRoom(Room $idRoom): self
    {
        if (!$this->idRoom->contains($idRoom)) {
            $this->idRoom[] = $idRoom;
            $idRoom->setIdHosting($this);
        }

        return $this;
    }

    public function removeIdRoom(Room $idRoom): self
    {
        if ($this->idRoom->contains($idRoom)) {
            $this->idRoom->removeElement($idRoom);
            // set the owning side to null (unless already changed)
            if ($idRoom->getIdHosting() === $this) {
                $idRoom->setIdHosting(null);
            }
        }

        return $this;
    }

    public function getIdType(): ?Type
    {
        return $this->idType;
    }

    public function setIdType(?Type $idType): self
    {
        $this->idType = $idType;

        return $this;
    }
}
