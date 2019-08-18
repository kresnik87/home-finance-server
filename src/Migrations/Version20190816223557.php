<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190816223557 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget_cat ADD amount DOUBLE PRECISION DEFAULT NULL, ADD frecuency VARCHAR(255) DEFAULT NULL, ADD start_date DATETIME DEFAULT NULL, ADD active_notif TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE operation ADD finance_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D5E87A6C2 FOREIGN KEY (finance_id) REFERENCES finance_status (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_1981A66D5E87A6C2 ON operation (finance_id)');
        $this->addSql('CREATE INDEX IDX_1981A66D12469DE2 ON operation (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE budget_cat DROP amount, DROP frecuency, DROP start_date, DROP active_notif');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D5E87A6C2');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D12469DE2');
        $this->addSql('DROP INDEX IDX_1981A66D5E87A6C2 ON operation');
        $this->addSql('DROP INDEX IDX_1981A66D12469DE2 ON operation');
        $this->addSql('ALTER TABLE operation DROP finance_id, DROP category_id');
    }
}
