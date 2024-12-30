<?php

/*
 * This file is part of open-bike.
 *
 * (c) Betsy Gamrat <betsy.gamrat@wirehopper.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
    public function findByDateRange($start, $end): ?array {
        return $this->createQueryBuilder('e')
                        ->where('e.start BETWEEN :start AND :end')
                        ->orWhere('e.end BETWEEN :start AND :end')
                        ->setParameter('start', $start)
                        ->setParameter('end', $end)
                        ->orderBy('e.start', 'DESC')
                        ->getQuery()
                        ->getResult()
        ;
    }

    public function findByDate($date): ?array {
        return $this->createQueryBuilder('e')
                        ->where(':date BETWEEN e.start AND e.end')
                        ->orWhere('DATE_DIFF(e.start,:date) = 0')
                        ->setParameter('date', $date)
                        ->getQuery()
                        ->getResult()
        ;
    }
}
