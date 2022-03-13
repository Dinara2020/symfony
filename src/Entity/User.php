<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="user_id")
     */
    private $car_id;

    public function __construct()
    {
        $this->car_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return Collection|Car[]
     */
    public function getCarId(): Collection
    {
        return $this->car_id;
    }

    public function addCarId(Car $carId): self
    {
        if (!$this->car_id->contains($carId)) {
            $this->car_id[] = $carId;
            $carId->setUserId($this);
        }

        return $this;
    }

    public function removeCarId(Car $carId): self
    {
        if ($this->car_id->removeElement($carId)) {
            // set the owning side to null (unless already changed)
            if ($carId->getUserId() === $this) {
                $carId->setUserId(null);
            }
        }

        return $this;
    }
}
