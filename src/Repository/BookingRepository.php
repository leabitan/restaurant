<?php

namespace App\Repository;

use DateTimeInterface;
use App\Entity\Booking;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    // Dans BookingRepository.php
    /**
     * @return Booking[] Returns an array of bookinh objects
     */
    public function findByDateRange(?DateTimeInterface $dateMin, ?DateTimeInterface $dateMax)
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->orderBy('b.date_booking', 'DESC'); // Vous pouvez ajuster cela selon vos besoins

        if ($dateMin !== null) {
            $queryBuilder->andWhere('b.date_booking >= :dateMin')
                ->setParameter('dateMin', $dateMin);
        }

        if ($dateMax !== null) {
            $queryBuilder->andWhere('b.date_booking <= :dateMax')
                ->setParameter('dateMax', $dateMax);
        }

        return $queryBuilder->getQuery()->getResult();
    }








    //    /**
    //     * @return Booking[] Returns an array of Booking objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Booking
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
