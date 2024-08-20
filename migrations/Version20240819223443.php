<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240819223443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bike (id INT AUTO_INCREMENT NOT NULL, serial_number VARCHAR(32) NOT NULL, brand VARCHAR(64) NOT NULL, model VARCHAR(64) DEFAULT NULL, speeds INT NOT NULL, wheel_size NUMERIC(10, 2) DEFAULT NULL, color VARCHAR(16) DEFAULT NULL, note VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, frame_size VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bike_request (id INT AUTO_INCREMENT NOT NULL, referrer_id INT NOT NULL, bike_id INT DEFAULT NULL, client_name VARCHAR(64) NOT NULL, contact VARCHAR(128) NOT NULL, date DATE NOT NULL, height VARCHAR(32) NOT NULL, status VARCHAR(255) DEFAULT NULL, INDEX IDX_812B16A2798C22DB (referrer_id), INDEX IDX_812B16A2D5A4816F (bike_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bike_request ADD CONSTRAINT FK_812B16A2798C22DB FOREIGN KEY (referrer_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE bike_request ADD CONSTRAINT FK_812B16A2D5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bike_request DROP FOREIGN KEY FK_812B16A2798C22DB');
        $this->addSql('ALTER TABLE bike_request DROP FOREIGN KEY FK_812B16A2D5A4816F');
        $this->addSql('DROP TABLE bike');
        $this->addSql('DROP TABLE bike_request');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
