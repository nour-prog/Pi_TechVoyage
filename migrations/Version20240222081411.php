<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222081411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_hotel (reservation_id INT NOT NULL, hotel_id INT NOT NULL, INDEX IDX_402C8E7EB83297E7 (reservation_id), INDEX IDX_402C8E7E3243BB18 (hotel_id), PRIMARY KEY(reservation_id, hotel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_hotel ADD CONSTRAINT FK_402C8E7EB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_hotel ADD CONSTRAINT FK_402C8E7E3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hotel ADD reservation_id INT DEFAULT NULL, ADD hotel22_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED934019660 FOREIGN KEY (hotel22_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_3535ED9B83297E7 ON hotel (reservation_id)');
        $this->addSql('CREATE INDEX IDX_3535ED934019660 ON hotel (hotel22_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_hotel DROP FOREIGN KEY FK_402C8E7EB83297E7');
        $this->addSql('ALTER TABLE reservation_hotel DROP FOREIGN KEY FK_402C8E7E3243BB18');
        $this->addSql('DROP TABLE reservation_hotel');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9B83297E7');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED934019660');
        $this->addSql('DROP INDEX IDX_3535ED9B83297E7 ON hotel');
        $this->addSql('DROP INDEX IDX_3535ED934019660 ON hotel');
        $this->addSql('ALTER TABLE hotel DROP reservation_id, DROP hotel22_id');
    }
}
