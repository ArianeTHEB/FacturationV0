<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124174828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv ADD rdvfacture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F8674B8C6F4 FOREIGN KEY (rdvfacture_id) REFERENCES rdv (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_10C31F8674B8C6F4 ON rdv (rdvfacture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F8674B8C6F4');
        $this->addSql('DROP INDEX UNIQ_10C31F8674B8C6F4 ON rdv');
        $this->addSql('ALTER TABLE rdv DROP rdvfacture_id');
    }
}
