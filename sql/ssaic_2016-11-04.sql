-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-11-2016 a las 14:55:48
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ssaic`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcontactos`
--

CREATE TABLE IF NOT EXISTS `dbcontactos` (
  `idcontacto` int(11) NOT NULL AUTO_INCREMENT,
  `reftipocontacto` int(11) NOT NULL,
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
  PRIMARY KEY (`idcontacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcountries`
--

CREATE TABLE IF NOT EXISTS `dbcountries` (
  `idcountries` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(65) COLLATE utf8_spanish_ci NOT NULL,
  `cuit` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `coordenadas` point DEFAULT NULL,
  `fechaalta` date DEFAULT NULL,
  `fechabaja` date DEFAULT NULL,
  `activo` bit(1) DEFAULT NULL,
  `refposiciontributaria` int(11) NOT NULL,
  `refcontacto` int(11) NOT NULL,
  PRIMARY KEY (`idcountries`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbusuarios`
--

CREATE TABLE IF NOT EXISTS `dbusuarios` (
  `IdUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(30) NOT NULL,
  `refContacto` int(11) NOT NULL,
  `Pass` varchar(30) NOT NULL,
  `Activo` bit(1) NOT NULL,
  PRIMARY KEY (`IdUsuario`),
  KEY `idcontacto` (`refContacto`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `predio_menu`
--

INSERT INTO `predio_menu` (`idmenu`, `url`, `icono`, `nombre`, `Orden`, `hover`, `permiso`, `administracion`, `torneo`, `reportes`) VALUES
(1, '../torneos/', 'icotorneos', 'Torneos', 2, NULL, 'Administrador', b'0', b'1', b'0'),
(2, '../equipos/', 'icoequipos', 'Equipos', 3, NULL, 'Administrador', b'0', b'1', b'0'),
(3, '../zonas/', 'icozonas', 'Zonas', 4, NULL, 'Administrador', b'0', b'1', b'0'),
(4, '../zonasequipos/', 'icozonasequipos', 'Zonas-Equipos', 5, NULL, 'Administrador', b'0', b'1', b'0'),
(5, '../fixture/', 'icofixture', 'Fixture', 6, NULL, 'Administrador', b'0', b'1', b'0'),
(6, '../jugadores/', 'icojugadores', 'Jugadores', 7, NULL, 'Administrador', b'0', b'1', b'0'),
(7, '../estadisticas/', 'icochart', 'Estadisticas', 8, NULL, 'Administrador, Empleado', b'0', b'1', b'0'),
(8, '../fairplay/', 'icofairplay', 'FairPlay', 9, NULL, 'Administrador', b'0', b'1', b'0'),
(10, '../suspendidos/', 'icosuspendidos', 'Suspendidos', 11, NULL, 'Administrador', b'0', b'1', b'0'),
(11, '../noticias/', 'icoalquileres', 'Ultimas Noticias-Predio', 12, NULL, 'Administrador', b'0', b'1', b'0'),
(12, '../logout.php', 'icosalir', 'Salir', 30, NULL, 'Administrador, Empleado', b'0', b'1', b'0'),
(13, '../index.php', 'icodashboard', 'Dashboard', 1, NULL, 'Administrador, Empleado', b'0', b'1', b'0'),
(14, '../planillas/', 'icoreportes', 'Planillas', 14, NULL, 'Administrador', b'0', b'1', b'0'),
(15, '../noticiasgenerales/', 'icoalquileres', 'Noticias Generales', 13, NULL, 'Administrador', b'0', b'1', b'0'),
(16, '../pagina/', 'icoreportes', 'Editar Pagina', 17, NULL, 'Administrador', b'0', b'1', b'0'),
(17, '../index.php', 'icodashboard', 'Administracion', 1, NULL, 'Administrador, Empleado', b'1', b'0', b'0'),
(18, '../index.php', 'icodashboard', 'Reportes', 1, NULL, 'Administrador, Empleado', b'0', b'0', b'1'),
(19, '../countries/', 'icoinmubles', 'Countries', 2, NULL, 'Administrador', b'1', b'0', b'0'),
(20, '../contactos/', 'icoamonestados', 'Contactos', 3, NULL, 'Administrador', b'1', b'0', b'0'),
(21, '../tipocontacto/', 'icoamonestados', 'Tipo Contactos', 4, NULL, 'Administrador', b'1', b'0', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_usuarios`
--

CREATE TABLE IF NOT EXISTS `se_usuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `refroll` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nombrecompleto` varchar(70) NOT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `se_usuarios`
--

INSERT INTO `se_usuarios` (`idusuario`, `usuario`, `password`, `refroll`, `email`, `nombrecompleto`) VALUES
(1, 'marcos', 'marcos97nico98', '1', 'msredhotero@msn.com', 'Marcos Safar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcanchas`
--

CREATE TABLE IF NOT EXISTS `tbcanchas` (
  `idcancha` int(11) NOT NULL AUTO_INCREMENT,
  `cancha` varchar(55) COLLATE utf8_spanish_ci NOT NULL,
  `coordenadas` point DEFAULT NULL,
  `refcountry` int(11) NOT NULL,
  PRIMARY KEY (`idcancha`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `tbcanchas`
--

INSERT INTO `tbcanchas` (`idcancha`, `cancha`, `coordenadas`, `refcountry`) VALUES
(1, 'Cancha 1A', NULL, 0),
(2, 'Cancha 2', NULL, 0),
(3, 'Cancha 3', NULL, 0),
(4, 'Cancha 4', NULL, 0),
(5, 'Cancha 5', NULL, 0),
(6, 'Cancha 6A', NULL, 0),
(7, 'Cancha 7', NULL, 0),
(8, 'Cancha 8', NULL, 0),
(9, 'Cancha 9', NULL, 0),
(10, 'Cancha 10', NULL, 0),
(11, 'Cancha 1B', NULL, 0),
(12, 'Cancha 6B', NULL, 0);

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
-- Estructura de tabla para la tabla `tbtipocontacto`
--

CREATE TABLE IF NOT EXISTS `tbtipocontacto` (
  `idtipocontacto` int(11) NOT NULL AUTO_INCREMENT,
  `tipocontacto` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `activo` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`idtipocontacto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `tbtipocontacto`
--

INSERT INTO `tbtipocontacto` (`idtipocontacto`, `tipocontacto`, `activo`) VALUES
(1, 'Cliente', b'1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
