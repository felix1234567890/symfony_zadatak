<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201017075602 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role_movie (role_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_EA821A40D60322AC (role_id), INDEX IDX_EA821A408F93B6FC (movie_id), PRIMARY KEY(role_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_movie ADD CONSTRAINT FK_EA821A40D60322AC FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_movie ADD CONSTRAINT FK_EA821A408F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roles DROP FOREIGN KEY FK_B63E2EC78F93B6FC');
        $this->addSql('DROP INDEX IDX_B63E2EC78F93B6FC ON roles');
        $this->addSql('ALTER TABLE roles DROP movie_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE role_movie');
        $this->addSql('ALTER TABLE roles ADD movie_id INT NOT NULL');
        $this->addSql('ALTER TABLE roles ADD CONSTRAINT FK_B63E2EC78F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B63E2EC78F93B6FC ON roles (movie_id)');
    }
}
