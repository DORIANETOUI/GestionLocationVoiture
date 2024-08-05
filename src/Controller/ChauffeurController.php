<?php

namespace App\Controller;

use App\Entity\Chauffeur;
use App\Form\ChauffeurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chauffeur")
 */
class ChauffeurController extends AbstractController
{
    /**
     * @Route("/", name="app_chauffeur_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $chauffeurs = $entityManager
            ->getRepository(Chauffeur::class)
            ->findAll();

        return $this->render('chauffeur/index.html.twig', [
            'chauffeurs' => $chauffeurs,
        ]);
    }

    /**
     * @Route("/new", name="app_chauffeur_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chauffeur = new Chauffeur();
        $form = $this->createForm(ChauffeurType::class, $chauffeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chauffeur);
            $entityManager->flush();

            return $this->redirectToRoute('app_chauffeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chauffeur/new.html.twig', [
            'chauffeur' => $chauffeur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{codeChauffeur}", name="app_chauffeur_show", methods={"GET"})
     */
    public function show(Chauffeur $chauffeur): Response
    {
        return $this->render('chauffeur/show.html.twig', [
            'chauffeur' => $chauffeur,
        ]);
    }

    /**
     * @Route("/{codeChauffeur}/edit", name="app_chauffeur_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Chauffeur $chauffeur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChauffeurType::class, $chauffeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chauffeur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chauffeur/edit.html.twig', [
            'chauffeur' => $chauffeur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{codeChauffeur}", name="app_chauffeur_delete", methods={"POST"})
     */
    public function delete(Request $request, Chauffeur $chauffeur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chauffeur->getCodeChauffeur(), $request->request->get('_token'))) {
            $entityManager->remove($chauffeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chauffeur_index', [], Response::HTTP_SEE_OTHER);
    }
}
