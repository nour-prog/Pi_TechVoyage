<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240216191344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offre_commentaire (id INT AUTO_INCREMENT NOT NULL, avis LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offres (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, published TINYINT(1) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_vols (id INT AUTO_INCREMENT NOT NULL, pourcentage DOUBLE PRECISION NOT NULL, date_debut_promo DATE NOT NULL, date_fin_promo DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, datesoumission DATETIME DEFAULT NULL, est_traite TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation_commentaire (id INT AUTO_INCREMENT NOT NULL, contenu LONGTEXT DEFAULT NULL, date_creation DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vols (id INT AUTO_INCREMENT NOT NULL, duree TIME NOT NULL, datedepart DATETIME NOT NULL, datearrive DATETIME NOT NULL, nbrescale INT NOT NULL, nbrplace INT NOT NULL, classe VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, pointdepart VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE offre_commentaire');
        $this->addSql('DROP TABLE offres');
        $this->addSql('DROP TABLE promo_vols');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reclamation_commentaire');
        $this->addSql('DROP TABLE vols');
    }
}
