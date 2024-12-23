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

use App\Entity\Recurrence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recurrence>
 */
class RecurrenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recurrence::class);
    }

    /**
     * @return Recurrence[] Returns an array of Recurrence objects
     */
    public function findByDateRange($start,$end): array {
        return $this->createQueryBuilder('r')
                        ->where('r.datetime BETWEEN :start AND :end')
                        ->setParameter('start', $start)
                        ->setParameter('end', $end)
                        ->orderBy('r.datetime', 'DESC') // based on the assumption later recurrences are more important
                        ->getQuery()
                        ->getResult()
        ;
    }

    public function findByDate($date): ?array {
        return $this->createQueryBuilder('r')
                        ->where(':date = r.datetime')
                        ->setParameter('date', $date)
                        ->getQuery()
                        ->getResult()
        ;
    }
}
