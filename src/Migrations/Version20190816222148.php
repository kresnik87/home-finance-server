<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190816222148 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE budget_cat (id INT AUTO_INCREMENT NOT NULL, budget_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_3006BB2336ABA6B8 (budget_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, date DATETIME DEFAULT NULL, frecuency VARCHAR(255) DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budget_cat ADD CONSTRAINT FK_3006BB2336ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E312469DE2');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E312469DE2 FOREIGN KEY (category_id) REFERENCES budget_cat (id)');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C136ABA6B8');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C18203A91');
        $this->addSql('DROP INDEX IDX_64C19C18203A91 ON category');
        $this->addSql('DROP INDEX IDX_64C19C136ABA6B8 ON category');
        $this->addSql('ALTER TABLE category ADD name VARCHAR(255) DEFAULT NULL, DROP budget_id, DROP finance_status_id, DROP concept, DROP discr, DROP type, DROP frequency, DROP date, CHANGE amount icon DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E312469DE2');
        $this->addSql('DROP TABLE budget_cat');
        $this->addSql('DROP TABLE operation');
        $this->addSql('ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E312469DE2');
        $this->addSql('ALTER TABLE bill ADD CONSTRAINT FK_7A2119E312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category ADD budget_id INT DEFAULT NULL, ADD finance_status_id INT DEFAULT NULL, ADD discr VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD frequency VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD date DATETIME DEFAULT NULL, CHANGE name concept VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE icon amount DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C136ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C18203A91 FOREIGN KEY (finance_status_id) REFERENCES finance_status (id)');
        $this->addSql('CREATE INDEX IDX_64C19C18203A91 ON category (finance_status_id)');
        $this->addSql('CREATE INDEX IDX_64C19C136ABA6B8 ON category (budget_id)');
    }
}
