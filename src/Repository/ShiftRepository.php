<?php

namespace App\Repository;

use App\Entity\Shift;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Shift>
 */
class ShiftRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Shift::class);
    }

    /**
     * @return Shift Returns a Shift object
     */
    public function findOneByShiftStarted($volunteer): ?Shift {
        return $this->createQueryBuilder('s')
                        ->where('s.Volunteer = :volunteer AND s.endDateTime IS NULL')
                        ->setParameter('volunteer', $volunteer)
                        ->getQuery()
                        ->setMaxResults(1)->getOneOrNullResult()
        ;
    }

    //    public function findOneBySomeField($value): ?Shift
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
