<?php

// src/Entity/Coli.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Coli
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $reference;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeDeColi;

    #[ORM\Column(type: 'string', length: 255)]
    private $categories;

    public const TYPES = [
        'Standard' => 'Standard',
        'Express' => 'Express',
        'Fragile' => 'Fragile',
    ];

    public const CATEGORIES = [
        'Documents' => 'Documents',
        'Electronique' => 'Electronique',
        'Vetements' => 'Vetements',
        'Nourriture' => 'Nourriture',
        'Meubles' => 'Meubles',
    ];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTypeDeColi(): ?string
    {
        return $this->typeDeColi;
    }

    public function setTypeDeColi(string $typeDeColi): self
    {
        $this->typeDeColi = $typeDeColi;

        return $this;
    }

    public function getCategories(): ?string
    {
        return $this->categories;
    }

    public function setCategories(string $categories): self
    {
        $this->categories = $categories;

        return $this;
    }
}
