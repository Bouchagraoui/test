<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Form\RessourceType;
use App\Repository\RessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/ressource')]
final class RessourceController extends AbstractController
{
    #[Route('/', name: 'app_ressource_index', methods: ['GET'])]
    public function index(RessourceRepository $ressourceRepository): Response
    {
        // Utiliser le repository pour récupérer les ressources
        $ressources = $ressourceRepository->findAll();

        return $this->render('ressource/index.html.twig', [
            'ressources' => $ressources,
        ]);
    }

    #[Route('/ressource/new', name: 'app_ressource_new')]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger)
    {
        $ressource = new Ressource();
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le fichier PDF téléchargé
            /** @var UploadedFile $pdfFile */
            $pdfFile = $form->get('pdfressource')->getData();

            if ($pdfFile) {
                // Générer un nom unique pour le fichier
                $originalFilename = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pdfFile->guessExtension();

                // Déplacer le fichier dans le dossier 'uploads/pdf'
                try {
                    $pdfFile->move(
                        $this->getParameter('uploads_directory'), // Vous pouvez définir ce paramètre dans config/services.yaml
                        $newFilename
                    );
                    // Mettre à jour l'entité avec le nom du fichier
                    $ressource->setPdfressource($newFilename);
                } catch (FileException $e) {
                    // Gérer l'exception si le fichier ne peut pas être déplacé
                }
            }

            // Sauvegarder l'entité dans la base de données
            $em->persist($ressource);
            $em->flush();

            return $this->redirectToRoute('app_ressource_index');
        }

        return $this->render('ressource/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/{id}', name: 'app_ressource_show', methods: ['GET'])]
    public function show(Ressource $ressource): Response
    {
        return $this->render('ressource/show.html.twig', [
            'ressource' => $ressource,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ressource_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ressource $ressource, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('pdfressource')->getData();
            $newFilename = $this->handleFileUpload($file, $slugger);

            if ($newFilename) {
                $ressource->setPdfressource($newFilename);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Ressource mise à jour.');
            return $this->redirectToRoute('app_ressource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ressource/edit.html.twig', [
            'form' => $form->createView(),
            'ressource' => $ressource,
        ]);
    }

    #[Route('/{id}', name: 'app_ressource_delete', methods: ['POST'])]
    public function delete(Request $request, Ressource $ressource, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si le token CSRF est valide
        if ($this->isCsrfTokenValid('delete' . $ressource->getId(), $request->request->get('_token'))) {
            // Supprimer la ressource
            $entityManager->remove($ressource);
            $entityManager->flush();
    
            // Ajouter un message de confirmation
            $this->addFlash('success', 'Ressource supprimée avec succès.');
        }
    
        // Redirection vers la liste des ressources
        return $this->redirectToRoute('app_ressource_index');
    }
    

    /**
     * Handle file upload safely.
     */
    private function handleFileUpload($file, SluggerInterface $slugger): ?string
    {
        if ($file) {
            $uploadDirectory = $this->getParameter('uploads_directory');

            // Ensure the upload directory exists
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

            try {
                $file->move(
                    $uploadDirectory,
                    $newFilename
                );
                return $newFilename;
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur lors de l\'upload du fichier.');
            }
        }

        return null;
    }
}
