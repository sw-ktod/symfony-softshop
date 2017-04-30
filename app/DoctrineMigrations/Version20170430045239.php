<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170430045239 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE image_url image_url VARCHAR(999) DEFAULT NULL');
        $this->addSql('ALTER TABLE purchase_history ADD CONSTRAINT FK_3C60BA324584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_3C60BA324584665A ON purchase_history (product_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product CHANGE description description VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE image_url image_url VARCHAR(999) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE purchase_history DROP FOREIGN KEY FK_3C60BA324584665A');
        $this->addSql('DROP INDEX IDX_3C60BA324584665A ON purchase_history');
    }
}
