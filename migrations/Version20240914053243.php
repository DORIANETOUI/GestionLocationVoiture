<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240914053243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE location CHANGE code_chauffeur code_chauffeur VARCHAR(9) DEFAULT NULL');
    }

    public function down(Schema $schema): void
{
    $this->addSql('ALTER TABLE location CHANGE code_chauffeur code_chauffeur VARCHAR(9) NOT NULL');
}
}
