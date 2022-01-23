<?php

namespace App\Repository;

use App\Entity\Intro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Intro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intro[]    findAll()
 * @method Intro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intro::class);
    }

    public function getByOrder()
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.place', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getLast()
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.place', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getFrom($from)
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.place', 'ASC')
            ->setFirstResult($from)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Intro[] Returns an array of Intro objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Intro
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
