-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 20-03-2017 a las 22:44:18
-- Versión del servidor: 5.5.20
-- Versión de PHP: 5.3.10

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
-- Estructura de tabla para la tabla `dbsancionesfechascumplidas`
--

CREATE TABLE IF NOT EXISTS `dbsancionesfechascumplidas` (
  `idsancionfechacumplida` int(11) NOT NULL AUTO_INCREMENT,
  `refsancionesfallos` int(11) NOT NULL,
  `reffechas` int(11) NOT NULL,
  `refestadospartidos` int(11) NOT NULL,
  `cumplida` bit(1) NOT NULL,
  PRIMARY KEY (`idsancionfechacumplida`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
