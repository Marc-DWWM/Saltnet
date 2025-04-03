<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250403143442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment CHANGE comment comment VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE message CHANGE message message VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE post post VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment CHANGE comment comment LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message CHANGE message message LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE post post LONGTEXT NOT NULL');
    }
}
