<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124143143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, relation_id INT DEFAULT NULL, relation_praticien_id INT DEFAULT NULL, date DATE NOT NULL, montant INT NOT NULL, INDEX IDX_10C31F863256915B (relation_id), INDEX IDX_10C31F86DE97FEA9 (relation_praticien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F863256915B FOREIGN KEY (relation_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86DE97FEA9 FOREIGN KEY (relation_praticien_id) REFERENCES praticien (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F863256915B');
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86DE97FEA9');
        $this->addSql('DROP TABLE rdv');
    }
}
