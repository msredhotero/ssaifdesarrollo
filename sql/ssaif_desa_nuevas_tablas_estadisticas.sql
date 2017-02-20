-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 20-02-2017 a las 11:55:12
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ssaif_desa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbmejorjugador`
--

CREATE TABLE IF NOT EXISTS `dbmejorjugador` (
  `idmejorjugador` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `reffixture` int(11) NOT NULL,
  `refequipos` int(11) NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `refdivisiones` int(11) NOT NULL,
  PRIMARY KEY (`idmejorjugador`),
  KEY `fk_mejor_jugador_idx` (`refjugadores`),
  KEY `fk_mejor_fixture_idx` (`reffixture`),
  KEY `fk_mejor_equipos_idx` (`refequipos`),
  KEY `fk_mejor_categorias_idx` (`refcategorias`),
  KEY `fk_mejor_divisiones_idx` (`refdivisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbminutosjugados`
--

CREATE TABLE IF NOT EXISTS `dbminutosjugados` (
  `idminutojugado` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `reffixture` int(11) NOT NULL,
  `refequipos` int(11) NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `refdivisiones` int(11) NOT NULL,
  `minutos` int(11) NOT NULL,
  PRIMARY KEY (`idminutojugado`),
  KEY `fk_minutos_jugadores_idx` (`refjugadores`),
  KEY `fk_minutos_fixture_idx` (`reffixture`),
  KEY `fk_minutos_equipos_idx` (`refequipos`),
  KEY `fk_minutos_categorias_idx` (`refcategorias`),
  KEY `fk_minutos_divisiones_idx` (`refdivisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbpenalesjugadores`
--

CREATE TABLE IF NOT EXISTS `dbpenalesjugadores` (
  `idpenaljugador` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `reffixture` int(11) NOT NULL,
  `refequipos` int(11) NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `refdivisiones` int(11) NOT NULL,
  `penalconvertido` int(11) DEFAULT NULL,
  `penalerrado` int(11) DEFAULT NULL,
  `penalatajado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idpenaljugador`),
  KEY `fk_penales_jugadores_idx` (`refjugadores`),
  KEY `fk_penales_fixture_idx` (`reffixture`),
  KEY `fk_penales_equipos_idx` (`refequipos`),
  KEY `fk_penales_categorias_idx` (`refcategorias`),
  KEY `fk_penales_divisiones_idx` (`refdivisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbsancionesfallos`
--

CREATE TABLE IF NOT EXISTS `dbsancionesfallos` (
  `idsancionfallo` int(11) NOT NULL AUTO_INCREMENT,
  `refsancionesjugadores` int(11) NOT NULL,
  `cantidadfechas` int(11) NOT NULL,
  `fechadesde` date DEFAULT NULL,
  `fechahasta` date DEFAULT NULL,
  `fechascumplidas` int(11) DEFAULT NULL,
  `pendientescumplimientos` bit(1) DEFAULT NULL,
  `pendientesfallo` bit(1) DEFAULT NULL,
  `generadaporacumulacion` bit(1) DEFAULT NULL,
  `observaciones` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idsancionfallo`),
  KEY `fk_fallos_sancionesjugadores_idx` (`refsancionesjugadores`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbsancionesjugadores`
--

CREATE TABLE IF NOT EXISTS `dbsancionesjugadores` (
  `idsancionjugador` int(11) NOT NULL AUTO_INCREMENT,
  `reftiposanciones` int(11) NOT NULL,
  `refjugadores` int(11) NOT NULL,
  `refequipos` int(11) NOT NULL,
  `reffixture` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `refdivisiones` int(11) NOT NULL,
  `refsancionesfallos` int(11) DEFAULT NULL,
  PRIMARY KEY (`idsancionjugador`),
  KEY `fk_sancionesjug_tiposancion_idx` (`reftiposanciones`),
  KEY `fk_sancionesjug_jugadores_idx` (`refjugadores`),
  KEY `fk_sancionesjug_fixture_idx` (`reffixture`),
  KEY `fk_sancionesjug_equipos_idx` (`refequipos`),
  KEY `fk_sancionesjug_categorias_idx` (`refcategorias`),
  KEY `fk_sancionesjug_divisiones_idx` (`refdivisiones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbmejorjugador`
--
ALTER TABLE `dbmejorjugador`
  ADD CONSTRAINT `fk_mejor_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mejor_divisiones` FOREIGN KEY (`refdivisiones`) REFERENCES `tbdivisiones` (`iddivision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mejor_equipos` FOREIGN KEY (`refequipos`) REFERENCES `dbequipos` (`idequipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mejor_fixture` FOREIGN KEY (`reffixture`) REFERENCES `dbfixture` (`idfixture`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mejor_jugador` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbminutosjugados`
--
ALTER TABLE `dbminutosjugados`
  ADD CONSTRAINT `fk_minutos_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_minutos_divisiones` FOREIGN KEY (`refdivisiones`) REFERENCES `tbdivisiones` (`iddivision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_minutos_equipos` FOREIGN KEY (`refequipos`) REFERENCES `dbequipos` (`idequipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_minutos_fixture` FOREIGN KEY (`reffixture`) REFERENCES `dbfixture` (`idfixture`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_minutos_jugadores` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbpenalesjugadores`
--
ALTER TABLE `dbpenalesjugadores`
  ADD CONSTRAINT `fk_penales_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_penales_divisiones` FOREIGN KEY (`refdivisiones`) REFERENCES `tbdivisiones` (`iddivision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_penales_equipos` FOREIGN KEY (`refequipos`) REFERENCES `dbequipos` (`idequipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_penales_fixture` FOREIGN KEY (`reffixture`) REFERENCES `dbfixture` (`idfixture`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_penales_jugadores` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbsancionesfallos`
--
ALTER TABLE `dbsancionesfallos`
  ADD CONSTRAINT `fk_fallos_sancionesjugadores` FOREIGN KEY (`refsancionesjugadores`) REFERENCES `dbsancionesjugadores` (`idsancionjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbsancionesjugadores`
--
ALTER TABLE `dbsancionesjugadores`
  ADD CONSTRAINT `fk_sancionesjug_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sancionesjug_divisiones` FOREIGN KEY (`refdivisiones`) REFERENCES `tbdivisiones` (`iddivision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sancionesjug_equipos` FOREIGN KEY (`refequipos`) REFERENCES `dbequipos` (`idequipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sancionesjug_fixture` FOREIGN KEY (`reffixture`) REFERENCES `dbfixture` (`idfixture`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sancionesjug_jugadores` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sancionesjug_tiposancion` FOREIGN KEY (`reftiposanciones`) REFERENCES `tbtiposanciones` (`idtiposancion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
