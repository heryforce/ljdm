<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240131183004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carousel_accueil (id INT AUTO_INCREMENT NOT NULL, fichier LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE luminosite (id INT AUTO_INCREMENT NOT NULL, libelle TINYTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, plante_id INT NOT NULL, fichier TINYTEXT NOT NULL, INDEX IDX_14B78418177B16E8 (plante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plante (id INT AUTO_INCREMENT NOT NULL, luminosite_id INT DEFAULT NULL, user_id INT NOT NULL, nom TINYTEXT DEFAULT NULL, notes TINYTEXT DEFAULT NULL, bouturage TINYTEXT DEFAULT NULL, arrosage TINYTEXT DEFAULT NULL, nom_latin TINYTEXT DEFAULT NULL, particularites JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', user_affiche TINYINT(1) NOT NULL, maladies TINYTEXT DEFAULT NULL, temporaire TINYINT(1) NOT NULL, INDEX IDX_517A694767DD065F (luminosite_id), INDEX IDX_517A6947A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email TINYTEXT NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, photo TINYTEXT DEFAULT NULL, pseudo TINYTEXT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_plante (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, plante_id INT NOT NULL, nombre INT NOT NULL, INDEX IDX_3428727AA76ED395 (user_id), INDEX IDX_3428727A177B16E8 (plante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418177B16E8 FOREIGN KEY (plante_id) REFERENCES plante (id)');
        $this->addSql('ALTER TABLE plante ADD CONSTRAINT FK_517A694767DD065F FOREIGN KEY (luminosite_id) REFERENCES luminosite (id)');
        $this->addSql('ALTER TABLE plante ADD CONSTRAINT FK_517A6947A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_plante ADD CONSTRAINT FK_3428727AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_plante ADD CONSTRAINT FK_3428727A177B16E8 FOREIGN KEY (plante_id) REFERENCES plante (id)');
        $this->addSql('INSERT INTO luminosite (libelle) VALUES ("Forte"), ("Forte sans lumière directe"), ("Forte ou mi-ombre"), ("Mi-ombre"), ("Mi-ombre ou ombre")');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418177B16E8');
        $this->addSql('ALTER TABLE plante DROP FOREIGN KEY FK_517A694767DD065F');
        $this->addSql('ALTER TABLE plante DROP FOREIGN KEY FK_517A6947A76ED395');
        $this->addSql('ALTER TABLE user_plante DROP FOREIGN KEY FK_3428727AA76ED395');
        $this->addSql('ALTER TABLE user_plante DROP FOREIGN KEY FK_3428727A177B16E8');
        $this->addSql('DROP TABLE carousel_accueil');
        $this->addSql('DROP TABLE luminosite');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE plante');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_plante');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
