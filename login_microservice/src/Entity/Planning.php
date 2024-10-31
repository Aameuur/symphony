<?php
// src/Entity/Planning.php

namespace App\Entity;

use App\Repository\PlanningRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Destination;
use App\Entity\Coli;

#[ORM\Entity(repositoryClass: PlanningRepository::class)]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'agent_id', referencedColumnName: 'id', nullable: false)]
    private $agent;

    #[ORM\Column(type: 'datetime')]
    private $deliveryDate;

    #[ORM\ManyToOne(targetEntity: Coli::class)]
    #[ORM\JoinColumn(name: 'ref_id', referencedColumnName: 'id', nullable: false)]
    private $reference;

    #[ORM\ManyToOne(targetEntity: Destination::class)]
    #[ORM\JoinColumn(name: 'depart_address_id', referencedColumnName: 'id', nullable: false)]
    private $departAddress;

    #[ORM\ManyToOne(targetEntity: Destination::class)]
    #[ORM\JoinColumn(name: 'delivery_address_id', referencedColumnName: 'id', nullable: false)]
    private $deliveryAddress;

    #[ORM\Column(type: 'string', nullable: true)]
    private $departLongitude;

    #[ORM\Column(type: 'string', nullable: true)]
    private $departLatitude;

    #[ORM\Column(type: 'string', nullable: true)]
    private $deliveryLongitude;

    #[ORM\Column(type: 'string', nullable: true)]
    private $deliveryLatitude;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent): self
    {
        $this->agent = $agent;
        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;
        return $this;
    }

    public function getReference(): ?Coli // Change made here
    {
        return $this->reference; // This can be null if not set
    }

    public function setReference(?Coli $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    public function getDepartAddress(): ?Destination
    {
        return $this->departAddress;
    }

    public function setDepartAddress(?Destination $departAddress): self
    {
        $this->departAddress = $departAddress;
        return $this;
    }

    public function getDeliveryAddress(): ?Destination
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?Destination $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

    public function getDepartLongitude(): ?string
    {
        return $this->departLongitude;
    }

    public function setDepartLongitude(?string $departLongitude): self
    {
        $this->departLongitude = $departLongitude;
        return $this;
    }

    public function getDepartLatitude(): ?string
    {
        return $this->departLatitude;
    }

    public function setDepartLatitude(?string $departLatitude): self
    {
        $this->departLatitude = $departLatitude;
        return $this;
    }

    public function getDeliveryLongitude(): ?string
    {
        return $this->deliveryLongitude;
    }

    public function setDeliveryLongitude(?string $deliveryLongitude): self
    {
        $this->deliveryLongitude = $deliveryLongitude;
        return $this;
    }

    public function getDeliveryLatitude(): ?string
    {
        return $this->deliveryLatitude;
    }

    public function setDeliveryLatitude(?string $deliveryLatitude): self
    {
        $this->deliveryLatitude = $deliveryLatitude;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
