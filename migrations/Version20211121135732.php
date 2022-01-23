<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211121135732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet ADD date DATE NOT NULL, ADD camera VARCHAR(255) DEFAULT NULL, ADD characters VARCHAR(255) DEFAULT NULL, ADD controllers VARCHAR(255) DEFAULT NULL, ADD gameplay VARCHAR(255) NOT NULL, ADD visuel VARCHAR(255) NOT NULL, CHANGE pitch pitch LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP date, DROP camera, DROP characters, DROP controllers, DROP gameplay, DROP visuel, CHANGE pitch pitch LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
