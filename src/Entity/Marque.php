<?php

// src/Entity/Marque.php
namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarqueRepository")
 * @ORM\Table(name="marque")
 */
class Marque
{
    /**
     * @ORM\Id
     * @ORM\Column(name="code_marque", type="string", length=9)
     * @Assert\NotBlank
     */
    
    private $codeMarque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleMarque;

    // Getters and setters

    public function getCodeMarque(): ?string
    {
        return $this->codeMarque;
    }

    public function setCodeMarque(string $codeMarque): self
    {
        $this->codeMarque = $codeMarque;
        return $this;
    }

    public function getLibelleMarque(): ?string
    {
        return $this->libelleMarque;
    }

    public function setLibelleMarque(string $libelleMarque): self
    {
        $this->libelleMarque = $libelleMarque;
        return $this;
    }

    public function __construct()
{
    $this->voitures = new ArrayCollection();
}

public function getVoitures(): Collection
{
    return $this->voitures;
}

public function addVoiture(Voiture $voiture): self
{
    if (!$this->voitures->contains($voiture)) {
        $this->voitures[] = $voiture;
        $voiture->setMarque($this);
    }

    return $this;
}

public function removeVoiture(Voiture $voiture): self
{
    if ($this->voitures->removeElement($voiture)) {
        // set the owning side to null (unless already changed)
        if ($voiture->getMarque() === $this) {
            $voiture->setMarque(null);
        }
    }
  
}

public function __toString(): string
{
    return $this->libelleMarque;
}

}
