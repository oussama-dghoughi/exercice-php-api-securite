<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241013182802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
{
    // Suppression des tables en tenant compte des dépendances
    $this->addSql('DROP TABLE IF EXISTS project CASCADE');
    $this->addSql('DROP TABLE IF EXISTS society CASCADE');
    $this->addSql('DROP TABLE IF EXISTS app_user CASCADE');
}

public function down(Schema $schema): void
{
    // Créer les tables dans l'ordre des dépendances
    $this->addSql('CREATE TABLE app_user (
        id SERIAL NOT NULL,
        email VARCHAR(180) NOT NULL,
        roles JSON NOT NULL,
        password VARCHAR(255) NOT NULL,
        CONSTRAINT UNIQ_IDENTIFIER_EMAIL UNIQUE (email),
        PRIMARY KEY(id)
    )');

    $this->addSql('CREATE TABLE society (
        id SERIAL NOT NULL,
        name VARCHAR(255) NOT NULL,
        siret VARCHAR(14) NOT NULL,
        address VARCHAR(255) NOT NULL,
        PRIMARY KEY(id)
    )');

    $this->addSql('CREATE TABLE project (
        id SERIAL NOT NULL,
        society_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
        PRIMARY KEY(id),
        CONSTRAINT fk_2fb3d0eee6389d24 FOREIGN KEY (society_id) REFERENCES society (id) NOT DEFERRABLE INITIALLY IMMEDIATE
    )');
}
}
