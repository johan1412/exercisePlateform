<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200813090241 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_FDCA8C9C41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercice (id INT AUTO_INCREMENT NOT NULL, cours_id INT DEFAULT NULL, instructions LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_E418C74D7ECF78B0 (cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_cours (student_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_75FDF501CB944F1A (student_id), INDEX IDX_75FDF5017ECF78B0 (cours_id), PRIMARY KEY(student_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C41807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exercice ADD CONSTRAINT FK_E418C74D7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE student_cours ADD CONSTRAINT FK_75FDF501CB944F1A FOREIGN KEY (student_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_cours ADD CONSTRAINT FK_75FDF5017ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice DROP FOREIGN KEY FK_E418C74D7ECF78B0');
        $this->addSql('ALTER TABLE student_cours DROP FOREIGN KEY FK_75FDF5017ECF78B0');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C41807E1D');
        $this->addSql('ALTER TABLE student_cours DROP FOREIGN KEY FK_75FDF501CB944F1A');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE exercice');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE student_cours');
    }
}
