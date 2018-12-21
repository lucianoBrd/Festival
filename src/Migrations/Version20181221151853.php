<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181221151853 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hosting (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hosting_service (hosting_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_8C1DCF48AE9044EA (hosting_id), INDEX IDX_8C1DCF48ED5CA9E6 (service_id), PRIMARY KEY(hosting_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, id_category_id INT NOT NULL, id_projection_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, length INT NOT NULL, competing TINYINT(1) NOT NULL, INDEX IDX_1D5EF26FA545015 (id_category_id), INDEX IDX_1D5EF26FE0E7B7D8 (id_projection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_vip (movie_id INT NOT NULL, vip_id INT NOT NULL, INDEX IDX_945729308F93B6FC (movie_id), INDEX IDX_94572930AA4E6FD (vip_id), PRIMARY KEY(movie_id, vip_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projection (id INT AUTO_INCREMENT NOT NULL, id_projection_room_id INT DEFAULT NULL, scheduled_time VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', date DATE DEFAULT NULL, INDEX IDX_8004C82649E16BF8 (id_projection_room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projection_room (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, capacity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projection_room_category (projection_room_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_F5FC374CAC3D957 (projection_room_id), INDEX IDX_F5FC37412469DE2 (category_id), PRIMARY KEY(projection_room_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_vip_id INT NOT NULL, id_hosting_id INT NOT NULL, date DATE NOT NULL, duration VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', INDEX IDX_42C849552C935310 (id_vip_id), INDEX IDX_42C84955B1AC43D (id_hosting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, id_hosting_id INT NOT NULL, type VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, room_number INT NOT NULL, INDEX IDX_729F519BB1AC43D (id_hosting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vip (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, jury TINYINT(1) NOT NULL, invited TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hosting_service ADD CONSTRAINT FK_8C1DCF48AE9044EA FOREIGN KEY (hosting_id) REFERENCES hosting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hosting_service ADD CONSTRAINT FK_8C1DCF48ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FA545015 FOREIGN KEY (id_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FE0E7B7D8 FOREIGN KEY (id_projection_id) REFERENCES projection (id)');
        $this->addSql('ALTER TABLE movie_vip ADD CONSTRAINT FK_945729308F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_vip ADD CONSTRAINT FK_94572930AA4E6FD FOREIGN KEY (vip_id) REFERENCES vip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projection ADD CONSTRAINT FK_8004C82649E16BF8 FOREIGN KEY (id_projection_room_id) REFERENCES projection_room (id)');
        $this->addSql('ALTER TABLE projection_room_category ADD CONSTRAINT FK_F5FC374CAC3D957 FOREIGN KEY (projection_room_id) REFERENCES projection_room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projection_room_category ADD CONSTRAINT FK_F5FC37412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849552C935310 FOREIGN KEY (id_vip_id) REFERENCES vip (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B1AC43D FOREIGN KEY (id_hosting_id) REFERENCES hosting (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BB1AC43D FOREIGN KEY (id_hosting_id) REFERENCES hosting (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FA545015');
        $this->addSql('ALTER TABLE projection_room_category DROP FOREIGN KEY FK_F5FC37412469DE2');
        $this->addSql('ALTER TABLE hosting_service DROP FOREIGN KEY FK_8C1DCF48AE9044EA');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B1AC43D');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BB1AC43D');
        $this->addSql('ALTER TABLE movie_vip DROP FOREIGN KEY FK_945729308F93B6FC');
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FE0E7B7D8');
        $this->addSql('ALTER TABLE projection DROP FOREIGN KEY FK_8004C82649E16BF8');
        $this->addSql('ALTER TABLE projection_room_category DROP FOREIGN KEY FK_F5FC374CAC3D957');
        $this->addSql('ALTER TABLE hosting_service DROP FOREIGN KEY FK_8C1DCF48ED5CA9E6');
        $this->addSql('ALTER TABLE movie_vip DROP FOREIGN KEY FK_94572930AA4E6FD');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849552C935310');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE hosting');
        $this->addSql('DROP TABLE hosting_service');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_vip');
        $this->addSql('DROP TABLE projection');
        $this->addSql('DROP TABLE projection_room');
        $this->addSql('DROP TABLE projection_room_category');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE vip');
    }
}
