<?php

namespace App\Repository;

use PDO;
use App\Entity\Projet;
use App\Entity\BanqueImage;
use App\Entity\Utilisateur;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method BanqueImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BanqueImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BanqueImage[]    findAll()
 * @method BanqueImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BanqueImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BanqueImage::class);
    }


    // Récupération de toutes les screens en fonction du projet
    public function findByLimit($value){
        $tab = $this->createQueryBuilder('b')
        ->andWhere('b.id_projet = :val')
        ->andWhere('b.nom = :val2')
        ->setParameter('val', $value)
        ->setParameter('val2', 'screen')

        ->getQuery()
        ->getResult()
        ;

        // Choix aléatoire de 5 images dans la selection
        if (count($tab) >= 5){
            $tabAlea = array_rand($tab, 5);
            for ($i=0; $i<count($tabAlea); $i++){
                $tabFinal[$i] = $tab[$tabAlea[$i]];
            }
        }
        elseif(count($tab) <= 0){
            return null;
        }
        else{
            // Duplication d'image si moins de 5
            $j = 5 - count($tab);
            for($i = 0; $i < $j; $i++){
                array_push($tab, $tab[0]);
                $tabFinal = $tab;
            }
        }

        return $tabFinal;
    }


    // Récupération du logo en fonction du projet
    public function findLogo($value){
        return $this->createQueryBuilder('b')
        ->andWhere('b.id_projet = :val')
        ->andWhere('b.nom = :val2')
        ->setParameter('val', $value)
        ->setParameter('val2', 'logo')
        ->setMaxResults(1)
        ->getQuery()
        ->getResult()
    ;
    }

    // Récupération de tous les logos en fonction des projets sur lesquels l'utilisateur a été ajouté
    public function findAllLogo($value){
    $sql = 
        "SELECT 
        `projet`.nom AS nomProjet,
        `projet`.id AS idProjet, 
        `banque_image`.nom AS nomImage,
        `banque_image`.lien AS lienImage
            FROM `banque_image`
                INNER JOIN `projet` ON `banque_image`.`id_projet_id` = `projet`.`id`
                INNER JOIN `projet_utilisateur` ON `projet`.`id` = `projet_utilisateur`.`projet_id` 
                INNER JOIN `utilisateur` ON `utilisateur`.`id` = `projet_utilisateur`.`utilisateur_id`
            WHERE `utilisateur`.`id` = :id and `banque_image`.`nom` = 'logo'
            ORDER BY `projet`.`id` ASC
        ";

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('id', $value, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
