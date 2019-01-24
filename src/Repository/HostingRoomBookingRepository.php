<?php

namespace App\Repository;

use App\Entity\HostingRoomBooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HostingRoomBooking|null find($id, $lockMode = null, $lockVersion = null)
 * @method HostingRoomBooking|null findOneBy(array $criteria, array $orderBy = null)
 * @method HostingRoomBooking[]    findAll()
 * @method HostingRoomBooking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HostingRoomBookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HostingRoomBooking::class);
    }

    /**
    * @return Query
    */
    public function findQuery($id)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.hostingRoom = :id')
            ->setParameter('id', $id)
            ->getQuery();
    }

    // /**
    //  * @return HostingRoomBooking[] Returns an array of HostingRoomBooking objects
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
    public function findOneBySomeField($value): ?HostingRoomBooking
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
