<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240722012802 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE voiture ADD code_marque VARCHAR(9) NOT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F3BAE6128 FOREIGN KEY (code_marque) REFERENCES marque (code_marque)');
        $this->addSql('CREATE INDEX IDX_E9E2810F3BAE6128 ON voiture (code_marque)');
    }
    
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F3BAE6128');
        $this->addSql('DROP INDEX IDX_E9E2810F3BAE6128 ON voiture');
        $this->addSql('ALTER TABLE voiture DROP code_marque');
    }
    
}
