<?php

namespace App\Repository;

use App\Entity\Hosting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hosting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hosting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hosting[]    findAll()
 * @method Hosting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HostingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hosting::class);
    }

    /**
      * @return Query
      */
      public function findQuery()
      {
          return $this->createQueryBuilder('h')
              ->getQuery();
      }

    // /**
    //  * @return Hosting[] Returns an array of Hosting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hosting
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
