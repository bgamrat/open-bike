<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241102013343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, host_id INT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(128) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, note VARCHAR(255) DEFAULT NULL, INDEX IDX_3BAE0AA71FB8D185 (host_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA71FB8D185 FOREIGN KEY (host_id) REFERENCES volunteer (id)');
        $this->addSql('ALTER TABLE agency CHANGE contact_email contact_email VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE bike CHANGE brand brand VARCHAR(64) DEFAULT NULL, CHANGE model model VARCHAR(64) DEFAULT NULL, CHANGE wheel_size wheel_size NUMERIC(10, 2) DEFAULT NULL, CHANGE color color VARCHAR(16) DEFAULT NULL, CHANGE note note VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE size size VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE shift CHANGE end_date_time end_date_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE volunteer CHANGE phone phone VARCHAR(16) DEFAULT NULL, CHANGE email email VARCHAR(32) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA71FB8D185');
        $this->addSql('DROP TABLE event');
        $this->addSql('ALTER TABLE agency CHANGE contact_email contact_email VARCHAR(32) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE bike CHANGE brand brand VARCHAR(64) DEFAULT \'NULL\', CHANGE model model VARCHAR(64) DEFAULT \'NULL\', CHANGE size size VARCHAR(255) DEFAULT \'NULL\', CHANGE wheel_size wheel_size NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE color color VARCHAR(16) DEFAULT \'NULL\', CHANGE note note VARCHAR(255) DEFAULT \'NULL\', CHANGE status status VARCHAR(255) DEFAULT \'NULL\', CHANGE type type VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE shift CHANGE end_date_time end_date_time DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE volunteer CHANGE phone phone VARCHAR(16) DEFAULT \'NULL\', CHANGE email email VARCHAR(32) DEFAULT \'NULL\'');
    }
}
