<?php

namespace App\Repository;

use App\Entity\SalesTax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SalesTax|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesTax|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesTax[]    findAll()
 * @method SalesTax[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesTaxRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SalesTax::class);
    }

//    /**
//     * @return SalesTax[] Returns an array of SalesTax objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SalesTax
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
