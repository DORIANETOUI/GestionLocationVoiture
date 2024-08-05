<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\LocationRepository;
use App\Service\DisponibiliteVoitureService;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/location")
 */
class LocationController extends AbstractController
{
    private $entityManager;
    private $locationRepository;
    private $disponibiliteVoitureService;
    private $emailService;

    public function __construct(
        EntityManagerInterface $entityManager,
        LocationRepository $locationRepository,
        DisponibiliteVoitureService $disponibiliteVoitureService,
        EmailService $emailService
    ) {
        $this->entityManager = $entityManager;
        $this->locationRepository = $locationRepository;
        $this->disponibiliteVoitureService = $disponibiliteVoitureService;
        $this->emailService = $emailService;
    }

    /**
     * @Route("/", name="app_location_index", methods={"GET"})
     */
    public function index(): Response
    {
        $locations = $this->locationRepository->findAll();

        return $this->render('location/index.html.twig', [
            'locations' => $locations,
        ]);
    }

    /**
     * @Route("/new", name="app_location_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voiture = $location->getVoiture();
            $chauffeur = $location->getChauffeur();
            $dateDebut = $location->getDateDebutLocation();
            $dateFin = $location->getDateFinLocation();

            // Vérifie si la voiture est déjà louée pour les dates spécifiées
            $existingLocations = $this->locationRepository->findByVoitureAndDates($voiture, $dateDebut, $dateFin);

            // Vérifie si le chauffeur est déjà loué pour les dates spécifiées
            $existingLocationsForChauffeur = $this->locationRepository->findByChauffeurAndDates($chauffeur, $dateDebut, $dateFin);

            if (count($existingLocations) > 0) {
                $this->addFlash('error', 'Cette voiture est déjà louée pour les dates spécifiées.');
            } elseif (count($existingLocationsForChauffeur) > 0) {
                $this->addFlash('error', 'Ce chauffeur est déjà loué pour les dates spécifiées.');
            } else {
                // Calculer le prix de la location
                $location->calculatePrixLocation();

                $this->entityManager->persist($location);
                $this->entityManager->flush();

                // Envoyer l'email de confirmation au client
                $this->emailService->sendLocationCreatedEmail($location);

                $this->addFlash('success', 'Location créée avec succès.');

                return $this->redirectToRoute('app_location_index');
            }
        }

        return $this->renderForm('location/new.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{codeLocation}", name="app_location_show", methods={"GET"})
     * @ParamConverter("location", class="App\Entity\Location")
     */
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * @Route("/{codeLocation}/edit", name="app_location_edit", methods={"GET", "POST"})
     * @ParamConverter("location", class="App\Entity\Location")
     */
    public function edit(Request $request, Location $location): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voiture = $location->getVoiture();
            $chauffeur = $location->getChauffeur();
            $dateDebut = $location->getDateDebutLocation();
            $dateFin = $location->getDateFinLocation();

            // Vérifie si la voiture est déjà louée pour les dates spécifiées
            $existingLocations = $this->locationRepository->findByVoitureAndDates($voiture, $dateDebut, $dateFin);

            // Vérifie si le chauffeur est déjà loué pour les dates spécifiées
            $existingLocationsForChauffeur = $this->locationRepository->findByChauffeurAndDates($chauffeur, $dateDebut, $dateFin);

            // Exclure l'entité elle-même de la vérification lors de l'édition
            $existingLocations = array_filter($existingLocations, function ($loc) use ($location) {
                return $loc->getCodeLocation() !== $location->getCodeLocation();
            });

            $existingLocationsForChauffeur = array_filter($existingLocationsForChauffeur, function ($loc) use ($location) {
                return $loc->getCodeLocation() !== $location->getCodeLocation();
            });

            if (count($existingLocations) > 0) {
                $this->addFlash('error', 'Cette voiture est déjà louée pour les dates spécifiées.');
            } elseif (count($existingLocationsForChauffeur) > 0) {
                $this->addFlash('error', 'Ce chauffeur est déjà loué pour les dates spécifiées.');
            } else {
                // Calculer le prix de la location
                $location->calculatePrixLocation();

                $this->entityManager->flush();

                // Envoyer l'email de confirmation au client
                $this->emailService->sendLocationCreatedEmail($location);

                $this->addFlash('success', 'Location modifiée avec succès.');

                return $this->redirectToRoute('app_location_index');
            }
        }

        return $this->renderForm('location/edit.html.twig', [
            'location' => $location,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{codeLocation}", name="app_location_delete", methods={"POST"})
     * @ParamConverter("location", class="App\Entity\Location")
     */
    public function delete(Request $request, Location $location): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getCodeLocation(), $request->request->get('_token'))) {
            $this->entityManager->remove($location);
            $this->entityManager->flush();

            $this->addFlash('success', 'Location supprimée avec succès.');
        } else {
            $this->addFlash('error', 'Erreur lors de la suppression de la location.');
        }

        return $this->redirectToRoute('app_location_index');
    }
}

