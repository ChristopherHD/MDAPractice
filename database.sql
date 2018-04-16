#DROP DATABASE `mdadb`;
CREATE SCHEMA `mdadb` DEFAULT CHARACTER SET utf8;

CREATE TABLE IF NOT EXISTS `mdadb`.`users` (
  `dni` varchar(10) NOT NULL,
  `password` varchar(64) NOT NULL,
  `name` varchar(45) NOT NULL,
  `social_security_number` varchar(25) NOT NULL,
  `birthdate` date NOT NULL,
  `phone` varchar(20) NOT NULL,
  `medical_history` longtext,
  PRIMARY KEY (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `doctors` (
  `dni` varchar(10) NOT NULL,
  `name` varchar(45) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `specialty` varchar(15) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mdadb`.`appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `description` varchar(200) DEFAULT 'Ninguna',
  `patient` varchar(10) DEFAULT NULL,
  `doctor` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `IDX_6A41727A1ADAD7EB` (`patient` ASC),
  INDEX `IDX_6A41727A1FC0F36A` (`doctor` ASC),
  UNIQUE INDEX `patient_date` (`date`, `patient`),
  UNIQUE INDEX `doctor_date` (`date`, `doctor`),
  CONSTRAINT `FK_6A41727A1ADAD7EB`
    FOREIGN KEY (`patient`)
    REFERENCES `mdadb`.`users` (`dni`)
    ON DELETE CASCADE,
  CONSTRAINT `FK_6A41727A1FC0F36A`
    FOREIGN KEY (`doctor`)
    REFERENCES `mdadb`.`doctors` (`dni`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;