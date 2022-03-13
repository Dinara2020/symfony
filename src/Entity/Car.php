<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
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
    private $number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mark;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="car_id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Cargo::class)
     */
    private $cargo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(?string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->user;
    }

    public function setUserId(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCargo(): ?Cargo
    {
        return $this->cargo;
    }

    public function setCargo(?Cargo $cargo): self
    {
        $this->cargo = $cargo;

        return $this;
    }
}
