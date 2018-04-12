<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412082815 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE appointments (id INT AUTO_INCREMENT NOT NULL, patient VARCHAR(10) DEFAULT NULL, doctor VARCHAR(10) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_6A41727A1ADAD7EB (patient), INDEX IDX_6A41727A1FC0F36A (doctor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctors (dni VARCHAR(10) NOT NULL, name VARCHAR(45) NOT NULL, phone VARCHAR(20) NOT NULL, specialty VARCHAR(10) NOT NULL, password VARCHAR(64) NOT NULL, PRIMARY KEY(dni)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (dni VARCHAR(10) NOT NULL, name VARCHAR(45) NOT NULL, social_security_number VARCHAR(25) NOT NULL, phone VARCHAR(20) NOT NULL, birthdate DATE NOT NULL, password VARCHAR(64) NOT NULL, medical_history LONGTEXT DEFAULT NULL, PRIMARY KEY(dni)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A1ADAD7EB FOREIGN KEY (patient) REFERENCES users (dni)');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A1FC0F36A FOREIGN KEY (doctor) REFERENCES doctors (dni)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appointments DROP FOREIGN KEY FK_6A41727A1FC0F36A');
        $this->addSql('ALTER TABLE appointments DROP FOREIGN KEY FK_6A41727A1ADAD7EB');
        $this->addSql('DROP TABLE appointments');
        $this->addSql('DROP TABLE doctors');
        $this->addSql('DROP TABLE users');
    }
}
