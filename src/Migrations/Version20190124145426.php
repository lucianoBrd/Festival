<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190124145426 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projection ADD id_movie_id INT NOT NULL');
        $this->addSql('ALTER TABLE projection ADD CONSTRAINT FK_8004C826DF485A69 FOREIGN KEY (id_movie_id) REFERENCES movie (id)');
        $this->addSql('CREATE INDEX IDX_8004C826DF485A69 ON projection (id_movie_id)');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FE0E7B7D8');
        $this->addSql('DROP INDEX IDX_1D5EF26FE0E7B7D8 ON movie');
        $this->addSql('ALTER TABLE movie DROP id_projection_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movie ADD id_projection_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FE0E7B7D8 FOREIGN KEY (id_projection_id) REFERENCES projection (id)');
        $this->addSql('CREATE INDEX IDX_1D5EF26FE0E7B7D8 ON movie (id_projection_id)');
        $this->addSql('ALTER TABLE projection DROP FOREIGN KEY FK_8004C826DF485A69');
        $this->addSql('DROP INDEX IDX_8004C826DF485A69 ON projection');
        $this->addSql('ALTER TABLE projection DROP id_movie_id');
    }
}
