<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624154100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD code_localite VARCHAR(9) NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455C569C82 FOREIGN KEY (code_localite) REFERENCES localite (code_localite)');
        $this->addSql('CREATE INDEX IDX_C7440455C569C82 ON client (code_localite)');
        $this->addSql('ALTER TABLE modele CHANGE code_marque code_marque VARCHAR(9) DEFAULT NULL');
        $this->addSql('ALTER TABLE voiture CHANGE code_marque code_marque VARCHAR(9) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455C569C82');
        $this->addSql('DROP INDEX IDX_C7440455C569C82 ON client');
        $this->addSql('ALTER TABLE client DROP code_localite');
        $this->addSql('ALTER TABLE modele CHANGE code_marque code_marque VARCHAR(9) NOT NULL');
        $this->addSql('ALTER TABLE voiture CHANGE code_marque code_marque VARCHAR(9) NOT NULL');
    }
}
