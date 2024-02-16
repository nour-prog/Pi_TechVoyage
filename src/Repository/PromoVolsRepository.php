<?php

namespace App\Repository;

use App\Entity\PromoVols;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PromoVols>
 *
 * @method PromoVols|null find($id, $lockMode = null, $lockVersion = null)
 * @method PromoVols|null findOneBy(array $criteria, array $orderBy = null)
 * @method PromoVols[]    findAll()
 * @method PromoVols[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromoVolsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromoVols::class);
    }

//    /**
//     * @return PromoVols[] Returns an array of PromoVols objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PromoVols
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
