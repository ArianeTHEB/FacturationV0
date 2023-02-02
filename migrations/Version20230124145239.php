<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124145239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, info_praticien_id INT DEFAULT NULL, info_patient_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_FE866410E4C51CC (info_praticien_id), INDEX IDX_FE866410334CAED5 (info_patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410E4C51CC FOREIGN KEY (info_praticien_id) REFERENCES praticien (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410334CAED5 FOREIGN KEY (info_patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE rdv ADD facture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F867F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('CREATE INDEX IDX_10C31F867F2DEE08 ON rdv (facture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F867F2DEE08');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410E4C51CC');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410334CAED5');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP INDEX IDX_10C31F867F2DEE08 ON rdv');
        $this->addSql('ALTER TABLE rdv DROP facture_id');
    }
}
