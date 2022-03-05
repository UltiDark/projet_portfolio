<?php

namespace App\Repository;

use App\Entity\Capacite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Capacite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Capacite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Capacite[]    findAll()
 * @method Capacite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CapaciteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Capacite::class);
    }
}
