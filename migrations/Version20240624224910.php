<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624224910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `primary` ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP code_user');
        $this->addSql('ALTER TABLE utilisateur ADD PRIMARY KEY (nom)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX `PRIMARY` ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD code_user VARCHAR(9) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD PRIMARY KEY (code_user)');
    }
}
