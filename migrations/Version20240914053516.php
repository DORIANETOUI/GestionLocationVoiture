<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240914053516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chauffeur CHANGE nom_chauffeur nom_chauffeur VARCHAR(255) NOT NULL, CHANGE prenom_chauffeur prenom_chauffeur VARCHAR(255) NOT NULL, CHANGE adresse adresse VARCHAR(255) NOT NULL, CHANGE contact contact VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chauffeur CHANGE nom_chauffeur nom_chauffeur VARCHAR(255) DEFAULT NULL, CHANGE prenom_chauffeur prenom_chauffeur VARCHAR(255) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL, CHANGE contact contact VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBB8C25CF7');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBBE73422E');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBF0E20F80');
    }
}
