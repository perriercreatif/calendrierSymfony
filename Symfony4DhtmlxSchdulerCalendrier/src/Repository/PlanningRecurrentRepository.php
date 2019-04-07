<?php

namespace App\Repository;

use App\Entity\PlanningRecurrent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlanningRecurrent|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanningRecurrent|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanningRecurrent[]    findAll()
 * @method PlanningRecurrent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningRecurrentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlanningRecurrent::class);
    }

    // /**
    //  * @return Atelier[] Returns an array of Atelier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Atelier
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
