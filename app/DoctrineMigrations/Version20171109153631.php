<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171109153631 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users ADD firstname VARCHAR(255) DEFAULT NULL, ADD lastname VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', ADD compagny VARCHAR(255) DEFAULT NULL, ADD created DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9444F97DD ON users (phone)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_1483A5E9444F97DD ON users');
        $this->addSql('ALTER TABLE users DROP firstname, DROP lastname, DROP phone, DROP compagny, DROP created');
    }
}
