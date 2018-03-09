#DROP DATABASE `mdadb`;
CREATE SCHEMA `mdadb` DEFAULT CHARACTER SET utf8;

#DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idusuarios` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `num_seguridad_social` varchar(25) NOT NULL,
  `es_medico` tinyint(1) DEFAULT '0',
  `fecha_nacimiento` date NOT NULL,
  `teléfono` varchar(20) NOT NULL,
  `historial` longtext,
  PRIMARY KEY (`idusuarios`),
  UNIQUE KEY `dni_UNIQUE` (`dni`),
  UNIQUE KEY `telephone_UNIQUE` (`teléfono`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#DROP TABLE IF EXISTS `citas`;
CREATE TABLE `mdadb`.`citas` (
  `idcita` INT NOT NULL AUTO_INCREMENT,
  `fechora` DATETIME NOT NULL,
  `idpaciente` INT NOT NULL,
  `idmedico` INT NOT NULL,
  PRIMARY KEY (`idcita`),
  INDEX `fk_idpaciente_idx` (`idpaciente` ASC),
  INDEX `fk_idmedico_idx` (`idmedico` ASC),
  UNIQUE INDEX `fechora_paciente` (`fechora`, `idpaciente`),
  UNIQUE INDEX `fechora_medico` (`fechora`, `idmedico`),
  CONSTRAINT `fk_idpaciente`
    FOREIGN KEY (`idpaciente`)
    REFERENCES `mdadb`.`usuarios` (`idusuarios`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_idmedico`
    FOREIGN KEY (`idmedico`)
    REFERENCES `mdadb`.`usuarios` (`idusuarios`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;