<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309054922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contacts (id INT IDENTITY NOT NULL, name NVARCHAR(50) NOT NULL, email NVARCHAR(180) NOT NULL, message NVARCHAR(255) NOT NULL, date_created DATETIME2(6), date_last_updated DATETIME2(6), PRIMARY KEY (id))');
        $this->addSql('CREATE TABLE [users] (id INT IDENTITY NOT NULL, username NVARCHAR(180) NOT NULL, email NVARCHAR(180) NOT NULL, first_name NVARCHAR(50) NOT NULL, last_name NVARCHAR(180) NOT NULL, roles NVARCHAR(255), password NVARCHAR(255) NOT NULL, api_token NVARCHAR(255), date_created DATETIME2(6), date_last_updated DATETIME2(6), PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON [users] (username) WHERE username IS NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_accessadmin');
        $this->addSql('CREATE SCHEMA db_backupoperator');
        $this->addSql('CREATE SCHEMA db_datareader');
        $this->addSql('CREATE SCHEMA db_datawriter');
        $this->addSql('CREATE SCHEMA db_ddladmin');
        $this->addSql('CREATE SCHEMA db_denydatareader');
        $this->addSql('CREATE SCHEMA db_denydatawriter');
        $this->addSql('CREATE SCHEMA db_owner');
        $this->addSql('CREATE SCHEMA db_securityadmin');
        $this->addSql('CREATE SCHEMA dbo');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE [users]');
    }
}
