<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220313075032 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT DEFAULT NULL, user_id INT NOT NULL, cargo_id INT DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, mark VARCHAR(255) DEFAULT NULL, INDEX IDX_773DE69DA76ED395 (user_id), INDEX IDX_773DE69D813AC380 (cargo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cargo (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D813AC380 FOREIGN KEY (cargo_id) REFERENCES cargo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D813AC380');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA76ED395');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE cargo');
        $this->addSql('DROP TABLE user');
    }
}
