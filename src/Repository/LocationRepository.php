<?php

// src/Repository/LocationRepository.php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * @param $voiture
     * @param \DateTimeInterface $dateDebut
     * @param \DateTimeInterface $dateFin
     * @return Location[] Returns an array of Location objects
     */
    public function findByVoitureAndDates($voiture, \DateTimeInterface $dateDebut, \DateTimeInterface $dateFin)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.voiture = :voiture')
            ->andWhere('l.dateDebutLocation < :dateFin')
            ->andWhere('l.dateFinLocation > :dateDebut')
            ->setParameter('voiture', $voiture)
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $chauffeur
     * @param \DateTimeInterface $dateDebut
     * @param \DateTimeInterface $dateFin
     * @return Location[] Returns an array of Location objects
     */
    public function findByChauffeurAndDates($chauffeur, \DateTimeInterface $dateDebut, \DateTimeInterface $dateFin)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.chauffeur = :chauffeur')
            ->andWhere('l.dateDebutLocation < :dateFin')
            ->andWhere('l.dateFinLocation > :dateDebut')
            ->setParameter('chauffeur', $chauffeur)
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->getQuery()
            ->getResult()
        ;
    }
}
