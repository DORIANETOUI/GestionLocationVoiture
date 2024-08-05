<?php

namespace App\Service;

use App\Repository\LocationRepository;

class DisponibiliteVoitureService
{
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function isVoitureDisponible($voiture, \DateTimeInterface $dateDebut, \DateTimeInterface $dateFin): bool
    {
        $locations = $this->locationRepository->findByVoitureAndDates($voiture, $dateDebut, $dateFin);

        return count($locations) === 0;
    }
}
