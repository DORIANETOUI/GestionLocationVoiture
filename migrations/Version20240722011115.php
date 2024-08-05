<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240722011115 extends AbstractMigration
{
    public function up(Schema $schema): void
{
    // Ajoutez la colonne code_marque à la table voiture
    $this->addSql('ALTER TABLE voiture ADD code_marque VARCHAR(9) NOT NULL');

    // Ajoutez la contrainte de clé étrangère
    $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F3BAE6128 FOREIGN KEY (code_marque) REFERENCES marque (code_marque)');

    // Créez un index pour la colonne code_marque
    $this->addSql('CREATE INDEX IDX_E9E2810F3BAE6128 ON voiture (code_marque)');
}

public function down(Schema $schema): void
{
    // Supprimez la contrainte de clé étrangère
    $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F3BAE6128');

    // Supprimez l'index
    $this->addSql('DROP INDEX IDX_E9E2810F3BAE6128 ON voiture');

    // Supprimez la colonne code_marque
    $this->addSql('ALTER TABLE voiture DROP code_marque');
}

}
