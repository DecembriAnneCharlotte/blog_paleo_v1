<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118151805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_ingredient (article_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_5776A9F17294869C (article_id), INDEX IDX_5776A9F1933FE08C (ingredient_id), PRIMARY KEY(article_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_ingredient ADD CONSTRAINT FK_5776A9F17294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_ingredient ADD CONSTRAINT FK_5776A9F1933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_ingredient DROP FOREIGN KEY FK_5776A9F17294869C');
        $this->addSql('ALTER TABLE article_ingredient DROP FOREIGN KEY FK_5776A9F1933FE08C');
        $this->addSql('DROP TABLE article_ingredient');
    }
}
