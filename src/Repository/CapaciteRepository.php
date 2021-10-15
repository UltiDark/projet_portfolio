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


    public function getCapacite()
    {
        $sql = 
        "SELECT 
            `domaine`.nom AS domaine, 
            `groupe`.nom AS groupe, 
            GROUP_CONCAT(`capacite`.`nom` SEPARATOR ', ')  AS `capacite`
        FROM `capacite` 
            LEFT OUTER JOIN `domaine_capacite` ON `capacite`.`id` = `domaine_capacite`.`capacite_id` 
            LEFT OUTER JOIN `domaine` ON `domaine_capacite`.`domaine_id` = `domaine`.`id` 
            LEFT OUTER JOIN `groupe` ON `groupe`.`id` = `capacite`.`id_groupe_id` 
        GROUP BY `domaine`.`id`,`groupe`.`id`
        ORDER BY `domaine`.`nom` ASC
        ";

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // /**
    //  * @return Capacite[] Returns an array of Capacite objects
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
    public function findOneBySomeField($value): ?Capacite
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
