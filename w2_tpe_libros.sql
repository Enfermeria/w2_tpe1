-- Creo la bd.
CREATE database w2_tpe_libros;
SH0W databases;
USE w2_tpe_libros;


-- y sus tablas
CREATE TABLE `w2_tpe_libros`.`libro` (
    `idlibro` INT NOT NULL AUTO_INCREMENT , 
    `titulo` VARCHAR(45) NOT NULL , 
    `idautor` INT NOT NULL , 
    `idgenero` INT NOT NULL ,
    `edicion` INT(4) NOT NULL ,
    `argumento` VARCHAR(300) NOT NULL ,
    PRIMARY KEY (`idlibro`), 
    INDEX `idx_idautor` (`idautor`), 
    INDEX `idx_idgenero` (`idgenero`)
) ENGINE = InnoDB;


CREATE TABLE `w2_tpe_libros`.`autor` (
    `idautor` INT NOT NULL AUTO_INCREMENT , 
    `nombre` VARCHAR(45) NOT NULL , 
    `biografia` VARCHAR(300) NOT NULL ,
    PRIMARY KEY (`idautor`) 
) ENGINE = InnoDB;

CREATE TABLE `w2_tpe_libros`.`genero` (
    `idgenero` INT NOT NULL AUTO_INCREMENT , 
    `genero` VARCHAR(45) NOT NULL , 
    PRIMARY KEY (`idgenero`)
) ENGINE = InnoDB;