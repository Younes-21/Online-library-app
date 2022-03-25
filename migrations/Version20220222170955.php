<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222170955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acquire ADD book_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE acquire ADD CONSTRAINT FK_C149020616A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_C149020616A2B381 ON acquire (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acquire DROP FOREIGN KEY FK_C149020616A2B381');
        $this->addSql('DROP INDEX IDX_C149020616A2B381 ON acquire');
        $this->addSql('ALTER TABLE acquire DROP book_id');
    }
}
