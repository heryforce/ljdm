<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230722171602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_plante (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, plante_id INT NOT NULL, nombre INT NOT NULL, INDEX IDX_3428727AA76ED395 (user_id), INDEX IDX_3428727A177B16E8 (plante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_plante ADD CONSTRAINT FK_3428727AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_plante ADD CONSTRAINT FK_3428727A177B16E8 FOREIGN KEY (plante_id) REFERENCES plante (id)');
        $this->addSql('ALTER TABLE plante DROP FOREIGN KEY FK_517A6947A76ED395');
        $this->addSql('DROP INDEX IDX_517A6947A76ED395 ON plante');
        $this->addSql('ALTER TABLE plante DROP user_id, DROP arrosage_nb, CHANGE arrosage_str arrosage VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_plante DROP FOREIGN KEY FK_3428727AA76ED395');
        $this->addSql('ALTER TABLE user_plante DROP FOREIGN KEY FK_3428727A177B16E8');
        $this->addSql('DROP TABLE user_plante');
        $this->addSql('ALTER TABLE plante ADD user_id INT NOT NULL, ADD arrosage_nb INT NOT NULL, CHANGE arrosage arrosage_str VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE plante ADD CONSTRAINT FK_517A6947A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_517A6947A76ED395 ON plante (user_id)');
    }
}
