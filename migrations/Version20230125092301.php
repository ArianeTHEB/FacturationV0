<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125092301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410334CAED5');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410E4C51CC');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F863256915B');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F8674B8C6F4');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F867F2DEE08');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86DE97FEA9');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE rdv');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, info_praticien_id INT DEFAULT NULL, info_patient_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_FE866410E4C51CC (info_praticien_id), INDEX IDX_FE866410334CAED5 (info_patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, relation_id INT DEFAULT NULL, relation_praticien_id INT DEFAULT NULL, facture_id INT DEFAULT NULL, rdvfacture_id INT DEFAULT NULL, date DATE NOT NULL, montant INT NOT NULL, UNIQUE INDEX UNIQ_10C31F8674B8C6F4 (rdvfacture_id), INDEX IDX_10C31F863256915B (relation_id), INDEX IDX_10C31F86DE97FEA9 (relation_praticien_id), INDEX IDX_10C31F867F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410334CAED5 FOREIGN KEY (info_patient_id) REFERENCES patient (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410E4C51CC FOREIGN KEY (info_praticien_id) REFERENCES praticien (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F863256915B FOREIGN KEY (relation_id) REFERENCES patient (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F8674B8C6F4 FOREIGN KEY (rdvfacture_id) REFERENCES rdv (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F867F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86DE97FEA9 FOREIGN KEY (relation_praticien_id) REFERENCES praticien (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
