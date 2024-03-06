<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305175826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offres DROP review_total, DROP review_value, DROP ueser_idreviews_list');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offres ADD review_total INT DEFAULT NULL, ADD review_value DOUBLE PRECISION DEFAULT NULL, ADD ueser_idreviews_list JSON DEFAULT NULL COMMENT \'(DC2Type:json)\'');
    }
}
