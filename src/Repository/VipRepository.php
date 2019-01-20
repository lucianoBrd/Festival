<?php

namespace App\Repository;

use App\Entity\Vip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Vip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vip[]    findAll()
 * @method Vip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VipRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vip::class);
    }

    /**
      * @return Query
      */
      public function findQuery()
      {
          return $this->createQueryBuilder('v')
              ->getQuery();
      }

    // /**
    //  * @return Vip[] Returns an array of Vip objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vip
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
