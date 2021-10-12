<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210930123307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capacite (id INT AUTO_INCREMENT NOT NULL, id_groupe_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_A1E9ED3BFA7089AB (id_groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, id_projet_id INT DEFAULT NULL, id_galerie_id INT DEFAULT NULL, contenu LONGTEXT NOT NULL, email LONGTEXT NOT NULL, INDEX IDX_67F068BC80F43E55 (id_projet_id), INDEX IDX_67F068BC27D9161C (id_galerie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domaine (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domaine_groupe (domaine_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_B503D0F4272FC9F (domaine_id), INDEX IDX_B503D0F7A45358C (groupe_id), PRIMARY KEY(domaine_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frise (id INT AUTO_INCREMENT NOT NULL, id_classe_id INT NOT NULL, nom VARCHAR(255) NOT NULL, contenu LONGTEXT DEFAULT NULL, lien LONGTEXT DEFAULT NULL, id_div VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_6FAA52AAF6B192E (id_classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerie (id INT AUTO_INCREMENT NOT NULL, id_categorie_id INT NOT NULL, nom VARCHAR(255) NOT NULL, lien LONGTEXT NOT NULL, INDEX IDX_9E7D15909F34925F (id_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, id_categorie_id INT NOT NULL, nom VARCHAR(255) NOT NULL, lien LONGTEXT NOT NULL, pitch LONGTEXT NOT NULL, document LONGTEXT DEFAULT NULL, build LONGTEXT DEFAULT NULL, INDEX IDX_50159CA99F34925F (id_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capacite ADD CONSTRAINT FK_A1E9ED3BFA7089AB FOREIGN KEY (id_groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC80F43E55 FOREIGN KEY (id_projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC27D9161C FOREIGN KEY (id_galerie_id) REFERENCES galerie (id)');
        $this->addSql('ALTER TABLE domaine_groupe ADD CONSTRAINT FK_B503D0F4272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domaine_groupe ADD CONSTRAINT FK_B503D0F7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE frise ADD CONSTRAINT FK_6FAA52AAF6B192E FOREIGN KEY (id_classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE galerie ADD CONSTRAINT FK_9E7D15909F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA99F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE galerie DROP FOREIGN KEY FK_9E7D15909F34925F');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA99F34925F');
        $this->addSql('ALTER TABLE frise DROP FOREIGN KEY FK_6FAA52AAF6B192E');
        $this->addSql('ALTER TABLE domaine_groupe DROP FOREIGN KEY FK_B503D0F4272FC9F');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC27D9161C');
        $this->addSql('ALTER TABLE capacite DROP FOREIGN KEY FK_A1E9ED3BFA7089AB');
        $this->addSql('ALTER TABLE domaine_groupe DROP FOREIGN KEY FK_B503D0F7A45358C');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC80F43E55');
        $this->addSql('DROP TABLE capacite');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE domaine');
        $this->addSql('DROP TABLE domaine_groupe');
        $this->addSql('DROP TABLE frise');
        $this->addSql('DROP TABLE galerie');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE utilisateur');
    }
}
