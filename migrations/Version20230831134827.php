<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230831134827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, description LONGTEXT DEFAULT NULL, color VARCHAR(6) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_tag_game (game_tag_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_6660711CC7E7CED9 (game_tag_id), INDEX IDX_6660711CE48FD905 (game_id), PRIMARY KEY(game_tag_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_tag_game ADD CONSTRAINT FK_6660711CC7E7CED9 FOREIGN KEY (game_tag_id) REFERENCES game_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_tag_game ADD CONSTRAINT FK_6660711CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_tag_game DROP FOREIGN KEY FK_6660711CC7E7CED9');
        $this->addSql('ALTER TABLE game_tag_game DROP FOREIGN KEY FK_6660711CE48FD905');
        $this->addSql('DROP TABLE game_tag');
        $this->addSql('DROP TABLE game_tag_game');
    }
}
