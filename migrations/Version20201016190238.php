<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201016190238 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roles ADD movie_id INT NOT NULL');
        $this->addSql('ALTER TABLE roles ADD CONSTRAINT FK_B63E2EC78F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
        $this->addSql('CREATE INDEX IDX_B63E2EC78F93B6FC ON roles (movie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roles DROP FOREIGN KEY FK_B63E2EC78F93B6FC');
        $this->addSql('DROP INDEX IDX_B63E2EC78F93B6FC ON roles');
        $this->addSql('ALTER TABLE roles DROP movie_id');
    }
}
