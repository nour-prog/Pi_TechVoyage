<?php

namespace App\Repository;

use App\Entity\OffreCommentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OffreCommentaire>
 *
 * @method OffreCommentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreCommentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreCommentaire[]    findAll()
 * @method OffreCommentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreCommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreCommentaire::class);
    }

//    /**
//     * @return OffreCommentaire[] Returns an array of OffreCommentaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OffreCommentaire
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
