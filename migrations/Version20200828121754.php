<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828121754 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stats (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, exercice_id INT NOT NULL, success TINYINT(1) NOT NULL, tries INT NOT NULL, INDEX IDX_574767AACB944F1A (student_id), INDEX IDX_574767AA89D40298 (exercice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stats ADD CONSTRAINT FK_574767AACB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stats ADD CONSTRAINT FK_574767AA89D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stats');
    }
}
