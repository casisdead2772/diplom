<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20210603062146 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE meet_urls');
        $this->addSql('ALTER TABLE answers CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE countries CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE currencies CHANGE type type TINYINT NOT NULL, CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE files CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE language_grades CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE languages CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE lesson_reserves CHANGE reserved_time reserved_time timestamp(6) DEFAULT NULL, CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE lessons ADD meet_url VARCHAR(255) DEFAULT NULL, CHANGE lesson_time lesson_time timestamp(6) DEFAULT NULL, CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE orders CHANGE type type TINYINT NOT NULL, CHANGE status status TINYINT, CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE questions CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE quizzes CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE roles CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE specialties CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE teacher_informations CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE user_groups CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE user_informations CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0, CHANGE deleted_at deleted_at timestamp DEFAULT 0');
        $this->addSql('ALTER TABLE wallets CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE zoom_meet_sessions CHANGE started_time started_time timestamp(6) DEFAULT NULL, CHANGE finished_time finished_time timestamp(6) DEFAULT NULL, CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
        $this->addSql('ALTER TABLE zoom_meets CHANGE created_at created_at timestamp(6) DEFAULT 0, CHANGE updated_at updated_at timestamp(6) DEFAULT 0');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE meet_urls (id INT AUTO_INCREMENT NOT NULL, lesson_id INT DEFAULT NULL, url_meet VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_2B8040B0CDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE meet_urls ADD CONSTRAINT FK_2B8040B0CDF80196 FOREIGN KEY (lesson_id) REFERENCES lessons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE answers CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE countries CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE currencies CHANGE type type TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE files CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE language_grades CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE languages CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE lesson_reserves CHANGE reserved_time reserved_time DATETIME DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE lessons DROP meet_url, CHANGE lesson_time lesson_time DATETIME DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE orders CHANGE type type TINYINT(1) NOT NULL, CHANGE status status TINYINT(1) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE questions CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE quizzes CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE roles CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE specialties CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE teacher_informations CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE user_groups CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE user_informations CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE users CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE deleted_at deleted_at DATETIME DEFAULT \'0000-00-00 00:00:00\'');
        $this->addSql('ALTER TABLE wallets CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE zoom_meet_sessions CHANGE started_time started_time DATETIME DEFAULT NULL, CHANGE finished_time finished_time DATETIME DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
        $this->addSql('ALTER TABLE zoom_meets CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\', CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00.000000\'');
    }
}
