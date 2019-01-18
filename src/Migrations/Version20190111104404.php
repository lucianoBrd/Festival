<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190111104404 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hosting ADD id_type_id INT NOT NULL, DROP type');
        $this->addSql('ALTER TABLE hosting ADD CONSTRAINT FK_E9168FDA1BD125E3 FOREIGN KEY (id_type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_E9168FDA1BD125E3 ON hosting (id_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hosting DROP FOREIGN KEY FK_E9168FDA1BD125E3');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_E9168FDA1BD125E3 ON hosting');
        $this->addSql('ALTER TABLE hosting ADD type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP id_type_id');
    }
}
