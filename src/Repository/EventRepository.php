<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return Event[] Returns an array of Event objects
     */
    public function findByDateRange($start,$end): array {
        return $this->createQueryBuilder('e')
                        ->where('e.start BETWEEN :start AND :end')
                        ->orWhere('e.end BETWEEN :start AND :end')
                        ->setParameter('start', $start)
                        ->setParameter('end', $end)
                        ->orderBy('e.start', 'ASC')
                        ->getQuery()
                        ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
