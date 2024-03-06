<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218182334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_voiture ADD voiture_id INT NOT NULL');
        $this->addSql('ALTER TABLE location_voiture ADD CONSTRAINT FK_7A792AB181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7A792AB181A8BA ON location_voiture (voiture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_voiture DROP FOREIGN KEY FK_7A792AB181A8BA');
        $this->addSql('DROP INDEX UNIQ_7A792AB181A8BA ON location_voiture');
        $this->addSql('ALTER TABLE location_voiture DROP voiture_id');
    }
}
