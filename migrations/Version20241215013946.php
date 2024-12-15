<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215013946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE access_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B6A2DD68A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD68A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE agency CHANGE contact_email contact_email VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE bike CHANGE brand brand VARCHAR(64) DEFAULT NULL, CHANGE model model VARCHAR(64) DEFAULT NULL, CHANGE size size VARCHAR(255) DEFAULT NULL, CHANGE wheel_size wheel_size NUMERIC(10, 2) DEFAULT NULL, CHANGE color color VARCHAR(16) DEFAULT NULL, CHANGE note note VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE event CHANGE note note VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE shift ADD volunteer_id INT DEFAULT NULL, ADD adjusted TINYINT(1) DEFAULT NULL, CHANGE start_date_time start_date_time DATETIME NOT NULL, CHANGE end_date_time end_date_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE shift ADD CONSTRAINT FK_A50B3B458EFAB6B1 FOREIGN KEY (volunteer_id) REFERENCES volunteer (id)');
        $this->addSql('CREATE INDEX IDX_A50B3B458EFAB6B1 ON shift (volunteer_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE volunteer CHANGE phone phone VARCHAR(16) DEFAULT NULL, CHANGE email email VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD68A76ED395');
        $this->addSql('DROP TABLE access_token');
        $this->addSql('ALTER TABLE agency CHANGE contact_email contact_email VARCHAR(32) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE bike CHANGE brand brand VARCHAR(64) DEFAULT \'NULL\', CHANGE model model VARCHAR(64) DEFAULT \'NULL\', CHANGE size size VARCHAR(255) DEFAULT \'NULL\', CHANGE wheel_size wheel_size NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE color color VARCHAR(16) DEFAULT \'NULL\', CHANGE note note VARCHAR(255) DEFAULT \'NULL\', CHANGE status status VARCHAR(255) DEFAULT \'NULL\', CHANGE type type VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE event CHANGE note note VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE shift DROP FOREIGN KEY FK_A50B3B458EFAB6B1');
        $this->addSql('DROP INDEX IDX_A50B3B458EFAB6B1 ON shift');
        $this->addSql('ALTER TABLE shift DROP volunteer_id, DROP adjusted, CHANGE start_date_time start_date_time DATETIME DEFAULT \'NULL\', CHANGE end_date_time end_date_time DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE volunteer CHANGE phone phone VARCHAR(16) DEFAULT \'NULL\', CHANGE email email VARCHAR(32) DEFAULT \'NULL\'');
    }
}
