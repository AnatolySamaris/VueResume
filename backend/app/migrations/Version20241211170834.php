<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211170834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE education (id SERIAL NOT NULL, level_id INT NOT NULL, place VARCHAR(512) DEFAULT NULL, faculty VARCHAR(512) DEFAULT NULL, specialty VARCHAR(512) DEFAULT NULL, end_year DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DB0A5ED25FB14BA7 ON education (level_id)');
        $this->addSql('COMMENT ON COLUMN education.end_year IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE education_level (id SERIAL NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE resume (id SERIAL NOT NULL, status_id INT NOT NULL, name VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, age INT NOT NULL, city VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, birthday DATE NOT NULL, salary DOUBLE PRECISION NOT NULL, about TEXT NOT NULL, skills VARCHAR(255) NOT NULL, photo VARCHAR(2048) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_60C1D0A06BF700BD ON resume (status_id)');
        $this->addSql('COMMENT ON COLUMN resume.birthday IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE resume_education (resume_id INT NOT NULL, education_id INT NOT NULL, PRIMARY KEY(resume_id, education_id))');
        $this->addSql('CREATE INDEX IDX_1673BF6BD262AF09 ON resume_education (resume_id)');
        $this->addSql('CREATE INDEX IDX_1673BF6B2CA1BD71 ON resume_education (education_id)');
        $this->addSql('CREATE TABLE resume_status (id SERIAL NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE education ADD CONSTRAINT FK_DB0A5ED25FB14BA7 FOREIGN KEY (level_id) REFERENCES education_level (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume ADD CONSTRAINT FK_60C1D0A06BF700BD FOREIGN KEY (status_id) REFERENCES resume_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume_education ADD CONSTRAINT FK_1673BF6BD262AF09 FOREIGN KEY (resume_id) REFERENCES resume (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE resume_education ADD CONSTRAINT FK_1673BF6B2CA1BD71 FOREIGN KEY (education_id) REFERENCES education (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE education DROP CONSTRAINT FK_DB0A5ED25FB14BA7');
        $this->addSql('ALTER TABLE resume DROP CONSTRAINT FK_60C1D0A06BF700BD');
        $this->addSql('ALTER TABLE resume_education DROP CONSTRAINT FK_1673BF6BD262AF09');
        $this->addSql('ALTER TABLE resume_education DROP CONSTRAINT FK_1673BF6B2CA1BD71');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE education_level');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP TABLE resume_education');
        $this->addSql('DROP TABLE resume_status');
    }
}
