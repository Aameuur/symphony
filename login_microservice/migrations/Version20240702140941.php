<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702140941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planning CHANGE delivery_address delivery_address VARCHAR(255) NOT NULL, CHANGE depart_address depart_address VARCHAR(255) DEFAULT NULL, CHANGE depart_longitude depart_longitude VARCHAR(255) DEFAULT NULL, CHANGE depart_latitude depart_latitude VARCHAR(255) DEFAULT NULL, CHANGE delivery_longitude delivery_longitude VARCHAR(255) DEFAULT NULL, CHANGE delivery_latitude delivery_latitude VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE planning CHANGE depart_address depart_address LONGTEXT DEFAULT NULL, CHANGE delivery_address delivery_address LONGTEXT NOT NULL, CHANGE depart_longitude depart_longitude DOUBLE PRECISION DEFAULT NULL, CHANGE depart_latitude depart_latitude DOUBLE PRECISION DEFAULT NULL, CHANGE delivery_longitude delivery_longitude DOUBLE PRECISION DEFAULT NULL, CHANGE delivery_latitude delivery_latitude DOUBLE PRECISION DEFAULT NULL');
    }
}
