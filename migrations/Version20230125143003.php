<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125143003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, praticien_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, rdv_id INT DEFAULT NULL, date DATE NOT NULL, montant INT DEFAULT NULL, INDEX IDX_FE8664102391866B (praticien_id), INDEX IDX_FE8664106B899279 (patient_id), UNIQUE INDEX UNIQ_FE8664104CCE3F86 (rdv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664102391866B FOREIGN KEY (praticien_id) REFERENCES praticien (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664106B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664104CCE3F86 FOREIGN KEY (rdv_id) REFERENCES rdv (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664102391866B');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664106B899279');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664104CCE3F86');
        $this->addSql('DROP TABLE facture');
    }
}
