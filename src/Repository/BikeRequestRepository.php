<?php

namespace App\Repository;

use App\Entity\BikeRequest;
use App\Config\BikeRequest\Status;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BikeRequest>
 */
class BikeRequestRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, BikeRequest::class);
    }

    /**
     * @return BikeRequest[] Returns an array of BikeRequest objects
     */
    public function findByDateRange($start, $end): array {
        return $this->createQueryBuilder('br')
                        ->where('br.date BETWEEN :start AND :end')
                        ->setParameter('start', $start)
                        ->setParameter('end', $end)
                        ->orderBy('br.date', 'ASC')
                        ->getQuery()
                        ->getResult()
        ;
    }

    public function countByStatusGroupByYearMonth(): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
SELECT DATE_FORMAT(br.date,"%Y-%b") yearmonth, br.status, COUNT(br.status) cnt FROM bike_request br
GROUP BY YEAR(br.date),MONTH(br.date)
ORDER BY br.date ASC';
        $resultSet = $conn->executeQuery($sql);
        return $resultSet->fetchAllAssociative();

    }

    //    public function findOneBySomeField($value): ?Appointment
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
