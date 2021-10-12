<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211011124220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capacite (id INT AUTO_INCREMENT NOT NULL, id_groupe_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_A1E9ED3BFA7089AB (id_groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domaine (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domaine_capacite (domaine_id INT NOT NULL, capacite_id INT NOT NULL, INDEX IDX_168868E44272FC9F (domaine_id), INDEX IDX_168868E47C79189D (capacite_id), PRIMARY KEY(domaine_id, capacite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capacite ADD CONSTRAINT FK_A1E9ED3BFA7089AB FOREIGN KEY (id_groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE domaine_capacite ADD CONSTRAINT FK_168868E44272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domaine_capacite ADD CONSTRAINT FK_168868E47C79189D FOREIGN KEY (capacite_id) REFERENCES capacite (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE domaine_capacite DROP FOREIGN KEY FK_168868E47C79189D');
        $this->addSql('ALTER TABLE domaine_capacite DROP FOREIGN KEY FK_168868E44272FC9F');
        $this->addSql('DROP TABLE capacite');
        $this->addSql('DROP TABLE domaine');
        $this->addSql('DROP TABLE domaine_capacite');
    }
}
