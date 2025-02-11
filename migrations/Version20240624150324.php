<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624150324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_100285583BAE6128');
        $this->addSql('DROP INDEX IDX_100285583BAE6128 ON modele');
        $this->addSql('ALTER TABLE modele ADD code_marque VARCHAR(9) NOT NULL, DROP codeMarque');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_1002855825E9C96C FOREIGN KEY (code_marque) REFERENCES marque (code_marque)');
        $this->addSql('CREATE INDEX IDX_1002855825E9C96C ON modele (code_marque)');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F3BAE6128');
        $this->addSql('DROP INDEX IDX_E9E2810F3BAE6128 ON voiture');
        $this->addSql('ALTER TABLE voiture ADD code_marque VARCHAR(9) NOT NULL, DROP codeMarque');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F25E9C96C FOREIGN KEY (code_marque) REFERENCES marque (code_marque)');
        $this->addSql('CREATE INDEX IDX_E9E2810F25E9C96C ON voiture (code_marque)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE modele DROP FOREIGN KEY FK_1002855825E9C96C');
        $this->addSql('DROP INDEX IDX_1002855825E9C96C ON modele');
        $this->addSql('ALTER TABLE modele ADD codeMarque VARCHAR(9) DEFAULT NULL, DROP code_marque');
        $this->addSql('ALTER TABLE modele ADD CONSTRAINT FK_100285583BAE6128 FOREIGN KEY (codeMarque) REFERENCES marque (code_marque) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_100285583BAE6128 ON modele (codeMarque)');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F25E9C96C');
        $this->addSql('DROP INDEX IDX_E9E2810F25E9C96C ON voiture');
        $this->addSql('ALTER TABLE voiture ADD codeMarque VARCHAR(9) DEFAULT NULL, DROP code_marque');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F3BAE6128 FOREIGN KEY (codeMarque) REFERENCES marque (code_marque) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E9E2810F3BAE6128 ON voiture (codeMarque)');
    }
}
