<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20210602200059 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE answers (id BIGINT AUTO_INCREMENT NOT NULL, question_id BIGINT DEFAULT NULL, answer_title VARCHAR(255) DEFAULT NULL, correct TINYINT(1) NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, INDEX IDX_50D0C6061E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, code VARCHAR(50) NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currencies (id INT AUTO_INCREMENT NOT NULL, file_id BIGINT DEFAULT NULL, `precision` SMALLINT NOT NULL, status SMALLINT NOT NULL, code VARCHAR(25) NOT NULL, short_code VARCHAR(6) NOT NULL, type TINYINT NOT NULL, is_system TINYINT(1) DEFAULT \'0\' NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, UNIQUE INDEX UNIQ_37C4469377153098 (code), INDEX IDX_37C4469393CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id BIGINT AUTO_INCREMENT NOT NULL, user_id BIGINT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, size INT NOT NULL, extension VARCHAR(5) DEFAULT NULL, real_name VARCHAR(255) DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, INDEX IDX_6354059A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language_grades (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE languages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, code VARCHAR(50) NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson_reserves (id INT AUTO_INCREMENT NOT NULL, user_id BIGINT DEFAULT NULL, teacher_id BIGINT DEFAULT NULL, status SMALLINT NOT NULL, reserved_time timestamp(6) DEFAULT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, INDEX IDX_8636241CA76ED395 (user_id), INDEX IDX_8636241C41807E1D (teacher_id), UNIQUE INDEX UNIQ_8636241C41807E1DA76ED3953F312D9A (teacher_id, user_id, reserved_time), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lessons (id INT AUTO_INCREMENT NOT NULL, user_id BIGINT DEFAULT NULL, teacher_id BIGINT DEFAULT NULL, status SMALLINT NOT NULL, lesson_time timestamp(6) DEFAULT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, INDEX IDX_3F4218D9A76ED395 (user_id), INDEX IDX_3F4218D941807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_access_tokens (id VARCHAR(100) NOT NULL, user_id INT DEFAULT NULL, client_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, scopes LONGTEXT DEFAULT NULL, revoked TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, expires_at DATETIME DEFAULT NULL, INDEX user_id_token_index (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_auth_codes (id VARCHAR(100) NOT NULL, user_id INT NOT NULL, client_id INT NOT NULL, scopes LONGTEXT DEFAULT NULL, revoked TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_clients (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, secret VARCHAR(100) NOT NULL, provider LONGTEXT DEFAULT NULL, redirect LONGTEXT NOT NULL, personal_access_client TINYINT(1) NOT NULL, password_client TINYINT(1) NOT NULL, revoked TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX user_id_client_index (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_personal_access_clients (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX client_id_index (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth_refresh_tokens (id VARCHAR(100) NOT NULL, access_token_id VARCHAR(100) NOT NULL, revoked TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, INDEX access_token_index (access_token_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id BIGINT AUTO_INCREMENT NOT NULL, user_id BIGINT DEFAULT NULL, teacher_id BIGINT DEFAULT NULL, lesson_id INT DEFAULT NULL, type TINYINT NOT NULL, amount NUMERIC(36, 18) DEFAULT \'0\' NOT NULL, locked_amount NUMERIC(36, 18) DEFAULT \'0\' NOT NULL, status TINYINT, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, INDEX IDX_E52FFDEEA76ED395 (user_id), INDEX IDX_E52FFDEE41807E1D (teacher_id), INDEX IDX_E52FFDEECDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permissions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id BIGINT AUTO_INCREMENT NOT NULL, quiz_id BIGINT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, type INT NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, INDEX IDX_8ADC54D5853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quizzes (id BIGINT AUTO_INCREMENT NOT NULL, user_id BIGINT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, INDEX IDX_94DC9FB5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, UNIQUE INDEX UNIQ_B63E2EC75E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission_role (role_id INT NOT NULL, permission_id INT NOT NULL, INDEX IDX_6A711CAD60322AC (role_id), INDEX IDX_6A711CAFED90CCA (permission_id), PRIMARY KEY(role_id, permission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialties (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, code VARCHAR(100) NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_information_language_grades (teacher_information_id BIGINT NOT NULL, language_id INT DEFAULT NULL, language_grade_id INT DEFAULT NULL, INDEX IDX_CCC49B1F82F1BAF4 (language_id), INDEX IDX_CCC49B1F92BBF992 (language_grade_id), UNIQUE INDEX UNIQ_CCC49B1F7950C5AA82F1BAF492BBF992 (teacher_information_id, language_id, language_grade_id), PRIMARY KEY(teacher_information_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_informations (id BIGINT AUTO_INCREMENT NOT NULL, user_id BIGINT DEFAULT NULL, specialty_id INT DEFAULT NULL, country_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, short_description VARCHAR(100) DEFAULT NULL, price_per_hour SMALLINT NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, UNIQUE INDEX UNIQ_F94990BBA76ED395 (user_id), INDEX IDX_F94990BB9A353316 (specialty_id), INDEX IDX_F94990BBF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_groups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(16) NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, UNIQUE INDEX UNIQ_953F224D5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_informations (id BIGINT AUTO_INCREMENT NOT NULL, user_id BIGINT DEFAULT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, UNIQUE INDEX UNIQ_EF5A188BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id BIGINT AUTO_INCREMENT NOT NULL, group_id INT DEFAULT NULL, base_currency_id INT DEFAULT NULL, email VARCHAR(60) NOT NULL, email_verified_at DATETIME DEFAULT NULL, agreement INT NOT NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(255) DEFAULT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, deleted_at timestamp DEFAULT 0, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), INDEX IDX_1483A5E9FE54D947 (group_id), INDEX IDX_1483A5E93101778E (base_currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_user (user_id BIGINT NOT NULL, role_id INT NOT NULL, INDEX IDX_332CA4DDA76ED395 (user_id), INDEX IDX_332CA4DDD60322AC (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission_user (user_id BIGINT NOT NULL, permission_id INT NOT NULL, INDEX IDX_DC5D4DE9A76ED395 (user_id), INDEX IDX_DC5D4DE9FED90CCA (permission_id), PRIMARY KEY(user_id, permission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallets (id BIGINT AUTO_INCREMENT NOT NULL, user_id BIGINT DEFAULT NULL, currency_id INT DEFAULT NULL, address VARCHAR(36) NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, UNIQUE INDEX UNIQ_967AAA6CD4E6F81 (address), INDEX IDX_967AAA6CA76ED395 (user_id), INDEX IDX_967AAA6C38248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoom_meet_sessions (id INT AUTO_INCREMENT NOT NULL, host_id BIGINT DEFAULT NULL, user_id BIGINT DEFAULT NULL, lesson_id INT DEFAULT NULL, zoom_meet_id INT DEFAULT NULL, status SMALLINT NOT NULL, started_time timestamp(6) DEFAULT NULL, finished_time timestamp(6) DEFAULT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, INDEX IDX_4332A151FB8D185 (host_id), INDEX IDX_4332A15A76ED395 (user_id), INDEX IDX_4332A15CDF80196 (lesson_id), INDEX IDX_4332A15E9957578 (zoom_meet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoom_meets (id INT AUTO_INCREMENT NOT NULL, meet_number VARCHAR(10) NOT NULL, meet_password VARCHAR(32) NOT NULL, created_at timestamp(6) DEFAULT 0, updated_at timestamp(6) DEFAULT 0, UNIQUE INDEX UNIQ_3E503730B28D9CF (meet_number), UNIQUE INDEX UNIQ_3E503730D570EF39 (meet_password), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE currencies ADD CONSTRAINT FK_37C4469393CB796C FOREIGN KEY (file_id) REFERENCES files (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE files ADD CONSTRAINT FK_6354059A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE lesson_reserves ADD CONSTRAINT FK_8636241CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_reserves ADD CONSTRAINT FK_8636241C41807E1D FOREIGN KEY (teacher_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lessons ADD CONSTRAINT FK_3F4218D9A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lessons ADD CONSTRAINT FK_3F4218D941807E1D FOREIGN KEY (teacher_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE41807E1D FOREIGN KEY (teacher_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEECDF80196 FOREIGN KEY (lesson_id) REFERENCES lessons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5853CD175 FOREIGN KEY (quiz_id) REFERENCES quizzes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quizzes ADD CONSTRAINT FK_94DC9FB5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE permission_role ADD CONSTRAINT FK_6A711CAD60322AC FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_role ADD CONSTRAINT FK_6A711CAFED90CCA FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_information_language_grades ADD CONSTRAINT FK_CCC49B1F7950C5AA FOREIGN KEY (teacher_information_id) REFERENCES teacher_informations (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE teacher_information_language_grades ADD CONSTRAINT FK_CCC49B1F82F1BAF4 FOREIGN KEY (language_id) REFERENCES languages (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE teacher_information_language_grades ADD CONSTRAINT FK_CCC49B1F92BBF992 FOREIGN KEY (language_grade_id) REFERENCES language_grades (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE teacher_informations ADD CONSTRAINT FK_F94990BBA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_informations ADD CONSTRAINT FK_F94990BB9A353316 FOREIGN KEY (specialty_id) REFERENCES specialties (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE teacher_informations ADD CONSTRAINT FK_F94990BBF92F3E70 FOREIGN KEY (country_id) REFERENCES countries (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user_informations ADD CONSTRAINT FK_EF5A188BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9FE54D947 FOREIGN KEY (group_id) REFERENCES user_groups (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E93101778E FOREIGN KEY (base_currency_id) REFERENCES currencies (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_user ADD CONSTRAINT FK_DC5D4DE9A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE permission_user ADD CONSTRAINT FK_DC5D4DE9FED90CCA FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE wallets ADD CONSTRAINT FK_967AAA6C38248176 FOREIGN KEY (currency_id) REFERENCES currencies (id) ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE zoom_meet_sessions ADD CONSTRAINT FK_4332A151FB8D185 FOREIGN KEY (host_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zoom_meet_sessions ADD CONSTRAINT FK_4332A15A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zoom_meet_sessions ADD CONSTRAINT FK_4332A15CDF80196 FOREIGN KEY (lesson_id) REFERENCES lessons (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zoom_meet_sessions ADD CONSTRAINT FK_4332A15E9957578 FOREIGN KEY (zoom_meet_id) REFERENCES zoom_meets (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE teacher_informations DROP FOREIGN KEY FK_F94990BBF92F3E70');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E93101778E');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6C38248176');
        $this->addSql('ALTER TABLE currencies DROP FOREIGN KEY FK_37C4469393CB796C');
        $this->addSql('ALTER TABLE teacher_information_language_grades DROP FOREIGN KEY FK_CCC49B1F92BBF992');
        $this->addSql('ALTER TABLE teacher_information_language_grades DROP FOREIGN KEY FK_CCC49B1F82F1BAF4');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEECDF80196');
        $this->addSql('ALTER TABLE zoom_meet_sessions DROP FOREIGN KEY FK_4332A15CDF80196');
        $this->addSql('ALTER TABLE permission_role DROP FOREIGN KEY FK_6A711CAFED90CCA');
        $this->addSql('ALTER TABLE permission_user DROP FOREIGN KEY FK_DC5D4DE9FED90CCA');
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5853CD175');
        $this->addSql('ALTER TABLE permission_role DROP FOREIGN KEY FK_6A711CAD60322AC');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE teacher_informations DROP FOREIGN KEY FK_F94990BB9A353316');
        $this->addSql('ALTER TABLE teacher_information_language_grades DROP FOREIGN KEY FK_CCC49B1F7950C5AA');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9FE54D947');
        $this->addSql('ALTER TABLE files DROP FOREIGN KEY FK_6354059A76ED395');
        $this->addSql('ALTER TABLE lesson_reserves DROP FOREIGN KEY FK_8636241CA76ED395');
        $this->addSql('ALTER TABLE lesson_reserves DROP FOREIGN KEY FK_8636241C41807E1D');
        $this->addSql('ALTER TABLE lessons DROP FOREIGN KEY FK_3F4218D9A76ED395');
        $this->addSql('ALTER TABLE lessons DROP FOREIGN KEY FK_3F4218D941807E1D');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE41807E1D');
        $this->addSql('ALTER TABLE quizzes DROP FOREIGN KEY FK_94DC9FB5A76ED395');
        $this->addSql('ALTER TABLE teacher_informations DROP FOREIGN KEY FK_F94990BBA76ED395');
        $this->addSql('ALTER TABLE user_informations DROP FOREIGN KEY FK_EF5A188BA76ED395');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
        $this->addSql('ALTER TABLE permission_user DROP FOREIGN KEY FK_DC5D4DE9A76ED395');
        $this->addSql('ALTER TABLE wallets DROP FOREIGN KEY FK_967AAA6CA76ED395');
        $this->addSql('ALTER TABLE zoom_meet_sessions DROP FOREIGN KEY FK_4332A151FB8D185');
        $this->addSql('ALTER TABLE zoom_meet_sessions DROP FOREIGN KEY FK_4332A15A76ED395');
        $this->addSql('ALTER TABLE zoom_meet_sessions DROP FOREIGN KEY FK_4332A15E9957578');
        $this->addSql('DROP TABLE answers');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE currencies');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE language_grades');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE lesson_reserves');
        $this->addSql('DROP TABLE lessons');
        $this->addSql('DROP TABLE oauth_access_tokens');
        $this->addSql('DROP TABLE oauth_auth_codes');
        $this->addSql('DROP TABLE oauth_clients');
        $this->addSql('DROP TABLE oauth_personal_access_clients');
        $this->addSql('DROP TABLE oauth_refresh_tokens');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE permissions');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE quizzes');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE permission_role');
        $this->addSql('DROP TABLE specialties');
        $this->addSql('DROP TABLE teacher_information_language_grades');
        $this->addSql('DROP TABLE teacher_informations');
        $this->addSql('DROP TABLE user_groups');
        $this->addSql('DROP TABLE user_informations');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP TABLE permission_user');
        $this->addSql('DROP TABLE wallets');
        $this->addSql('DROP TABLE zoom_meet_sessions');
        $this->addSql('DROP TABLE zoom_meets');
    }
}
