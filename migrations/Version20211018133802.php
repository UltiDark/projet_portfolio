<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018133802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reseau ADD id_categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE reseau ADD CONSTRAINT FK_CDE52CB89F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie_reseau (id)');
        $this->addSql('CREATE INDEX IDX_CDE52CB89F34925F ON reseau (id_categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reseau DROP FOREIGN KEY FK_CDE52CB89F34925F');
        $this->addSql('DROP INDEX IDX_CDE52CB89F34925F ON reseau');
        $this->addSql('ALTER TABLE reseau DROP id_categorie_id');
    }
}
