<?php

namespace App\Repository;

use App\Entity\LocationVoiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LocationVoiture>
 *
 * @method LocationVoiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocationVoiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocationVoiture[]    findAll()
 * @method LocationVoiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationVoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocationVoiture::class);
    }

//    /**
//     * @return LocationVoiture[] Returns an array of LocationVoiture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LocationVoiture
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
