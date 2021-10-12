<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211011123719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capacite (id INT AUTO_INCREMENT NOT NULL, id_groupe_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_A1E9ED3BFA7089AB (id_groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE capacite_capacite (capacite_source INT NOT NULL, capacite_target INT NOT NULL, INDEX IDX_7FE0E76B7614BACA (capacite_source), INDEX IDX_7FE0E76B6FF1EA45 (capacite_target), PRIMARY KEY(capacite_source, capacite_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domaine (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capacite ADD CONSTRAINT FK_A1E9ED3BFA7089AB FOREIGN KEY (id_groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE capacite_capacite ADD CONSTRAINT FK_7FE0E76B7614BACA FOREIGN KEY (capacite_source) REFERENCES capacite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE capacite_capacite ADD CONSTRAINT FK_7FE0E76B6FF1EA45 FOREIGN KEY (capacite_target) REFERENCES capacite (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capacite_capacite DROP FOREIGN KEY FK_7FE0E76B7614BACA');
        $this->addSql('ALTER TABLE capacite_capacite DROP FOREIGN KEY FK_7FE0E76B6FF1EA45');
        $this->addSql('DROP TABLE capacite');
        $this->addSql('DROP TABLE capacite_capacite');
        $this->addSql('DROP TABLE domaine');
    }
}
