<?php

namespace App\Repository;

use App\Entity\Projection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Projection|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projection|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projection[]    findAll()
 * @method Projection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Projection::class);
    }

    /**
      * @return Query
      */
      public function findQuery()
      {
          return $this->createQueryBuilder('m')
              ->getQuery();
      }

    // /**
    //  * @return Projection[] Returns an array of Projection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Projection
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
