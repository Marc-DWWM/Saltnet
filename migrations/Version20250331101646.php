<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331101646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repost DROP FOREIGN KEY FK_DD3446C513841D26');
        $this->addSql('DROP INDEX IDX_DD3446C513841D26 ON repost');
        $this->addSql('ALTER TABLE repost CHANGE user_post_id user_repost_id INT NOT NULL');
        $this->addSql('ALTER TABLE repost ADD CONSTRAINT FK_DD3446C576520094 FOREIGN KEY (user_repost_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DD3446C576520094 ON repost (user_repost_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repost DROP FOREIGN KEY FK_DD3446C576520094');
        $this->addSql('DROP INDEX IDX_DD3446C576520094 ON repost');
        $this->addSql('ALTER TABLE repost CHANGE user_repost_id user_post_id INT NOT NULL');
        $this->addSql('ALTER TABLE repost ADD CONSTRAINT FK_DD3446C513841D26 FOREIGN KEY (user_post_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DD3446C513841D26 ON repost (user_post_id)');
    }
}
