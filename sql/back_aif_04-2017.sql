CREATE TABLE `arbitros` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS atributosespecialespartidos;

CREATE TABLE `atributosespecialespartidos` (
  `atributoespecialpartidoid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `tipodato` varchar(3) NOT NULL,
  PRIMARY KEY (`atributoespecialpartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS canchas;

CREATE TABLE `canchas` (
  `canchaid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  `coordgpslat` varchar(25) DEFAULT NULL COMMENT 'Determina la latitud para el posicionamiento global',
  `coordgpslong` varchar(25) DEFAULT NULL COMMENT 'Determina la longitud para el posicionamiento global',
  `observaciones` varchar(500) NOT NULL,
  `suspendida` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`canchaid`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=latin1 COMMENT='Canchas disponibles para disputar los partidos';



DROP TABLE IF EXISTS categorias;

CREATE TABLE `categorias` (
  `categoriaid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) NOT NULL,
  PRIMARY KEY (`categoriaid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS clubes;

CREATE TABLE `clubes` (
  `clubid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código interno para el club',
  `nombre` varchar(50) NOT NULL COMMENT 'Nombre del club',
  `postributariaid` int(11) NOT NULL COMMENT 'Código de la posición tributaria del club',
  `cuit` varchar(13) DEFAULT NULL,
  `fechaalta` datetime NOT NULL COMMENT 'Fecha en que se dio de alta el club dentro del sistema',
  `fechabaja` datetime DEFAULT NULL COMMENT 'Fecha en que se elimino el equipo del sistema',
  `coordgpslat` varchar(25) DEFAULT NULL COMMENT 'Determina la latitud para el posicionamiento global',
  `coordgpslong` varchar(25) DEFAULT NULL COMMENT 'Determina la longitud para el posicionamiento global',
  `usuarioid` varchar(25) NOT NULL COMMENT 'Código del usuario que administra al club',
  `logo` varchar(100) DEFAULT NULL COMMENT 'Nombre de la imagen',
  `activo` tinyint(1) NOT NULL COMMENT 'Determina si el club se encuentra activo para utilizarlo en el resto del sistema',
  PRIMARY KEY (`clubid`),
  KEY `FOREING` (`postributariaid`),
  KEY `FOREING2` (`usuarioid`),
  CONSTRAINT `FKclubesposicionestributarias` FOREIGN KEY (`postributariaid`) REFERENCES `posicionestributarias` (`postributariaid`),
  CONSTRAINT `FKclubesusuarios` FOREIGN KEY (`usuarioid`) REFERENCES `usuarios` (`usuarioid`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1 COMMENT='Clubes disponibles dentro del sistema';



DROP TABLE IF EXISTS configuracion;

CREATE TABLE `configuracion` (
  `configuracionid` int(11) NOT NULL AUTO_INCREMENT,
  `parametro` varchar(100) NOT NULL,
  `nombreamostrar` varchar(100) NOT NULL,
  `valor` varchar(1000) NOT NULL,
  PRIMARY KEY (`configuracionid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS definicionescategoriastemporadas;

CREATE TABLE `definicionescategoriastemporadas` (
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
  KEY `FKdefinicionescategoriastemporadastemporadas` (`temporadaid`),
  CONSTRAINT `FKdefinicionescategoriastemporadascategorias` FOREIGN KEY (`categoriaid`) REFERENCES `categorias` (`categoriaid`),
  CONSTRAINT `FKdefinicionescategoriastemporadastemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS definicionescategoriastemporadashabtransitorias;

CREATE TABLE `definicionescategoriastemporadashabtransitorias` (
  `categoriaid` int(11) NOT NULL,
  `temporadaid` int(11) NOT NULL,
  `motivohabtransitoriaid` int(11) NOT NULL,
  `cantporequipos` int(11) NOT NULL,
  `cantencancha` int(11) NOT NULL,
  PRIMARY KEY (`categoriaid`,`temporadaid`,`motivohabtransitoriaid`),
  KEY `FKdefinicionescategoriastemporadashabtransitoriastemporadas` (`temporadaid`),
  KEY `FKdefcategoriastemporadashabtransitoriasmotivoshabtransitoria` (`motivohabtransitoriaid`),
  CONSTRAINT `FKdefcategoriastemporadashabtransitoriasmotivoshabtransitoria` FOREIGN KEY (`motivohabtransitoriaid`) REFERENCES `motivoshabilitaciontransitoria` (`motivohabtransitoriaid`),
  CONSTRAINT `FKdefinicionescategoriastemporadashabtransitoriascategorias` FOREIGN KEY (`categoriaid`) REFERENCES `categorias` (`categoriaid`),
  CONSTRAINT `FKdefinicionescategoriastemporadashabtransitoriastemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS definicionescategoriastemporadastipojugador;

CREATE TABLE `definicionescategoriastemporadastipojugador` (
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
  KEY `FKdefcategoriastemporadastipojugadortipojugadores` (`tipojugadorid`),
  CONSTRAINT `FKdefcategoriastemporadastipojugadorcategorias` FOREIGN KEY (`categoriaid`) REFERENCES `categorias` (`categoriaid`),
  CONSTRAINT `FKdefcategoriastemporadastipojugadortemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`),
  CONSTRAINT `FKdefcategoriastemporadastipojugadortipojugadores` FOREIGN KEY (`tipojugadorid`) REFERENCES `tipojugadores` (`tipojugadorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS definicionessancionesacumuladastemporadas;

CREATE TABLE `definicionessancionesacumuladastemporadas` (
  `tiposancionid` int(11) NOT NULL,
  `temporadaid` int(11) NOT NULL,
  `cantacumulada` int(11) NOT NULL,
  `cantfechasacumplir` int(11) NOT NULL,
  PRIMARY KEY (`tiposancionid`,`temporadaid`),
  KEY `FKdefsancionesacumuladastemporadastemporadas` (`temporadaid`),
  CONSTRAINT `FKdefsancionesacumuladastemporadastemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`),
  CONSTRAINT `FKdefsancionesacumuladastemporadastipossanciones` FOREIGN KEY (`tiposancionid`) REFERENCES `tiposanciones` (`tiposancionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS divisiones;

CREATE TABLE `divisiones` (
  `divisionid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) NOT NULL,
  PRIMARY KEY (`divisionid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS documentacionjugadores;

CREATE TABLE `documentacionjugadores` (
  `docjugadoresid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `obligatoria` tinyint(1) NOT NULL DEFAULT '0',
  `observaciones` varchar(500) NOT NULL,
  PRIMARY KEY (`docjugadoresid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS documentacionjugadoresvalores;

CREATE TABLE `documentacionjugadoresvalores` (
  `docjugadoresid` int(11) NOT NULL,
  `valorid` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `esdefault` tinyint(1) NOT NULL DEFAULT '0',
  `habilita` tinyint(1) NOT NULL DEFAULT '0',
  `llevaimagen` tinyint(1) NOT NULL DEFAULT '0',
  `permitidosporequipo` int(11) NOT NULL DEFAULT '999',
  PRIMARY KEY (`docjugadoresid`,`valorid`),
  CONSTRAINT `FKdocumentacionjugadoresvaloresdocumentacionjugadores` FOREIGN KEY (`docjugadoresid`) REFERENCES `documentacionjugadores` (`docjugadoresid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS equipos;

CREATE TABLE `equipos` (
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
  KEY `FKCONTACTO` (`contactoclubid`),
  CONSTRAINT `FKequiposcanchas` FOREIGN KEY (`canchadefid`) REFERENCES `canchas` (`canchaid`),
  CONSTRAINT `FKequiposcategorias` FOREIGN KEY (`categoriaid`) REFERENCES `categorias` (`categoriaid`),
  CONSTRAINT `FKequiposclubes` FOREIGN KEY (`clubid`) REFERENCES `clubes` (`clubid`),
  CONSTRAINT `FKequiposdivisiones` FOREIGN KEY (`divisionid`) REFERENCES `divisiones` (`divisionid`)
) ENGINE=InnoDB AUTO_INCREMENT=755 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS estadospartidos;

CREATE TABLE `estadospartidos` (
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





DROP TABLE IF EXISTS fechasexcluidas;

CREATE TABLE `fechasexcluidas` (
  `fechaexcluidaid` int(11) NOT NULL AUTO_INCREMENT,
  `dia` int(11) NOT NULL,
  `mes` int(11) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`fechaexcluidaid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS formatostorneo;

CREATE TABLE `formatostorneo` (
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS ganadorestorneos;

CREATE TABLE `ganadorestorneos` (
  `torneoid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `fechacierre` datetime NOT NULL,
  PRIMARY KEY (`torneoid`,`equipoid`),
  KEY `equipoid` (`equipoid`),
  CONSTRAINT `ganadorestorneos_ibfk_1` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`),
  CONSTRAINT `ganadorestorneos_ibfk_2` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS gruposusuarios;

CREATE TABLE `gruposusuarios` (
  `grupousuarioid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`grupousuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS habilitacionestranjugadores;

CREATE TABLE `habilitacionestranjugadores` (
  `temporadaid` int(11) NOT NULL,
  `jugadorid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `motivohabtransitoriaid` int(11) NOT NULL,
  `fechalimhabtransitoria` datetime NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  PRIMARY KEY (`temporadaid`,`jugadorid`,`equipoid`,`motivohabtransitoriaid`),
  KEY `FKhabilitacionestranjugadoresjugadores` (`jugadorid`),
  KEY `FKhabilitacionestranjugadoresequipos` (`equipoid`),
  KEY `FKhabilitacionestranjugadoresmotivoshabtransitoria` (`motivohabtransitoriaid`),
  CONSTRAINT `FKhabilitacionestranjugadoresequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `FKhabilitacionestranjugadoresjugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  CONSTRAINT `FKhabilitacionestranjugadoresmotivoshabtransitoria` FOREIGN KEY (`motivohabtransitoriaid`) REFERENCES `motivoshabilitaciontransitoria` (`motivohabtransitoriaid`),
  CONSTRAINT `FKhabilitacionestranjugadorestemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS incidenciaspartidos;

CREATE TABLE `incidenciaspartidos` (
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS jugadores;

CREATE TABLE `jugadores` (
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
  KEY `FKCLUB` (`clubid`),
  CONSTRAINT `FKjugadoresclubes` FOREIGN KEY (`clubid`) REFERENCES `clubes` (`clubid`)
) ENGINE=InnoDB AUTO_INCREMENT=17762 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



DROP TABLE IF EXISTS lotessancionesacumuladas;

CREATE TABLE `lotessancionesacumuladas` (
  `lotesancionacumuladaid` int(11) NOT NULL AUTO_INCREMENT,
  `cantacumulada` int(11) NOT NULL,
  `finalizado` tinyint(1) NOT NULL,
  PRIMARY KEY (`lotesancionacumuladaid`)
) ENGINE=InnoDB AUTO_INCREMENT=21286 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS motivoshabilitaciontransitoria;

CREATE TABLE `motivoshabilitaciontransitoria` (
  `motivohabtransitoriaid` int(11) NOT NULL AUTO_INCREMENT,
  `docjugadoresid` int(11) DEFAULT NULL,
  `inhabilitaalvencimiento` tinyint(1) NOT NULL DEFAULT '0',
  `descripcion` varchar(150) NOT NULL,
  PRIMARY KEY (`motivohabtransitoriaid`),
  KEY `docjugadoresid` (`docjugadoresid`),
  CONSTRAINT `motivoshabilitaciontransitoria_ibfk_1` FOREIGN KEY (`docjugadoresid`) REFERENCES `documentacionjugadores` (`docjugadoresid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS partidos;

CREATE TABLE `partidos` (
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
  KEY `FKESTADOPARTIDO` (`estadopartidoid`),
  CONSTRAINT `FKpartidosarbitros` FOREIGN KEY (`arbitroid`) REFERENCES `arbitros` (`arbitroid`),
  CONSTRAINT `FKpartidoscanchas` FOREIGN KEY (`canchaid`) REFERENCES `canchas` (`canchaid`),
  CONSTRAINT `FKpartidosequiposlocales` FOREIGN KEY (`equipolocalid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `FKpartidosequiposvisitas` FOREIGN KEY (`equipovisitaid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `FKpartidosestadospartidos` FOREIGN KEY (`estadopartidoid`) REFERENCES `estadospartidos` (`estadopartidoid`),
  CONSTRAINT `FKpartidostorneos` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`)
) ENGINE=InnoDB AUTO_INCREMENT=9474 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS partidoscumplimientosanciones;

CREATE TABLE `partidoscumplimientosanciones` (
  `partidoidcumplimiento` int(11) NOT NULL,
  `sancionfalloid` int(11) NOT NULL,
  PRIMARY KEY (`partidoidcumplimiento`,`sancionfalloid`),
  KEY `sancionfalloid` (`sancionfalloid`),
  CONSTRAINT `partidoscumplimientosanciones_ibfk_1` FOREIGN KEY (`partidoidcumplimiento`) REFERENCES `partidos` (`partidoid`),
  CONSTRAINT `partidoscumplimientosanciones_ibfk_2` FOREIGN KEY (`sancionfalloid`) REFERENCES `sancionesfallos` (`sancionfalloid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS partidosdetalle;

CREATE TABLE `partidosdetalle` (
  `partidodetalleid` int(11) NOT NULL AUTO_INCREMENT,
  `partidoid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL COMMENT 'Equipo al que pertenece el jugador',
  `jugadorid` int(11) NOT NULL,
  `incidenciapartidoid` int(11) NOT NULL,
  `valor` varchar(5) NOT NULL,
  PRIMARY KEY (`partidodetalleid`),
  KEY `FKPARTIDO` (`partidoid`),
  KEY `FKJUGADOR` (`jugadorid`),
  KEY `FKINCIDENCIA` (`incidenciapartidoid`),
  KEY `EquipoId` (`equipoid`),
  CONSTRAINT `FKpartidosdetalleequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `FKpartidosdetalleincidenciaspartidos` FOREIGN KEY (`incidenciapartidoid`) REFERENCES `incidenciaspartidos` (`incidenciapartidoid`),
  CONSTRAINT `FKpartidosdetallejugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  CONSTRAINT `FKpartidosdetallepartidos` FOREIGN KEY (`partidoid`) REFERENCES `partidos` (`partidoid`)
) ENGINE=InnoDB AUTO_INCREMENT=444940 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS posicionestorneos;

CREATE TABLE `posicionestorneos` (
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
  KEY `FKposicionestorneosequipos` (`equipoid`),
  CONSTRAINT `FKposicionestorneosequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `FKposicionestorneostorneos` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS posicionestributarias;

CREATE TABLE `posicionestributarias` (
  `postributariaid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código interno para la posicion tributaria',
  `descripcion` varchar(50) NOT NULL COMMENT 'Nombre de la posición tributaria',
  PRIMARY KEY (`postributariaid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Definición de las posiciones frente al organismo recaudador del país en cuestión';





DROP TABLE IF EXISTS premiaciones;

CREATE TABLE `premiaciones` (
  `premiacionid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`premiacionid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS puntobonus;

CREATE TABLE `puntobonus` (
  `puntobonusid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `cantidadfechas` int(11) NOT NULL,
  `consecutivas` tinyint(1) NOT NULL,
  `comparacion` char(2) NOT NULL,
  `valoracomparar` int(11) NOT NULL,
  `puntosextra` int(11) NOT NULL,
  PRIMARY KEY (`puntobonusid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS relclubescanchas;

CREATE TABLE `relclubescanchas` (
  `clubid` int(11) NOT NULL,
  `canchaid` int(11) NOT NULL,
  PRIMARY KEY (`clubid`,`canchaid`),
  KEY `FKrelclubescanchascanchas` (`canchaid`),
  CONSTRAINT `FKrelclubescanchascanchas` FOREIGN KEY (`canchaid`) REFERENCES `canchas` (`canchaid`),
  CONSTRAINT `FKrelclubescanchasclubes` FOREIGN KEY (`clubid`) REFERENCES `clubes` (`clubid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Asocia los clubes con sus respectivas canchas';



DROP TABLE IF EXISTS relclubescontactos;

CREATE TABLE `relclubescontactos` (
  `clubid` int(11) NOT NULL COMMENT 'Código del club al que pertenece el contacto',
  `contactoid` int(11) NOT NULL COMMENT 'Código del contacto dentro del club asignado',
  `tipocontactoid` int(11) NOT NULL COMMENT 'Código del tipo de contacto',
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
  KEY `FKTIPOCONTACTO` (`tipocontactoid`),
  CONSTRAINT `FKrelcontactosclubesclubes` FOREIGN KEY (`clubid`) REFERENCES `clubes` (`clubid`),
  CONSTRAINT `FKrelcontactosclubestipocontactosclubes` FOREIGN KEY (`tipocontactoid`) REFERENCES `tipocontactosclubes` (`tipocontactoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contactos asociados a los clubes';



DROP TABLE IF EXISTS relestadospartidosincidenciaspartidos;

CREATE TABLE `relestadospartidosincidenciaspartidos` (
  `incidenciapartidoid` int(11) NOT NULL,
  `estadopartidoid` int(11) NOT NULL,
  PRIMARY KEY (`incidenciapartidoid`,`estadopartidoid`),
  KEY `FKrelestadospartidosincidenciaspartidosestadospartidos` (`estadopartidoid`),
  CONSTRAINT `FKrelestadospartidosincidenciaspartidosestadospartidos` FOREIGN KEY (`estadopartidoid`) REFERENCES `estadospartidos` (`estadopartidoid`),
  CONSTRAINT `FKrelestadospartidosincidenciaspartidosincidenciaspartidos` FOREIGN KEY (`incidenciapartidoid`) REFERENCES `incidenciaspartidos` (`incidenciapartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS relgruposusuariosaplicaciones;

CREATE TABLE `relgruposusuariosaplicaciones` (
  `aplicacionid` int(11) NOT NULL,
  `grupousuarioid` int(11) NOT NULL,
  PRIMARY KEY (`aplicacionid`,`grupousuarioid`),
  KEY `FKrelgruposusuariosaplicacionesgruposusuarios` (`grupousuarioid`),
  CONSTRAINT `FKrelgruposusuariosaplicacionesgruposusuarios` FOREIGN KEY (`grupousuarioid`) REFERENCES `gruposusuarios` (`grupousuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS reljugadoresdocumentacionjugadores;

CREATE TABLE `reljugadoresdocumentacionjugadores` (
  `jugadorid` int(11) NOT NULL,
  `docjugadoresid` int(11) NOT NULL,
  `valorid` int(11) NOT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`jugadorid`,`docjugadoresid`),
  KEY `FKreljugadoresdocumentacionjugadoresdocumentacionjugadores` (`docjugadoresid`),
  CONSTRAINT `FKreljugadoresdocumentacionjugadoresdocumentacionjugadores` FOREIGN KEY (`docjugadoresid`) REFERENCES `documentacionjugadores` (`docjugadoresid`),
  CONSTRAINT `FKreljugadoresdocumentacionjugadoresjugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS reljugadoresdocumentacionjugadoresimagenes;

CREATE TABLE `reljugadoresdocumentacionjugadoresimagenes` (
  `jugadorid` int(11) NOT NULL,
  `docjugadoresid` int(11) NOT NULL,
  `nroimagen` int(11) NOT NULL DEFAULT '1',
  `imagen` varchar(100) NOT NULL,
  PRIMARY KEY (`jugadorid`,`docjugadoresid`,`nroimagen`),
  KEY `docjugadoresid` (`docjugadoresid`),
  CONSTRAINT `reljugadoresdocumentacionjugadoresimagenes_ibfk_1` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  CONSTRAINT `reljugadoresdocumentacionjugadoresimagenes_ibfk_2` FOREIGN KEY (`docjugadoresid`) REFERENCES `documentacionjugadores` (`docjugadoresid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS reljugadoresequipos;

CREATE TABLE `reljugadoresequipos` (
  `jugadorid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `tipojugadorid` int(11) NOT NULL,
  PRIMARY KEY (`jugadorid`,`equipoid`),
  KEY `FKTIPOJUGADOR` (`tipojugadorid`),
  KEY `FKreljugadoresequiposequipos` (`equipoid`),
  CONSTRAINT `FKreljugadoresequiposequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `FKreljugadoresequiposjugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  CONSTRAINT `FKreljugadoresequipostipojugadores` FOREIGN KEY (`tipojugadorid`) REFERENCES `tipojugadores` (`tipojugadorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS reljugadoresequiposhistorico;

CREATE TABLE `reljugadoresequiposhistorico` (
  `temporadaid` int(11) NOT NULL,
  `jugadorid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `fechaalta` datetime NOT NULL,
  PRIMARY KEY (`temporadaid`,`jugadorid`,`equipoid`,`fechaalta`),
  KEY `FKreljugadoresequiposhistoricojugadores` (`jugadorid`),
  KEY `FKreljugadoresequiposhistoricoequipos` (`equipoid`),
  CONSTRAINT `FKreljugadoresequiposhistoricoequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `FKreljugadoresequiposhistoricojugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  CONSTRAINT `FKreljugadoresequiposhistoricotemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS rellotessancionesacumuladassancionesjugadores;

CREATE TABLE `rellotessancionesacumuladassancionesjugadores` (
  `lotesancionacumuladaid` int(11) NOT NULL,
  `sancionjugadorid` int(11) NOT NULL,
  PRIMARY KEY (`lotesancionacumuladaid`,`sancionjugadorid`),
  KEY `sancionjugadorid` (`sancionjugadorid`),
  CONSTRAINT `rellotessancionesacumuladassancionesjugadores_ibfk_1` FOREIGN KEY (`lotesancionacumuladaid`) REFERENCES `lotessancionesacumuladas` (`lotesancionacumuladaid`),
  CONSTRAINT `rellotessancionesacumuladassancionesjugadores_ibfk_2` FOREIGN KEY (`sancionjugadorid`) REFERENCES `sancionesjugadores` (`sancionjugadorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS relopcionesatributosespecialespartidos;

CREATE TABLE `relopcionesatributosespecialespartidos` (
  `atributoespecialpartidoid` int(11) NOT NULL,
  `valor` varchar(250) NOT NULL,
  KEY `FKATRIBUTO` (`atributoespecialpartidoid`),
  CONSTRAINT `FKrelopcionesatrespecialespartidosatrespecialespartidos` FOREIGN KEY (`atributoespecialpartidoid`) REFERENCES `atributosespecialespartidos` (`atributoespecialpartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS relpartidosatributosespecialespartidos;

CREATE TABLE `relpartidosatributosespecialespartidos` (
  `atributoespecialpartidoid` int(11) NOT NULL,
  `partidoid` int(11) NOT NULL,
  `valor` varchar(250) NOT NULL,
  PRIMARY KEY (`atributoespecialpartidoid`,`partidoid`),
  KEY `FKrelpartidosatrespecialespartidospartidos` (`partidoid`),
  CONSTRAINT `FKrelpartidosatrespecialespartidosatrespecialespartidos` FOREIGN KEY (`atributoespecialpartidoid`) REFERENCES `atributosespecialespartidos` (`atributoespecialpartidoid`),
  CONSTRAINT `FKrelpartidosatrespecialespartidospartidos` FOREIGN KEY (`partidoid`) REFERENCES `partidos` (`partidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS relpartidospuntobonus;

CREATE TABLE `relpartidospuntobonus` (
  `puntobonusid` int(11) NOT NULL,
  `partidoid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY (`puntobonusid`,`partidoid`,`equipoid`),
  KEY `FKrelpartidospuntobonuspartidos` (`partidoid`),
  KEY `FKrelpartidospuntobonusequipos` (`equipoid`),
  CONSTRAINT `FKrelpartidospuntobonusequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `FKrelpartidospuntobonuspartidos` FOREIGN KEY (`partidoid`) REFERENCES `partidos` (`partidoid`),
  CONSTRAINT `FKrelpartidospuntobonuspuntobonus` FOREIGN KEY (`puntobonusid`) REFERENCES `puntobonus` (`puntobonusid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS relpuntobonusincidenciaspartidos;

CREATE TABLE `relpuntobonusincidenciaspartidos` (
  `puntobonusid` int(11) NOT NULL,
  `incidenciapartidoid` int(11) NOT NULL,
  PRIMARY KEY (`puntobonusid`,`incidenciapartidoid`),
  KEY `incidenciapartidoid` (`incidenciapartidoid`),
  CONSTRAINT `relpuntobonusincidenciaspartidos_ibfk_1` FOREIGN KEY (`puntobonusid`) REFERENCES `puntobonus` (`puntobonusid`),
  CONSTRAINT `relpuntobonusincidenciaspartidos_ibfk_2` FOREIGN KEY (`incidenciapartidoid`) REFERENCES `incidenciaspartidos` (`incidenciapartidoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS relpuntobonustiposanciones;

CREATE TABLE `relpuntobonustiposanciones` (
  `puntobonusid` int(11) NOT NULL,
  `tiposancionid` int(11) NOT NULL,
  PRIMARY KEY (`puntobonusid`,`tiposancionid`),
  KEY `tiposancionid` (`tiposancionid`),
  CONSTRAINT `relpuntobonustiposanciones_ibfk_1` FOREIGN KEY (`puntobonusid`) REFERENCES `puntobonus` (`puntobonusid`),
  CONSTRAINT `relpuntobonustiposanciones_ibfk_2` FOREIGN KEY (`tiposancionid`) REFERENCES `tiposanciones` (`tiposancionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS reltemporadaspremiacionesequipos;

CREATE TABLE `reltemporadaspremiacionesequipos` (
  `temporadaid` int(11) NOT NULL,
  `premiacionid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  PRIMARY KEY (`temporadaid`,`premiacionid`,`equipoid`),
  KEY `FKreltemporadaspremiacionesequipospremiaciones` (`premiacionid`),
  KEY `FKreltemporadaspremiacionesequiposequipos` (`equipoid`),
  CONSTRAINT `FKreltemporadaspremiacionesequiposequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `FKreltemporadaspremiacionesequipospremiaciones` FOREIGN KEY (`premiacionid`) REFERENCES `premiaciones` (`premiacionid`),
  CONSTRAINT `FKreltemporadaspremiacionesequipostemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS reltemporadaspremiacionesjugadores;

CREATE TABLE `reltemporadaspremiacionesjugadores` (
  `temporadaid` int(11) NOT NULL,
  `premiacionid` int(11) NOT NULL,
  `jugadorid` int(11) NOT NULL,
  PRIMARY KEY (`temporadaid`,`premiacionid`,`jugadorid`),
  KEY `FKreltemporadaspremiacionesjugadorespremiaciones` (`premiacionid`),
  KEY `FKreltemporadaspremiacionesjugadoresjugadores` (`jugadorid`),
  CONSTRAINT `FKreltemporadaspremiacionesjugadoresjugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  CONSTRAINT `FKreltemporadaspremiacionesjugadorespremiaciones` FOREIGN KEY (`premiacionid`) REFERENCES `premiaciones` (`premiacionid`),
  CONSTRAINT `FKreltemporadaspremiacionesjugadorestemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS reltorneospremiacionesequipos;

CREATE TABLE `reltorneospremiacionesequipos` (
  `torneoid` int(11) NOT NULL,
  `premiacionid` int(11) NOT NULL,
  `equipoid` int(11) NOT NULL,
  PRIMARY KEY (`torneoid`,`premiacionid`,`equipoid`),
  KEY `FKreltorneospremiacionesequipospremiaciones` (`premiacionid`),
  KEY `FKreltorneospremiacionesequiposequipos` (`equipoid`),
  CONSTRAINT `FKreltorneospremiacionesequiposequipos` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `FKreltorneospremiacionesequipospremiaciones` FOREIGN KEY (`premiacionid`) REFERENCES `premiaciones` (`premiacionid`),
  CONSTRAINT `FKreltorneospremiacionesequipostorneos` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS reltorneospremiacionesjugadores;

CREATE TABLE `reltorneospremiacionesjugadores` (
  `torneoid` int(11) NOT NULL,
  `premiacionid` int(11) NOT NULL,
  `jugadorid` int(11) NOT NULL,
  PRIMARY KEY (`torneoid`,`premiacionid`,`jugadorid`),
  KEY `FKreltorneospremiacionesjugadorespremiaciones` (`premiacionid`),
  KEY `FKreltorneospremiacionesjugadoresjugadores` (`jugadorid`),
  CONSTRAINT `FKreltorneospremiacionesjugadoresjugadores` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  CONSTRAINT `FKreltorneospremiacionesjugadorespremiaciones` FOREIGN KEY (`premiacionid`) REFERENCES `premiaciones` (`premiacionid`),
  CONSTRAINT `FKreltorneospremiacionesjugadorestorneos` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS reltorneospuntobonus;

CREATE TABLE `reltorneospuntobonus` (
  `puntobonusid` int(11) NOT NULL,
  `torneoid` int(11) NOT NULL,
  PRIMARY KEY (`puntobonusid`,`torneoid`),
  KEY `FKtorneospuntobonustorneos` (`torneoid`),
  CONSTRAINT `FKtorneospuntobonuspuntobonus` FOREIGN KEY (`puntobonusid`) REFERENCES `puntobonus` (`puntobonusid`),
  CONSTRAINT `FKtorneospuntobonustorneos` FOREIGN KEY (`torneoid`) REFERENCES `torneos` (`torneoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS relusuariosgruposusuarios;

CREATE TABLE `relusuariosgruposusuarios` (
  `usuarioid` varchar(25) NOT NULL,
  `grupousuarioid` int(11) NOT NULL,
  PRIMARY KEY (`usuarioid`,`grupousuarioid`),
  KEY `FKrelusuariosgruposusuariosgruposusuarios` (`grupousuarioid`),
  CONSTRAINT `FKrelusuariosgruposusuariosgruposusuarios` FOREIGN KEY (`grupousuarioid`) REFERENCES `gruposusuarios` (`grupousuarioid`),
  CONSTRAINT `FKreusuariosgruposusuariosusuarios` FOREIGN KEY (`usuarioid`) REFERENCES `usuarios` (`usuarioid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS sancionesfallos;

CREATE TABLE `sancionesfallos` (
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
  KEY `sancionjugadorid` (`sancionjugadorid`),
  CONSTRAINT `sancionesfallos_ibfk_1` FOREIGN KEY (`sancionjugadorid`) REFERENCES `sancionesjugadores` (`sancionjugadorid`)
) ENGINE=InnoDB AUTO_INCREMENT=11017 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS sancionesjugadores;

CREATE TABLE `sancionesjugadores` (
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
  KEY `sancionfalloid` (`sancionfalloid`),
  CONSTRAINT `sancionesjugadores_ibfk_1` FOREIGN KEY (`tiposancionid`) REFERENCES `tiposanciones` (`tiposancionid`),
  CONSTRAINT `sancionesjugadores_ibfk_2` FOREIGN KEY (`jugadorid`) REFERENCES `jugadores` (`jugadorid`),
  CONSTRAINT `sancionesjugadores_ibfk_3` FOREIGN KEY (`equipoid`) REFERENCES `equipos` (`equipoid`),
  CONSTRAINT `sancionesjugadores_ibfk_4` FOREIGN KEY (`partidoid`) REFERENCES `partidos` (`partidoid`),
  CONSTRAINT `sancionesjugadores_ibfk_5` FOREIGN KEY (`categoriasancionorigenid`) REFERENCES `categorias` (`categoriaid`),
  CONSTRAINT `sancionesjugadores_ibfk_6` FOREIGN KEY (`sancionfalloid`) REFERENCES `sancionesfallos` (`sancionfalloid`)
) ENGINE=InnoDB AUTO_INCREMENT=58042 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS temporadas;

CREATE TABLE `temporadas` (
  `temporadaid` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(15) NOT NULL,
  PRIMARY KEY (`temporadaid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS tipocontactosclubes;

CREATE TABLE `tipocontactosclubes` (
  `tipocontactoid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Código Interno para el tipo de contacto',
  `descripcion` varchar(50) NOT NULL COMMENT 'Nombre del tipo de contacto',
  PRIMARY KEY (`tipocontactoid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Clasificación de los diferentes contactos que puede contener un club';





DROP TABLE IF EXISTS tipojugadores;

CREATE TABLE `tipojugadores` (
  `tipojugadorid` int(11) NOT NULL AUTO_INCREMENT,
  `abreviatura` varchar(5) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`tipojugadorid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Define una clasificación para los jugadores';





DROP TABLE IF EXISTS tiposanciones;

CREATE TABLE `tiposanciones` (
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;





DROP TABLE IF EXISTS torneos;

CREATE TABLE `torneos` (
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
  KEY `FKDIVISION` (`divisionid`),
  CONSTRAINT `FKtorneoscategorias` FOREIGN KEY (`categoriaid`) REFERENCES `categorias` (`categoriaid`),
  CONSTRAINT `FKtorneosdivisiones` FOREIGN KEY (`divisionid`) REFERENCES `divisiones` (`divisionid`),
  CONSTRAINT `FKtorneosformatostorneo` FOREIGN KEY (`formatotorneoid`) REFERENCES `formatostorneo` (`formatotorneoid`),
  CONSTRAINT `FKtorneostemporadas` FOREIGN KEY (`temporadaid`) REFERENCES `temporadas` (`temporadaid`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;






