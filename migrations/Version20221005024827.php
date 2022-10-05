<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221005024827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adult_fare (id INT AUTO_INCREMENT NOT NULL, branch_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, days INT NOT NULL, adults INT NOT NULL, INDEX IDX_29FFFE53DCD6CC49 (branch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE branch (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, phone VARCHAR(50) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, max_visitors INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fare (id INT AUTO_INCREMENT NOT NULL, branch_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, days INT NOT NULL, time INT NOT NULL, INDEX IDX_56CD5877DCD6CC49 (branch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE play_date (id INT AUTO_INCREMENT NOT NULL, branch_id INT NOT NULL, starts_at TIME NOT NULL, ends_at TIME NOT NULL, payment_status INT NOT NULL, date DATE NOT NULL, INDEX IDX_A19BC9ABDCD6CC49 (branch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE play_date_product (id INT AUTO_INCREMENT NOT NULL, play_date_id INT NOT NULL, product_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, INDEX IDX_334694F4CE8951DB (play_date_id), INDEX IDX_334694F44584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE play_date_visitor (id INT AUTO_INCREMENT NOT NULL, play_date_id INT NOT NULL, visitor_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_2AE971C6CE8951DB (play_date_id), INDEX IDX_2AE971C670BEE6D (visitor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, branch_id INT NOT NULL, name VARCHAR(140) NOT NULL, price DOUBLE PRECISION NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, INDEX IDX_D34A04ADDCD6CC49 (branch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, branch_id INT NOT NULL, type INT NOT NULL, open_time TIME DEFAULT NULL, close_time TIME DEFAULT NULL, starts_at DATE DEFAULT NULL, ends_at DATE DEFAULT NULL, INDEX IDX_5A3811FBDCD6CC49 (branch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, api_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitor (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, type INT DEFAULT 1 NOT NULL, birthday DATE NOT NULL, gender INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adult_fare ADD CONSTRAINT FK_29FFFE53DCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id)');
        $this->addSql('ALTER TABLE fare ADD CONSTRAINT FK_56CD5877DCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id)');
        $this->addSql('ALTER TABLE play_date ADD CONSTRAINT FK_A19BC9ABDCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id)');
        $this->addSql('ALTER TABLE play_date_product ADD CONSTRAINT FK_334694F4CE8951DB FOREIGN KEY (play_date_id) REFERENCES play_date (id)');
        $this->addSql('ALTER TABLE play_date_product ADD CONSTRAINT FK_334694F44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE play_date_visitor ADD CONSTRAINT FK_2AE971C6CE8951DB FOREIGN KEY (play_date_id) REFERENCES play_date (id)');
        $this->addSql('ALTER TABLE play_date_visitor ADD CONSTRAINT FK_2AE971C670BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADDCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBDCD6CC49 FOREIGN KEY (branch_id) REFERENCES branch (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adult_fare DROP FOREIGN KEY FK_29FFFE53DCD6CC49');
        $this->addSql('ALTER TABLE fare DROP FOREIGN KEY FK_56CD5877DCD6CC49');
        $this->addSql('ALTER TABLE play_date DROP FOREIGN KEY FK_A19BC9ABDCD6CC49');
        $this->addSql('ALTER TABLE play_date_product DROP FOREIGN KEY FK_334694F4CE8951DB');
        $this->addSql('ALTER TABLE play_date_product DROP FOREIGN KEY FK_334694F44584665A');
        $this->addSql('ALTER TABLE play_date_visitor DROP FOREIGN KEY FK_2AE971C6CE8951DB');
        $this->addSql('ALTER TABLE play_date_visitor DROP FOREIGN KEY FK_2AE971C670BEE6D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADDCD6CC49');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBDCD6CC49');
        $this->addSql('DROP TABLE adult_fare');
        $this->addSql('DROP TABLE branch');
        $this->addSql('DROP TABLE fare');
        $this->addSql('DROP TABLE play_date');
        $this->addSql('DROP TABLE play_date_product');
        $this->addSql('DROP TABLE play_date_visitor');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE visitor');
    }
}
