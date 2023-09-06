<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230831140219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, description LONGTEXT DEFAULT NULL, color VARCHAR(6) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_game (category_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_A8B04BCB12469DE2 (category_id), INDEX IDX_A8B04BCBE48FD905 (game_id), PRIMARY KEY(category_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_game ADD CONSTRAINT FK_A8B04BCB12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_game ADD CONSTRAINT FK_A8B04BCBE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_tag_game DROP FOREIGN KEY FK_6660711CC7E7CED9');
        $this->addSql('ALTER TABLE game_tag_game DROP FOREIGN KEY FK_6660711CE48FD905');
        $this->addSql('DROP TABLE game_tag');
        $this->addSql('DROP TABLE game_tag_game');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, color VARCHAR(6) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE game_tag_game (game_tag_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_6660711CC7E7CED9 (game_tag_id), INDEX IDX_6660711CE48FD905 (game_id), PRIMARY KEY(game_tag_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE game_tag_game ADD CONSTRAINT FK_6660711CC7E7CED9 FOREIGN KEY (game_tag_id) REFERENCES game_tag (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_tag_game ADD CONSTRAINT FK_6660711CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_game DROP FOREIGN KEY FK_A8B04BCB12469DE2');
        $this->addSql('ALTER TABLE category_game DROP FOREIGN KEY FK_A8B04BCBE48FD905');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_game');
    }
}
