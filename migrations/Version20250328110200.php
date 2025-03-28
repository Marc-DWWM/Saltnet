<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250328110200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784A2AC4596');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784216BA2F6');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784C5DD1BB6');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784EABCDA37');
        $this->addSql('DROP INDEX IDX_C42F7784C5DD1BB6 ON report');
        $this->addSql('DROP INDEX IDX_C42F7784EABCDA37 ON report');
        $this->addSql('DROP INDEX IDX_C42F7784A2AC4596 ON report');
        $this->addSql('DROP INDEX IDX_C42F7784216BA2F6 ON report');
        $this->addSql('ALTER TABLE report DROP post_report_id, DROP comment_report_id, DROP message_report_id, DROP file_report_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE report ADD post_report_id INT DEFAULT NULL, ADD comment_report_id INT DEFAULT NULL, ADD message_report_id INT DEFAULT NULL, ADD file_report_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784A2AC4596 FOREIGN KEY (comment_report_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784216BA2F6 FOREIGN KEY (message_report_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784C5DD1BB6 FOREIGN KEY (file_report_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784EABCDA37 FOREIGN KEY (post_report_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_C42F7784C5DD1BB6 ON report (file_report_id)');
        $this->addSql('CREATE INDEX IDX_C42F7784EABCDA37 ON report (post_report_id)');
        $this->addSql('CREATE INDEX IDX_C42F7784A2AC4596 ON report (comment_report_id)');
        $this->addSql('CREATE INDEX IDX_C42F7784216BA2F6 ON report (message_report_id)');
    }
}
