<?php
namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;  // N'oubliez pas d'importer ce service
use App\Repository\CoursRepository;

#[Route('/cours')]
final class CoursController extends AbstractController
{
    private ValidatorInterface $validator;  // Propriété pour stocker le validateur

    // Injection du service ValidatorInterface via le constructeur
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    // Méthode pour afficher tous les cours ou les rechercher
    #[Route('/', name: 'app_cours_index', methods: ['GET'])]
    public function index(Request $request, CoursRepository $coursRepository): Response
    {
        // Récupérer le terme de recherche
        $searchTerm = $request->query->get('search', '');

        // Rechercher les cours en fonction du terme de recherche
        if ($searchTerm) {
            $cours = $coursRepository->findBySearchTerm($searchTerm);
        } else {
            // Si pas de recherche, afficher tous les cours
            $cours = $coursRepository->findAll();
        }

        return $this->render('cours/index.html.twig', [
            'cours' => $cours,
        ]);
    }

    // Méthode pour créer un nouveau cours
    #[Route('/new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cours = new Cours();
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        // Valider le formulaire et les données du cours
        if ($form->isSubmitted() && $form->isValid()) {
            // Validation du cours (exemple pour vérifier la durée)
            $errors = $this->validator->validate($cours);

            if (count($errors) > 0) {
                // S'il y a des erreurs de validation, les afficher
                return $this->render('cours/error.html.twig', [
                    'errors' => $errors,
                ]);
            }

            // Si aucune erreur, persister l'entité
            $entityManager->persist($cours);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/new.html.twig', [
            'cours' => $cours,
            'form' => $form,
        ]);
    }

    // Méthode pour afficher un cours spécifique
    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cours): Response
    {
        return $this->render('cours/show.html.twig', [
            'cours' => $cours,
        ]);
    }

    // Méthode pour éditer un cours existant
    #[Route('/{id}/edit', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cours, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        // Valider le formulaire et les données du cours
        if ($form->isSubmitted() && $form->isValid()) {
            // Validation du cours
            $errors = $this->validator->validate($cours);

            if (count($errors) > 0) {
                // Si des erreurs sont présentes, les afficher
                return $this->render('cours/error.html.twig', [
                    'errors' => $errors,
                ]);
            }

            // Si aucune erreur, appliquer les modifications
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/edit.html.twig', [
            'cours' => $cours,
            'form' => $form,
        ]);
    }

    // Méthode pour supprimer un cours
    #[Route('/{id}', name: 'app_cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cours, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si le token CSRF est valide avant de supprimer
        if ($this->isCsrfTokenValid('delete' . $cours->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cours);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
