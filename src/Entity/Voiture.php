<?php

// src/Entity/Voiture.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 * @ORM\Table(name="voiture")
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=9)
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modele;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque")
     * @ORM\JoinColumn(name="code_marque", referencedColumnName="code_marque")
     */
    private $marque;

    // Getters and setters

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;
        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;
        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;
        return $this;
    }

    public function __toString(): string
    {
        return $this->modele . ' - ' . $this->immatriculation;
    }
}
