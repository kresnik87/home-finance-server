<?php

namespace App\Repository;

use App\Entity\FinanceStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FinanceStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinanceStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinanceStatus[]    findAll()
 * @method FinanceStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinanceStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FinanceStatus::class);
    }

    // /**
    //  * @return FinanceStatus[] Returns an array of FinanceStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FinanceStatus
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
