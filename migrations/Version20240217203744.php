<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217203744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation_commentaire ADD reclamation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation_commentaire ADD CONSTRAINT FK_7BA4D82D2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('CREATE INDEX IDX_7BA4D82D2D6BA2D9 ON reclamation_commentaire (reclamation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation_commentaire DROP FOREIGN KEY FK_7BA4D82D2D6BA2D9');
        $this->addSql('DROP INDEX IDX_7BA4D82D2D6BA2D9 ON reclamation_commentaire');
        $this->addSql('ALTER TABLE reclamation_commentaire DROP reclamation_id');
    }
}
