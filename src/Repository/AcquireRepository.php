<?php

namespace App\Repository;

use App\Entity\Acquire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Acquire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Acquire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Acquire[]    findAll()
 * @method Acquire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcquireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Acquire::class);
    }

    // /**
    //  * @return Acquire[] Returns an array of Acquire objects
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
    public function findOneBySomeField($value): ?Acquire
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
