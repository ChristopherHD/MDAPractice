<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180508095032 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE recipes (id INT AUTO_INCREMENT NOT NULL, patient VARCHAR(10) DEFAULT NULL, doctor VARCHAR(10) DEFAULT NULL, date DATETIME NOT NULL, name VARCHAR(20) NOT NULL, INDEX IDX_A369E2B51ADAD7EB (patient), INDEX IDX_A369E2B51FC0F36A (doctor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B51ADAD7EB FOREIGN KEY (patient) REFERENCES users (dni)');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B51FC0F36A FOREIGN KEY (doctor) REFERENCES doctors (dni)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE recipes');
    }
}
