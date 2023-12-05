<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123112408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, quantity_sold INT DEFAULT NULL, quantity_prepared INT DEFAULT NULL, quantity_real INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD number_order VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stock');
        $this->addSql('ALTER TABLE `order` DROP number_order');
        $this->addSql('ALTER TABLE product ADD user_id INT NOT NULL');
    }
}
