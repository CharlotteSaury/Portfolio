<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125142030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expectation (id INT AUTO_INCREMENT NOT NULL, realization_id INT NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_A2B998F11A26530A (realization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, realization_id INT NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_5E3DE4771A26530A (realization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expectation ADD CONSTRAINT FK_A2B998F11A26530A FOREIGN KEY (realization_id) REFERENCES realization (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4771A26530A FOREIGN KEY (realization_id) REFERENCES realization (id)');
        $this->addSql('ALTER TABLE realization DROP skills, DROP expectations');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE expectation');
        $this->addSql('DROP TABLE skill');
        $this->addSql('ALTER TABLE realization ADD skills LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', ADD expectations LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
