<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019120129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classroom MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON classroom');
        $this->addSql('ALTER TABLE classroom CHANGE id ref INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE classroom ADD PRIMARY KEY (ref)');
        $this->addSql('ALTER TABLE student ADD n_id INT DEFAULT NULL, DROP classroom_id');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF3363BD430E FOREIGN KEY (n_id) REFERENCES classroom (ref)');
        $this->addSql('CREATE INDEX IDX_B723AF3363BD430E ON student (n_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classroom MODIFY ref INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON classroom');
        $this->addSql('ALTER TABLE classroom CHANGE ref id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE classroom ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF3363BD430E');
        $this->addSql('DROP INDEX IDX_B723AF3363BD430E ON student');
        $this->addSql('ALTER TABLE student ADD classroom_id INT NOT NULL, DROP n_id');
    }
}
