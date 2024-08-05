<?php
// src/Entity/Location.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @ORM\Table(name="location")
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\Column(name="code_location", type="string", length=9)
     * @Assert\NotBlank
     */
    private $codeLocation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client")
     * @ORM\JoinColumn(name="code_client", referencedColumnName="code_client", nullable=false)
     * @Assert\NotNull
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Voiture")
     * @ORM\JoinColumn(name="immatriculation", referencedColumnName="immatriculation", nullable=false)
     * @Assert\NotNull
     */
    private $voiture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chauffeur")
     * @ORM\JoinColumn(name="code_chauffeur", referencedColumnName="code_chauffeur", nullable=false)
     * @Assert\NotNull
     */
    private $chauffeur;

    /**
     * @ORM\Column(name="date_debut_location", type="datetime")
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual("today")
     */
    private $dateDebutLocation;

    /**
     * @ORM\Column(name="date_fin_location", type="datetime")
     * @Assert\NotNull
     * @Assert\GreaterThan(propertyPath="dateDebutLocation")
     */
    private $dateFinLocation;

    /**
     * @ORM\Column(name="prix_location", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $prixLocation;

    // Getters and setters...


    public function getCodeLocation(): ?string
    {
        return $this->codeLocation;
    }

    public function setCodeLocation(string $codeLocation): self
    {
        $this->codeLocation = $codeLocation;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?Voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getChauffeur(): ?Chauffeur
    {
        return $this->chauffeur;
    }

    public function setChauffeur(?Chauffeur $chauffeur): self
    {
        $this->chauffeur = $chauffeur;

        return $this;
    }

    public function getDateDebutLocation(): ?\DateTimeInterface
    {
        return $this->dateDebutLocation;
    }

    public function setDateDebutLocation(\DateTimeInterface $dateDebutLocation): self
    {
        $this->dateDebutLocation = $dateDebutLocation;

        return $this;
    }

    public function getDateFinLocation(): ?\DateTimeInterface
    {
        return $this->dateFinLocation;
    }

    public function setDateFinLocation(\DateTimeInterface $dateFinLocation): self
    {
        $this->dateFinLocation = $dateFinLocation;

        return $this;
    }

    public function getPrixLocation(): ?string
    {
        return $this->prixLocation;
    }

    public function setPrixLocation(?string $prixLocation): self
    {
        $this->prixLocation = $prixLocation;

        return $this;
    }

    public function calculatePrixLocation(): void
    {
        // Vérifie que les dates de début et de fin sont définies
        if ($this->dateDebutLocation && $this->dateFinLocation) {
            // Calcul de la durée de location en jours
            $diff = $this->dateDebutLocation->diff($this->dateFinLocation);
            $days = $diff->days;

            // Vérifie que la voiture est définie et a un prix
            if ($this->voiture && $this->voiture->getPrix()) {
                $prixVoiture = $this->voiture->getPrix();

                // Calcul du prix total de la location (par exemple, prix par jour)
                $prixTotal = $prixVoiture * $days;

                // Met à jour le prix de location dans l'entité
                $this->prixLocation = $prixTotal;
            }
        }
    }
}
