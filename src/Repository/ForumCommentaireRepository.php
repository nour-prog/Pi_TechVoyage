<?php

namespace App\Repository;

use App\Entity\ForumCommentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ForumCommentaire>
 *
 * @method ForumCommentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForumCommentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForumCommentaire[]    findAll()
 * @method ForumCommentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumCommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForumCommentaire::class);
    }

//    /**
//     * @return ForumCommentaire[] Returns an array of ForumCommentaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ForumCommentaire
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
