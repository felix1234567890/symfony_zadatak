<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201018081117 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE person_movie');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE person_movie (person_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_B168EDAB217BBB47 (person_id), INDEX IDX_B168EDAB8F93B6FC (movie_id), PRIMARY KEY(person_id, movie_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE person_movie ADD CONSTRAINT FK_B168EDAB217BBB47 FOREIGN KEY (person_id) REFERENCES persons (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE person_movie ADD CONSTRAINT FK_B168EDAB8F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
