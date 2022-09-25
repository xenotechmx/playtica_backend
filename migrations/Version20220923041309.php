<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923041309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE play_date_visitor DROP FOREIGN KEY FK_2AE971C670BEE6D');
        $this->addSql('ALTER TABLE play_date_visitor DROP FOREIGN KEY FK_2AE971C6CE8951DB');
        $this->addSql('DROP TABLE play_date_visitor');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE play_date_visitor (play_date_id INT NOT NULL, visitor_id INT NOT NULL, INDEX IDX_2AE971C6CE8951DB (play_date_id), INDEX IDX_2AE971C670BEE6D (visitor_id), PRIMARY KEY(play_date_id, visitor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE play_date_visitor ADD CONSTRAINT FK_2AE971C670BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE play_date_visitor ADD CONSTRAINT FK_2AE971C6CE8951DB FOREIGN KEY (play_date_id) REFERENCES play_date (id) ON DELETE CASCADE');
    }
}
