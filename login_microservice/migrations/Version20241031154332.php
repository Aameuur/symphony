<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031154332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE planning ADD depart_address_id INT NOT NULL, ADD delivery_address_id INT NOT NULL, DROP reference, DROP depart_address, DROP delivery_address');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF63414710B FOREIGN KEY (agent_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF69D0BF8BB FOREIGN KEY (depart_address_id) REFERENCES destination (id)');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES destination (id)');
        $this->addSql('CREATE INDEX IDX_D499BFF69D0BF8BB ON planning (depart_address_id)');
        $this->addSql('CREATE INDEX IDX_D499BFF6EBF23851 ON planning (delivery_address_id)');
        $this->addSql('ALTER TABLE task_record ADD CONSTRAINT FK_A09D1B423414710B FOREIGN KEY (agent_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF63414710B');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF69D0BF8BB');
        $this->addSql('ALTER TABLE planning DROP FOREIGN KEY FK_D499BFF6EBF23851');
        $this->addSql('DROP INDEX IDX_D499BFF69D0BF8BB ON planning');
        $this->addSql('DROP INDEX IDX_D499BFF6EBF23851 ON planning');
        $this->addSql('ALTER TABLE planning ADD reference LONGTEXT DEFAULT NULL, ADD depart_address VARCHAR(255) DEFAULT NULL, ADD delivery_address VARCHAR(255) NOT NULL, DROP depart_address_id, DROP delivery_address_id');
        $this->addSql('ALTER TABLE task_record DROP FOREIGN KEY FK_A09D1B423414710B');
    }
}
