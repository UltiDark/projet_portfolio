<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211121140932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banque_image ADD id_projet_id INT NOT NULL');
        $this->addSql('ALTER TABLE banque_image ADD CONSTRAINT FK_C5E92B8380F43E55 FOREIGN KEY (id_projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_C5E92B8380F43E55 ON banque_image (id_projet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banque_image DROP FOREIGN KEY FK_C5E92B8380F43E55');
        $this->addSql('DROP INDEX IDX_C5E92B8380F43E55 ON banque_image');
        $this->addSql('ALTER TABLE banque_image DROP id_projet_id');
    }
}
