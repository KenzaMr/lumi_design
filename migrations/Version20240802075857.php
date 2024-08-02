<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240802075857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'ajout base de données';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD name VARCHAR(50) NOT NULL, ADD prenom VARCHAR(50) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD code_postal INT NOT NULL, ADD ville VARCHAR(50) NOT NULL, ADD numero_tel INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP name, DROP prenom, DROP adresse, DROP code_postal, DROP ville, DROP numero_tel');
    }
}
