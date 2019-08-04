<?php

namespace App\Repository;

use App\Entity\BudgetCat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BudgetCat|null find($id, $lockMode = null, $lockVersion = null)
 * @method BudgetCat|null findOneBy(array $criteria, array $orderBy = null)
 * @method BudgetCat[]    findAll()
 * @method BudgetCat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BudgetCatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BudgetCat::class);
    }

    // /**
    //  * @return BudgetCat[] Returns an array of BudgetCat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BudgetCat
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
