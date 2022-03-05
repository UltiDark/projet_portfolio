<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Galerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Galerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Galerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Galerie[]    findAll()
 * @method Galerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Galerie::class);
    }


    // Récupération de tous les éléments en fonction de sa catégorie (2D ou 3D)
    public function findByJoin($value)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin(Categorie::class, 'c', Join::WITH,'g.id_categorie = c.id')
            ->andWhere('c.nom = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    // Récupération de tous les éléments par ordre alphabétique
    public function getByOrder()
    {
        return $this->createQueryBuilder('g')
            ->orderBy('g.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
