<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323154618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DCD09ADDB');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF675F31B ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8DCD09ADDB ON post');
        $this->addSql('ALTER TABLE post DROP original_post_id, CHANGE author_id user_post_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D13841D26 FOREIGN KEY (user_post_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D13841D26 ON post (user_post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D13841D26');
        $this->addSql('DROP INDEX IDX_5A8A6C8D13841D26 ON post');
        $this->addSql('ALTER TABLE post ADD original_post_id INT DEFAULT NULL, CHANGE user_post_id author_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DCD09ADDB FOREIGN KEY (original_post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DCD09ADDB ON post (original_post_id)');
    }
}
