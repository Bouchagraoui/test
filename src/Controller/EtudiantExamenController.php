<?php

namespace App\Controller;

use App\Entity\EtudiantExamen;
use App\Form\EtudiantExamenType;
use App\Repository\EtudiantExamenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/etudiant/examen')]
final class EtudiantExamenController extends AbstractController{
    #[Route(name: 'app_etudiant_examen_index', methods: ['GET'])]
    public function index(EtudiantExamenRepository $etudiantExamenRepository): Response
    {
        return $this->render('etudiant_examen/index.html.twig', [
            'etudiant_examens' => $etudiantExamenRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etudiant_examen_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etudiantExaman = new EtudiantExamen();
        $form = $this->createForm(EtudiantExamenType::class, $etudiantExaman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etudiantExaman);
            $entityManager->flush();

            return $this->redirectToRoute('app_etudiant_examen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant_examen/new.html.twig', [
            'etudiant_examan' => $etudiantExaman,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_examen_show', methods: ['GET'])]
    public function show(EtudiantExamen $etudiantExaman): Response
    {
        return $this->render('etudiant_examen/show.html.twig', [
            'etudiant_examan' => $etudiantExaman,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_examen_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtudiantExamen $etudiantExaman, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtudiantExamenType::class, $etudiantExaman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etudiant_examen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant_examen/edit.html.twig', [
            'etudiant_examan' => $etudiantExaman,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_examen_delete', methods: ['POST'])]
    public function delete(Request $request, EtudiantExamen $etudiantExaman, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiantExaman->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($etudiantExaman);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etudiant_examen_index', [], Response::HTTP_SEE_OTHER);
    }
}
