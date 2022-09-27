<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927020421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fare ADD branch_id INT NOT NULL');
        $this->addSql('ALTER TABLE fare ADD CONSTRAINT FK_56CD5877DCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id)');
        $this->addSql('CREATE INDEX IDX_56CD5877DCD6CC49 ON fare (branch_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fare DROP FOREIGN KEY FK_56CD5877DCD6CC49');
        $this->addSql('DROP INDEX IDX_56CD5877DCD6CC49 ON fare');
        $this->addSql('ALTER TABLE fare DROP branch_id');
    }
}
