<?php

namespace App\Repository;

use App\Entity\EtudiantExamen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EtudiantExamenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtudiantExamen::class);
    }

    public function findByEtudiantWithUpcomingExamens($etudiant)
    {
        return $this->createQueryBuilder('ee')
            ->join('ee.examen', 'e')
            ->where('ee.etudiant = :etudiant')
            ->andWhere('e.date > :now')
            ->setParameter('etudiant', $etudiant)
            ->setParameter('now', new \DateTime())
            ->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult();
    }
}