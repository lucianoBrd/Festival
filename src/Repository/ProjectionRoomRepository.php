<?php

namespace App\Repository;

use App\Entity\ProjectionRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProjectionRoom|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectionRoom|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectionRoom[]    findAll()
 * @method ProjectionRoom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectionRoomRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProjectionRoom::class);
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
    //  * @return ProjectionRoom[] Returns an array of ProjectionRoom objects
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
    public function findOneBySomeField($value): ?ProjectionRoom
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
