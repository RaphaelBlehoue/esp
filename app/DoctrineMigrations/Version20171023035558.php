<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171023035558 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, online TINYINT(1) DEFAULT NULL, draft INT DEFAULT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_472B783A989D9B62 (slug), INDEX IDX_472B783AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C166D1F9C');
        $this->addSql('DROP INDEX IDX_6A2CA10C166D1F9C ON media');
        $this->addSql('ALTER TABLE media CHANGE project_id gallery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C4E7AF8F ON media (gallery_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C4E7AF8F');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP INDEX IDX_6A2CA10C4E7AF8F ON media');
        $this->addSql('ALTER TABLE media CHANGE gallery_id project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C166D1F9C ON media (project_id)');
    }
}
