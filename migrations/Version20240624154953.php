<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624154953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location ADD code_client VARCHAR(9) NOT NULL, ADD immatriculation VARCHAR(9) NOT NULL, ADD code_chauffeur VARCHAR(9) NOT NULL');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBB8C25CF7 FOREIGN KEY (code_client) REFERENCES client (code_client)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBBE73422E FOREIGN KEY (immatriculation) REFERENCES voiture (immatriculation)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBF0E20F80 FOREIGN KEY (code_chauffeur) REFERENCES chauffeur (code_chauffeur)');
        $this->addSql('CREATE INDEX IDX_5E9E89CBB8C25CF7 ON location (code_client)');
        $this->addSql('CREATE INDEX IDX_5E9E89CBBE73422E ON location (immatriculation)');
        $this->addSql('CREATE INDEX IDX_5E9E89CBF0E20F80 ON location (code_chauffeur)');
        $this->addSql('ALTER TABLE modele ADD code_marque VARCHAR(9) NOT NULL');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_1002855825E9C96C FOREIGN KEY (code_marque) REFERENCES marque (code_marque)');
        $this->addSql('CREATE INDEX IDX_1002855825E9C96C ON modele (code_marque)');
        $this->addSql('ALTER TABLE voiture ADD code_marque VARCHAR(9) NOT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F25E9C96C FOREIGN KEY (code_marque) REFERENCES marque (code_marque)');
        $this->addSql('CREATE INDEX IDX_E9E2810F25E9C96C ON voiture (code_marque)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBB8C25CF7');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBBE73422E');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBF0E20F80');
        $this->addSql('DROP INDEX IDX_5E9E89CBB8C25CF7 ON location');
        $this->addSql('DROP INDEX IDX_5E9E89CBBE73422E ON location');
        $this->addSql('DROP INDEX IDX_5E9E89CBF0E20F80 ON location');
        $this->addSql('ALTER TABLE location DROP code_client, DROP immatriculation, DROP code_chauffeur');
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_1002855825E9C96C');
        $this->addSql('DROP INDEX IDX_1002855825E9C96C ON modele');
        $this->addSql('ALTER TABLE modele DROP code_marque');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F25E9C96C');
        $this->addSql('DROP INDEX IDX_E9E2810F25E9C96C ON voiture');
        $this->addSql('ALTER TABLE voiture DROP code_marque');
    }
}
