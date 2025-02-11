<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Repository\LocationRepository;
use App\Service\DisponibiliteVoitureService;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Dompdf\Dompdf;
use Dompdf\Options;

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
     * @Route("/pdf", name="app_location_pdf", methods={"GET"})
     */
    public function pdf(): Response
    {
        // Configurer Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instancier Dompdf avec les options
        $dompdf = new Dompdf($pdfOptions);

        // Récupérer les données des locations
        $locations = $this->locationRepository->findAll();

        // Générer le HTML à partir du template Twig
        $html = $this->renderView('location/pdf.html.twig', [
            'locations' => $locations,
        ]);

        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Définir le format du papier
        $dompdf->setPaper('A4', 'portrait');

        // Rendre le PDF
        $dompdf->render();

        // Retourner le PDF en réponse HTTP
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="locations.pdf"',
        ]);
    }

    /**
     * @Route("/{codeLocation}/pdf", name="app_location_pdf_single", methods={"GET"})
     */
    public function pdfSingle(Location $location): Response
    {
        // Configurer Dompdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instancier Dompdf avec les options
        $dompdf = new Dompdf($pdfOptions);

        // Générer le HTML à partir du template Twig
        $html = $this->renderView('location/pdf_single.html.twig', [
            'location' => $location,  // Utilisation de la location spécifique
        ]);

        // Charger le HTML dans Dompdf
        $dompdf->loadHtml($html);

        // Définir le format du papier
        $dompdf->setPaper('A4', 'portrait');

        // Rendre le PDF
        $dompdf->render();

        // Retourner le PDF en réponse HTTP
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="location_' . $location->getCodeLocation() . '.pdf"',
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
        if ($chauffeur) {
            $existingChauffeurLocations = $this->locationRepository->findByChauffeurAndDates($chauffeur, $dateDebut, $dateFin);
            if ($existingChauffeurLocations) {
                $this->addFlash('error', 'Le chauffeur est déjà occupé durant cette période.');
                return $this->render('location/new.html.twig', [
                    'location' => $location,
                    'form' => $form->createView(),
                ]);
            }
        }

        // Si la voiture est déjà louée, renvoie un message d'erreur
        if ($existingLocations) {
            $this->addFlash('error', 'La voiture est déjà louée durant cette période.');
            return $this->render('location/new.html.twig', [
                'location' => $location,
                'form' => $form->createView(),
            ]);
        }

        // Calculer le prix de location
        $location->calculerPrix();

        // Persister la nouvelle location
        $this->entityManager->persist($location);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_location_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('location/new.html.twig', [
        'location' => $location,
        'form' => $form->createView(),
    ]);
}


    /**
     * @Route("/location/update-render-date/{codeLocation}", name="app_location_update_render_date")
     */
    public function updateRenderDate($codeLocation, Request $request, EntityManagerInterface $entityManager)
    {
        $location = $entityManager->getRepository(Location::class)->find($codeLocation);

        if (!$location) {
            throw $this->createNotFoundException('Location not found');
        }

        // Création du formulaire pour la date de rendu
        $form = $this->createFormBuilder()
            ->add('rendu', DateTimeType::class, [
                'label' => 'Date de rendu',
                'widget' => 'single_text',
                'required' => true,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $location->setRendu($data['rendu']); // Met à jour la date de rendu
            $entityManager->flush(); // Enregistre les modifications

            return $this->redirectToRoute('app_location_index');
        }

        return $this->render('location/update_render_date.html.twig', [
            'form' => $form->createView(),
        ]);
    } 
    

    /**
     * @Route("/{codeLocation}", name="app_location_show", methods={"GET"})
     */
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * @Route("/{codeLocation}/edit", name="app_location_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Location $location): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Calculer le prix de location
            $location->calculerPrix();

            $this->entityManager->flush();

            return $this->redirectToRoute('app_location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('location/edit.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeLocation}", name="app_location_delete", methods={"POST"})
     */
    public function delete(Request $request, Location $location): Response
    {
        if ($this->isCsrfTokenValid('delete' . $location->getCodeLocation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($location);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_location_index');
    }
}
