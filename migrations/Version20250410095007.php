<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250410095007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D60946AC24F853');
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D6094653F31C6');

        // Supprimer les tables
        $this->addSql('DROP TABLE IF EXISTS file');
        $this->addSql('DROP TABLE IF EXISTS follower');
    }

    public function down(Schema $schema): void
    {
    }
}
