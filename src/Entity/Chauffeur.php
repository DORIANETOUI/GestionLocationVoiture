<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="chauffeur")
 */
class Chauffeur
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=9)
     */
    private $codeChauffeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomChauffeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomChauffeur;

    /**
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(name="contact", type="string", length=20)
     */
    private $contact;


    // Getters and setters
    public function getCodeChauffeur(): ?string
    {
        return $this->codeChauffeur;
    }

    public function setCodeChauffeur(string $codeChauffeur): self
    {
        $this->codeChauffeur = $codeChauffeur;

        return $this;
    }

    public function getNomChauffeur(): ?string
    {
        return $this->nomChauffeur;
    }

    public function setNomChauffeur(string $nomChauffeur): self
    {
        $this->nomChauffeur = $nomChauffeur;

        return $this;
    }

    public function getPrenomChauffeur(): ?string
    {
        return $this->prenomChauffeur;
    }

    public function setPrenomChauffeur(string $prenomChauffeur): self
    {
        $this->prenomChauffeur = $prenomChauffeur;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function __toString(): string
    {
        return $this->nomChauffeur . ' ' . $this->prenomChauffeur;
    }
}
