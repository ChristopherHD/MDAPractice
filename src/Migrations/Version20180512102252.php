<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180512102252 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admins (dni VARCHAR(10) NOT NULL, name VARCHAR(45) NOT NULL, password VARCHAR(64) NOT NULL, email LONGTEXT DEFAULT NULL, PRIMARY KEY(dni)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animals (id INT AUTO_INCREMENT NOT NULL, patient VARCHAR(10) DEFAULT NULL, birthdate DATETIME NOT NULL, type VARCHAR(200) NOT NULL, other VARCHAR(200) DEFAULT NULL, name VARCHAR(200) NOT NULL, INDEX IDX_966C69DD1ADAD7EB (patient), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE appointments (id INT AUTO_INCREMENT NOT NULL, patient VARCHAR(10) DEFAULT NULL, doctor VARCHAR(10) DEFAULT NULL, animal INT DEFAULT NULL, date DATETIME NOT NULL, description VARCHAR(200) NOT NULL, is_closed TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_6A41727A1ADAD7EB (patient), INDEX IDX_6A41727A1FC0F36A (doctor), INDEX IDX_6A41727A6AAB231F (animal), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctors (dni VARCHAR(10) NOT NULL, name VARCHAR(45) NOT NULL, email VARCHAR(40) NOT NULL, phone VARCHAR(20) NOT NULL, specialty VARCHAR(15) NOT NULL, password VARCHAR(64) NOT NULL, PRIMARY KEY(dni)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incidents (id INT AUTO_INCREMENT NOT NULL, patient VARCHAR(10) DEFAULT NULL, doctor VARCHAR(10) DEFAULT NULL, date DATETIME NOT NULL, description VARCHAR(200) NOT NULL, email VARCHAR(200) NOT NULL, is_closed TINYINT(1) NOT NULL, INDEX IDX_E65135D01ADAD7EB (patient), INDEX IDX_E65135D01FC0F36A (doctor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipes (id INT AUTO_INCREMENT NOT NULL, patient VARCHAR(10) DEFAULT NULL, doctor VARCHAR(10) DEFAULT NULL, date DATETIME NOT NULL, name VARCHAR(20) NOT NULL, INDEX IDX_A369E2B51ADAD7EB (patient), INDEX IDX_A369E2B51FC0F36A (doctor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (dni VARCHAR(10) NOT NULL, name VARCHAR(45) NOT NULL, social_security_number VARCHAR(25) NOT NULL, phone VARCHAR(20) NOT NULL, birthdate DATE NOT NULL, password VARCHAR(64) NOT NULL, medical_history LONGTEXT DEFAULT NULL, is_subscribed TINYINT(1) DEFAULT NULL, credit_card VARCHAR(200) DEFAULT NULL, PRIMARY KEY(dni)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD1ADAD7EB FOREIGN KEY (patient) REFERENCES users (dni)');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A1ADAD7EB FOREIGN KEY (patient) REFERENCES users (dni)');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A1FC0F36A FOREIGN KEY (doctor) REFERENCES doctors (dni)');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A6AAB231F FOREIGN KEY (animal) REFERENCES animals (id)');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D01ADAD7EB FOREIGN KEY (patient) REFERENCES users (dni)');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D01FC0F36A FOREIGN KEY (doctor) REFERENCES doctors (dni)');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B51ADAD7EB FOREIGN KEY (patient) REFERENCES users (dni)');
        $this->addSql('ALTER TABLE recipes ADD CONSTRAINT FK_A369E2B51FC0F36A FOREIGN KEY (doctor) REFERENCES doctors (dni)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appointments DROP FOREIGN KEY FK_6A41727A6AAB231F');
        $this->addSql('ALTER TABLE appointments DROP FOREIGN KEY FK_6A41727A1FC0F36A');
        $this->addSql('ALTER TABLE incidents DROP FOREIGN KEY FK_E65135D01FC0F36A');
        $this->addSql('ALTER TABLE recipes DROP FOREIGN KEY FK_A369E2B51FC0F36A');
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD1ADAD7EB');
        $this->addSql('ALTER TABLE appointments DROP FOREIGN KEY FK_6A41727A1ADAD7EB');
        $this->addSql('ALTER TABLE incidents DROP FOREIGN KEY FK_E65135D01ADAD7EB');
        $this->addSql('ALTER TABLE recipes DROP FOREIGN KEY FK_A369E2B51ADAD7EB');
        $this->addSql('DROP TABLE admins');
        $this->addSql('DROP TABLE animals');
        $this->addSql('DROP TABLE appointments');
        $this->addSql('DROP TABLE doctors');
        $this->addSql('DROP TABLE incidents');
        $this->addSql('DROP TABLE recipes');
        $this->addSql('DROP TABLE users');
    }
}
