<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331092705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE repost (id INT AUTO_INCREMENT NOT NULL, original_post_id INT NOT NULL, user_post_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DD3446C5CD09ADDB (original_post_id), INDEX IDX_DD3446C513841D26 (user_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repost ADD CONSTRAINT FK_DD3446C5CD09ADDB FOREIGN KEY (original_post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE repost ADD CONSTRAINT FK_DD3446C513841D26 FOREIGN KEY (user_post_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post DROP profile_picture, DROP username');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repost DROP FOREIGN KEY FK_DD3446C5CD09ADDB');
        $this->addSql('ALTER TABLE repost DROP FOREIGN KEY FK_DD3446C513841D26');
        $this->addSql('DROP TABLE repost');
        $this->addSql('ALTER TABLE post ADD profile_picture VARCHAR(255) DEFAULT NULL, ADD username VARCHAR(255) DEFAULT NULL');
    }
}
