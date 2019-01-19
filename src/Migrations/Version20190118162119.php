<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190118162119 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE projection_vip (projection_id INT NOT NULL, vip_id INT NOT NULL, INDEX IDX_955D04E65ECF66BD (projection_id), INDEX IDX_955D04E6AA4E6FD (vip_id), PRIMARY KEY(projection_id, vip_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projection_vip ADD CONSTRAINT FK_955D04E65ECF66BD FOREIGN KEY (projection_id) REFERENCES projection (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projection_vip ADD CONSTRAINT FK_955D04E6AA4E6FD FOREIGN KEY (vip_id) REFERENCES vip (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE projection_vip');
    }
}
