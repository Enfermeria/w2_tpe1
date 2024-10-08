-- Creo la bd.
CREATE database w2_tpe_libros;

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

CREATE TABLE `w2_tpe_libros`.`usuarios` (
    `idusuario` INT NOT NULL AUTO_INCREMENT ,
    `nombre` VARCHAR(45) NOT NULL , 
    `contraseña` VARCHAR(45) NOT NULL ,
    PRIMARY KEY (`idusuario`)
) ENGINE = InnoDB;


-- Relaciones entre tablas
ALTER TABLE `libro`
  ADD CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`idgenero`) REFERENCES `genero` (`idgenero`) ON UPDATE CASCADE,
  ADD CONSTRAINT `libro_ibfk_2` FOREIGN KEY (`idautor`) REFERENCES `autor` (`idautor`) ON UPDATE CASCADE;
COMMIT;


-- Insertamos datos de ejemplo a las tablas

INSERT INTO `genero` (`idgenero`, `genero`) VALUES 
    (NULL, 'Thriller'),
    (NULL, 'Narrativa'), 
    (NULL, 'Novela Realista'),
    (NULL, 'Juvenil'), 
    (NULL, 'Fantástico'), 
    (NULL, 'Histórica'), 
    (NULL, 'Misterio'), 
    (NULL, 'Ciencia Ficción'),
    (NULL, 'Clásico');;    


INSERT INTO `autor` (`idautor`, `nombre`, `biografia`) VALUES 
    (NULL, 'Aguinis, M', ''), 
    (NULL, 'Agustí, I', ''),
    (NULL, 'Alas Clarín, L', ''), 
    (NULL, 'Alcott, Louise M.', ''), 
    (NULL, 'Alexaindre, V', ''), 
    (NULL, 'Allende, Isabel', ''), 
    (NULL, 'Chesterton, G.K.', ''),
    (NULL, 'Christie, A.', ''), 
    (NULL, 'Chicot, M.', '');

INSERT INTO `libro` (`idlibro`, `titulo`, `idautor`, `idgenero`, `edicion`, `argumento`) VALUES 
    (NULL, 'Asalto al paraíso', '1', '5', '2002', ''), 
    (NULL, 'Mariona', '2', '6', '2001', ''), 
    (NULL, 'La Regenta', '3', '7', '1994', ''), 
    (NULL, 'Mujercitas', '4', '8', '2004', ''), 
    (NULL, 'La destrucción o el amor', '5', '13', '1984', ''), 
    (NULL, 'El reino del dragón de oro', '6', '9', '2016', ''),
    (NULL, 'El hombre que fue Jueves', '7', '13', '1984', ''), 
    (NULL, 'El asesinato de Pitágoras', '9', '10', '2013', ''), 
    (NULL, 'Asesinato en el Orient Expresss', '8', '11', '1987', ''), 
    (NULL, 'Maldad bajo el sol', '8', '11', '1983', '');

INSERT INTO `usuarios` (`idusuario`, `nombre`, `contraseña`) VALUES 
    (NULL, 'webadmin', 'admin');
