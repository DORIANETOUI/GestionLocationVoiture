<?php

// src/Entity/Voiture.php

namespace App\Entity;

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
    private $prixAbidjan;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $prixHorsAbidjan;

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

    public function getPrixAbidjan(): ?string
    {
        return $this->prixAbidjan;
    }

    public function setPrixAbidjan(string $prixAbidjan): self
    {
        $this->prixAbidjan = $prixAbidjan;
        return $this;
    }

    public function getPrixHorsAbidjan(): ?string
    {
        return $this->prixHorsAbidjan;
    }

    public function setPrixHorsAbidjan(string $prixHorsAbidjan): self
    {
        $this->prixHorsAbidjan = $prixHorsAbidjan;
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

