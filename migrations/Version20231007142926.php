<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231007142926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE luminosite CHANGE libelle libelle TINYTEXT NOT NULL');
        $this->addSql('ALTER TABLE photo CHANGE fichier fichier TINYTEXT NOT NULL');
        $this->addSql('ALTER TABLE plante ADD maladies TINYTEXT DEFAULT NULL, CHANGE nom nom TINYTEXT NOT NULL, CHANGE notes notes TINYTEXT DEFAULT NULL, CHANGE arrosage arrosage TINYTEXT DEFAULT NULL, CHANGE bouturage bouturage TINYTEXT DEFAULT NULL, CHANGE nom_latin nom_latin TINYTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user CHANGE photo photo TINYTEXT DEFAULT NULL, CHANGE pseudo pseudo TINYTEXT NOT NULL, CHANGE email text VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6493B8BA7C7 ON user (text)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE luminosite CHANGE libelle libelle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE photo CHANGE fichier fichier VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE plante DROP maladies, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE notes notes LONGTEXT DEFAULT NULL, CHANGE bouturage bouturage VARCHAR(255) DEFAULT NULL, CHANGE arrosage arrosage VARCHAR(255) NOT NULL, CHANGE nom_latin nom_latin VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D6493B8BA7C7 ON user');
        $this->addSql('ALTER TABLE user CHANGE photo photo VARCHAR(255) DEFAULT NULL, CHANGE pseudo pseudo VARCHAR(255) NOT NULL, CHANGE text email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
