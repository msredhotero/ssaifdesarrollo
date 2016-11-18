-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 18-11-2016 a las 15:59:12
-- Versión del servidor: 5.1.36-community-log
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
-- Estructura de tabla para la tabla `dbjugadores`
--

CREATE TABLE IF NOT EXISTS `dbjugadores` (
  `idjugador` int(11) NOT NULL AUTO_INCREMENT,
  `reftipodocumentos` int(11) NOT NULL,
  `nrodocumento` int(11) NOT NULL,
  `apellido` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechanacimiento` date NOT NULL,
  `fechaalta` date NOT NULL,
  `fechabaja` date DEFAULT NULL,
  `refcountries` int(11) NOT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idjugador`),
  KEY `fk_jugadores_tipodocumentos_idx` (`reftipodocumentos`),
  KEY `fk_jugadores_countries_idx` (`refcountries`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbjugadoresdocumentacion`
--

CREATE TABLE IF NOT EXISTS `dbjugadoresdocumentacion` (
  `idjugadordocumentacion` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `refdocumentaciones` int(11) NOT NULL,
  `valor` bit(1) DEFAULT NULL,
  `habilita` bit(1) DEFAULT NULL,
  `observaciones` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idjugadordocumentacion`),
  KEY `fk_jugadoresdocu_jugadores_idx` (`refjugadores`),
  KEY `fk_jugadoresdocu_documentacion_idx` (`refdocumentaciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio_menu`
--

CREATE TABLE IF NOT EXISTS `predio_menu` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `icono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` smallint(6) DEFAULT NULL,
  `hover` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `permiso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `administracion` bit(1) DEFAULT NULL,
  `torneo` bit(1) DEFAULT NULL,
  `reportes` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=32 ;

--
-- Volcado de datos para la tabla `predio_menu`
--

INSERT INTO `predio_menu` (`idmenu`, `url`, `icono`, `nombre`, `Orden`, `hover`, `permiso`, `administracion`, `torneo`, `reportes`) VALUES
(12, '../logout.php', 'icosalir', 'Salir', 30, NULL, 'Administrador, Empleado', b'0', b'1', b'0'),
(13, '../index.php', 'icodashboard', 'Dashboard', 1, NULL, 'Administrador, Empleado', b'0', b'1', b'0'),
(19, '../countries/', 'icozonas', 'Countries', 2, NULL, 'Administrador', b'1', b'0', b'0'),
(20, '../contactos/', 'icozonas', 'Contactos', 3, NULL, 'Administrador', b'1', b'0', b'0'),
(21, '../tipocontacto/', 'icozonas', 'Tipo Contactos', 4, NULL, 'Administrador', b'1', b'0', b'0'),
(22, '../posiciontributaria/', 'icozonas', 'Posicion Tributaria', 25, NULL, 'Administrador', b'1', b'0', b'0'),
(23, '../canchas/', 'icozonas', 'Canchas', 24, NULL, 'Administrador', b'1', b'0', b'0'),
(24, '../arbitros/', 'icozonas', 'Arbitros', 9, NULL, 'Administrador', b'1', b'1', b'1'),
(25, '../categorias/', 'icozonas', 'Categorias', 8, NULL, 'Administrador', b'1', b'1', b'1'),
(26, '../divisiones/', 'icozonas', 'Divisiones', 7, NULL, 'Administrador', b'1', b'1', b'1'),
(27, '../temporadas/', 'icozonas', 'Temporadas', 6, NULL, 'Administrador', b'1', b'1', b'1'),
(28, '../motivoshabilitacionestransitorias/', 'icozonas', 'Mot. Hab. Trans.', 10, NULL, 'Administrador', b'1', b'1', b'1'),
(29, '../documentaciones/', 'icozonas', 'Documentaciones', 11, NULL, 'Administrador', b'1', b'1', b'1'),
(30, '../tipojugadores/', 'icozonas', 'Tipo Jugadores', 12, NULL, 'Administrador', b'1', b'1', b'1'),
(31, '../jugadores/', 'icozonas', 'Jugadores', 13, NULL, 'Administrador', b'1', b'1', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdocumentaciones`
--

CREATE TABLE IF NOT EXISTS `tbdocumentaciones` (
  `iddocumentacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `obligatoria` bit(1) NOT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`iddocumentacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `tbdocumentaciones`
--

INSERT INTO `tbdocumentaciones` (`iddocumentacion`, `descripcion`, `obligatoria`, `observaciones`) VALUES
(1, 'Foto', b'1', ''),
(2, 'Nro Documento', b'1', ''),
(3, 'Ficha', b'1', ''),
(4, 'Expensas', b'1', ''),
(5, 'Titulo', b'1', ''),
(6, 'Inhabilitacion Countrie', b'1', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbmotivoshabilitacionestransitorias`
--

CREATE TABLE IF NOT EXISTS `tbmotivoshabilitacionestransitorias` (
  `idmotivoshabilitacionestransitoria` int(11) NOT NULL AUTO_INCREMENT,
  `inhabilita` bit(1) NOT NULL DEFAULT b'1',
  `descripcion` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idmotivoshabilitacionestransitoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `tbmotivoshabilitacionestransitorias`
--

INSERT INTO `tbmotivoshabilitacionestransitorias` (`idmotivoshabilitacionestransitoria`, `inhabilita`, `descripcion`) VALUES
(1, b'0', 'Foto'),
(2, b'0', 'Documento'),
(3, b'0', 'Titulo Propiedad'),
(4, b'0', 'Boleto'),
(5, b'0', 'Dominio'),
(6, b'0', 'Expensa o Servicio'),
(7, b'1', 'Edad'),
(8, b'1', 'Antiguedad 10 años');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipodocumentos`
--

CREATE TABLE IF NOT EXISTS `tbtipodocumentos` (
  `idtipodocumento` int(11) NOT NULL AUTO_INCREMENT,
  `tipodocumento` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipodocumento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tbtipodocumentos`
--

INSERT INTO `tbtipodocumentos` (`idtipodocumento`, `tipodocumento`) VALUES
(1, 'DNI'),
(2, 'LE'),
(3, 'LC'),
(4, 'Pasaporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipojugadores`
--

CREATE TABLE IF NOT EXISTS `tbtipojugadores` (
  `idtipojugador` int(11) NOT NULL AUTO_INCREMENT,
  `tipojugador` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `abreviatura` varchar(6) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipojugador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbjugadores`
--
ALTER TABLE `dbjugadores`
  ADD CONSTRAINT `fk_jugadores_tipodocumentos` FOREIGN KEY (`reftipodocumentos`) REFERENCES `tbtipodocumentos` (`idtipodocumento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jugadores_countries` FOREIGN KEY (`refcountries`) REFERENCES `dbcountries` (`idcountrie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbjugadoresdocumentacion`
--
ALTER TABLE `dbjugadoresdocumentacion`
  ADD CONSTRAINT `fk_jugadoresdocu_documentacion` FOREIGN KEY (`refdocumentaciones`) REFERENCES `tbdocumentaciones` (`iddocumentacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jugadoresdocu_jugadores` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
