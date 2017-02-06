-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 06-02-2017 a las 11:01:29
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tempo000000002`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arbitros`
--

CREATE TABLE IF NOT EXISTS `arbitros` (
  `arbitroid` int(11) NOT NULL AUTO_INCREMENT,
  `apellido` varchar(50) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `tipodocumento` int(11) NOT NULL,
  `nrodocumento` varchar(15) DEFAULT NULL,
  `fechaalta` datetime NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `celular` varchar(25) DEFAULT NULL,
  `fechabaja` datetime DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`arbitroid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atributosespecialespartidos`
--

CREATE TABLE IF NOT EXISTS `atributosespecialespartidos` (
  `atributoespecialpartidoid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `tipodato` varchar(3) NOT NULL,
  PRIMARY KEY (`atributoespecialpartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canchas`
--

CREATE TABLE IF NOT EXISTS `canchas` (
  `canchaid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  `coordgpslat` varchar(25) DEFAULT NULL,
  `coordgpslong` varchar(25) DEFAULT NULL,
  `observaciones` varchar(500) NOT NULL,
  `suspendida` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`canchaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `categoriaid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) NOT NULL,
  PRIMARY KEY (`categoriaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clubes`
--

CREATE TABLE IF NOT EXISTS `clubes` (
  `clubid` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `postributariaid` int(11) NOT NULL,
  `cuit` varchar(13) DEFAULT NULL,
  `fechaalta` datetime NOT NULL,
  `fechabaja` datetime DEFAULT NULL,
  `coordgpslat` varchar(25) DEFAULT NULL,
  `coordgpslong` varchar(25) DEFAULT NULL,
  `usuarioid` varchar(25) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`clubid`),
  KEY `FOREING` (`postributariaid`),
  KEY `FOREING2` (`usuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `configuracionid` int(11) NOT NULL AUTO_INCREMENT,
  `parametro` varchar(100) NOT NULL,
  `nombreamostrar` varchar(100) NOT NULL,
  `valor` varchar(1000) NOT NULL,
  PRIMARY KEY (`configuracionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `definicionescategoriastemporadas`
--

CREATE TABLE IF NOT EXISTS `definicionescategoriastemporadas` (
  `categoriaid` int(11) NOT NULL,
  `temporadaid` int(11) NOT NULL,
  `cantmaxjugadores` int(11) NOT NULL,
  `cantminjugadores` int(11) NOT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `dias` varchar(15) NOT NULL,
  `hora` varchar(5) NOT NULL,
  `minutospartido` int(11) NOT NULL,
  `cantcambiosporpartido` int(11) NOT NULL,
  `conreingreso` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`categoriaid`,`temporadaid`),
  KEY `FKdefinicionescategoriastemporadastemporadas` (`temporadaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `definicionescategoriastemporadashabtransitorias`
--

CREATE TABLE IF NOT EXISTS `definicionescategoriastemporadashabtransitorias` (
  `categoriaid` int(11) NOT NULL,
  `temporadaid` int(11) NOT NULL,
  `motivohabtransitoriaid` int(11) NOT NULL,
  `cantporequipos` int(11) NOT NULL,
  `cantencancha` int(11) NOT NULL,
  PRIMARY KEY (`categoriaid`,`temporadaid`,`motivohabtransitoriaid`),
  KEY `FKdefinicionescategoriastemporadashabtransitoriastemporadas` (`temporadaid`),
  KEY `FKdefcategoriastemporadashabtransitoriasmotivoshabtransitoria` (`motivohabtransitoriaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `definicionescategoriastemporadastipojugador`
--

CREATE TABLE IF NOT EXISTS `definicionescategoriastemporadastipojugador` (
  `categoriaid` int(11) NOT NULL,
  `temporadaid` int(11) NOT NULL,
  `tipojugadorid` int(11) NOT NULL,
  `edadmaxima` int(11) NOT NULL,
  `edadminima` int(11) NOT NULL,
  `diamescumplemin` varchar(4) NOT NULL,
  `diamescumplemax` varchar(4) NOT NULL,
  `cantjugadoresporequipo` int(11) NOT NULL,
  `cantjugadoresencancha` int(11) NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  PRIMARY KEY (`categoriaid`,`temporadaid`,`tipojugadorid`),
  KEY `FKdefcategoriastemporadastipojugadortemporadas` (`temporadaid`),
  KEY `FKdefcategoriastemporadastipojugadortipojugadores` (`tipojugadorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `definicionessancionesacumuladastemporadas`
--

CREATE TABLE IF NOT EXISTS `definicionessancionesacumuladastemporadas` (
  `tiposancionid` int(11) NOT NULL,
  `temporadaid` int(11) NOT NULL,
  `cantacumulada` int(11) NOT NULL,
  `cantfechasacumplir` int(11) NOT NULL,
  PRIMARY KEY (`tiposancionid`,`temporadaid`),
  KEY `FKdefsancionesacumuladastemporadastemporadas` (`temporadaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisiones`
--

CREATE TABLE IF NOT EXISTS `divisiones` (
  `divisionid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) NOT NULL,
  PRIMARY KEY (`divisionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacionjugadores`
--

CREATE TABLE IF NOT EXISTS `documentacionjugadores` (
  `docjugadoresid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `obligatoria` tinyint(1) NOT NULL DEFAULT '0',
  `observaciones` varchar(500) NOT NULL,
  PRIMARY KEY (`docjugadoresid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacionjugadoresvalores`
--

CREATE TABLE IF NOT EXISTS `documentacionjugadoresvalores` (
  `docjugadoresid` int(11) NOT NULL,
  `valorid` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `esdefault` tinyint(1) NOT NULL DEFAULT '0',
  `habilita` tinyint(1) NOT NULL DEFAULT '0',
  `llevaimagen` tinyint(1) NOT NULL DEFAULT '0',
  `permitidosporequipo` int(11) NOT NULL DEFAULT '999',
  PRIMARY KEY (`docjugadoresid`,`valorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE IF NOT EXISTS `equipos` (
  `equipoid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `clubid` int(11) NOT NULL,
  `categoriaid` int(11) NOT NULL,
  `divisionid` int(11) NOT NULL,
  `canchadefid` int(11) DEFAULT NULL,
  `fechaalta` datetime NOT NULL,
  `fechabaja` datetime NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `contactoclubid` int(11) NOT NULL,
  PRIMARY KEY (`equipoid`),
  KEY `FKCLUB` (`clubid`),
  KEY `FKCATEGORIA` (`categoriaid`),
  KEY `FKDIVISION` (`divisionid`),
  KEY `FKCANCHA` (`canchadefid`),
  KEY `FKCONTACTO` (`contactoclubid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadospartidos`
--

CREATE TABLE IF NOT EXISTS `estadospartidos` (
  `estadopartidoid` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `defautomatica` tinyint(1) NOT NULL,
  `goleslocalauto` int(11) NOT NULL,
  `goleslocalborra` tinyint(1) NOT NULL,
  `golesvisitanteauto` int(11) NOT NULL,
  `golesvisitanteborra` tinyint(1) NOT NULL,
  `puntoslocal` int(11) NOT NULL,
  `puntosvisitante` int(11) NOT NULL,
  `finalizado` tinyint(1) NOT NULL DEFAULT '1',
  `ocultardetallepublico` tinyint(1) NOT NULL DEFAULT '0',
  `visibleparaarbitros` tinyint(1) NOT NULL,
  `contabilizalocal` varchar(1) NOT NULL DEFAULT 'G',
  `contabilizavisitante` varchar(1) NOT NULL DEFAULT 'G',
  PRIMARY KEY (`estadopartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechasexcluidas`
--

CREATE TABLE IF NOT EXISTS `fechasexcluidas` (
  `fechaexcluidaid` int(11) NOT NULL AUTO_INCREMENT,
  `dia` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`fechaexcluidaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formatostorneo`
--

CREATE TABLE IF NOT EXISTS `formatostorneo` (
  `formatotorneoid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `liga` tinyint(1) NOT NULL DEFAULT '1',
  `playoff` tinyint(1) NOT NULL DEFAULT '0',
  `ligayplayoff` tinyint(1) NOT NULL DEFAULT '0',
  `idayvueltagrupos` tinyint(1) NOT NULL DEFAULT '0',
  `idayvueltaplayoff` tinyint(1) NOT NULL DEFAULT '0',
  `idayvueltafinal` tinyint(1) NOT NULL DEFAULT '0',
  `elimdirecta` tinyint(1) NOT NULL DEFAULT '0',
  `ultimopuesto` int(11) NOT NULL,
  `ordendefpuntos` int(11) NOT NULL,
  `ordendefdifgoles` int(11) NOT NULL,
  `ordendefgolesafavor` int(11) NOT NULL,
  `ordendefgolesencontra` int(11) NOT NULL,
  `ordendefamonestaciones` int(11) NOT NULL,
  `ordendefexpulsiones` int(11) NOT NULL,
  PRIMARY KEY (`formatotorneoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ganadorestorneos`
--

CREATE TABLE IF NOT EXISTS `ganadorestorneos` (
  `torneoid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `fechacierre` datetime NOT NULL,
  PRIMARY KEY (`torneoid`,`equipoid`),
  KEY `equipoid` (`equipoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gruposusuarios`
--

CREATE TABLE IF NOT EXISTS `gruposusuarios` (
  `grupousuarioid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`grupousuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilitacionestranjugadores`
--

CREATE TABLE IF NOT EXISTS `habilitacionestranjugadores` (
  `temporadaid` int(11) NOT NULL,
  `jugadorid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `motivohabtransitoriaid` int(11) NOT NULL,
  `fechalimhabtransitoria` datetime NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  PRIMARY KEY (`temporadaid`,`jugadorid`,`equipoid`,`motivohabtransitoriaid`),
  KEY `FKhabilitacionestranjugadoresjugadores` (`jugadorid`),
  KEY `FKhabilitacionestranjugadoresequipos` (`equipoid`),
  KEY `FKhabilitacionestranjugadoresmotivoshabtransitoria` (`motivohabtransitoriaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidenciaspartidos`
--

CREATE TABLE IF NOT EXISTS `incidenciaspartidos` (
  `incidenciapartidoid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(25) NOT NULL,
  `abreviatura` varchar(4) NOT NULL,
  `tipodato` varchar(3) NOT NULL DEFAULT 'INT',
  `definemarcador` tinyint(1) NOT NULL DEFAULT '0',
  `definemarcadornegativo` tinyint(1) NOT NULL DEFAULT '0',
  `ordenenmarcador` int(11) NOT NULL DEFAULT '0',
  `totalizacomosuma` tinyint(1) NOT NULL DEFAULT '1',
  `totalizacomocuenta` tinyint(1) NOT NULL DEFAULT '0',
  `unicoenpartido` tinyint(1) NOT NULL DEFAULT '0',
  `unicoenequipo` tinyint(1) NOT NULL DEFAULT '0',
  `mostrarpublico` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`incidenciapartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE IF NOT EXISTS `jugadores` (
  `jugadorid` int(11) NOT NULL AUTO_INCREMENT,
  `nrocarnet` int(11) NOT NULL,
  `tipodocumento` int(11) NOT NULL DEFAULT '1',
  `documento` varchar(25) CHARACTER SET latin1 NOT NULL,
  `apellido` varchar(50) CHARACTER SET latin1 NOT NULL,
  `clubid` int(11) NOT NULL,
  `nombres` varchar(50) CHARACTER SET latin1 NOT NULL,
  `fechanac` datetime NOT NULL,
  `fechaalta` datetime NOT NULL,
  `baja` tinyint(1) NOT NULL,
  `fechabaja` datetime NOT NULL,
  `auxiliar` varchar(25) CHARACTER SET latin1 NOT NULL,
  `observaciones` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`jugadorid`),
  KEY `FKCLUB` (`clubid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotessancionesacumuladas`
--

CREATE TABLE IF NOT EXISTS `lotessancionesacumuladas` (
  `lotesancionacumuladaid` int(11) NOT NULL AUTO_INCREMENT,
  `cantacumulada` int(11) NOT NULL,
  `finalizado` tinyint(1) NOT NULL,
  PRIMARY KEY (`lotesancionacumuladaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivoshabilitaciontransitoria`
--

CREATE TABLE IF NOT EXISTS `motivoshabilitaciontransitoria` (
  `motivohabtransitoriaid` int(11) NOT NULL AUTO_INCREMENT,
  `docjugadoresid` int(11) DEFAULT NULL,
  `inhabilitaalvencimiento` tinyint(1) NOT NULL DEFAULT '0',
  `descripcion` varchar(150) NOT NULL,
  PRIMARY KEY (`motivohabtransitoriaid`),
  KEY `docjugadoresid` (`docjugadoresid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE IF NOT EXISTS `partidos` (
  `partidoid` int(11) NOT NULL AUTO_INCREMENT,
  `torneoid` int(11) NOT NULL,
  `esplayoff` tinyint(1) NOT NULL DEFAULT '0',
  `instancia` varchar(6) NOT NULL,
  `nrogrupo` varchar(2) NOT NULL,
  `fechanro` int(11) NOT NULL,
  `nropartido` int(11) NOT NULL,
  `equipolocalid` int(11) NOT NULL,
  `equipovisitaid` int(11) NOT NULL,
  `arbitroid` int(11) DEFAULT NULL,
  `juez1` varchar(100) DEFAULT NULL,
  `juez2` varchar(100) DEFAULT NULL,
  `canchaid` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `hora` varchar(5) NOT NULL,
  `estadopartidoid` int(11) NOT NULL,
  `calificacioncancha` int(11) NOT NULL,
  `puntoslocal` int(11) NOT NULL,
  `puntosvisita` int(11) NOT NULL,
  `goleslocal` int(11) NOT NULL,
  `golesvisita` int(11) NOT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `publicar` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`partidoid`),
  KEY `FKTORNEO` (`torneoid`),
  KEY `FKEQLOCAL` (`equipolocalid`),
  KEY `FKEQVISITA` (`equipovisitaid`),
  KEY `FKARBITRO` (`arbitroid`),
  KEY `FKCANCHA` (`canchaid`),
  KEY `FKESTADOPARTIDO` (`estadopartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidoscumplimientosanciones`
--

CREATE TABLE IF NOT EXISTS `partidoscumplimientosanciones` (
  `partidoidcumplimiento` int(11) NOT NULL,
  `sancionfalloid` int(11) NOT NULL,
  PRIMARY KEY (`partidoidcumplimiento`,`sancionfalloid`),
  KEY `sancionfalloid` (`sancionfalloid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidosdetalle`
--

CREATE TABLE IF NOT EXISTS `partidosdetalle` (
  `partidodetalleid` int(11) NOT NULL AUTO_INCREMENT,
  `partidoid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `jugadorid` int(11) NOT NULL,
  `incidenciapartidoid` int(11) NOT NULL,
  `valor` varchar(5) NOT NULL,
  PRIMARY KEY (`partidodetalleid`),
  KEY `FKPARTIDO` (`partidoid`),
  KEY `FKJUGADOR` (`jugadorid`),
  KEY `FKINCIDENCIA` (`incidenciapartidoid`),
  KEY `EquipoId` (`equipoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posicionestorneos`
--

CREATE TABLE IF NOT EXISTS `posicionestorneos` (
  `torneoid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `grupoid` int(11) NOT NULL,
  `partidosjugados` int(11) NOT NULL,
  `partidosganados` int(11) NOT NULL,
  `partidosempatados` int(11) NOT NULL,
  `partidosperdidos` int(11) NOT NULL,
  `puntos` int(11) NOT NULL,
  `golesafavor` int(11) NOT NULL,
  `golesencontra` int(11) NOT NULL,
  `difgoles` int(11) NOT NULL,
  `cantamonestaciones` int(11) NOT NULL,
  `cantexpulsados` int(11) NOT NULL,
  PRIMARY KEY (`torneoid`,`equipoid`),
  KEY `FKposicionestorneosequipos` (`equipoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posicionestributarias`
--

CREATE TABLE IF NOT EXISTS `posicionestributarias` (
  `postributariaid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`postributariaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premiaciones`
--

CREATE TABLE IF NOT EXISTS `premiaciones` (
  `premiacionid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`premiacionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntobonus`
--

CREATE TABLE IF NOT EXISTS `puntobonus` (
  `puntobonusid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `cantidadfechas` int(11) NOT NULL,
  `consecutivas` tinyint(1) NOT NULL,
  `comparacion` char(2) NOT NULL,
  `valoracomparar` int(11) NOT NULL,
  `puntosextra` int(11) NOT NULL,
  PRIMARY KEY (`puntobonusid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relclubescanchas`
--

CREATE TABLE IF NOT EXISTS `relclubescanchas` (
  `clubid` int(11) NOT NULL,
  `canchaid` int(11) NOT NULL,
  PRIMARY KEY (`clubid`,`canchaid`),
  KEY `FKrelclubescanchascanchas` (`canchaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relclubescontactos`
--

CREATE TABLE IF NOT EXISTS `relclubescontactos` (
  `clubid` int(11) NOT NULL,
  `contactoid` int(11) NOT NULL,
  `tipocontactoid` int(11) NOT NULL,
  `observaciones` varchar(100) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `codpostal` varchar(15) DEFAULT NULL,
  `localidad` varchar(50) DEFAULT NULL,
  `provincia` varchar(50) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `celular` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `mail` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`clubid`,`contactoid`),
  KEY `FKTIPOCONTACTO` (`tipocontactoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relestadospartidosincidenciaspartidos`
--

CREATE TABLE IF NOT EXISTS `relestadospartidosincidenciaspartidos` (
  `incidenciapartidoid` int(11) NOT NULL,
  `estadopartidoid` int(11) NOT NULL,
  PRIMARY KEY (`incidenciapartidoid`,`estadopartidoid`),
  KEY `FKrelestadospartidosincidenciaspartidosestadospartidos` (`estadopartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relgruposusuariosaplicaciones`
--

CREATE TABLE IF NOT EXISTS `relgruposusuariosaplicaciones` (
  `aplicacionid` int(11) NOT NULL,
  `grupousuarioid` int(11) NOT NULL,
  PRIMARY KEY (`aplicacionid`,`grupousuarioid`),
  KEY `FKrelgruposusuariosaplicacionesgruposusuarios` (`grupousuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reljugadoresdocumentacionjugadores`
--

CREATE TABLE IF NOT EXISTS `reljugadoresdocumentacionjugadores` (
  `jugadorid` int(11) NOT NULL,
  `docjugadoresid` int(11) NOT NULL,
  `valorid` int(11) NOT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`jugadorid`,`docjugadoresid`),
  KEY `FKreljugadoresdocumentacionjugadoresdocumentacionjugadores` (`docjugadoresid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reljugadoresdocumentacionjugadoresimagenes`
--

CREATE TABLE IF NOT EXISTS `reljugadoresdocumentacionjugadoresimagenes` (
  `jugadorid` int(11) NOT NULL,
  `docjugadoresid` int(11) NOT NULL,
  `nroimagen` int(11) NOT NULL DEFAULT '1',
  `imagen` varchar(100) NOT NULL,
  PRIMARY KEY (`jugadorid`,`docjugadoresid`,`nroimagen`),
  KEY `docjugadoresid` (`docjugadoresid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reljugadoresequipos`
--

CREATE TABLE IF NOT EXISTS `reljugadoresequipos` (
  `jugadorid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `tipojugadorid` int(11) NOT NULL,
  PRIMARY KEY (`jugadorid`,`equipoid`),
  KEY `FKTIPOJUGADOR` (`tipojugadorid`),
  KEY `FKreljugadoresequiposequipos` (`equipoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reljugadoresequiposhistorico`
--

CREATE TABLE IF NOT EXISTS `reljugadoresequiposhistorico` (
  `temporadaid` int(11) NOT NULL,
  `jugadorid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `fechaalta` datetime NOT NULL,
  PRIMARY KEY (`temporadaid`,`jugadorid`,`equipoid`,`fechaalta`),
  KEY `FKreljugadoresequiposhistoricojugadores` (`jugadorid`),
  KEY `FKreljugadoresequiposhistoricoequipos` (`equipoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rellotessancionesacumuladassancionesjugadores`
--

CREATE TABLE IF NOT EXISTS `rellotessancionesacumuladassancionesjugadores` (
  `lotesancionacumuladaid` int(11) NOT NULL,
  `sancionjugadorid` int(11) NOT NULL,
  PRIMARY KEY (`lotesancionacumuladaid`,`sancionjugadorid`),
  KEY `sancionjugadorid` (`sancionjugadorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relopcionesatributosespecialespartidos`
--

CREATE TABLE IF NOT EXISTS `relopcionesatributosespecialespartidos` (
  `atributoespecialpartidoid` int(11) NOT NULL,
  `valor` varchar(250) NOT NULL,
  KEY `FKATRIBUTO` (`atributoespecialpartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relpartidosatributosespecialespartidos`
--

CREATE TABLE IF NOT EXISTS `relpartidosatributosespecialespartidos` (
  `atributoespecialpartidoid` int(11) NOT NULL,
  `partidoid` int(11) NOT NULL,
  `valor` varchar(250) NOT NULL,
  PRIMARY KEY (`atributoespecialpartidoid`,`partidoid`),
  KEY `FKrelpartidosatrespecialespartidospartidos` (`partidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relpartidospuntobonus`
--

CREATE TABLE IF NOT EXISTS `relpartidospuntobonus` (
  `puntobonusid` int(11) NOT NULL,
  `partidoid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY (`puntobonusid`,`partidoid`,`equipoid`),
  KEY `FKrelpartidospuntobonuspartidos` (`partidoid`),
  KEY `FKrelpartidospuntobonusequipos` (`equipoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relpuntobonusincidenciaspartidos`
--

CREATE TABLE IF NOT EXISTS `relpuntobonusincidenciaspartidos` (
  `puntobonusid` int(11) NOT NULL,
  `incidenciapartidoid` int(11) NOT NULL,
  PRIMARY KEY (`puntobonusid`,`incidenciapartidoid`),
  KEY `incidenciapartidoid` (`incidenciapartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relpuntobonustiposanciones`
--

CREATE TABLE IF NOT EXISTS `relpuntobonustiposanciones` (
  `puntobonusid` int(11) NOT NULL,
  `tiposancionid` int(11) NOT NULL,
  PRIMARY KEY (`puntobonusid`,`tiposancionid`),
  KEY `tiposancionid` (`tiposancionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reltemporadaspremiacionesequipos`
--

CREATE TABLE IF NOT EXISTS `reltemporadaspremiacionesequipos` (
  `temporadaid` int(11) NOT NULL,
  `premiacionid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  PRIMARY KEY (`temporadaid`,`premiacionid`,`equipoid`),
  KEY `FKreltemporadaspremiacionesequipospremiaciones` (`premiacionid`),
  KEY `FKreltemporadaspremiacionesequiposequipos` (`equipoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reltemporadaspremiacionesjugadores`
--

CREATE TABLE IF NOT EXISTS `reltemporadaspremiacionesjugadores` (
  `temporadaid` int(11) NOT NULL,
  `premiacionid` int(11) NOT NULL,
  `jugadorid` int(11) NOT NULL,
  PRIMARY KEY (`temporadaid`,`premiacionid`,`jugadorid`),
  KEY `FKreltemporadaspremiacionesjugadorespremiaciones` (`premiacionid`),
  KEY `FKreltemporadaspremiacionesjugadoresjugadores` (`jugadorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reltorneospremiacionesequipos`
--

CREATE TABLE IF NOT EXISTS `reltorneospremiacionesequipos` (
  `torneoid` int(11) NOT NULL,
  `premiacionid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  PRIMARY KEY (`torneoid`,`premiacionid`,`equipoid`),
  KEY `FKreltorneospremiacionesequipospremiaciones` (`premiacionid`),
  KEY `FKreltorneospremiacionesequiposequipos` (`equipoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reltorneospremiacionesjugadores`
--

CREATE TABLE IF NOT EXISTS `reltorneospremiacionesjugadores` (
  `torneoid` int(11) NOT NULL,
  `premiacionid` int(11) NOT NULL,
  `jugadorid` int(11) NOT NULL,
  PRIMARY KEY (`torneoid`,`premiacionid`,`jugadorid`),
  KEY `FKreltorneospremiacionesjugadorespremiaciones` (`premiacionid`),
  KEY `FKreltorneospremiacionesjugadoresjugadores` (`jugadorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reltorneospuntobonus`
--

CREATE TABLE IF NOT EXISTS `reltorneospuntobonus` (
  `puntobonusid` int(11) NOT NULL,
  `torneoid` int(11) NOT NULL,
  PRIMARY KEY (`puntobonusid`,`torneoid`),
  KEY `FKtorneospuntobonustorneos` (`torneoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relusuariosgruposusuarios`
--

CREATE TABLE IF NOT EXISTS `relusuariosgruposusuarios` (
  `usuarioid` varchar(25) NOT NULL,
  `grupousuarioid` int(11) NOT NULL,
  PRIMARY KEY (`usuarioid`,`grupousuarioid`),
  KEY `FKrelusuariosgruposusuariosgruposusuarios` (`grupousuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sancionesfallos`
--

CREATE TABLE IF NOT EXISTS `sancionesfallos` (
  `sancionfalloid` int(11) NOT NULL AUTO_INCREMENT,
  `sancionjugadorid` int(11) NOT NULL,
  `cantfechas` int(11) NOT NULL,
  `fechadde` datetime NOT NULL,
  `fechahta` datetime NOT NULL,
  `fechascumplidas` int(11) NOT NULL,
  `pendcumplimiento` tinyint(1) NOT NULL,
  `pendfallo` tinyint(1) NOT NULL,
  `generadaporacumulacion` tinyint(1) NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  PRIMARY KEY (`sancionfalloid`),
  KEY `sancionjugadorid` (`sancionjugadorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sancionesjugadores`
--

CREATE TABLE IF NOT EXISTS `sancionesjugadores` (
  `sancionjugadorid` int(11) NOT NULL AUTO_INCREMENT,
  `tiposancionid` int(11) NOT NULL,
  `jugadorid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `partidoid` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `cantidad` int(11) NOT NULL,
  `categoriasancionorigenid` int(11) NOT NULL,
  `sancionfalloid` int(11) DEFAULT NULL,
  PRIMARY KEY (`sancionjugadorid`),
  KEY `tiposancionid` (`tiposancionid`),
  KEY `jugadorid` (`jugadorid`),
  KEY `equipoid` (`equipoid`),
  KEY `partidoid` (`partidoid`),
  KEY `categoriasancionorigenid` (`categoriasancionorigenid`),
  KEY `sancionfalloid` (`sancionfalloid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporadas`
--

CREATE TABLE IF NOT EXISTS `temporadas` (
  `temporadaid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) NOT NULL,
  PRIMARY KEY (`temporadaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocontactosclubes`
--

CREATE TABLE IF NOT EXISTS `tipocontactosclubes` (
  `tipocontactoid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`tipocontactoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipojugadores`
--

CREATE TABLE IF NOT EXISTS `tipojugadores` (
  `tipojugadorid` int(11) NOT NULL AUTO_INCREMENT,
  `abreviatura` varchar(5) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`tipojugadorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposanciones`
--

CREATE TABLE IF NOT EXISTS `tiposanciones` (
  `tiposancionid` int(11) NOT NULL AUTO_INCREMENT,
  `expulsion` tinyint(1) NOT NULL,
  `amonestacion` tinyint(1) NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `cantminfechas` int(11) NOT NULL,
  `abreviatura` varchar(4) NOT NULL,
  `cantmaxfechas` int(11) NOT NULL,
  `cumpletodascategorias` tinyint(1) NOT NULL DEFAULT '0',
  `llevapendiente` tinyint(1) NOT NULL,
  `color` varchar(10) NOT NULL,
  `colortexto` varchar(10) NOT NULL,
  `ocultardetallepublico` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tiposancionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneos`
--

CREATE TABLE IF NOT EXISTS `torneos` (
  `torneoid` int(11) NOT NULL AUTO_INCREMENT,
  `formatotorneoid` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `cantgrupos` int(11) NOT NULL DEFAULT '1',
  `cantequiposplayoff` int(11) NOT NULL DEFAULT '0',
  `temporadaid` int(11) NOT NULL,
  `categoriaid` int(11) NOT NULL,
  `divisionid` int(11) NOT NULL,
  `observaciones` varchar(1000) NOT NULL,
  `cantascensos` int(11) NOT NULL,
  `cantdescensos` int(11) NOT NULL,
  `respetadeftipojugadores` tinyint(1) NOT NULL DEFAULT '1',
  `respetadefhabtransitorias` tinyint(1) NOT NULL DEFAULT '1',
  `respetadefsancionesacum` tinyint(1) NOT NULL DEFAULT '1',
  `acumulagoleadores` tinyint(1) NOT NULL DEFAULT '0',
  `acumulatablaconformada` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`torneoid`),
  KEY `FKFORMATOTORNEO` (`formatotorneoid`),
  KEY `FKTEMPORADA` (`temporadaid`),
  KEY `FKCATEGORIA` (`categoriaid`),
  KEY `FKDIVISION` (`divisionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuarioid` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cantpartidosmaxacargarporfecha` int(11) NOT NULL DEFAULT '1',
  `arbitro` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clubes`
--
ALTER TABLE `clubes`
  ADD CONSTRAINT `FKclubesposicionestributarias` FOREIGN KEY (`postributariaid`) REFERENCES `posicionestributarias` (`postributariaid`),
  ADD CONSTRAINT `FKclubesusuarios` FOREIGN KEY (`usuarioid`) REFERENCES `usuarios` (`usuarioid`);

--
-- Filtros para la tabla `definicionescategoriastemporadas`
--
ALTER TABLE `definicionescategoriastemporadas`
  ADD CONSTRAINT `FKdefinicionescategoriastemporadascategorias` FOREIGN KEY (`categoriaid`) REFERENCES `categorias` (`categoriaid`),
  ADD CONSTRAINT `FKdefinicionescategoriastemporadastemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`);

--
-- Filtros para la tabla `definicionescategoriastemporadashabtransitorias`
--
ALTER TABLE `definicionescategoriastemporadashabtransitorias`
  ADD CONSTRAINT `FKdefcategoriastemporadashabtransitoriasmotivoshabtransitoria` FOREIGN KEY (`motivohabtransitoriaid`) REFERENCES `motivoshabilitaciontransitoria` (`motivohabtransitoriaid`),
  ADD CONSTRAINT `FKdefinicionescategoriastemporadashabtransitoriascategorias` FOREIGN KEY (`categoriaid`) REFERENCES `categorias` (`categoriaid`),
  ADD CONSTRAINT `FKdefinicionescategoriastemporadashabtransitoriastemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`);

--
-- Filtros para la tabla `definicionescategoriastemporadastipojugador`
--
ALTER TABLE `definicionescategoriastemporadastipojugador`
  ADD CONSTRAINT `FKdefcategoriastemporadastipojugadorcategorias` FOREIGN KEY (`categoriaid`) REFERENCES `categorias` (`categoriaid`),
  ADD CONSTRAINT `FKdefcategoriastemporadastipojugadortemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`),
  ADD CONSTRAINT `FKdefcategoriastemporadastipojugadortipojugadores` FOREIGN KEY (`tipojugadorid`) REFERENCES `tipojugadores` (`tipojugadorid`);

--
-- Filtros para la tabla `definicionessancionesacumuladastemporadas`
--
ALTER TABLE `definicionessancionesacumuladastemporadas`
  ADD CONSTRAINT `FKdefsancionesacumuladastemporadastemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`),
  ADD CONSTRAINT `FKdefsancionesacumuladastemporadastipossanciones` FOREIGN KEY (`tiposancionid`) REFERENCES `tiposanciones` (`tiposancionid`);

--
-- Filtros para la tabla `documentacionjugadoresvalores`
--
ALTER TABLE `documentacionjugadoresvalores`
  ADD CONSTRAINT `FKdocumentacionjugadoresvaloresdocumentacionjugadores` FOREIGN KEY (`docjugadoresid`) REFERENCES `documentacionjugadores` (`docjugadoresid`);

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `FKequiposcanchas` FOREIGN KEY (`canchadefid`) REFERENCES `canchas` (`canchaid`),
  ADD CONSTRAINT `FKequiposcategorias` FOREIGN KEY (`categoriaid`) REFERENCES `categorias` (`categoriaid`),
  ADD CONSTRAINT `FKequiposclubes` FOREIGN KEY (`clubid`) REFERENCES `clubes` (`clubid`),
  ADD CONSTRAINT `FKequiposdivisiones` FOREIGN KEY (`divisionid`) REFERENCES `divisiones` (`divisionid`);

--
-- Filtros para la tabla `ganadorestorneos`
--
ALTER TABLE `ganadorestorneos`
  ADD CONSTRAINT `ganadorestorneos_ibfk_1` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`),
  ADD CONSTRAINT `ganadorestorneos_ibfk_2` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`);

--
-- Filtros para la tabla `habilitacionestranjugadores`
--
ALTER TABLE `habilitacionestranjugadores`
  ADD CONSTRAINT `FKhabilitacionestranjugadoresequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `FKhabilitacionestranjugadoresjugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  ADD CONSTRAINT `FKhabilitacionestranjugadoresmotivoshabtransitoria` FOREIGN KEY (`motivohabtransitoriaid`) REFERENCES `motivoshabilitaciontransitoria` (`motivohabtransitoriaid`),
  ADD CONSTRAINT `FKhabilitacionestranjugadorestemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`);

--
-- Filtros para la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD CONSTRAINT `FKjugadoresclubes` FOREIGN KEY (`clubid`) REFERENCES `clubes` (`clubid`);

--
-- Filtros para la tabla `motivoshabilitaciontransitoria`
--
ALTER TABLE `motivoshabilitaciontransitoria`
  ADD CONSTRAINT `motivoshabilitaciontransitoria_ibfk_1` FOREIGN KEY (`docjugadoresid`) REFERENCES `documentacionjugadores` (`docjugadoresid`);

--
-- Filtros para la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD CONSTRAINT `FKpartidosarbitros` FOREIGN KEY (`arbitroid`) REFERENCES `arbitros` (`arbitroid`),
  ADD CONSTRAINT `FKpartidoscanchas` FOREIGN KEY (`canchaid`) REFERENCES `canchas` (`canchaid`),
  ADD CONSTRAINT `FKpartidosequiposlocales` FOREIGN KEY (`equipolocalid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `FKpartidosequiposvisitas` FOREIGN KEY (`equipovisitaid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `FKpartidosestadospartidos` FOREIGN KEY (`estadopartidoid`) REFERENCES `estadospartidos` (`estadopartidoid`),
  ADD CONSTRAINT `FKpartidostorneos` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`);

--
-- Filtros para la tabla `partidoscumplimientosanciones`
--
ALTER TABLE `partidoscumplimientosanciones`
  ADD CONSTRAINT `partidoscumplimientosanciones_ibfk_1` FOREIGN KEY (`partidoidcumplimiento`) REFERENCES `partidos` (`partidoid`),
  ADD CONSTRAINT `partidoscumplimientosanciones_ibfk_2` FOREIGN KEY (`sancionfalloid`) REFERENCES `sancionesfallos` (`sancionfalloid`);

--
-- Filtros para la tabla `partidosdetalle`
--
ALTER TABLE `partidosdetalle`
  ADD CONSTRAINT `FKpartidosdetalleequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `FKpartidosdetalleincidenciaspartidos` FOREIGN KEY (`incidenciapartidoid`) REFERENCES `incidenciaspartidos` (`incidenciapartidoid`),
  ADD CONSTRAINT `FKpartidosdetallejugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  ADD CONSTRAINT `FKpartidosdetallepartidos` FOREIGN KEY (`partidoid`) REFERENCES `partidos` (`partidoid`);

--
-- Filtros para la tabla `posicionestorneos`
--
ALTER TABLE `posicionestorneos`
  ADD CONSTRAINT `FKposicionestorneosequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `FKposicionestorneostorneos` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`);

--
-- Filtros para la tabla `relclubescanchas`
--
ALTER TABLE `relclubescanchas`
  ADD CONSTRAINT `FKrelclubescanchascanchas` FOREIGN KEY (`canchaid`) REFERENCES `canchas` (`canchaid`),
  ADD CONSTRAINT `FKrelclubescanchasclubes` FOREIGN KEY (`clubid`) REFERENCES `clubes` (`clubid`);

--
-- Filtros para la tabla `relclubescontactos`
--
ALTER TABLE `relclubescontactos`
  ADD CONSTRAINT `FKrelcontactosclubesclubes` FOREIGN KEY (`clubid`) REFERENCES `clubes` (`clubid`),
  ADD CONSTRAINT `FKrelcontactosclubestipocontactosclubes` FOREIGN KEY (`tipocontactoid`) REFERENCES `tipocontactosclubes` (`tipocontactoid`);

--
-- Filtros para la tabla `relestadospartidosincidenciaspartidos`
--
ALTER TABLE `relestadospartidosincidenciaspartidos`
  ADD CONSTRAINT `FKrelestadospartidosincidenciaspartidosestadospartidos` FOREIGN KEY (`estadopartidoid`) REFERENCES `estadospartidos` (`estadopartidoid`),
  ADD CONSTRAINT `FKrelestadospartidosincidenciaspartidosincidenciaspartidos` FOREIGN KEY (`incidenciapartidoid`) REFERENCES `incidenciaspartidos` (`incidenciapartidoid`);

--
-- Filtros para la tabla `relgruposusuariosaplicaciones`
--
ALTER TABLE `relgruposusuariosaplicaciones`
  ADD CONSTRAINT `FKrelgruposusuariosaplicacionesgruposusuarios` FOREIGN KEY (`grupousuarioid`) REFERENCES `gruposusuarios` (`grupousuarioid`);

--
-- Filtros para la tabla `reljugadoresdocumentacionjugadores`
--
ALTER TABLE `reljugadoresdocumentacionjugadores`
  ADD CONSTRAINT `FKreljugadoresdocumentacionjugadoresdocumentacionjugadores` FOREIGN KEY (`docjugadoresid`) REFERENCES `documentacionjugadores` (`docjugadoresid`),
  ADD CONSTRAINT `FKreljugadoresdocumentacionjugadoresjugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`);

--
-- Filtros para la tabla `reljugadoresdocumentacionjugadoresimagenes`
--
ALTER TABLE `reljugadoresdocumentacionjugadoresimagenes`
  ADD CONSTRAINT `reljugadoresdocumentacionjugadoresimagenes_ibfk_1` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  ADD CONSTRAINT `reljugadoresdocumentacionjugadoresimagenes_ibfk_2` FOREIGN KEY (`docjugadoresid`) REFERENCES `documentacionjugadores` (`docjugadoresid`);

--
-- Filtros para la tabla `reljugadoresequipos`
--
ALTER TABLE `reljugadoresequipos`
  ADD CONSTRAINT `FKreljugadoresequiposequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `FKreljugadoresequiposjugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  ADD CONSTRAINT `FKreljugadoresequipostipojugadores` FOREIGN KEY (`tipojugadorid`) REFERENCES `tipojugadores` (`tipojugadorid`);

--
-- Filtros para la tabla `reljugadoresequiposhistorico`
--
ALTER TABLE `reljugadoresequiposhistorico`
  ADD CONSTRAINT `FKreljugadoresequiposhistoricoequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `FKreljugadoresequiposhistoricojugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  ADD CONSTRAINT `FKreljugadoresequiposhistoricotemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`);

--
-- Filtros para la tabla `rellotessancionesacumuladassancionesjugadores`
--
ALTER TABLE `rellotessancionesacumuladassancionesjugadores`
  ADD CONSTRAINT `rellotessancionesacumuladassancionesjugadores_ibfk_1` FOREIGN KEY (`lotesancionacumuladaid`) REFERENCES `lotessancionesacumuladas` (`lotesancionacumuladaid`),
  ADD CONSTRAINT `rellotessancionesacumuladassancionesjugadores_ibfk_2` FOREIGN KEY (`sancionjugadorid`) REFERENCES `sancionesjugadores` (`sancionjugadorid`);

--
-- Filtros para la tabla `relopcionesatributosespecialespartidos`
--
ALTER TABLE `relopcionesatributosespecialespartidos`
  ADD CONSTRAINT `FKrelopcionesatrespecialespartidosatrespecialespartidos` FOREIGN KEY (`atributoespecialpartidoid`) REFERENCES `atributosespecialespartidos` (`atributoespecialpartidoid`);

--
-- Filtros para la tabla `relpartidosatributosespecialespartidos`
--
ALTER TABLE `relpartidosatributosespecialespartidos`
  ADD CONSTRAINT `FKrelpartidosatrespecialespartidosatrespecialespartidos` FOREIGN KEY (`atributoespecialpartidoid`) REFERENCES `atributosespecialespartidos` (`atributoespecialpartidoid`),
  ADD CONSTRAINT `FKrelpartidosatrespecialespartidospartidos` FOREIGN KEY (`partidoid`) REFERENCES `partidos` (`partidoid`);

--
-- Filtros para la tabla `relpartidospuntobonus`
--
ALTER TABLE `relpartidospuntobonus`
  ADD CONSTRAINT `FKrelpartidospuntobonusequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `FKrelpartidospuntobonuspartidos` FOREIGN KEY (`partidoid`) REFERENCES `partidos` (`partidoid`),
  ADD CONSTRAINT `FKrelpartidospuntobonuspuntobonus` FOREIGN KEY (`puntobonusid`) REFERENCES `puntobonus` (`puntobonusid`);

--
-- Filtros para la tabla `relpuntobonusincidenciaspartidos`
--
ALTER TABLE `relpuntobonusincidenciaspartidos`
  ADD CONSTRAINT `relpuntobonusincidenciaspartidos_ibfk_1` FOREIGN KEY (`puntobonusid`) REFERENCES `puntobonus` (`puntobonusid`),
  ADD CONSTRAINT `relpuntobonusincidenciaspartidos_ibfk_2` FOREIGN KEY (`incidenciapartidoid`) REFERENCES `incidenciaspartidos` (`incidenciapartidoid`);

--
-- Filtros para la tabla `relpuntobonustiposanciones`
--
ALTER TABLE `relpuntobonustiposanciones`
  ADD CONSTRAINT `relpuntobonustiposanciones_ibfk_1` FOREIGN KEY (`puntobonusid`) REFERENCES `puntobonus` (`puntobonusid`),
  ADD CONSTRAINT `relpuntobonustiposanciones_ibfk_2` FOREIGN KEY (`tiposancionid`) REFERENCES `tiposanciones` (`tiposancionid`);

--
-- Filtros para la tabla `reltemporadaspremiacionesequipos`
--
ALTER TABLE `reltemporadaspremiacionesequipos`
  ADD CONSTRAINT `FKreltemporadaspremiacionesequiposequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `FKreltemporadaspremiacionesequipospremiaciones` FOREIGN KEY (`premiacionid`) REFERENCES `premiaciones` (`premiacionid`),
  ADD CONSTRAINT `FKreltemporadaspremiacionesequipostemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`);

--
-- Filtros para la tabla `reltemporadaspremiacionesjugadores`
--
ALTER TABLE `reltemporadaspremiacionesjugadores`
  ADD CONSTRAINT `FKreltemporadaspremiacionesjugadoresjugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  ADD CONSTRAINT `FKreltemporadaspremiacionesjugadorespremiaciones` FOREIGN KEY (`premiacionid`) REFERENCES `premiaciones` (`premiacionid`),
  ADD CONSTRAINT `FKreltemporadaspremiacionesjugadorestemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`);

--
-- Filtros para la tabla `reltorneospremiacionesequipos`
--
ALTER TABLE `reltorneospremiacionesequipos`
  ADD CONSTRAINT `FKreltorneospremiacionesequiposequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `FKreltorneospremiacionesequipospremiaciones` FOREIGN KEY (`premiacionid`) REFERENCES `premiaciones` (`premiacionid`),
  ADD CONSTRAINT `FKreltorneospremiacionesequipostorneos` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`);

--
-- Filtros para la tabla `reltorneospremiacionesjugadores`
--
ALTER TABLE `reltorneospremiacionesjugadores`
  ADD CONSTRAINT `FKreltorneospremiacionesjugadoresjugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  ADD CONSTRAINT `FKreltorneospremiacionesjugadorespremiaciones` FOREIGN KEY (`premiacionid`) REFERENCES `premiaciones` (`premiacionid`),
  ADD CONSTRAINT `FKreltorneospremiacionesjugadorestorneos` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`);

--
-- Filtros para la tabla `reltorneospuntobonus`
--
ALTER TABLE `reltorneospuntobonus`
  ADD CONSTRAINT `FKtorneospuntobonuspuntobonus` FOREIGN KEY (`puntobonusid`) REFERENCES `puntobonus` (`puntobonusid`),
  ADD CONSTRAINT `FKtorneospuntobonustorneos` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`);

--
-- Filtros para la tabla `relusuariosgruposusuarios`
--
ALTER TABLE `relusuariosgruposusuarios`
  ADD CONSTRAINT `FKrelusuariosgruposusuariosgruposusuarios` FOREIGN KEY (`grupousuarioid`) REFERENCES `gruposusuarios` (`grupousuarioid`),
  ADD CONSTRAINT `FKreusuariosgruposusuariosusuarios` FOREIGN KEY (`usuarioid`) REFERENCES `usuarios` (`usuarioid`);

--
-- Filtros para la tabla `sancionesjugadores`
--
ALTER TABLE `sancionesjugadores`
  ADD CONSTRAINT `sancionesjugadores_ibfk_1` FOREIGN KEY (`tiposancionid`) REFERENCES `tiposanciones` (`tiposancionid`),
  ADD CONSTRAINT `sancionesjugadores_ibfk_2` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  ADD CONSTRAINT `sancionesjugadores_ibfk_3` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  ADD CONSTRAINT `sancionesjugadores_ibfk_4` FOREIGN KEY (`partidoid`) REFERENCES `partidos` (`partidoid`),
  ADD CONSTRAINT `sancionesjugadores_ibfk_5` FOREIGN KEY (`categoriasancionorigenid`) REFERENCES `categorias` (`categoriaid`),
  ADD CONSTRAINT `sancionesjugadores_ibfk_6` FOREIGN KEY (`sancionfalloid`) REFERENCES `sancionesfallos` (`sancionfalloid`);

--
-- Filtros para la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD CONSTRAINT `FKtorneoscategorias` FOREIGN KEY (`categoriaid`) REFERENCES `categorias` (`categoriaid`),
  ADD CONSTRAINT `FKtorneosdivisiones` FOREIGN KEY (`divisionid`) REFERENCES `divisiones` (`divisionid`),
  ADD CONSTRAINT `FKtorneosformatostorneo` FOREIGN KEY (`formatotorneoid`) REFERENCES `formatostorneo` (`formatotorneoid`),
  ADD CONSTRAINT `FKtorneostemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
