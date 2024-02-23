<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217021719 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "order_status_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, customer VARCHAR(255) NOT NULL, address1 VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL, postcode VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, amount NUMERIC(10, 2) NOT NULL, deleted VARCHAR(3) NOT NULL, last_modified TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, order_status_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F5299398263E25CF ON "order" (order_status_id)');
        $this->addSql('COMMENT ON COLUMN "order".date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "order_status" (id INT NOT NULL, code VARCHAR(30) NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398263E25CF FOREIGN KEY (order_status_id) REFERENCES "order_status" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398263E25CF');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "order_status_id_seq" CASCADE');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE "order_status"');
    }
}
