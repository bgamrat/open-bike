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

    public function countByYearMonth(): ?array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
SELECT DATE_FORMAT(s.start_date_time,"%Y-%b") yearmonth, SUM((s.end_date_time - s.start_date_time)/3600) hours FROM shift s
GROUP BY YEAR(s.start_date_time),MONTH(s.start_date_time)
ORDER BY s.start_date_time ASC';
        $resultSet = $conn->executeQuery($sql);
        return $resultSet->fetchAllAssociative();
    }

    public function countHours(): array {
        return $this->createQueryBuilder('s')
                        ->select('SUM(s.endDateTime - s.startDateTime) AS total')
                        ->getQuery()->getOneOrNullResult();
    }
}
