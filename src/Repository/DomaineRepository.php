<?php

namespace App\Repository;

use App\Entity\Domaine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Domaine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Domaine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Domaine[]    findAll()
 * @method Domaine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomaineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Domaine::class);
    }

    public function getDomaine()
    {
        $sql = 
        "SELECT 
            `domaine`.id AS domaine_id, 
            `domaine`.nom AS domaine, 
            `groupe`.nom AS groupe, 
            `groupe`.id AS groupe_id, 

            GROUP_CONCAT(`capacite`.`nom` SEPARATOR ', ')  AS `capacite`
        FROM `domaine` 
            LEFT OUTER JOIN `domaine_capacite` ON `domaine`.`id` = `domaine_capacite`.`domaine_id` 
            LEFT OUTER JOIN `capacite` ON `domaine_capacite`.`capacite_id` = `capacite`.`id` 
            LEFT OUTER JOIN `groupe` ON `groupe`.`id` = `capacite`.`id_groupe_id` 
        GROUP BY `domaine`.`id`,`groupe`.`id`
        ORDER BY `domaine`.`nom` ASC
        ";

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $groupes = $stmt->fetchAll();
        $domaines = [];

        foreach ($groupes as $groupe) {
            $domaines[$groupe['domaine_id']]['id'] = $groupe['domaine_id'];
            $domaines[$groupe['domaine_id']]['nom'] = $groupe['domaine'];
            $domaines[$groupe['domaine_id']]['groupes'][] = $groupe;
        }

        return $domaines;
    }

    public function getGroupe()
    {
        $sql = 
        "SELECT 
            `domaine`.nom AS domaine, 
            `domaine`.id AS domaine_id, 
            `groupe`.nom AS groupe, 
            `groupe`.id AS groupe_id, 
            GROUP_CONCAT(`capacite`.`nom` SEPARATOR ', ')  AS `capacite`
        FROM `domaine` 
            LEFT OUTER JOIN `domaine_capacite` ON `domaine`.`id` = `domaine_capacite`.`domaine_id` 
            LEFT OUTER JOIN `capacite` ON `domaine_capacite`.`capacite_id` = `capacite`.`id` 
            LEFT OUTER JOIN `groupe` ON `groupe`.`id` = `capacite`.`id_groupe_id` 
        GROUP BY `domaine`.`id`,`groupe`.`id`
        ORDER BY `domaine`.`nom` ASC
        ";

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOneDomaine($id)
    {
        $sql = 
        "SELECT
            `domaine`.id AS domaine_id,
            `domaine`.nom AS domaine,
            `groupe`.nom AS groupe,
            `groupe`.id AS groupe_id,
            GROUP_CONCAT(`capacite`.`nom` SEPARATOR ', ') AS `capacite`
        FROM `domaine`
            LEFT OUTER JOIN `domaine_capacite` ON `domaine`.`id` = `domaine_capacite`.`domaine_id`
            LEFT OUTER JOIN `capacite` ON `domaine_capacite`.`capacite_id` = `capacite`.`id`
            LEFT OUTER JOIN `groupe` ON `groupe`.`id` = `capacite`.`id_groupe_id`
        WHERE
            `domaine`.`id` = ?
        GROUP BY
            `domaine`.`id`,
            `groupe`.`id`
        ";

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $groupes = $stmt->fetchAll();
        $domaines = [];

        foreach ($groupes as $groupe) {
            $domaines[$groupe['domaine_id']]['id'] = $groupe['domaine_id'];
            $domaines[$groupe['domaine_id']]['nom'] = $groupe['domaine'];
            $domaines[$groupe['domaine_id']]['groupes'][] = $groupe;
        }

        return $domaines;
    }


    // /**
    //  * @return Domaine[] Returns an array of Domaine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Domaine
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
