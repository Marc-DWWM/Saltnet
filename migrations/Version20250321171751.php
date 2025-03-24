<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321171751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_comment_id INT NOT NULL, post_comment_id INT NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9474526C5F0EBBFF (user_comment_id), INDEX IDX_9474526CDB1174D2 (post_comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, user_file_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8C9F3610CBC66766 (user_file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE follower (id INT AUTO_INCREMENT NOT NULL, user_follower_id INT NOT NULL, follower_id INT NOT NULL, follower_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B9D6094653F31C6 (user_follower_id), INDEX IDX_B9D60946AC24F853 (follower_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_user (group_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A4C98D39FE54D947 (group_id), INDEX IDX_A4C98D39A76ED395 (user_id), PRIMARY KEY(group_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, user_like_id INT NOT NULL, post_like_id INT NOT NULL, like_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AC6340B3DD96E438 (user_like_id), INDEX IDX_AC6340B3B8734D01 (post_like_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_message_id INT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B6BD307FF41DD5C5 (user_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_notification_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_BF5476CAFDC6F10B (user_notification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, user_report_id INT NOT NULL, post_report_id INT DEFAULT NULL, comment_report_id INT DEFAULT NULL, message_report_id INT DEFAULT NULL, file_report_id INT DEFAULT NULL, report_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C42F77844B322924 (user_report_id), INDEX IDX_C42F7784EABCDA37 (post_report_id), INDEX IDX_C42F7784A2AC4596 (comment_report_id), INDEX IDX_C42F7784216BA2F6 (message_report_id), INDEX IDX_C42F7784C5DD1BB6 (file_report_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5F0EBBFF FOREIGN KEY (user_comment_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CDB1174D2 FOREIGN KEY (post_comment_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610CBC66766 FOREIGN KEY (user_file_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D6094653F31C6 FOREIGN KEY (user_follower_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE follower ADD CONSTRAINT FK_B9D60946AC24F853 FOREIGN KEY (follower_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT FK_A4C98D39A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3DD96E438 FOREIGN KEY (user_like_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3B8734D01 FOREIGN KEY (post_like_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF41DD5C5 FOREIGN KEY (user_message_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAFDC6F10B FOREIGN KEY (user_notification_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77844B322924 FOREIGN KEY (user_report_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784EABCDA37 FOREIGN KEY (post_report_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784A2AC4596 FOREIGN KEY (comment_report_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784216BA2F6 FOREIGN KEY (message_report_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784C5DD1BB6 FOREIGN KEY (file_report_id) REFERENCES file (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5F0EBBFF');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CDB1174D2');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610CBC66766');
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D6094653F31C6');
        $this->addSql('ALTER TABLE follower DROP FOREIGN KEY FK_B9D60946AC24F853');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39FE54D947');
        $this->addSql('ALTER TABLE group_user DROP FOREIGN KEY FK_A4C98D39A76ED395');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3DD96E438');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3B8734D01');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF41DD5C5');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAFDC6F10B');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F77844B322924');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784EABCDA37');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784A2AC4596');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784216BA2F6');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784C5DD1BB6');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE follower');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE group_user');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE report');
    }
}
