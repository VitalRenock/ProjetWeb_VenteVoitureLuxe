<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319134314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_color (car_id INT NOT NULL, color_id INT NOT NULL, INDEX IDX_B9FDCD3EC3C6F69F (car_id), INDEX IDX_B9FDCD3E7ADA1FB5 (color_id), PRIMARY KEY(car_id, color_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_color ADD CONSTRAINT FK_B9FDCD3EC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car_color ADD CONSTRAINT FK_B9FDCD3E7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car_color DROP FOREIGN KEY FK_B9FDCD3EC3C6F69F');
        $this->addSql('ALTER TABLE car_color DROP FOREIGN KEY FK_B9FDCD3E7ADA1FB5');
        $this->addSql('DROP TABLE car_color');
    }
}
