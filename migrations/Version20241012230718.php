<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241012230718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chapter (id UUID NOT NULL, manga_id UUID NOT NULL, chapter_number INT NOT NULL, title VARCHAR(255) NOT NULL, release_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, pages JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F981B52E7B6461 ON chapter (manga_id)');
        $this->addSql('COMMENT ON COLUMN chapter.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN chapter.manga_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE comment (id UUID NOT NULL, user_id UUID NOT NULL, manga_id UUID DEFAULT NULL, chapter_id UUID DEFAULT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C7B6461 ON comment (manga_id)');
        $this->addSql('CREATE INDEX IDX_9474526C579F4768 ON comment (chapter_id)');
        $this->addSql('COMMENT ON COLUMN comment.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.manga_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN comment.chapter_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE genre (id UUID NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN genre.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE language (id UUID NOT NULL, name VARCHAR(50) NOT NULL, code VARCHAR(5) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D4DB71B577153098 ON language (code)');
        $this->addSql('COMMENT ON COLUMN language.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE manga (id UUID NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, author VARCHAR(255) NOT NULL, cover_image VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN manga.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE manga_genre (manga_id UUID NOT NULL, genre_id UUID NOT NULL, PRIMARY KEY(manga_id, genre_id))');
        $this->addSql('CREATE INDEX IDX_1506CF9F7B6461 ON manga_genre (manga_id)');
        $this->addSql('CREATE INDEX IDX_1506CF9F4296D31F ON manga_genre (genre_id)');
        $this->addSql('COMMENT ON COLUMN manga_genre.manga_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN manga_genre.genre_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE manga_translation (id UUID NOT NULL, manga_id UUID DEFAULT NULL, language_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, chapters JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BA453ED7B6461 ON manga_translation (manga_id)');
        $this->addSql('CREATE INDEX IDX_3BA453ED82F1BAF4 ON manga_translation (language_id)');
        $this->addSql('COMMENT ON COLUMN manga_translation.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN manga_translation.manga_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN manga_translation.language_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "users" (id UUID NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "users" (email)');
        $this->addSql('COMMENT ON COLUMN "users".id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manga_genre ADD CONSTRAINT FK_1506CF9F7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manga_genre ADD CONSTRAINT FK_1506CF9F4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manga_translation ADD CONSTRAINT FK_3BA453ED7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manga_translation ADD CONSTRAINT FK_3BA453ED82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chapter DROP CONSTRAINT FK_F981B52E7B6461');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C7B6461');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C579F4768');
        $this->addSql('ALTER TABLE manga_genre DROP CONSTRAINT FK_1506CF9F7B6461');
        $this->addSql('ALTER TABLE manga_genre DROP CONSTRAINT FK_1506CF9F4296D31F');
        $this->addSql('ALTER TABLE manga_translation DROP CONSTRAINT FK_3BA453ED7B6461');
        $this->addSql('ALTER TABLE manga_translation DROP CONSTRAINT FK_3BA453ED82F1BAF4');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE manga');
        $this->addSql('DROP TABLE manga_genre');
        $this->addSql('DROP TABLE manga_translation');
        $this->addSql('DROP TABLE "users"');
    }
}
