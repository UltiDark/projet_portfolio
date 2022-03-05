<?php

namespace App\Repository;

use App\Entity\BanqueImage;
use App\Entity\Categorie;
use App\Entity\Projet;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }


    // Récupération des projets + leurs logos en fonction de leur catégorie (game ou web)
    public function findByJoin($value)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin(Categorie::class, 'c', Join::WITH,'p.id_categorie = c.id')
            ->innerjoin(BanqueImage::class, 'b', Join::WITH,'p.id = b.id_projet')
            ->addSelect('c.nom AS nomCategorie')
            ->addSelect('b.nom AS nomImage')
            ->addSelect('b.lien AS lienImage')
            ->andWhere('c.nom = :val')
            ->andWhere('b.nom = :val2')
            ->setParameter('val', $value)
            ->setParameter('val2', 'logo')
            ->getQuery()
            ->getResult()
        ;
    }
}
