<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930020929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE play_date_product (id INT AUTO_INCREMENT NOT NULL, play_date_id INT NOT NULL, product_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_334694F4CE8951DB (play_date_id), INDEX IDX_334694F44584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE play_date_product ADD CONSTRAINT FK_334694F4CE8951DB FOREIGN KEY (play_date_id) REFERENCES play_date (id)');
        $this->addSql('ALTER TABLE play_date_product ADD CONSTRAINT FK_334694F44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE play_date_product DROP FOREIGN KEY FK_334694F4CE8951DB');
        $this->addSql('ALTER TABLE play_date_product DROP FOREIGN KEY FK_334694F44584665A');
        $this->addSql('DROP TABLE play_date_product');
    }
}
