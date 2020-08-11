<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200807203918 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B723AF33E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_cours (student_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_75FDF501CB944F1A (student_id), INDEX IDX_75FDF5017ECF78B0 (cours_id), PRIMARY KEY(student_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B0F6A6D5E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_cours ADD CONSTRAINT FK_75FDF501CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_cours ADD CONSTRAINT FK_75FDF5017ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours ADD teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C41807E1D ON cours (teacher_id)');
        $this->addSql('ALTER TABLE exercice ADD cours_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE exercice ADD CONSTRAINT FK_E418C74D7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_E418C74D7ECF78B0 ON exercice (cours_id)');
        $this->addSql('ALTER TABLE user ADD lastname VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_cours DROP FOREIGN KEY FK_75FDF501CB944F1A');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C41807E1D');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_cours');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP INDEX IDX_FDCA8C9C41807E1D ON cours');
        $this->addSql('ALTER TABLE cours DROP teacher_id');
        $this->addSql('ALTER TABLE exercice DROP FOREIGN KEY FK_E418C74D7ECF78B0');
        $this->addSql('DROP INDEX IDX_E418C74D7ECF78B0 ON exercice');
        $this->addSql('ALTER TABLE exercice DROP cours_id');
        $this->addSql('ALTER TABLE user DROP lastname, DROP firstname');
    }
}
