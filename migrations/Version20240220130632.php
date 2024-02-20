<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220130632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forum_commentaire ADD publication_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE forum_commentaire ADD CONSTRAINT FK_61C4EB1E38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_61C4EB1E38B217A7 ON forum_commentaire (publication_id)');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779BA9CD190');
        $this->addSql('DROP INDEX IDX_AF3C6779BA9CD190 ON publication');
        $this->addSql('ALTER TABLE publication DROP commentaire_id, DROP created_at, DROP updated_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forum_commentaire DROP FOREIGN KEY FK_61C4EB1E38B217A7');
        $this->addSql('DROP INDEX IDX_61C4EB1E38B217A7 ON forum_commentaire');
        $this->addSql('ALTER TABLE forum_commentaire DROP publication_id');
        $this->addSql('ALTER TABLE publication ADD commentaire_id INT NOT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES forum_commentaire (id)');
        $this->addSql('CREATE INDEX IDX_AF3C6779BA9CD190 ON publication (commentaire_id)');
    }
}
