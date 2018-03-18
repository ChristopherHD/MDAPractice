#DROP DATABASE `mdadb`;
CREATE SCHEMA `mdadb` DEFAULT CHARACTER SET utf8;

CREATE TABLE `mdadb`.`users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(10) NOT NULL,
  `password` varchar(40) NOT NULL,
  `name` varchar(45) NOT NULL,
  `social_security_number` varchar(25) NOT NULL,
  `isDoctor` tinyint(1) DEFAULT '0',
  `birthdate` date NOT NULL,
  `phone` varchar(20) NOT NULL,
  `medical_history` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni_UNIQUE` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mdadb`.`appointments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL,
  `patient` INT NOT NULL,
  `doctor` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_patient_idx` (`patient` ASC),
  INDEX `fk_doctor_idx` (`doctor` ASC),
  UNIQUE INDEX `patient_date` (`date`, `patient`),
  UNIQUE INDEX `doctor_date` (`date`, `doctor`),
  CONSTRAINT `fk_patient`
    FOREIGN KEY (`patient`)
    REFERENCES `mdadb`.`users` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_doctor`
    FOREIGN KEY (`doctor`)
    REFERENCES `mdadb`.`users` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;