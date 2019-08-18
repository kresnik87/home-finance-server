<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190816224914 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget_cat ADD category_id INT DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE budget_cat ADD CONSTRAINT FK_3006BB2312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_3006BB2312469DE2 ON budget_cat (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget_cat DROP FOREIGN KEY FK_3006BB2312469DE2');
        $this->addSql('DROP INDEX IDX_3006BB2312469DE2 ON budget_cat');
        $this->addSql('ALTER TABLE budget_cat ADD type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP category_id');
    }
}
