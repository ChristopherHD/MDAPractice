<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180419085113 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admins (dni VARCHAR(10) NOT NULL, name VARCHAR(45) NOT NULL, password VARCHAR(64) NOT NULL, email LONGTEXT DEFAULT NULL, PRIMARY KEY(dni)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animals (id INT AUTO_INCREMENT NOT NULL, patient VARCHAR(10) DEFAULT NULL, birthdate DATETIME NOT NULL, type VARCHAR(200) NOT NULL, other VARCHAR(200) DEFAULT NULL, name VARCHAR(200) NOT NULL, INDEX IDX_966C69DD1ADAD7EB (patient), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incidents (id INT AUTO_INCREMENT NOT NULL, patient VARCHAR(10) DEFAULT NULL, doctor VARCHAR(10) DEFAULT NULL, date DATETIME NOT NULL, description VARCHAR(200) NOT NULL, email VARCHAR(200) NOT NULL, is_closed TINYINT(1) NOT NULL, INDEX IDX_E65135D01ADAD7EB (patient), INDEX IDX_E65135D01FC0F36A (doctor), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD1ADAD7EB FOREIGN KEY (patient) REFERENCES users (dni)');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D01ADAD7EB FOREIGN KEY (patient) REFERENCES users (dni)');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D01FC0F36A FOREIGN KEY (doctor) REFERENCES doctors (dni)');
        $this->addSql('ALTER TABLE appointments ADD animal INT DEFAULT NULL');
        $this->addSql('ALTER TABLE appointments ADD CONSTRAINT FK_6A41727A6AAB231F FOREIGN KEY (animal) REFERENCES animals (id)');
        $this->addSql('CREATE INDEX IDX_6A41727A6AAB231F ON appointments (animal)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appointments DROP FOREIGN KEY FK_6A41727A6AAB231F');
        $this->addSql('DROP TABLE admins');
        $this->addSql('DROP TABLE animals');
        $this->addSql('DROP TABLE incidents');
        $this->addSql('DROP INDEX IDX_6A41727A6AAB231F ON appointments');
        $this->addSql('ALTER TABLE appointments DROP animal');
    }
}
