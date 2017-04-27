<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170427203336 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cart (
                        id      INT AUTO_INCREMENT NOT NULL,
                        user_id INT DEFAULT NULL,
                        userId  INT                NOT NULL,
                        UNIQUE INDEX UNIQ_BA388B764B64DCC (userId),
                        UNIQUE INDEX UNIQ_BA388B7A76ED395 (user_id),
                        PRIMARY KEY (id)
                      )
                        DEFAULT CHARACTER SET utf8
                        COLLATE utf8_unicode_ci
                        ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9C370B71 FOREIGN KEY (categoryId) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD9C370B71 ON product (categoryId)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cart');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD9C370B71');
        $this->addSql('DROP INDEX IDX_D34A04AD9C370B71 ON product');
    }
}
