<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170429000212 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64966A25B38');
        $this->addSql('DROP INDEX UNIQ_8D93D64966A25B38 ON user');
        $this->addSql('ALTER TABLE user DROP customer_account_id');
        $this->addSql('ALTER TABLE customer_account ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer_account ADD CONSTRAINT FK_61EBF21AA76ED395 FOREIGN KEY (user_id) REFERENCES category (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_61EBF21AA76ED395 ON customer_account (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer_account DROP FOREIGN KEY FK_61EBF21AA76ED395');
        $this->addSql('DROP INDEX UNIQ_61EBF21AA76ED395 ON customer_account');
        $this->addSql('ALTER TABLE customer_account DROP user_id');
        $this->addSql('ALTER TABLE user ADD customer_account_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64966A25B38 FOREIGN KEY (customer_account_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64966A25B38 ON user (customer_account_id)');
    }
}
