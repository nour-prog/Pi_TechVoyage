<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306230848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offres ADD vol_id INT DEFAULT NULL, ADD location_voiture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC35449F2BFB7A FOREIGN KEY (vol_id) REFERENCES vols (id)');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC3544B8A9A965 FOREIGN KEY (location_voiture_id) REFERENCES location_voiture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C6AC35449F2BFB7A ON offres (vol_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C6AC3544B8A9A965 ON offres (location_voiture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offres DROP FOREIGN KEY FK_C6AC35449F2BFB7A');
        $this->addSql('ALTER TABLE offres DROP FOREIGN KEY FK_C6AC3544B8A9A965');
        $this->addSql('DROP INDEX UNIQ_C6AC35449F2BFB7A ON offres');
        $this->addSql('DROP INDEX UNIQ_C6AC3544B8A9A965 ON offres');
        $this->addSql('ALTER TABLE offres DROP vol_id, DROP location_voiture_id');
    }
}
