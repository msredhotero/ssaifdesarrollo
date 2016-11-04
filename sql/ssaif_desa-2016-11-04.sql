-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-11-2016 a las 19:33:58
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
-- Estructura de tabla para la tabla `dbcontactos`
--

CREATE TABLE IF NOT EXISTS `dbcontactos` (
  `idcontacto` int(11) NOT NULL AUTO_INCREMENT,
  `reftipocontactos` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `localidad` varchar(65) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cp` varchar(7) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(22) COLLATE utf8_spanish_ci DEFAULT NULL,
  `celular` varchar(22) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fax` varchar(22) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `publico` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idcontacto`),
  KEY `fk_contacto_tipocontacto_idx` (`reftipocontactos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `dbcontactos`
--

INSERT INTO `dbcontactos` (`idcontacto`, `reftipocontactos`, `nombre`, `direccion`, `localidad`, `cp`, `telefono`, `celular`, `fax`, `email`, `observaciones`, `publico`) VALUES
(2, 2, 'Cardozo Julian', '', 'La plata', '1900', '4657899', '', '', 'gerardo@msn.com', '', b'1'),
(4, 1, 'Safar Marcos', 'Barrio UOM torre "C" dpto 320', 'Ensenada', '1925', '65498312', '', '', 'juancarlos@msn.com', '', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcountries`
--

CREATE TABLE IF NOT EXISTS `dbcountries` (
  `idcountrie` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(65) COLLATE utf8_spanish_ci NOT NULL,
  `cuit` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `fechaalta` date DEFAULT NULL,
  `fechabaja` date DEFAULT NULL,
  `refposiciontributaria` int(11) NOT NULL,
  `refcontactos` int(11) NOT NULL,
  `latitud` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `longitud` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` bit(1) DEFAULT NULL,
  `referencia` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcountrie`),
  KEY `fk_countries_contactos_idx` (`refcontactos`),
  KEY `fk_countries_posiciontributaria_idx` (`refposiciontributaria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `dbcountries`
--

INSERT INTO `dbcountries` (`idcountrie`, `nombre`, `cuit`, `fechaalta`, `fechabaja`, `refposiciontributaria`, `refcontactos`, `latitud`, `longitud`, `activo`, `referencia`) VALUES
(1, 'Los alpes', '30-20654789', '2016-11-04', '2016-11-04', 1, 2, '-34.61936482473979', '-58.61048699123785', b'0', 'Javier');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbusuarios`
--

CREATE TABLE IF NOT EXISTS `dbusuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `refroles` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nombrecompleto` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idusuario`),
  KEY `fk_dbusuarios_tbroles1_idx` (`refroles`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `dbusuarios`
--

INSERT INTO `dbusuarios` (`idusuario`, `usuario`, `password`, `refroles`, `email`, `nombrecompleto`) VALUES
(2, 'marcos', 'marcos', 1, 'msredhotero@msn.com', 'Saupurein Marcos');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `predio_menu`
--

INSERT INTO `predio_menu` (`idmenu`, `url`, `icono`, `nombre`, `Orden`, `hover`, `permiso`, `administracion`, `torneo`, `reportes`) VALUES
(12, '../logout.php', 'icosalir', 'Salir', 30, NULL, 'Administrador, Empleado', b'0', b'1', b'0'),
(13, '../index.php', 'icodashboard', 'Dashboard', 1, NULL, 'Administrador, Empleado', b'0', b'1', b'0'),
(19, '../countries/', 'icoinmubles', 'Countries', 2, NULL, 'Administrador', b'1', b'0', b'0'),
(20, '../contactos/', 'icoamonestados', 'Contactos', 3, NULL, 'Administrador', b'1', b'0', b'0'),
(21, '../tipocontacto/', 'icoamonestados', 'Tipo Contactos', 4, NULL, 'Administrador', b'1', b'0', b'0'),
(22, '../posiciontributaria/', 'icoamonestados', 'Posicion Tributaria', 25, NULL, 'Administrador', b'1', b'0', b'0'),
(23, '../canchas/', 'icocanchas', 'Canchas', 24, NULL, 'Administrador', b'1', b'0', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcanchas`
--

CREATE TABLE IF NOT EXISTS `tbcanchas` (
  `idcancha` int(11) NOT NULL AUTO_INCREMENT,
  `refcountries` int(11) NOT NULL,
  `nombre` varchar(55) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idcancha`),
  KEY `fk_canchas_countries_idx` (`refcountries`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `tbcanchas`
--

INSERT INTO `tbcanchas` (`idcancha`, `refcountries`, `nombre`) VALUES
(13, 1, 'Cancha 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbposiciontributaria`
--

CREATE TABLE IF NOT EXISTS `tbposiciontributaria` (
  `idposiciontributaria` int(11) NOT NULL AUTO_INCREMENT,
  `posiciontributaria` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `activo` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`idposiciontributaria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tbposiciontributaria`
--

INSERT INTO `tbposiciontributaria` (`idposiciontributaria`, `posiciontributaria`, `activo`) VALUES
(1, 'General', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbroles`
--

CREATE TABLE IF NOT EXISTS `tbroles` (
  `idrol` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `activo` bit(1) NOT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tbroles`
--

INSERT INTO `tbroles` (`idrol`, `descripcion`, `activo`) VALUES
(1, 'Administrador', b'1'),
(2, 'Empleado', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipocontactos`
--

CREATE TABLE IF NOT EXISTS `tbtipocontactos` (
  `idtipocontacto` int(11) NOT NULL AUTO_INCREMENT,
  `tipocontacto` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `activo` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`idtipocontacto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tbtipocontactos`
--

INSERT INTO `tbtipocontactos` (`idtipocontacto`, `tipocontacto`, `activo`) VALUES
(1, 'Cliente', b'1'),
(2, 'Delegado', b'1');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbcontactos`
--
ALTER TABLE `dbcontactos`
  ADD CONSTRAINT `fk_contacto_tipocontacto` FOREIGN KEY (`reftipocontactos`) REFERENCES `tbtipocontactos` (`idtipocontacto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbcountries`
--
ALTER TABLE `dbcountries`
  ADD CONSTRAINT `fk_countries_contactos` FOREIGN KEY (`refcontactos`) REFERENCES `dbcontactos` (`idcontacto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_countries_posiciontributaria` FOREIGN KEY (`refposiciontributaria`) REFERENCES `tbposiciontributaria` (`idposiciontributaria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbcanchas`
--
ALTER TABLE `tbcanchas`
  ADD CONSTRAINT `fk_canchas_countries` FOREIGN KEY (`refcountries`) REFERENCES `dbcountries` (`idcountrie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
