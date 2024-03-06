<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305175725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offer_review (id INT AUTO_INCREMENT NOT NULL, offer_list_id INT DEFAULT NULL, value INT NOT NULL, user_id VARCHAR(255) NOT NULL, INDEX IDX_A016F6679CA6D082 (offer_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offer_review ADD CONSTRAINT FK_A016F6679CA6D082 FOREIGN KEY (offer_list_id) REFERENCES offres (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer_review DROP FOREIGN KEY FK_A016F6679CA6D082');
        $this->addSql('DROP TABLE offer_review');
    }
}
