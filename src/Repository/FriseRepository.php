<?php

namespace App\Repository;

use App\Entity\Frise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Frise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Frise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Frise[]    findAll()
 * @method Frise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Frise::class);
    }


    // Récupération de tous les éléments par ordre chronologique
    public function getByOrder()
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
