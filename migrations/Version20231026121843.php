<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231026121843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC4852B505');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC39759382');
        $this->addSql('DROP INDEX IDX_2784DCC39759382 ON rent');
        $this->addSql('DROP INDEX UNIQ_2784DCC4852B505 ON rent');
        $this->addSql('ALTER TABLE rent ADD user_id INT DEFAULT NULL, ADD book_id INT DEFAULT NULL, DROP borrow_book_id, DROP borrowed_by_id, CHANGE borrow_date borrowed_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_2784DCCA76ED395 ON rent (user_id)');
        $this->addSql('CREATE INDEX IDX_2784DCC16A2B381 ON rent (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCCA76ED395');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC16A2B381');
        $this->addSql('DROP INDEX IDX_2784DCCA76ED395 ON rent');
        $this->addSql('DROP INDEX IDX_2784DCC16A2B381 ON rent');
        $this->addSql('ALTER TABLE rent ADD borrow_book_id INT DEFAULT NULL, ADD borrowed_by_id INT DEFAULT NULL, DROP user_id, DROP book_id, CHANGE borrowed_date borrow_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC4852B505 FOREIGN KEY (borrow_book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC39759382 FOREIGN KEY (borrowed_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2784DCC39759382 ON rent (borrowed_by_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2784DCC4852B505 ON rent (borrow_book_id)');
    }
}
