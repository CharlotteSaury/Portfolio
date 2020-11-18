<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118132854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE realization (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, short_desc VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, context VARCHAR(255) NOT NULL, github VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, defense VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realization_techno (realization_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_D5B315AF1A26530A (realization_id), INDEX IDX_D5B315AF51F3C1BC (techno_id), PRIMARY KEY(realization_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE realization_techno ADD CONSTRAINT FK_D5B315AF1A26530A FOREIGN KEY (realization_id) REFERENCES realization (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE realization_techno ADD CONSTRAINT FK_D5B315AF51F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realization_techno DROP FOREIGN KEY FK_D5B315AF1A26530A');
        $this->addSql('DROP TABLE realization');
        $this->addSql('DROP TABLE realization_techno');
    }
}
