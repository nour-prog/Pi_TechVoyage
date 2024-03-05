<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305151541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_voiture ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE location_voiture ADD CONSTRAINT FK_7A792ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7A792ABA76ED395 ON location_voiture (user_id)');
        $this->addSql('ALTER TABLE publication ADD image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication DROP image');
        $this->addSql('ALTER TABLE location_voiture DROP FOREIGN KEY FK_7A792ABA76ED395');
        $this->addSql('DROP INDEX IDX_7A792ABA76ED395 ON location_voiture');
        $this->addSql('ALTER TABLE location_voiture DROP user_id');
    }
}
