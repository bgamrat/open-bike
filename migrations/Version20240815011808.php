<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240815011808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, point_of_contact VARCHAR(128) NOT NULL, contact_phone VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, referrer_id INT NOT NULL, client_name VARCHAR(64) NOT NULL, contact VARCHAR(128) NOT NULL, date DATE NOT NULL, height VARCHAR(32) NOT NULL, INDEX IDX_FE38F844798C22DB (referrer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844798C22DB FOREIGN KEY (referrer_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE bike CHANGE model model VARCHAR(64) DEFAULT NULL, CHANGE wheel_size wheel_size NUMERIC(4, 2) DEFAULT NULL, CHANGE color color VARCHAR(16) DEFAULT NULL, CHANGE note note VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844798C22DB');
        $this->addSql('DROP TABLE agency');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('ALTER TABLE bike CHANGE model model VARCHAR(64) DEFAULT \'NULL\', CHANGE wheel_size wheel_size NUMERIC(4, 2) DEFAULT \'NULL\', CHANGE color color VARCHAR(16) DEFAULT \'NULL\', CHANGE note note VARCHAR(255) DEFAULT \'NULL\', CHANGE status status VARCHAR(255) DEFAULT \'NULL\', CHANGE type type VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
