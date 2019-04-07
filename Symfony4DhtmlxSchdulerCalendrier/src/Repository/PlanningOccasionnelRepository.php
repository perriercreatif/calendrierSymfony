<?php

namespace App\Repository;

use App\Entity\PlanningOccasionnel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PlanningOccasionnel|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlanningOccasionnel|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlanningOccasionnel[]    findAll()
 * @method PlanningOccasionnel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningOccasionnelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PlanningOccasionnel::class);
    }

    // /**
    //  * @return AtelierPrevention[] Returns an array of AtelierPrevention objects
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
    public function findOneBySomeField($value): ?AtelierPrevention
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
