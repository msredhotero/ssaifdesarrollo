-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-02-2017 a las 16:35:55
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
-- Estructura de tabla para la tabla `dbarbitros`
--

CREATE TABLE IF NOT EXISTS `dbarbitros` (
  `idarbitro` int(11) NOT NULL AUTO_INCREMENT,
  `nombrecompleto` varchar(200) CHARACTER SET utf8 NOT NULL,
  `telefonoparticular` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonoceleluar` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonolaboral` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonofamiliar` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(130) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idarbitro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=895 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcanchasuspenciones`
--

CREATE TABLE IF NOT EXISTS `dbcanchasuspenciones` (
  `idcanchasuspencion` int(11) NOT NULL AUTO_INCREMENT,
  `refcanchas` int(11) NOT NULL,
  `vigenciadesde` date NOT NULL,
  `vigenciahasta` date DEFAULT NULL,
  `usuacrea` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechacrea` datetime DEFAULT NULL,
  `usuamodi` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechamodi` datetime DEFAULT NULL,
  PRIMARY KEY (`idcanchasuspencion`),
  KEY `fk_canchassuspenciones_canchas_idx` (`refcanchas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbconector`
--

CREATE TABLE IF NOT EXISTS `dbconector` (
  `idconector` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `reftipojugadores` int(11) NOT NULL,
  `refequipos` int(11) NOT NULL,
  `refcountries` int(11) NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `esfusion` bit(1) NOT NULL,
  `activo` bit(1) NOT NULL,
  PRIMARY KEY (`idconector`),
  KEY `fk_conector_jugadores_idx` (`refjugadores`),
  KEY `fk_conector_tj_idx` (`reftipojugadores`),
  KEY `fk_conector_refequipos_idx` (`refequipos`),
  KEY `fk_conector_countrie_idx` (`refcountries`),
  KEY `fk_conector_categoria_idx` (`refcategorias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=19 ;

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
  `email` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `publico` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idcontacto`),
  KEY `fk_contacto_tipocontacto_idx` (`reftipocontactos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcountriecanchas`
--

CREATE TABLE IF NOT EXISTS `dbcountriecanchas` (
  `idcountriecancha` int(11) NOT NULL AUTO_INCREMENT,
  `refcountries` int(11) NOT NULL,
  `refcanchas` int(11) NOT NULL,
  PRIMARY KEY (`idcountriecancha`),
  KEY `fk_tabla_countries_idx` (`refcountries`),
  KEY `fk_tabla_canchas_idx` (`refcanchas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbcountriecontactos`
--

CREATE TABLE IF NOT EXISTS `dbcountriecontactos` (
  `idcountriecontacto` int(11) NOT NULL AUTO_INCREMENT,
  `refcountries` int(11) NOT NULL,
  `refcontactos` int(11) NOT NULL,
  PRIMARY KEY (`idcountriecontacto`),
  KEY `fk_tabla_countries_idx` (`refcountries`),
  KEY `fk_tabla2_contactos_idx` (`refcontactos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=46 ;

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
  `latitud` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `longitud` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` bit(1) DEFAULT NULL,
  `referencia` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen` varchar(110) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonoadministrativo` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefonocampo` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `localidad` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigopostal` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idcountrie`),
  KEY `fk_countries_posiciontributaria_idx` (`refposiciontributaria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdefinicionescategoriastemporadas`
--

CREATE TABLE IF NOT EXISTS `dbdefinicionescategoriastemporadas` (
  `iddefinicioncategoriatemporada` int(11) NOT NULL AUTO_INCREMENT,
  `refcategorias` int(11) NOT NULL,
  `reftemporadas` int(11) NOT NULL,
  `cantmaxjugadores` int(11) NOT NULL,
  `cantminjugadores` int(11) NOT NULL,
  `refdias` int(11) NOT NULL,
  `hora` varchar(5) CHARACTER SET utf8 NOT NULL,
  `minutospartido` int(11) NOT NULL,
  `cantidadcambiosporpartido` int(11) NOT NULL,
  `conreingreso` bit(1) NOT NULL,
  `observaciones` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`iddefinicioncategoriatemporada`),
  KEY `fk_dct_categorias_idx` (`refcategorias`),
  KEY `fk_dct_temporadas_idx` (`reftemporadas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdefinicionescategoriastemporadastipojugador`
--

CREATE TABLE IF NOT EXISTS `dbdefinicionescategoriastemporadastipojugador` (
  `iddefinicionescategoriastemporadastipojugador` int(11) NOT NULL AUTO_INCREMENT,
  `refdefinicionescategoriastemporadas` int(11) NOT NULL,
  `reftipojugadores` int(11) NOT NULL,
  `edadmaxima` int(11) NOT NULL,
  `edadminima` int(11) NOT NULL,
  `cantjugadoresporequipo` int(11) NOT NULL,
  `jugadorescancha` int(11) NOT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`iddefinicionescategoriastemporadastipojugador`),
  KEY `fk_dcttj_dct_idx` (`refdefinicionescategoriastemporadas`),
  KEY `fk_dcttj_tipojugador_idx` (`reftipojugadores`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbdefinicionessancionesacumuladastemporadas`
--

CREATE TABLE IF NOT EXISTS `dbdefinicionessancionesacumuladastemporadas` (
  `iddefinicionessancionesacumuladastemporadas` int(11) NOT NULL AUTO_INCREMENT,
  `reftiposanciones` int(11) NOT NULL,
  `reftemporadas` int(11) NOT NULL,
  `cantidadacumulada` int(11) NOT NULL,
  `cantidadfechasacumplir` int(11) NOT NULL,
  PRIMARY KEY (`iddefinicionessancionesacumuladastemporadas`),
  KEY `fk_dsat_tiposanciones_idx` (`reftiposanciones`),
  KEY `fk_dsat_temporadas_idx` (`reftemporadas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbequipos`
--

CREATE TABLE IF NOT EXISTS `dbequipos` (
  `idequipo` int(11) NOT NULL AUTO_INCREMENT,
  `refcountries` int(11) NOT NULL,
  `nombre` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `refdivisiones` int(11) NOT NULL,
  `refcontactos` int(11) DEFAULT NULL,
  `fechaalta` date DEFAULT NULL,
  `fachebaja` date DEFAULT NULL,
  `activo` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idequipo`),
  KEY `fk_equipos_contries_idx` (`refcountries`),
  KEY `fk_equipos_categorias_idx` (`refcategorias`),
  KEY `fk_equipos_divisiones_idx` (`refdivisiones`),
  KEY `fk_equipos_contactos_idx` (`refcontactos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbfixture`
--

CREATE TABLE IF NOT EXISTS `dbfixture` (
  `idfixture` int(11) NOT NULL AUTO_INCREMENT,
  `reftorneos` int(11) NOT NULL,
  `reffechas` int(11) NOT NULL,
  `refconectorlocal` int(11) DEFAULT '0',
  `refconectorvisitante` int(11) DEFAULT '0',
  `refarbitros` int(11) DEFAULT '0',
  `juez1` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `juez2` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `refcanchas` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `hora` time NOT NULL,
  `refestadospartidos` int(11) DEFAULT '0',
  `calificacioncancha` int(11) DEFAULT NULL,
  `puntoslocal` int(11) DEFAULT NULL,
  `puntosvisita` int(11) DEFAULT NULL,
  `goleslocal` int(11) DEFAULT NULL,
  `golesvisitantes` int(11) DEFAULT NULL,
  `observaciones` varchar(500) COLLATE utf8_spanish_ci DEFAULT NULL,
  `publicar` bit(1) NOT NULL,
  PRIMARY KEY (`idfixture`),
  KEY `fk_fixture_torneos_idx` (`reftorneos`),
  KEY `fk_fixture_fechas_idx` (`reffechas`),
  KEY `fk_fixture_estadopartidos_idx` (`refestadospartidos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbgoleadores`
--

CREATE TABLE IF NOT EXISTS `dbgoleadores` (
  `idgoleador` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `reffixture` int(11) NOT NULL,
  `refequipos` int(11) NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `refdivisiones` int(11) NOT NULL,
  `goles` int(11) DEFAULT '0',
  `encontra` int(11) DEFAULT '0',
  PRIMARY KEY (`idgoleador`),
  KEY `fk_goleadores_jugadores_idx` (`refjugadores`),
  KEY `fk_goleadores_fixture_idx` (`reffixture`),
  KEY `fk_goleadores_equipos_idx` (`refequipos`),
  KEY `fk_goleadores_categorias_idx` (`refcategorias`),
  KEY `fk_goleadores_divisiones_idx` (`refdivisiones`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=16 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbjugadoresdocumentacion`
--

CREATE TABLE IF NOT EXISTS `dbjugadoresdocumentacion` (
  `idjugadordocumentacion` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `refdocumentaciones` int(11) NOT NULL,
  `valor` bit(1) DEFAULT NULL,
  `observaciones` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idjugadordocumentacion`),
  KEY `fk_jugadoresdocu_jugadores_idx` (`refjugadores`),
  KEY `fk_jugadoresdocu_documentacion_idx` (`refdocumentaciones`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=183 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbjugadoresmotivoshabilitacionestransitorias`
--

CREATE TABLE IF NOT EXISTS `dbjugadoresmotivoshabilitacionestransitorias` (
  `iddbjugadormotivohabilitaciontransitoria` int(11) NOT NULL AUTO_INCREMENT,
  `reftemporadas` int(11) NOT NULL,
  `refjugadores` int(11) NOT NULL,
  `refdocumentaciones` int(11) DEFAULT NULL,
  `refmotivoshabilitacionestransitorias` int(11) NOT NULL,
  `refequipos` int(11) NOT NULL,
  `refcategorias` int(11) DEFAULT NULL,
  `fechalimite` date NOT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`iddbjugadormotivohabilitaciontransitoria`),
  KEY `fk_jmht_jugador_idx` (`refjugadores`),
  KEY `fk_jmht_motivos_idx` (`refmotivoshabilitacionestransitorias`),
  KEY `fk_jmht_temporadas_idx` (`reftemporadas`),
  KEY `fk_jmht_equipos_idx` (`refequipos`),
  KEY `fk_jmht_categorias_idx` (`refcategorias`),
  KEY `fk_jmht_documentaciones_idx` (`refdocumentaciones`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbjugadoresvaloreshabilitacionestransitorias`
--

CREATE TABLE IF NOT EXISTS `dbjugadoresvaloreshabilitacionestransitorias` (
  `iddbjugadorvalorhabilitaciontransitoria` int(11) NOT NULL AUTO_INCREMENT,
  `refjugadores` int(11) NOT NULL,
  `refvaloreshabilitacionestransitorias` int(11) NOT NULL,
  PRIMARY KEY (`iddbjugadorvalorhabilitaciontransitoria`),
  KEY `fk_jvht_jugadores_idx` (`refjugadores`),
  KEY `fk_jvht_valores_idx` (`refvaloreshabilitacionestransitorias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=52 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=19 ;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbtorneos`
--

CREATE TABLE IF NOT EXISTS `dbtorneos` (
  `idtorneo` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `reftipotorneo` int(11) NOT NULL,
  `reftemporadas` int(11) NOT NULL,
  `refcategorias` int(11) NOT NULL,
  `refdivisiones` int(11) NOT NULL,
  `cantidadascensos` smallint(6) DEFAULT NULL,
  `cantidaddescensos` smallint(6) DEFAULT NULL,
  `respetadefiniciontipojugadores` bit(1) DEFAULT NULL,
  `respetadefinicionhabilitacionestransitorias` bit(1) DEFAULT NULL,
  `respetadefinicionsancionesacumuladas` bit(1) DEFAULT NULL,
  `acumulagoleadores` bit(1) DEFAULT NULL,
  `acumulatablaconformada` bit(1) DEFAULT NULL,
  `observaciones` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idtorneo`),
  KEY `fk_torneo_tipotorneo_idx` (`reftipotorneo`),
  KEY `fk_torneo_divicion_idx` (`refdivisiones`),
  KEY `fk_torneo_temporadas_idx` (`reftemporadas`),
  KEY `fk_torneo_categorias_idx` (`refcategorias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `idfoto` int(11) NOT NULL AUTO_INCREMENT,
  `refproyecto` int(11) NOT NULL,
  `reftabla` int(11) NOT NULL,
  `imagen` varchar(500) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `principal` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idfoto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `predio_menu`
--

CREATE TABLE IF NOT EXISTS `predio_menu` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(65) CHARACTER SET utf8 NOT NULL,
  `icono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Orden` smallint(6) DEFAULT NULL,
  `hover` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `permiso` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `administracion` bit(1) DEFAULT NULL,
  `torneo` bit(1) DEFAULT NULL,
  `reportes` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcanchas`
--

CREATE TABLE IF NOT EXISTS `tbcanchas` (
  `idcancha` int(11) NOT NULL AUTO_INCREMENT,
  `refcountries` int(11) NOT NULL,
  `nombre` varchar(55) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idcancha`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbcategorias`
--

CREATE TABLE IF NOT EXISTS `tbcategorias` (
  `idtcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtcategoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdias`
--

CREATE TABLE IF NOT EXISTS `tbdias` (
  `iddia` int(11) NOT NULL AUTO_INCREMENT,
  `dia` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`iddia`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbdivisiones`
--

CREATE TABLE IF NOT EXISTS `tbdivisiones` (
  `iddivision` int(11) NOT NULL AUTO_INCREMENT,
  `division` varchar(130) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`iddivision`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbestadospartidos`
--

CREATE TABLE IF NOT EXISTS `tbestadospartidos` (
  `idestadopartido` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(120) NOT NULL,
  `defautomatica` bit(1) NOT NULL,
  `goleslocalauto` int(11) NOT NULL,
  `goleslocalborra` bit(1) NOT NULL,
  `golesvisitanteauto` int(11) NOT NULL,
  `golesvisitanteborra` bit(1) NOT NULL,
  `puntoslocal` int(11) NOT NULL,
  `puntosvisitante` int(11) NOT NULL,
  `finalizado` bit(1) NOT NULL,
  `ocultardetallepublico` bit(1) NOT NULL,
  `visibleparaarbitros` bit(1) NOT NULL,
  PRIMARY KEY (`idestadopartido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfechas`
--

CREATE TABLE IF NOT EXISTS `tbfechas` (
  `idfecha` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idfecha`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbfechasexcluidas`
--

CREATE TABLE IF NOT EXISTS `tbfechasexcluidas` (
  `idfechaexcluida` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idfechaexcluida`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbmotivoshabilitacionestransitorias`
--

CREATE TABLE IF NOT EXISTS `tbmotivoshabilitacionestransitorias` (
  `idmotivoshabilitacionestransitoria` int(11) NOT NULL AUTO_INCREMENT,
  `inhabilita` bit(1) NOT NULL DEFAULT b'1',
  `descripcion` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `refdocumentaciones` int(11) NOT NULL,
  PRIMARY KEY (`idmotivoshabilitacionestransitoria`),
  KEY `fk_documentaciones_idx` (`refdocumentaciones`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbpuntobonus`
--

CREATE TABLE IF NOT EXISTS `tbpuntobonus` (
  `idpuntobonus` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `cantidadfechas` int(11) NOT NULL,
  `comparacion` char(2) NOT NULL,
  `valoracomparar` int(11) NOT NULL,
  `puntosextra` int(11) NOT NULL,
  `consecutivas` bit(1) NOT NULL,
  PRIMARY KEY (`idpuntobonus`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtemporadas`
--

CREATE TABLE IF NOT EXISTS `tbtemporadas` (
  `idtemporadas` int(11) NOT NULL AUTO_INCREMENT,
  `temporada` smallint(6) NOT NULL,
  PRIMARY KEY (`idtemporadas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=2 ;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipodocumentos`
--

CREATE TABLE IF NOT EXISTS `tbtipodocumentos` (
  `idtipodocumento` int(11) NOT NULL AUTO_INCREMENT,
  `tipodocumento` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipodocumento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipojugadores`
--

CREATE TABLE IF NOT EXISTS `tbtipojugadores` (
  `idtipojugador` int(11) NOT NULL AUTO_INCREMENT,
  `tipojugador` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `abreviatura` varchar(6) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipojugador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtiposanciones`
--

CREATE TABLE IF NOT EXISTS `tbtiposanciones` (
  `idtiposancion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(120) NOT NULL,
  `cantminfechas` int(11) NOT NULL,
  `cantmaxfechas` int(11) NOT NULL,
  `abreviatura` varchar(4) NOT NULL,
  `expulsion` bit(1) NOT NULL,
  `amonestacion` bit(1) NOT NULL,
  `cumpletodascategorias` bit(1) NOT NULL,
  `llevapendiente` bit(1) NOT NULL,
  `ocultardetallepublico` bit(1) NOT NULL,
  PRIMARY KEY (`idtiposancion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbtipotorneo`
--

CREATE TABLE IF NOT EXISTS `tbtipotorneo` (
  `idtipotorneo` int(11) NOT NULL AUTO_INCREMENT,
  `tipotorneo` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipotorneo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbvaloreshabilitacionestransitorias`
--

CREATE TABLE IF NOT EXISTS `tbvaloreshabilitacionestransitorias` (
  `idvalorhabilitaciontransitoria` int(11) NOT NULL AUTO_INCREMENT,
  `refdocumentaciones` int(11) NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `habilita` bit(1) NOT NULL DEFAULT b'1',
  `predeterminado` bit(1) DEFAULT NULL,
  PRIMARY KEY (`idvalorhabilitaciontransitoria`),
  KEY `fk_valores_documentaciones_idx` (`refdocumentaciones`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=12 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dbcanchasuspenciones`
--
ALTER TABLE `dbcanchasuspenciones`
  ADD CONSTRAINT `fk_canchassuspenciones_canchas` FOREIGN KEY (`refcanchas`) REFERENCES `tbcanchas` (`idcancha`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbcontactos`
--
ALTER TABLE `dbcontactos`
  ADD CONSTRAINT `fk_contacto_tipocontacto` FOREIGN KEY (`reftipocontactos`) REFERENCES `tbtipocontactos` (`idtipocontacto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbcountriecanchas`
--
ALTER TABLE `dbcountriecanchas`
  ADD CONSTRAINT `fk_tabla_canchas` FOREIGN KEY (`refcanchas`) REFERENCES `tbcanchas` (`idcancha`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tabla_countries` FOREIGN KEY (`refcountries`) REFERENCES `dbcountries` (`idcountrie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbcountriecontactos`
--
ALTER TABLE `dbcountriecontactos`
  ADD CONSTRAINT `fk_tabla2_contactos` FOREIGN KEY (`refcontactos`) REFERENCES `dbcontactos` (`idcontacto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tabla2_countries` FOREIGN KEY (`refcountries`) REFERENCES `dbcountries` (`idcountrie`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbcountries`
--
ALTER TABLE `dbcountries`
  ADD CONSTRAINT `fk_countries_posiciontributaria` FOREIGN KEY (`refposiciontributaria`) REFERENCES `tbposiciontributaria` (`idposiciontributaria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbdefinicionescategoriastemporadas`
--
ALTER TABLE `dbdefinicionescategoriastemporadas`
  ADD CONSTRAINT `fk_dct_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dct_temporadas` FOREIGN KEY (`reftemporadas`) REFERENCES `tbtemporadas` (`idtemporadas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbdefinicionescategoriastemporadastipojugador`
--
ALTER TABLE `dbdefinicionescategoriastemporadastipojugador`
  ADD CONSTRAINT `fk_dcttj_dct` FOREIGN KEY (`refdefinicionescategoriastemporadas`) REFERENCES `dbdefinicionescategoriastemporadas` (`iddefinicioncategoriatemporada`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dcttj_tipojugador` FOREIGN KEY (`reftipojugadores`) REFERENCES `tbtipojugadores` (`idtipojugador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbdefinicionessancionesacumuladastemporadas`
--
ALTER TABLE `dbdefinicionessancionesacumuladastemporadas`
  ADD CONSTRAINT `fk_dsat_temporadas` FOREIGN KEY (`reftemporadas`) REFERENCES `tbtemporadas` (`idtemporadas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dsat_tiposanciones` FOREIGN KEY (`reftiposanciones`) REFERENCES `tbtiposanciones` (`idtiposancion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbequipos`
--
ALTER TABLE `dbequipos`
  ADD CONSTRAINT `fk_equipos_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipos_contactos` FOREIGN KEY (`refcontactos`) REFERENCES `dbcontactos` (`idcontacto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipos_contries` FOREIGN KEY (`refcountries`) REFERENCES `dbcountries` (`idcountrie`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_equipos_divisiones` FOREIGN KEY (`refdivisiones`) REFERENCES `tbdivisiones` (`iddivision`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbfixture`
--
ALTER TABLE `dbfixture`
  ADD CONSTRAINT `fk_fixture_fechas` FOREIGN KEY (`reffechas`) REFERENCES `tbfechas` (`idfecha`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_fixture_torneos` FOREIGN KEY (`reftorneos`) REFERENCES `dbtorneos` (`idtorneo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbgoleadores`
--
ALTER TABLE `dbgoleadores`
  ADD CONSTRAINT `fk_goleadores_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_goleadores_divisiones` FOREIGN KEY (`refdivisiones`) REFERENCES `tbdivisiones` (`iddivision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_goleadores_equipos` FOREIGN KEY (`refequipos`) REFERENCES `dbequipos` (`idequipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_goleadores_fixture` FOREIGN KEY (`reffixture`) REFERENCES `dbfixture` (`idfixture`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_goleadores_jugadores` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbjugadores`
--
ALTER TABLE `dbjugadores`
  ADD CONSTRAINT `fk_jugadores_countries` FOREIGN KEY (`refcountries`) REFERENCES `dbcountries` (`idcountrie`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jugadores_tipodocumentos` FOREIGN KEY (`reftipodocumentos`) REFERENCES `tbtipodocumentos` (`idtipodocumento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbjugadoresdocumentacion`
--
ALTER TABLE `dbjugadoresdocumentacion`
  ADD CONSTRAINT `fk_jugadoresdocu_documentacion` FOREIGN KEY (`refdocumentaciones`) REFERENCES `tbdocumentaciones` (`iddocumentacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jugadoresdocu_jugadores` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbjugadoresmotivoshabilitacionestransitorias`
--
ALTER TABLE `dbjugadoresmotivoshabilitacionestransitorias`
  ADD CONSTRAINT `fk_jmht_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jmht_documentaciones` FOREIGN KEY (`refdocumentaciones`) REFERENCES `tbdocumentaciones` (`iddocumentacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jmht_equipos` FOREIGN KEY (`refequipos`) REFERENCES `dbequipos` (`idequipo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jmht_jugador` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jmht_motivos` FOREIGN KEY (`refmotivoshabilitacionestransitorias`) REFERENCES `tbmotivoshabilitacionestransitorias` (`idmotivoshabilitacionestransitoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jmht_temporadas` FOREIGN KEY (`reftemporadas`) REFERENCES `tbtemporadas` (`idtemporadas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dbjugadoresvaloreshabilitacionestransitorias`
--
ALTER TABLE `dbjugadoresvaloreshabilitacionestransitorias`
  ADD CONSTRAINT `fk_jvht_jugadores` FOREIGN KEY (`refjugadores`) REFERENCES `dbjugadores` (`idjugador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jvht_valores` FOREIGN KEY (`refvaloreshabilitacionestransitorias`) REFERENCES `tbvaloreshabilitacionestransitorias` (`idvalorhabilitaciontransitoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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

--
-- Filtros para la tabla `dbtorneos`
--
ALTER TABLE `dbtorneos`
  ADD CONSTRAINT `fk_torneo_categorias` FOREIGN KEY (`refcategorias`) REFERENCES `tbcategorias` (`idtcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_torneo_divicion` FOREIGN KEY (`refdivisiones`) REFERENCES `tbdivisiones` (`iddivision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_torneo_temporadas` FOREIGN KEY (`reftemporadas`) REFERENCES `tbtemporadas` (`idtemporadas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_torneo_tipotorneo` FOREIGN KEY (`reftipotorneo`) REFERENCES `tbtipotorneo` (`idtipotorneo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbmotivoshabilitacionestransitorias`
--
ALTER TABLE `tbmotivoshabilitacionestransitorias`
  ADD CONSTRAINT `fk_documentaciones` FOREIGN KEY (`refdocumentaciones`) REFERENCES `tbdocumentaciones` (`iddocumentacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbvaloreshabilitacionestransitorias`
--
ALTER TABLE `tbvaloreshabilitacionestransitorias`
  ADD CONSTRAINT `fk_valores_documentaciones` FOREIGN KEY (`refdocumentaciones`) REFERENCES `tbdocumentaciones` (`iddocumentacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
