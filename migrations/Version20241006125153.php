<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241006125153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD destination VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE voiture ADD prix_hors_abidjan NUMERIC(10, 2) NOT NULL, CHANGE prix prix_abidjan NUMERIC(10, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBB8C25CF7');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBBE73422E');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBF0E20F80');
        $this->addSql('ALTER TABLE location DROP destination');
        $this->addSql('ALTER TABLE voiture ADD prix NUMERIC(10, 2) NOT NULL, DROP prix_abidjan, DROP prix_hors_abidjan');
    }
}
