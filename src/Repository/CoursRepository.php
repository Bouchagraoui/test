<?php
namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cours>
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    /**
     * Méthode pour rechercher des cours par un terme de recherche.
     * Recherche dans le nom, la période et la description du cours.
     */
    public function findBySearchTerm($searchTerm)
    {
        return $this->createQueryBuilder('c')
            ->where('c.nomC LIKE :searchTerm')
            ->orWhere('c.periodeC LIKE :searchTerm')
            ->orWhere('c.descriptionC LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Méthode pour récupérer tous les cours avec une durée strictement positive.
     */
    public function findCoursWithPositiveDuration(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.dureeC > 0')  // On filtre ici pour ne récupérer que les cours avec une durée positive
            ->getQuery()
            ->getResult();
    }
}
