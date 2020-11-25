<?php

namespace App\Repository;

use App\Entity\Expectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Expectation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expectation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expectation[]    findAll()
 * @method Expectation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpectationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expectation::class);
    }

    // /**
    //  * @return Expectation[] Returns an array of Expectation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Expectation
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
