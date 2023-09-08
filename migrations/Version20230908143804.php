<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908143804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item_trade (id INT AUTO_INCREMENT NOT NULL, first_item_id INT NOT NULL, second_item_id INT NOT NULL, trade_date DATE NOT NULL, return_date DATE DEFAULT NULL, is_proposal TINYINT(1) NOT NULL, INDEX IDX_54BD58B61E33EA2 (first_item_id), INDEX IDX_54BD58B652DD233 (second_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_trade ADD CONSTRAINT FK_54BD58B61E33EA2 FOREIGN KEY (first_item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item_trade ADD CONSTRAINT FK_54BD58B652DD233 FOREIGN KEY (second_item_id) REFERENCES item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_trade DROP FOREIGN KEY FK_54BD58B61E33EA2');
        $this->addSql('ALTER TABLE item_trade DROP FOREIGN KEY FK_54BD58B652DD233');
        $this->addSql('DROP TABLE item_trade');
    }
}
