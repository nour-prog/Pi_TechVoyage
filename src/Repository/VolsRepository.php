<?php

namespace App\Repository;

use App\Entity\Vols;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vols>
 *
 * @method Vols|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vols|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vols[]    findAll()
 * @method Vols[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VolsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vols::class);
    }

    public function findByKeyword($keyword)
    {
        return $this->createQueryBuilder('v')
            ->where('v.pointdepart LIKE :keyword 
                  OR v.destination LIKE :keyword 
                  OR v.duree LIKE :keyword 
                  OR v.datedepart LIKE :keyword 
                  OR v.datearrive LIKE :keyword 
                  OR v.nbrescale LIKE :keyword 
                  OR v.nbrplace LIKE :keyword 
                  OR v.classe LIKE :keyword 
                  OR v.prix LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Vols[] Returns an array of Vols objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vols
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
