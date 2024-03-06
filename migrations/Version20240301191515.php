<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301191515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre_commentaire ADD offres_id INT NOT NULL, ADD parent_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE offre_commentaire ADD CONSTRAINT FK_2CD9E29C6C83CD9F FOREIGN KEY (offres_id) REFERENCES offres (id)');
        $this->addSql('ALTER TABLE offre_commentaire ADD CONSTRAINT FK_2CD9E29C727ACA70 FOREIGN KEY (parent_id) REFERENCES offre_commentaire (id)');
        $this->addSql('CREATE INDEX IDX_2CD9E29C6C83CD9F ON offre_commentaire (offres_id)');
        $this->addSql('CREATE INDEX IDX_2CD9E29C727ACA70 ON offre_commentaire (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre_commentaire DROP FOREIGN KEY FK_2CD9E29C6C83CD9F');
        $this->addSql('ALTER TABLE offre_commentaire DROP FOREIGN KEY FK_2CD9E29C727ACA70');
        $this->addSql('DROP INDEX IDX_2CD9E29C6C83CD9F ON offre_commentaire');
        $this->addSql('DROP INDEX IDX_2CD9E29C727ACA70 ON offre_commentaire');
        $this->addSql('ALTER TABLE offre_commentaire DROP offres_id, DROP parent_id, DROP active');
    }
}
