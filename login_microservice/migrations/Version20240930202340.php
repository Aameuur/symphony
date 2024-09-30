<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240930202340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coli (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(255) NOT NULL, type_de_coli VARCHAR(255) NOT NULL, categories VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, is_read TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, delivery_date DATETIME NOT NULL, reference LONGTEXT DEFAULT NULL, depart_address VARCHAR(255) DEFAULT NULL, delivery_address VARCHAR(255) NOT NULL, depart_longitude VARCHAR(255) DEFAULT NULL, depart_latitude VARCHAR(255) DEFAULT NULL, delivery_longitude VARCHAR(255) DEFAULT NULL, delivery_latitude VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, agent_id INT NOT NULL, INDEX IDX_D499BFF63414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE task_record (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, task_id INT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME DEFAULT NULL, status VARCHAR(255) NOT NULL, distance_traveled DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, cin VARCHAR(20) NOT NULL, address VARCHAR(255) NOT NULL, num_tel VARCHAR(15) NOT NULL, date_naissance DATE NOT NULL, genre VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649ABE530DA (cin), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF63414710B FOREIGN KEY (agent_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF63414710B');
        $this->addSql('DROP TABLE coli');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE planning');
        $this->addSql('DROP TABLE task_record');
        $this->addSql('DROP TABLE user');
    }
}
