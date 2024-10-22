<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190815145640 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE home ADD budget_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE home ADD CONSTRAINT FK_71D60CD036ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_71D60CD036ABA6B8 ON home (budget_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE home DROP FOREIGN KEY FK_71D60CD036ABA6B8');
        $this->addSql('DROP INDEX UNIQ_71D60CD036ABA6B8 ON home');
        $this->addSql('ALTER TABLE home DROP budget_id');
    }
}
