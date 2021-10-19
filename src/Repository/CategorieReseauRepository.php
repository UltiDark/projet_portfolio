<?php

namespace App\Repository;

use App\Entity\CategorieReseau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieReseau|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieReseau|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieReseau[]    findAll()
 * @method CategorieReseau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieReseauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieReseau::class);
    }

    // /**
    //  * @return CategorieReseau[] Returns an array of CategorieReseau objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategorieReseau
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
