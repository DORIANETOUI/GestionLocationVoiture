<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240722013244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F25E9C96C FOREIGN KEY (code_marque) REFERENCES marque (code_marque)');
        $this->addSql('ALTER TABLE voiture RENAME INDEX idx_e9e2810f3bae6128 TO IDX_E9E2810F25E9C96C');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBB8C25CF7');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBBE73422E');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBF0E20F80');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F25E9C96C');
        $this->addSql('ALTER TABLE voiture RENAME INDEX idx_e9e2810f25e9c96c TO IDX_E9E2810F3BAE6128');
    }
}
