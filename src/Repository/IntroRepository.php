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


    // Récupération de tous les paragraphes par ordre de classement
    public function getByOrder()
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.place', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    // Récupération du dernier paragraphe dans la liste
    public function getLast()
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.place', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }


    // Récupération des paragraphes  en fonction d'une certaine place pour modifier les leurs ( les déplacer dans la liste)
    public function getFrom($from)
    {
        return $this->createQueryBuilder('i')
            ->orderBy('i.place', 'ASC')
            ->setFirstResult($from)
            ->getQuery()
            ->getResult()
        ;
    }
}
