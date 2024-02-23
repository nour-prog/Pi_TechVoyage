<?php

namespace App\Repository;

use App\Entity\Publication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Publication>
 *
 * @method Publication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publication[]    findAll()
 * @method Publication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, Publication::class);
    }

//    /**
//     * @return Publication[] Returns an array of Publication objects
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

    public function findOneBySomeField($value): ?Publication
    {
       return $this->createQueryBuilder('p')
           ->andWhere('p.id = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }

   public function findOneById($value): ?Publication
{
    return $this->createQueryBuilder('p')
        ->andWhere('p.id = :val')
        ->setParameter('val', $value)
        ->getQuery()
        ->getOneOrNullResult();
}
//Recherche 
public function findAllSorted($sortOption = 'title')
{
    $queryBuilder = $this->createQueryBuilder('p');

    switch ($sortOption) {
        case 'title':
            $queryBuilder->orderBy('p.title', 'ASC');
            break;
        case 'createdAt':
            $queryBuilder->orderBy('p.createdAt', 'ASC');
            break;
        case 'commentsCount':
            // Ajoutez ici votre logique pour trier par le nombre de commentaires
            break;
        // Ajoutez d'autres options de tri au besoin

        default:
            $queryBuilder->orderBy('p.title', 'ASC');
    }

    return $queryBuilder->getQuery()->getResult();
}

    public function findBySearchTerm(string $searchTerm): array
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($searchTerm)) {
            $qb->andWhere('p.title LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        return $qb->getQuery()->getResult();
    }

    // Dans PublicationRepository.php
    public function findAllSortedAndSearch(string $sort, string $searchTerm): array
    {
        $queryBuilder = $this->createQueryBuilder('p');
    
        if ($searchTerm) {
            $queryBuilder->andWhere('p.title LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
    
        // Add sorting conditions based on your requirements
        switch ($sort) {
            case 'title':
                $queryBuilder->orderBy('p.title', 'ASC');
                break;
            case 'shortDescription':
                $queryBuilder->orderBy('p.shortDescription', 'ASC');
                break;
            // Add other sorting cases as needed
            default:
                // Default sorting (e.g., by ID)
                $queryBuilder->orderBy('p.id', 'ASC');
        }
    
        return $queryBuilder->getQuery()->getResult();
    }

}


