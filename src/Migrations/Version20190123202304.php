<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190123202304 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hosting_room_booking (id INT AUTO_INCREMENT NOT NULL, hosting_room_id INT NOT NULL, INDEX IDX_5A2D9F7539972509 (hosting_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hosting_room_booking_vip (hosting_room_booking_id INT NOT NULL, vip_id INT NOT NULL, INDEX IDX_75638BE877DA571 (hosting_room_booking_id), INDEX IDX_75638BEAA4E6FD (vip_id), PRIMARY KEY(hosting_room_booking_id, vip_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hosting_room_booking ADD CONSTRAINT FK_5A2D9F7539972509 FOREIGN KEY (hosting_room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE hosting_room_booking_vip ADD CONSTRAINT FK_75638BE877DA571 FOREIGN KEY (hosting_room_booking_id) REFERENCES hosting_room_booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hosting_room_booking_vip ADD CONSTRAINT FK_75638BEAA4E6FD FOREIGN KEY (vip_id) REFERENCES vip (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE hosting_room_booking_vip DROP FOREIGN KEY FK_75638BE877DA571');
        $this->addSql('DROP TABLE hosting_room_booking');
        $this->addSql('DROP TABLE hosting_room_booking_vip');
    }
}
