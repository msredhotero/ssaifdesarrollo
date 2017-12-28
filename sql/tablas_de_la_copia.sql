CREATE TABLE `dbcabeceracopia` (
  `idcabeceracopia` int(11) NOT NULL AUTO_INCREMENT,
  `copia` int(11) NOT NULL,
  `reftemporadas` int(11) NOT NULL,
  PRIMARY KEY (`idcabeceracopia`),
  KEY `fk_copia_temporadas_idx` (`reftemporadas`),
  CONSTRAINT `fk_copia_temporadas` FOREIGN KEY (`reftemporadas`) REFERENCES `tbtemporadas` (`idtemporadas`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `dbjugadoresdocumentacion_copia` (
  `idjugadordocumentacioncopia` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `refdocumentaciones` int(11) NOT NULL,
  `valor` bit(1) DEFAULT NULL,
  `observaciones` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `refjugadoresdocumentacion` int(11) NOT NULL,
  `refcabeceracopia` int(11) DEFAULT NULL,
  PRIMARY KEY (`idjugadordocumentacioncopia`),
  KEY `fk_jd_copia_idx` (`refcabeceracopia`),
  CONSTRAINT `fk_jd_copia` FOREIGN KEY (`refcabeceracopia`) REFERENCES `dbcabeceracopia` (`idcabeceracopia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `dbjugadoresmotivoshabilitacionestransitorias_copia` (
  `iddbjugadormotivohabilitaciontransitoriacopia` int(11) NOT NULL AUTO_INCREMENT,
  `reftemporadas` int(11) NOT NULL,
  `refjugadores` int(11) NOT NULL,
  `refdocumentaciones` int(11) DEFAULT NULL,
  `refmotivoshabilitacionestransitorias` int(11) NOT NULL,
  `refequipos` int(11) DEFAULT NULL,
  `refcategorias` int(11) DEFAULT NULL,
  `fechalimite` date NOT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `refdbjugadormotivohabilitaciontransitoria` int(11) NOT NULL,
  `refcabeceracopia` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddbjugadormotivohabilitaciontransitoriacopia`),
  KEY `fk_jm_copia_idx` (`refcabeceracopia`),
  CONSTRAINT `fk_jm_copia` FOREIGN KEY (`refcabeceracopia`) REFERENCES `dbcabeceracopia` (`idcabeceracopia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `dbjugadoresvaloreshabilitacionestransitorias_copia` (
  `iddbjugadorvalorhabilitaciontransitoriacopia` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `refvaloreshabilitacionestransitorias` int(11) NOT NULL,
  `refdbjugadorvalorhabilitaciontransitoria` int(11) NOT NULL,
  `refcabeceracopia` int(11) DEFAULT NULL,
  PRIMARY KEY (`iddbjugadorvalorhabilitaciontransitoriacopia`),
  KEY `fk_jv_copia_idx` (`refcabeceracopia`),
  CONSTRAINT `fk_jv_copia` FOREIGN KEY (`refcabeceracopia`) REFERENCES `dbcabeceracopia` (`idcabeceracopia`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



