<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();


$accion = $_POST['accion'];


switch ($accion) {
    case 'login':
        enviarMail($serviciosUsuarios);
        break;
	case 'entrar':
		entrar($serviciosUsuarios);
		break;
	case 'insertarUsuario':
        insertarUsuario($serviciosUsuarios);
        break;
	case 'modificarUsuario':
        modificarUsuario($serviciosUsuarios);
        break;
	case 'registrar':
		registrar($serviciosUsuarios);
        break;


/* PARA Tipocontactos */

case 'insertarFixture':
insertarFixture($serviciosReferencias);
break;
case 'modificarFixture':
modificarFixture($serviciosReferencias);
break;
case 'eliminarFixture':
eliminarFixture($serviciosReferencias);
break; 


case 'insertarContactos':
insertarContactos($serviciosReferencias);
break;
case 'insertarContactosId':
insertarContactosId($serviciosReferencias);
break;
case 'modificarContactos':
modificarContactos($serviciosReferencias);
break;
case 'eliminarContactos':
eliminarContactos($serviciosReferencias);
break;

case 'traerCountriesPorContactos':
	traerCountriesPorContactos($serviciosReferencias);
	break;

case 'insertarCountries':
insertarCountries($serviciosReferencias);
break;
case 'modificarCountries':
modificarCountries($serviciosReferencias);
break;
case 'eliminarCountries':
eliminarCountries($serviciosReferencias);
break;

case 'existeCuit':
	existeCuit($serviciosReferencias);
	break;
case 'eliminarFoto':
	eliminarFoto($serviciosReferencias);
	break;
case 'traerContactosPorCountries':
	traerContactosPorCountries($serviciosFunciones,$serviciosReferencias);
	break;
	
case 'insertarUsuarios':
insertarUsuarios($serviciosReferencias);
break;
case 'modificarUsuarios':
modificarUsuarios($serviciosReferencias);
break;
case 'eliminarUsuarios':
eliminarUsuarios($serviciosReferencias);
break;
case 'insertarPredio_menu':
insertarPredio_menu($serviciosReferencias);
break;
case 'modificarPredio_menu':
modificarPredio_menu($serviciosReferencias);
break;
case 'eliminarPredio_menu':
eliminarPredio_menu($serviciosReferencias);
break;
case 'insertarCanchas':
insertarCanchas($serviciosReferencias);
break;
case 'modificarCanchas':
modificarCanchas($serviciosReferencias);
break;
case 'eliminarCanchas':
eliminarCanchas($serviciosReferencias);
break;
case 'insertarPosiciontributaria':
insertarPosiciontributaria($serviciosReferencias);
break;
case 'modificarPosiciontributaria':
modificarPosiciontributaria($serviciosReferencias);
break;
case 'eliminarPosiciontributaria':
eliminarPosiciontributaria($serviciosReferencias);
break;
case 'insertarRoles':
insertarRoles($serviciosReferencias);
break;
case 'modificarRoles':
modificarRoles($serviciosReferencias);
break;
case 'eliminarRoles':
eliminarRoles($serviciosReferencias);
break;
case 'insertarTipocontactos':
insertarTipocontactos($serviciosReferencias);
break;
case 'modificarTipocontactos':
modificarTipocontactos($serviciosReferencias);
break;
case 'eliminarTipocontactos':
eliminarTipocontactos($serviciosReferencias);
break;

/* Fin */


case 'insertarArbitros':
insertarArbitros($serviciosReferencias);
break;
case 'modificarArbitros':
modificarArbitros($serviciosReferencias);
break;
case 'eliminarArbitros':
eliminarArbitros($serviciosReferencias);
break; 

case 'insertarCategorias':
insertarCategorias($serviciosReferencias);
break;
case 'modificarCategorias':
modificarCategorias($serviciosReferencias);
break;
case 'eliminarCategorias':
eliminarCategorias($serviciosReferencias);
break;
case 'insertarDivisiones':
insertarDivisiones($serviciosReferencias);
break;
case 'modificarDivisiones':
modificarDivisiones($serviciosReferencias);
break;
case 'eliminarDivisiones':
eliminarDivisiones($serviciosReferencias);
break; 

case 'insertarTemporadas':
insertarTemporadas($serviciosReferencias);
break;
case 'modificarTemporadas':
modificarTemporadas($serviciosReferencias);
break;
case 'eliminarTemporadas':
eliminarTemporadas($serviciosReferencias);
break; 


case 'insertarCanchasuspenciones':
insertarCanchasuspenciones($serviciosReferencias);
break;
case 'modificarCanchasuspenciones':
modificarCanchasuspenciones($serviciosReferencias);
break;
case 'eliminarCanchasuspenciones':
eliminarCanchasuspenciones($serviciosReferencias);
break; 

case 'existeJugador':
	existeJugador($serviciosReferencias);
	break;

case 'insertarJugadores': 
insertarJugadores($serviciosReferencias); 
break; 
case 'modificarJugadores': 
modificarJugadores($serviciosReferencias); 
break; 
case 'eliminarJugadores': 
eliminarJugadores($serviciosReferencias); 
break; 
case 'insertarJugadoresdocumentacion': 
insertarJugadoresdocumentacion($serviciosReferencias); 
break; 
case 'modificarJugadoresdocumentacion': 
modificarJugadoresdocumentacion($serviciosReferencias); 
break; 
case 'eliminarJugadoresdocumentacion': 
eliminarJugadoresdocumentacion($serviciosReferencias); 
break; 

////*** traer datos completos ***////
case 'traerDatosJugador':
	traerDatosJugador($serviciosReferencias);
	break;
////*** fin    ****//////////////////

case 'traerJugadoresPorCountrie':
	traerJugadoresPorCountrie($serviciosReferencias);
	break;

case 'insertarDocumentaciones': 
insertarDocumentaciones($serviciosReferencias); 
break; 
case 'modificarDocumentaciones': 
modificarDocumentaciones($serviciosReferencias); 
break; 
case 'eliminarDocumentaciones': 
eliminarDocumentaciones($serviciosReferencias); 
break; 
case 'insertarMotivoshabilitacionestransitorias': 
insertarMotivoshabilitacionestransitorias($serviciosReferencias); 
break; 
case 'modificarMotivoshabilitacionestransitorias': 
modificarMotivoshabilitacionestransitorias($serviciosReferencias); 
break; 
case 'eliminarMotivoshabilitacionestransitorias': 
eliminarMotivoshabilitacionestransitorias($serviciosReferencias); 
break; 

case 'traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion':
	traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion($serviciosReferencias,$serviciosFunciones);
	break;
	
case 'insertarTipodocumentos': 
insertarTipodocumentos($serviciosReferencias); 
break; 
case 'modificarTipodocumentos': 
modificarTipodocumentos($serviciosReferencias); 
break; 
case 'eliminarTipodocumentos': 
eliminarTipodocumentos($serviciosReferencias); 
break; 
case 'insertarTipojugadores': 
insertarTipojugadores($serviciosReferencias); 
break; 
case 'modificarTipojugadores': 
modificarTipojugadores($serviciosReferencias); 
break; 
case 'eliminarTipojugadores': 
eliminarTipojugadores($serviciosReferencias); 
break; 

case 'insertarValoreshabilitacionestransitorias': 
insertarValoreshabilitacionestransitorias($serviciosReferencias); 
break; 
case 'modificarValoreshabilitacionestransitorias': 
modificarValoreshabilitacionestransitorias($serviciosReferencias); 
break; 
case 'eliminarValoreshabilitacionestransitorias': 
eliminarValoreshabilitacionestransitorias($serviciosReferencias); 
break; 

case 'insertarJugadoresmotivoshabilitacionestransitoriasA': 
insertarJugadoresmotivoshabilitacionestransitoriasA($serviciosReferencias); 
break; 
case 'insertarJugadoresmotivoshabilitacionestransitoriasB': 
insertarJugadoresmotivoshabilitacionestransitoriasB($serviciosReferencias); 
break; 

case 'modificarJugadoresmotivoshabilitacionestransitorias': 
modificarJugadoresmotivoshabilitacionestransitorias($serviciosReferencias); 
break; 
case 'eliminarJugadoresmotivoshabilitacionestransitorias': 
eliminarJugadoresmotivoshabilitacionestransitorias($serviciosReferencias); 
break; 


/**************  ETAPA 3 Y 4 **************************************/
case 'insertarTorneos': 
insertarTorneos($serviciosReferencias); 
break; 
case 'modificarTorneos': 
modificarTorneos($serviciosReferencias); 
break; 
case 'eliminarTorneos': 
eliminarTorneos($serviciosReferencias); 
break; 

case 'insertarEquipos': 
insertarEquipos($serviciosReferencias); 
break; 
case 'modificarEquipos': 
modificarEquipos($serviciosReferencias); 
break; 
case 'eliminarEquipos': 
eliminarEquipos($serviciosReferencias); 
break; 

case 'traerEquiposPorCountries':
	traerEquiposPorCountries($serviciosFunciones,$serviciosReferencias);
	break;
case 'traerEquipoPorCategoria':
	traerEquipoPorCategoria($serviciosFunciones,$serviciosReferencias);
	break;

case 'insertarPuntobonus': 
insertarPuntobonus($serviciosReferencias); 
break; 
case 'modificarPuntobonus': 
modificarPuntobonus($serviciosReferencias); 
break; 
case 'eliminarPuntobonus': 
eliminarPuntobonus($serviciosReferencias); 
break; 

case 'insertarTiposanciones': 
insertarTiposanciones($serviciosReferencias); 
break; 
case 'modificarTiposanciones': 
modificarTiposanciones($serviciosReferencias); 
break; 
case 'eliminarTiposanciones': 
eliminarTiposanciones($serviciosReferencias); 
break; 

case 'insertarFechasexcluidas': 
insertarFechasexcluidas($serviciosReferencias); 
break; 
case 'modificarFechasexcluidas': 
modificarFechasexcluidas($serviciosReferencias); 
break; 
case 'eliminarFechasexcluidas': 
eliminarFechasexcluidas($serviciosReferencias); 
break; 

case 'insertarEstadospartidos': 
insertarEstadospartidos($serviciosReferencias); 
break; 
case 'modificarEstadospartidos': 
modificarEstadospartidos($serviciosReferencias); 
break; 
case 'eliminarEstadospartidos': 
eliminarEstadospartidos($serviciosReferencias); 
break; 

case 'insertarDefinicionescategoriastemporadas': 
insertarDefinicionescategoriastemporadas($serviciosReferencias); 
break; 
case 'modificarDefinicionescategoriastemporadas': 
modificarDefinicionescategoriastemporadas($serviciosReferencias); 
break; 
case 'eliminarDefinicionescategoriastemporadas': 
eliminarDefinicionescategoriastemporadas($serviciosReferencias); 
break;

case 'insertarDefinicionescategoriastemporadastipojugador': 
insertarDefinicionescategoriastemporadastipojugador($serviciosReferencias); 
break; 
case 'modificarDefinicionescategoriastemporadastipojugador': 
modificarDefinicionescategoriastemporadastipojugador($serviciosReferencias); 
break; 
case 'eliminarDefinicionescategoriastemporadastipojugador': 
eliminarDefinicionescategoriastemporadastipojugador($serviciosReferencias); 
break; 

case 'traerDefinicionesPorTemporadaCategoriaTipoJugador':
	traerDefinicionesPorTemporadaCategoriaTipoJugador($serviciosReferencias);
	break;


case 'insertarDefinicionessancionesacumuladastemporadas': 
insertarDefinicionessancionesacumuladastemporadas($serviciosReferencias); 
break; 
case 'modificarDefinicionessancionesacumuladastemporadas': 
modificarDefinicionessancionesacumuladastemporadas($serviciosReferencias); 
break; 
case 'eliminarDefinicionessancionesacumuladastemporadas': 
eliminarDefinicionessancionesacumuladastemporadas($serviciosReferencias); 
break; 


case 'insertarConector': 
insertarConector($serviciosReferencias); 
break; 
case 'insertarConectorAjax': 
insertarConectorAjax($serviciosReferencias); 
break; 
case 'modificarConector': 
modificarConector($serviciosReferencias); 
break; 
case 'eliminarConector': 
eliminarConector($serviciosReferencias); 
break; 

case 'eliminarConectorDefinitivamente': 
eliminarConectorDefinitivamente($serviciosReferencias); 
break; 

/***************  FIN  ********************************************/

/*****         FUNCIONES       **********/
case 'verificarEdad':
	verificarEdad($serviciosReferencias);
	break;
case 'verificaEdadCategoriaJugador':
	verificaEdadCategoriaJugador($serviciosReferencias);
	break;

/*****          fin          ************/


/*****        BUSQUEDAS        **********/
case 'buscarJugadores':
	buscarJugadores($serviciosReferencias);
	break;

/*****          FIN            ***********/


/*****		ESTADISTICAS        **********/
case 'insertarEstadisticaMasiva':
	insertarEstadisticaMasiva($serviciosReferencias);
	break;
case 'buscarPartido':
	buscarPartido($serviciosReferencias);
	break;

/*****			FIN				**********/
}

/* Fin */

function formatearFechas($fecha) {
	if ($fecha != '') {
		$arFecha = explode("/", $fecha);
		
		$nuevaFecha = 	$arFecha[2]."/".$arFecha[1]."/".$arFecha[0];
		
		if (checkdate($arFecha[1],$arFecha[0],$arFecha[2])) {
			return $nuevaFecha;
		} else {
			return '***';	
		}
	}
	return $fecha;
}

function formatearEntero($entero) {
	if ($entero == '') {
		return 'NULL';	
	}
	return $entero;
}


/*****		ESTADISTICAS        **********/

function buscarPartido($serviciosReferencias) {
	$id = $_POST['id'];
	
	$res = $serviciosReferencias->traerFixturePorId($id);
	
	if (mysql_num_rows($res)>0) {
		echo $id;	
	} else {
		echo 0;	
	}
}


/*****			FIN				**********/


/*****         FUNCIONES       **********/
function verificarEdad($serviciosReferencias) {
	$id	= $_POST['refjugador'];
	
	echo $serviciosReferencias->verificarEdad($id);
}

function verificaEdadCategoriaJugador($serviciosReferencias) {
	$refjugador		= $_POST['refjugador'];
	$refcategoria	= $_POST['refcategoria'];
	$refequipo		= $_POST['refequipo'];
	$reftemporada	= $_POST['reftemporada'];
	$tipoJugador	= $_POST['tipoJugador'];
	
	//obtengo el valor que verifica si el jugador puede jugar para ese categoria en esa posicion
	$valorA = $serviciosReferencias->verificaEdadCategoriaJugador($refjugador, $refcategoria, $tipoJugador);
	
	//obtengo el valor que verifica si el jugador tiene alguna habilitacion temporaria deportiva
	$valorB = $serviciosReferencias->verificaHabilitacionDeportiva($refjugador, $refcategoria, $reftemporada, $refequipo);
	
	if (($valorA == 0) && ($valorB == 0)) {
		echo 0;	
	} else {
		echo 1;	
	}
}
/*****          fin          ************/


/**********************     BUSQUEDAS             ********************************************************/
function buscarJugadores($serviciosReferencias) {
	$tipobusqueda	=	$_POST['tipobusqueda'];
	$busqueda		=	$_POST['busqueda'];
	
	$res	=	$serviciosReferencias->buscarJugadores($tipobusqueda,$busqueda);
	
	$cad3 = '';
	//////////////////////////////////////////////////////busquedajugadores/////////////////////
	$cad3 = $cad3.'
				<div class="col-md-12">
				<div class="panel panel-info">
                                <div class="panel-heading">
                                	<h3 class="panel-title">Resultado de la Busqueda</h3>
                                	
                                </div>
                                <div class="panel-body-predio" style="padding:5px 20px;">
                                	';
	$cad3 = $cad3.'
	<div class="row">
                	<table id="example" class="table table-responsive table-striped" style="font-size:0.8em; padding:2px;">
						<thead>
                        <tr>
                        	<th>Tipo Documento</th>
							<th>Nro Doc</th>
							<th>Apellido</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Fecha Nac.</th>
							<th>Fecha Alta</th>
							<th>Fecha Baja</th>
							<th>Countrie</th>
							<th>Obs.</th>
							<th>Acciones</th>
                        </tr>
						</thead>
						<tbody id="resultadosProd">';
	while ($rowJ = mysql_fetch_array($res)) {
		$cad3 .= '<tr>
					<td>'.($rowJ[1]).'</td>
					<td>'.($rowJ[2]).'</td>
					<td>'.utf8_encode($rowJ[3]).'</td>
					<td>'.utf8_encode($rowJ[4]).'</td>
					<td>'.($rowJ[5]).'</td>
					<td>'.($rowJ[6]).'</td>
					<td>'.($rowJ[7]).'</td>
					<td>'.($rowJ[8]).'</td>
					<td>'.($rowJ[9]).'</td>
					<td>'.($rowJ[10]).'</td>
					<td>
								
							<div class="btn-group">
								<button class="btn btn-success" type="button">Acciones</button>
								
								<button class="btn btn-success dropdown-toggle" data-toggle="dropdown" type="button">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								
								<ul class="dropdown-menu" role="menu">
									<li>
									<a href="jugadores/modificar.php?id='.$rowJ[0].'" class="varmodificarJugador" id="'.$rowJ[0].'"><span class="glyphicon glyphicon-pencil"></span>  Modificar</a>
									</li>
									
								</ul>
							</div>
							
							
						</td>
				 </tr>';
	}
	
	$cad3 = $cad3.'</tbody>
                                </table></div>
                            </div>
						</div>';
						
	echo $cad3;
}




/**********************                        FIN                     ***********************************/

/**********************          CONECTA JUGADORES CON EQUIPOS *******************************************/

function insertarConectorAjax($serviciosReferencias) { 
	$refjugadores = $_POST['refjugadores']; 
	$reftipojugadores = $_POST['reftipojugadores']; 
	$refequipos = $_POST['refequipos']; 
	$refcountries = $_POST['refcountries']; 
	$refcategorias = $_POST['refcategorias']; 
	$reftemporada = $_POST['reftemporada']; 
	
	if (isset($_POST['esfusion'])) { 
		$refcountries = $_POST['refcountriesaux'];
		$esfusion	= 1; 
	} else { 
		$esfusion = 0; 
	} 
	
	$activo	= 1; 

	$cad = '';
	
	//// verifico si el jugador ya fue cargado 1=existe, 0=no existe /////
	$existeJugador = $serviciosReferencias->existeConectorJugadorEquipo($refjugadores, $refequipos);	
	
	///  verifico si cumple con la edad 	1=ok, 0=mal	/////
	$vEdad = $serviciosReferencias->verificaEdadCategoriaJugador($refjugadores, $refcategorias, $reftipojugadores);
	
	// Verifico si tiene una hab. transitoria
	$vHabTrns = $serviciosReferencias->verificaHabilitacionDeportiva($refjugadores, $refcategorias, $reftemporada, $refequipos);
	
	if ($existeJugador == 0) {
		if (($vEdad == 1) || ($vHabTrns == 1)) {
			$res = $serviciosReferencias->insertarConector($refjugadores,$reftipojugadores,$refequipos,$refcountries,$refcategorias,$esfusion,$activo); 
			if ((integer)$res > 0) { 
				
				$serviciosReferencias->actualizarConectoresPorJugador($refjugadores, $res);
				
				$resConector = $serviciosReferencias->traerConectorActivosPorConector($res);
				
				
				$cad = '
						<tr>
						<td>'.mysql_result($resConector,0,'nombrecompleto').'</td>
						<td>'.mysql_result($resConector,0,'nrodocumento').'</td>
						<td>'.mysql_result($resConector,0,'tipojugador').'</td>
						<td>'.mysql_result($resConector,0,'countrie').'</td>
						<td>'.mysql_result($resConector,0,'edad').'</td>
						<td align="center"><img src="../../imagenes/editarIco.png" style="cursor:pointer;" id="'.mysql_result($resConector,0,'refjugadores').'" class="varModificarJugador"></td>
						<td align="center"><img src="../../imagenes/eliminarIco.png" style="cursor:pointer;" id="'.mysql_result($resConector,0,'idconector').'" class="varEliminarJugador"></td>
						</tr>
						';
				
				echo $cad; 
			} else { 
				echo 'Huvo un error al insertar datos';	 
			} 
		} else {
			echo 'El jugador no cumple con la edad';	
		}
	} else {
		echo 'El jugador ya fue cargado en este equipo';	
	}
	
} 


function insertarConector($serviciosReferencias) { 
	$refjugadores = $_POST['refjugadores']; 
	$reftipojugadores = $_POST['reftipojugadores']; 
	$refequipos = $_POST['refequipos']; 
	$refcountries = $_POST['refcountries']; 
	$refcategorias = $_POST['refcategorias']; 
	
	$reftemporada = $_POST['reftemporada'];
	
	if (isset($_POST['esfusion'])) { 
		$refcountries = $_POST['refcountriesaux'];
		$esfusion	= 1; 
	} else { 
		$esfusion = 0; 
	} 
	
	$activo	= 1; 
	
	// Verifico si tiene una hab. transitoria
	$vHabTrns = $serviciosReferencias->verificaHabilitacionDeportiva($refjugadores, $refcategorias, $reftemporada, $refequipos);
	
	$existe = $serviciosReferencias->existeConectorJugadorEquipo($refjugadores, $refequipos);
	
	if ($existe == 1) {
		echo 'Ya cargo a este jugador en el equipo';	 
	} else {
		$res = $serviciosReferencias->insertarConector($refjugadores,$reftipojugadores,$refequipos,$refcountries,$refcategorias,$esfusion,$activo); 
		
		if ((integer)$res > 0) { 
			//si voy a cargar al agente y ademas posee otro conector y esta activo, pero esta carga viene de un habilitacion deportiva
			if ($vHabTrns != 1) {
				$serviciosReferencias->actualizarConectoresPorJugador($refjugadores, $res);
			}
			echo ''; 
		} else { 
			echo 'Huvo un error al insertar datos';	 
		} 
	}
} 


function modificarConector($serviciosReferencias) { 
$id = $_POST['id']; 
$refjugadores = $_POST['refjugadores']; 
$reftipojugadores = $_POST['reftipojugadores']; 
$refequipos = $_POST['refequipos']; 
$refcountries = $_POST['refcountries']; 
$refcategorias = $_POST['refcategorias']; 
if (isset($_POST['esfusion'])) { 
$esfusion	= 1; 
} else { 
$esfusion = 0; 
} 
if (isset($_POST['activo'])) { 
$activo	= 1; 
} else { 
$activo = 0; 
} 
$res = $serviciosReferencias->modificarConector($id,$refjugadores,$reftipojugadores,$refequipos,$refcountries,$refcategorias,$esfusion,$activo); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarConector($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarConector($id); 
echo $res; 
} 



function eliminarConectorDefinitivamente($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	//verifico que no esta cargado en ningun fixture sino le doy una baja logica  //eliminarConector
	
	$res = $serviciosReferencias->eliminarConectorDefinitivamente($id); 
	echo $res; 
} 




function insertarFixture($serviciosReferencias) {
	$reftorneos = $_POST['reftorneos'];
	$reffechas = $_POST['reffechas'];
	$refconectorlocal = $_POST['refconectorlocal'];
	$refconectorvisitante = $_POST['refconectorvisitante'];
	$refarbitros = $_POST['refarbitros'];
	$juez1 = $_POST['juez1'];
	$juez2 = $_POST['juez2'];
	$refcanchas = $_POST['refcanchas'];
	$fecha = formatearFechas($_POST['fecha']);
	$hora = $_POST['hora'];
	$refestadospartidos = $_POST['refestadospartidos'];
	$calificacioncancha = $_POST['calificacioncancha'];
	$puntoslocal = $_POST['puntoslocal'];
	$puntosvisita = $_POST['puntosvisita'];
	$goleslocal = $_POST['goleslocal'];
	$golesvisitantes = $_POST['golesvisitantes'];
	$observaciones = $_POST['observaciones'];
	
	if (isset($_POST['publicar'])) {
		$publicar = 1;
	} else {
		$publicar = 0;
	}
	
	if ($fecha == '***') {
		$res = $serviciosReferencias->insertarFixture($reftorneos,$reffechas,$refconectorlocal,$refconectorvisitante,$refarbitros,$juez1,$juez2,$refcanchas,$fecha,$hora,$refestadospartidos,$calificacioncancha,$puntoslocal,$puntosvisita,$goleslocal,$golesvisitantes,$observaciones,$publicar);
		
		if ((integer)$res > 0) {
			echo '';
		} else {
			echo 'Huvo un error al insertar datos';
		}
	} else {
		echo 'Formato de fecha erroneo';	
	}
}


function modificarFixture($serviciosReferencias) {
	$id = $_POST['id'];
	$reftorneos = $_POST['reftorneos'];
	$reffechas = $_POST['reffechas'];
	$refconectorlocal = $_POST['refconectorlocal'];
	$refconectorvisitante = $_POST['refconectorvisitante'];
	$refarbitros = $_POST['refarbitros'];
	$juez1 = $_POST['juez1'];
	$juez2 = $_POST['juez2'];
	$refcanchas = $_POST['refcanchas'];
	$fecha = formatearFechas($_POST['fecha']);
	$hora = $_POST['hora'];
	$refestadospartidos = $_POST['refestadospartidos'];
	$calificacioncancha = $_POST['calificacioncancha'];
	$puntoslocal = $_POST['puntoslocal'];
	$puntosvisita = $_POST['puntosvisita'];
	$goleslocal = $_POST['goleslocal'];
	$golesvisitantes = $_POST['golesvisitantes'];
	$observaciones = $_POST['observaciones'];
	
	if (isset($_POST['publicar'])) {
		$publicar = 1;
	} else {
		$publicar = 0;
	}
	
	if ($fecha == '***') {
		$res = $serviciosReferencias->modificarFixture($id,$reftorneos,$reffechas,$refconectorlocal,$refconectorvisitante,$refarbitros,$juez1,$juez2,$refcanchas,$fecha,$hora,$refestadospartidos,$calificacioncancha,$puntoslocal,$puntosvisita,$goleslocal,$golesvisitantes,$observaciones,$publicar);
		
		if ($res == true) {
			echo '';
		} else {
			echo 'Huvo un error al modificar datos';
		}
	} else {
		echo 'Formato de fecha erroneo';	
	}
}

function eliminarFixture($serviciosReferencias) {
	$id = $_POST['id'];
	$res = $serviciosReferencias->eliminarFixture($id);
	echo $res;
} 

/**********************                        FIN                     ***********************************/


/* PARA Tipocontactos */

function insertarContactos($serviciosReferencias) {
	$reftipocontactos = $_POST['reftipocontactos'];
	$nombre = $_POST['nombre'];
	$direccion = $_POST['direccion'];
	$localidad = $_POST['localidad'];
	$cp = $_POST['cp'];
	$telefono = $_POST['telefono'];
	$celular = $_POST['celular'];
	$fax = $_POST['fax'];
	$email = $_POST['email'];
	$observaciones = $_POST['observaciones'];
	
	if (isset($_POST['publico'])) {
		$publico = 1;
	} else {
		$publico = 0;
	}
	
	$refCountries	= $_POST['refcountries'];

	$res = $serviciosReferencias->insertarContactos($reftipocontactos,$nombre,$direccion,$localidad,$cp,$telefono,$celular,$fax,$email,$observaciones,$publico);
	
	if ((integer)$res > 0) {
		
		if ($refCountries != 0) {
			$serviciosReferencias->insertarCountriecontactos($refCountries,$res);
		}
		echo '';
	} else {
		echo 'Huvo un error al insertar datos'.$res;
	}
}


function insertarContactosId($serviciosReferencias) {
	$reftipocontactos = $_POST['reftipocontactos'];
	$nombre = $_POST['nombre'];
	$direccion = $_POST['direccion'];
	$localidad = $_POST['localidad'];
	$cp = $_POST['cp'];
	$telefono = $_POST['telefono'];
	$celular = $_POST['celular'];
	$fax = $_POST['fax'];
	$email = $_POST['email'];
	$observaciones = $_POST['observaciones'];
	
	if (isset($_POST['publico'])) {
		$publico = 1;
	} else {
		$publico = 0;
	}
	
	$refCountries	= $_POST['refcountries'];

	$res = $serviciosReferencias->insertarContactos($reftipocontactos,$nombre,$direccion,$localidad,$cp,$telefono,$celular,$fax,$email,$observaciones,$publico);
	
	if ((integer)$res > 0) {
		
		if ($refCountries != 0) {
			$serviciosReferencias->insertarCountriecontactos($refCountries,$res);
		}
		echo $res;
	} else {
		echo 'Huvo un error al insertar datos'.$res;
	}
}

function modificarContactos($serviciosReferencias) {
	$id = $_POST['id'];
	$reftipocontactos = $_POST['reftipocontactos'];
	$nombre = $_POST['nombre'];
	$direccion = $_POST['direccion'];
	$localidad = $_POST['localidad'];
	$cp = $_POST['cp'];
	$telefono = $_POST['telefono'];
	$celular = $_POST['celular'];
	$fax = $_POST['fax'];
	$email = $_POST['email'];
	$observaciones = $_POST['observaciones'];
	
	if (isset($_POST['publico'])) {
		$publico = 1;
	} else {
		$publico = 0;
	}
	
	$refCountries	= $_POST['refcountries'];

	$res = $serviciosReferencias->modificarContactos($id,$reftipocontactos,$nombre,$direccion,$localidad,$cp,$telefono,$celular,$fax,$email,$observaciones,$publico);
	
	if ($res == true) {
		if ($refCountries != 0) {
			$serviciosReferencias->insertarCountriecontactos($refCountries,$id);
		}
		echo '';
	} else {
		echo 'Huvo un error al modificar datos';
	}
}
function eliminarContactos($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarContactos($id);
echo $res;
}

function traerCountriesPorContactos($serviciosReferencias) {
	$id		=	$_POST['id'];
	
	$res	= $serviciosReferencias->traerCountriesPorContactos($id);
	$cadRows='';
	$total = 0;
	
	while ($row = mysql_fetch_array($res)) {
			$cadsubRows = '';
			$cadRows = $cadRows.'
			
					<tr class="'.$row[0].'">
                        	';
			
			
			for ($i=1;$i<=1;$i++) {
				
				$cadsubRows = $cadsubRows.'<td><div style="height:20px;overflow:auto;">'.$row[$i].'</div></td>';	
			}
			
			$cadRows = $cadRows.'
								'.$cadsubRows.'</tr>';
			
	}
			
	
	$cad	= '';
	$cad = $cad.'
			<table class="table table-striped table-responsive">
            	<thead>
                	<tr>
                        <th>Countries</th>
                    </tr>
                </thead>
                <tbody>

                	'.($cadRows).'
                </tbody>
            </table>
			<div style="margin-bottom:85px; margin-right:60px;"></div>
		
		';	
	echo $cad;
	
	
}

function existeCuit($serviciosReferencias) {
	$cuit = $_POST['cuit'];	
	
	$res = $serviciosReferencias->existeCountrie($cuit);
	
	if ($res == 0) {
		echo '';	
	} else {
		echo 'Ya existe este Cuit';	
	}
}

function insertarCountries($serviciosReferencias) {
	$nombre = $_POST['nombre'];
	$cuit = $_POST['cuit'];
	$fechaalta = formatearFechas($_POST['fechaalta']);
	$fechabaja = formatearFechas($_POST['fechabaja']);
	$refposiciontributaria = $_POST['refposiciontributaria'];
	
	$latitud = $_POST['latitud'];
	$longitud = $_POST['longitud'];
	
	$direccion = $_POST['direccion']; 
	$telefonoadministrativo = $_POST['telefonoadministrativo']; 
	$telefonocampo = $_POST['telefonocampo']; 
	
	if (isset($_POST['activo'])) {
		$activo = 1;
	} else {
		$activo = 0;
	}
	
	$referencia = $_POST['referencia'];
	$imagen = ''; 
	
	$email = $_POST['email'];
	$localidad = $_POST['localidad'];
	$codigopostal = $_POST['codigopostal']; 
	
	$errorArchivo = '';
	
	if (($fechaalta == '***') || ($fechabaja == '***')) {
		echo 'Formato de fecha incorrecto';
	} else {
		if ($serviciosReferencias->existeCountrie($cuit)==0) {
			$res = $serviciosReferencias->insertarCountries($nombre,$cuit,$fechaalta,$fechabaja,$refposiciontributaria,$latitud,$longitud,$activo,$referencia,$imagen,$direccion,$telefonoadministrativo,$telefonocampo,$email,$localidad,$codigopostal);
			
			if ((integer)$res > 0) {
				$resUser = $serviciosReferencias->traerContactos();
				$cad = 'user';
				while ($rowFS = mysql_fetch_array($resUser)) {
					if (isset($_POST[$cad.$rowFS[0]])) {
						$serviciosReferencias->insertarCountriecontactos($res,$rowFS[0]);
					}
				}
				
				$imagenes = array("imagen" => 'imagen');
			
				foreach ($imagenes as $valor) {
					$errorArchivo .= $serviciosReferencias->subirArchivo($valor,'countries',$res,1);
				}
				echo ''.$errorArchivo;
			} else {
				echo 'Huvo un error al insertar datos';
			}
		} else {
			echo 'Ya existe un Cuit cargado';
		}
	}
}
function modificarCountries($serviciosReferencias) {
	$id = $_POST['id'];
	$nombre = $_POST['nombre'];
	$cuit = $_POST['cuit'];
	$fechaalta = formatearFechas($_POST['fechaalta']);
	$fechabaja = formatearFechas($_POST['fechabaja']);
	$refposiciontributaria = $_POST['refposiciontributaria'];
	
	$latitud = $_POST['latitud'];
	$longitud = $_POST['longitud'];
	
	$direccion = $_POST['direccion']; 
	$telefonoadministrativo = $_POST['telefonoadministrativo']; 
	$telefonocampo = $_POST['telefonocampo']; 
	
	if (isset($_POST['activo'])) {
		$activo = 1;
	} else {
		$activo = 0;
	}
	
	$referencia = $_POST['referencia'];
	$imagen = ''; 
	$email = $_POST['email'];
	$localidad = $_POST['localidad'];
	$codigopostal = $_POST['codigopostal']; 
	
	$errorArchivo = '';
	
	if (($fechaalta == '***') || ($fechabaja == '***')) {
		echo 'Formato de fecha incorrecto';
	} else {
		if ($serviciosReferencias->existeCountriePorId($cuit,$id)==0) {
			$res = $serviciosReferencias->modificarCountries($id,$nombre,$cuit,$fechaalta,$fechabaja,$refposiciontributaria,$latitud,$longitud,$activo,$referencia,$imagen,$direccion,$telefonoadministrativo,$telefonocampo,$email,$localidad,$codigopostal);
			
			if ($res == true) {
				$serviciosReferencias->eliminarCountriecontactosPorCountrie($id);
					$resUser = $serviciosReferencias->traerContactos();
					$cad = 'user';
					while ($rowFS = mysql_fetch_array($resUser)) {
						if (isset($_POST[$cad.$rowFS[0]])) {
							$serviciosReferencias->insertarCountriecontactos($id,$rowFS[0]);
						}
					}
					
				$imagenes = array("imagen" => 'imagen');
			
				foreach ($imagenes as $valor) {
					$errorArchivo .= $serviciosReferencias->subirArchivo($valor,'countries',$id,1);
				}
				echo ''.$errorArchivo;
			} else {
				echo 'Huvo un error al modificar datos';
			}
		} else {
			echo 'Ya existe un Cuit cargado';
		}
	}
}
function eliminarCountries($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarCountries($id);
echo $res;
}

function eliminarFoto($serviciosReferencias) {
	$id			=	$_POST['id'];
	echo $serviciosReferencias->eliminarFoto($id,'countries');
}

function traerContactosPorCountries($serviciosFunciones, $serviciosReferencias) {
	$id				=	$_POST['id'];
	$resContactos	=	$serviciosReferencias->traerContactosAsignadosPorCountrie($id);
	$cadRef			=	$serviciosFunciones->devolverSelectBox($resContactos,array(1,2),' - ');
	echo $cadRef;
}


function insertarUsuarios($serviciosReferencias) {
$usuario = $_POST['usuario'];
$password = $_POST['password'];
$refroles = $_POST['refroles'];
$email = $_POST['email'];
$nombrecompleto = $_POST['nombrecompleto'];
$res = $serviciosReferencias->insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarUsuarios($serviciosReferencias) {
$id = $_POST['id'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];
$refroles = $_POST['refroles'];
$email = $_POST['email'];
$nombrecompleto = $_POST['nombrecompleto'];
$res = $serviciosReferencias->modificarUsuarios($id,$usuario,$password,$refroles,$email,$nombrecompleto);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarUsuarios($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarUsuarios($id);
echo $res;
}
function insertarPredio_menu($serviciosReferencias) {
$url = $_POST['url'];
$icono = $_POST['icono'];
$nombre = $_POST['nombre'];
$Orden = $_POST['Orden'];
$hover = $_POST['hover'];
$permiso = $_POST['permiso'];
if (isset($_POST['administracion'])) {
$administracion = 1;
} else {
$administracion = 0;
}
if (isset($_POST['torneo'])) {
$torneo = 1;
} else {
$torneo = 0;
}
if (isset($_POST['reportes'])) {
$reportes = 1;
} else {
$reportes = 0;
}
$res = $serviciosReferencias->insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso,$administracion,$torneo,$reportes);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarPredio_menu($serviciosReferencias) {
$id = $_POST['id'];
$url = $_POST['url'];
$icono = $_POST['icono'];
$nombre = $_POST['nombre'];
$Orden = $_POST['Orden'];
$hover = $_POST['hover'];
$permiso = $_POST['permiso'];
if (isset($_POST['administracion'])) {
$administracion = 1;
} else {
$administracion = 0;
}
if (isset($_POST['torneo'])) {
$torneo = 1;
} else {
$torneo = 0;
}
if (isset($_POST['reportes'])) {
$reportes = 1;
} else {
$reportes = 0;
}
$res = $serviciosReferencias->modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso,$administracion,$torneo,$reportes);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarPredio_menu($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarPredio_menu($id);
echo $res;
}
function insertarCanchas($serviciosReferencias) {
$refcountries = $_POST['refcountries'];
$nombre = $_POST['nombre'];
$res = $serviciosReferencias->insertarCanchas($refcountries,$nombre);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarCanchas($serviciosReferencias) {
$id = $_POST['id'];
$refcountries = $_POST['refcountries'];
$nombre = $_POST['nombre'];
$res = $serviciosReferencias->modificarCanchas($id,$refcountries,$nombre);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarCanchas($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarCanchas($id);
echo $res;
}
function insertarPosiciontributaria($serviciosReferencias) {
$posiciontributaria = $_POST['posiciontributaria'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$res = $serviciosReferencias->insertarPosiciontributaria($posiciontributaria,$activo);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarPosiciontributaria($serviciosReferencias) {
$id = $_POST['id'];
$posiciontributaria = $_POST['posiciontributaria'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$res = $serviciosReferencias->modificarPosiciontributaria($id,$posiciontributaria,$activo);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarPosiciontributaria($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarPosiciontributaria($id);
echo $res;
}
function insertarRoles($serviciosReferencias) {
$descripcion = $_POST['descripcion'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$res = $serviciosReferencias->insertarRoles($descripcion,$activo);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarRoles($serviciosReferencias) {
$id = $_POST['id'];
$descripcion = $_POST['descripcion'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$res = $serviciosReferencias->modificarRoles($id,$descripcion,$activo);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarRoles($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarRoles($id);
echo $res;
}
function insertarTipocontactos($serviciosReferencias) {
$tipocontacto = $_POST['tipocontacto'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$res = $serviciosReferencias->insertarTipocontactos($tipocontacto,$activo);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarTipocontactos($serviciosReferencias) {
$id = $_POST['id'];
$tipocontacto = $_POST['tipocontacto'];
if (isset($_POST['activo'])) {
$activo = 1;
} else {
$activo = 0;
}
$res = $serviciosReferencias->modificarTipocontactos($id,$tipocontacto,$activo);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarTipocontactos($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarTipocontactos($id);
echo $res;
}

/* Fin */


function insertarArbitros($serviciosReferencias) {
$nombrecompleto = $_POST['nombrecompleto'];
$telefonoparticular = $_POST['telefonoparticular'];
$telefonoceleluar = $_POST['telefonoceleluar'];
$telefonolaboral = $_POST['telefonolaboral'];
$telefonofamiliar = $_POST['telefonofamiliar'];
$email = $_POST['email'];
$res = $serviciosReferencias->insertarArbitros($nombrecompleto,$telefonoparticular,$telefonoceleluar,$telefonolaboral,$telefonofamiliar,$email);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarArbitros($serviciosReferencias) {
$id = $_POST['id'];
$nombrecompleto = $_POST['nombrecompleto'];
$telefonoparticular = $_POST['telefonoparticular'];
$telefonoceleluar = $_POST['telefonoceleluar'];
$telefonolaboral = $_POST['telefonolaboral'];
$telefonofamiliar = $_POST['telefonofamiliar'];
$email = $_POST['email'];
$res = $serviciosReferencias->modificarArbitros($id,$nombrecompleto,$telefonoparticular,$telefonoceleluar,$telefonolaboral,$telefonofamiliar,$email);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarArbitros($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarArbitros($id);
echo $res;
} 

function insertarCategorias($serviciosReferencias) {
$categoria = $_POST['categoria'];
$res = $serviciosReferencias->insertarCategorias($categoria);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarCategorias($serviciosReferencias) {
$id = $_POST['id'];
$categoria = $_POST['categoria'];
$res = $serviciosReferencias->modificarCategorias($id,$categoria);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarCategorias($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarCategorias($id);
echo $res;
}
function insertarDivisiones($serviciosReferencias) {
$division = $_POST['division'];
$res = $serviciosReferencias->insertarDivisiones($division);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarDivisiones($serviciosReferencias) {
$id = $_POST['id'];
$division = $_POST['division'];
$res = $serviciosReferencias->modificarDivisiones($id,$division);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarDivisiones($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarDivisiones($id);
echo $res;
} 

function insertarTemporadas($serviciosReferencias) {
$temporada = $_POST['temporada'];
$res = $serviciosReferencias->insertarTemporadas($temporada);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarTemporadas($serviciosReferencias) {
$id = $_POST['id'];
$temporada = $_POST['temporada'];
$res = $serviciosReferencias->modificarTemporadas($id,$temporada);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}
function eliminarTemporadas($serviciosReferencias) {
$id = $_POST['id'];
$res = $serviciosReferencias->eliminarTemporadas($id);
echo $res;
} 


function insertarCanchasuspenciones($serviciosReferencias) {
	$refcanchas = $_POST['refcanchas'];
	$vigenciadesde = $_POST['vigenciadesde'];
	$vigenciahasta = $_POST['vigenciahasta'];
	$usuacrea = $_POST['usuacrea'];
	$fechacrea = date('Y-m-d H:i:s');
	$usuamodi = '';
	$fechamodi = '';
	
	$res = $serviciosReferencias->insertarCanchasuspenciones($refcanchas,$vigenciadesde,$vigenciahasta,$usuacrea,$fechacrea,$usuamodi,$fechamodi);
	
	if ((integer)$res > 0) {
		echo '';
	} else {
		echo 'Huvo un error al insertar datos';
	}
}
function modificarCanchasuspenciones($serviciosReferencias) {
	$id = $_POST['id'];
	
	$refcanchas = $_POST['refcanchas'];
	$vigenciadesde = $_POST['vigenciadesde'];
	$vigenciahasta = ($_POST['vigenciahasta'] == '' ? 'null' : $_POST['vigenciahasta']);
	$usuacrea = $_POST['usuacrea'];
	$fechacrea = $_POST['fechacrea'];
	$usuamodi = $_POST['usuamodi'];
	$fechamodi = date('Y-m-d H:i:s');
	
	$res = $serviciosReferencias->modificarCanchasuspenciones($id,$refcanchas,$vigenciadesde,$vigenciahasta,$usuacrea,$fechacrea,$usuamodi,$fechamodi);
	
	if ($res == true) {
		echo '';
	} else {
		echo 'Huvo un error al modificar datos';
	}
}
function eliminarCanchasuspenciones($serviciosReferencias) {
	$id = $_POST['id'];
	$res = $serviciosReferencias->eliminarCanchasuspenciones($id);
	echo $res;
} 



function existeJugador($serviciosReferencias) {
	$nrodocumento = $_POST['nrodocumento']; 
	
	$res = $serviciosReferencias->existeJugador($nrodocumento);
	
	if ($res == 0) {
		echo '';	
	} else {
		echo 'Ya existe este Nro de Documento';	
	}
}


function insertarJugadores($serviciosReferencias) { 
	$reftipodocumentos = $_POST['reftipodocumentos']; 
	$nrodocumento = $_POST['nrodocumento']; 
	$apellido = $_POST['apellido']; 
	$nombres = $_POST['nombres']; 
	$email = $_POST['email']; 
	$fechanacimiento = formatearFechas($_POST['fechanacimiento']); 
	$fechaalta = formatearFechas($_POST['fechaalta']); 
	$fechabaja = formatearFechas($_POST['fechabaja']); 
	$refcountries = $_POST['refcountries']; 
	$observaciones = $_POST['observaciones']; 
	
	if (($fechaalta == '***') || ($fechabaja == '***') || ($fechanacimiento == '***')) {
		echo 'Formato de fecha incorrecto';
	} else {
		if ($serviciosReferencias->existeJugador($nrodocumento) == 0) {
			$res = $serviciosReferencias->insertarJugadores($reftipodocumentos,$nrodocumento,$apellido,$nombres,$email,$fechanacimiento,$fechaalta,$fechabaja,$refcountries,$observaciones); 
			
			if ((integer)$res > 0) { 
				echo $res; 
			} else { 
				echo 'Huvo un error al insertar datos';	 
			} 
		} else {
			echo 'Ya existe ese numero de documento';	
		}
	}
} 

function modificarJugadores($serviciosReferencias) { 
	$id = $_POST['id']; 
	$reftipodocumentos = $_POST['reftipodocumentos']; 
	$nrodocumento = $_POST['nrodocumento']; 
	$apellido = $_POST['apellido']; 
	$nombres = $_POST['nombres']; 
	$email = $_POST['email']; 
	$fechanacimiento = formatearFechas($_POST['fechanacimiento']); 
	$fechaalta = formatearFechas($_POST['fechaalta']); 
	$fechabaja = formatearFechas($_POST['fechabaja']); 
	$refcountries = $_POST['refcountries']; 
	$observaciones = $_POST['observaciones']; 
	
	if (($fechaalta == '***') || ($fechabaja == '***') || ($fechanacimiento == '***')) {
		echo 'Formato de fecha incorrecto';
	} else {
		if ($serviciosReferencias->existeJugadorConIdJugador($nrodocumento, $id) == 0) {
			$res = $serviciosReferencias->modificarJugadores($id,$reftipodocumentos,$nrodocumento,$apellido,$nombres,$email,$fechanacimiento,$fechaalta,$fechabaja,$refcountries,$observaciones); 
			
			if ($res == true) { 
				echo ''; 
			} else { 
				echo 'Huvo un error al modificar datos'; 
			} 
		} else {
			echo 'Ya existe ese numero de documento';
		}
	}
} 
function eliminarJugadores($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarJugadores($id); 
echo $res; 
} 

function traerJugadoresPorCountrie($serviciosReferencias) {
	$id		=	$_POST['refcountries'];
	
	$res 	=	$serviciosReferencias->traerJugadoresPorCountrie($id);
	/*
	$cadJugadores = '';
	while ($row = mysql_fetch_array($res)) {
		//$cadJugadores .= '"'.$row[0].'": "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'",';
		$cadJugadores .= '
		      {
				id: "'.$row[0].'",
				label: "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'"
			  },';
	}
	
	echo substr($cadJugadores,0,-1);
	*/
	echo json_encode(toArray($res));	
}

function insertarJugadoresdocumentacion($serviciosReferencias) { 
	$refjugadores = $_POST['refjugadores']; 
	$observaciones = '';
	
	$resDocu = $serviciosReferencias->traerDocumentaciones();
	$cad = 'docu';
	while ($rowFS = mysql_fetch_array($resDocu)) {
		if (isset($_POST[$cad.$rowFS[0]])) {
		
			$res = $serviciosReferencias->insertarJugadoresdocumentacion($refjugadores,$rowFS[0],1,$observaciones);
		} else {
			$res = $serviciosReferencias->insertarJugadoresdocumentacion($refjugadores,$rowFS[0],0,$observaciones);
		
		}
	}
	
	$resV = '';
	$resValores = $serviciosReferencias->traerValoreshabilitacionestransitorias();
	$cadV = 'multiselect';

	while ($rowV = mysql_fetch_array($resValores)) {
		$resV .= $cadV.$rowV[0];
		if (isset($_POST[$cadV.$rowV[0]])) {
			$resV .= 'entro';
			$resV .= $serviciosReferencias->insertarJugadoresvaloreshabilitacionestransitorias($refjugadores,$rowV[0]);
		}
	}
	
	/*
	for($i=0;$i<$numero;$i++){
		$cad .= $tags[$i]." - ";
		if (strpos($tags[$i],"docu") !== false) {
			$idDocu		= str_replace("docu","",$tags[$i]);
			/*
			if (isset($valores[$i])) {
				$res = $serviciosReferencias->insertarJugadoresdocumentacion($refjugadores,$idDocu,1,$observaciones);
			} else {
				$res = $serviciosReferencias->insertarJugadoresdocumentacion($refjugadores,$idDocu,0,$observaciones);
			}
			*//*
		}
	}
	*/
	 
	if ((integer)$resV > 0) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al insertar datos'.$resV.' ---- ';	 
	} 
	//echo $cad;
} 


function modificarJugadoresdocumentacion($serviciosReferencias) { 
$id = $_POST['id']; 
$refjugadores = $_POST['refjugadores']; 
$refdocumentaciones = $_POST['refdocumentaciones']; 
if (isset($_POST['valor'])) { 
$valor	= 1; 
} else { 
$valor = 0; 
} 
if (isset($_POST['habilita'])) { 
$habilita	= 1; 
} else { 
$habilita = 0; 
} 
$observaciones = $_POST['observaciones']; 
$res = $serviciosReferencias->modificarJugadoresdocumentacion($id,$refjugadores,$refdocumentaciones,$valor,$habilita,$observaciones); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarJugadoresdocumentacion($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarJugadoresdocumentacion($id); 
echo $res; 
} 

function insertarDocumentaciones($serviciosReferencias) { 
$descripcion = $_POST['descripcion']; 
if (isset($_POST['obligatoria'])) { 
$obligatoria	= 1; 
} else { 
$obligatoria = 0; 
} 
$observaciones = $_POST['observaciones']; 
$res = $serviciosReferencias->insertarDocumentaciones($descripcion,$obligatoria,$observaciones); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	 
} 
} 
function modificarDocumentaciones($serviciosReferencias) { 
$id = $_POST['id']; 
$descripcion = $_POST['descripcion']; 
if (isset($_POST['obligatoria'])) { 
$obligatoria	= 1; 
} else { 
$obligatoria = 0; 
} 
$observaciones = $_POST['observaciones']; 
$res = $serviciosReferencias->modificarDocumentaciones($id,$descripcion,$obligatoria,$observaciones); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarDocumentaciones($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarDocumentaciones($id); 
echo $res; 
} 
function insertarMotivoshabilitacionestransitorias($serviciosReferencias) { 
if (isset($_POST['inhabilita'])) { 
$inhabilita	= 1; 
} else { 
$inhabilita = 0; 
} 
$descripcion = $_POST['descripcion']; 
$refdocumentaciones = $_POST['refdocumentaciones'];
$res = $serviciosReferencias->insertarMotivoshabilitacionestransitorias($inhabilita,$descripcion,$refdocumentaciones); 

if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	 
} 
} 
function modificarMotivoshabilitacionestransitorias($serviciosReferencias) { 
$id = $_POST['id']; 
if (isset($_POST['inhabilita'])) { 
$inhabilita	= 1; 
} else { 
$inhabilita = 0; 
} 
$descripcion = $_POST['descripcion']; 
$refdocumentaciones = $_POST['refdocumentaciones'];
$res = $serviciosReferencias->modificarMotivoshabilitacionestransitorias($id,$inhabilita,$descripcion,$refdocumentaciones); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarMotivoshabilitacionestransitorias($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarMotivoshabilitacionestransitorias($id); 
echo $res; 
} 

function traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion($serviciosReferencias,$serviciosFunciones) {
	$id = 	$_POST['id']; 
	$res =  $serviciosReferencias->traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion($id);
	$cadRef = $serviciosFunciones->devolverSelectBox($res,array(2,1),' - inhabilita:');
	
	echo $cadRef;
	
}

function insertarTipodocumentos($serviciosReferencias) { 
$tipodocumento = $_POST['tipodocumento']; 
$res = $serviciosReferencias->insertarTipodocumentos($tipodocumento); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	 
} 
} 
function modificarTipodocumentos($serviciosReferencias) { 
$id = $_POST['id']; 
$tipodocumento = $_POST['tipodocumento']; 
$res = $serviciosReferencias->modificarTipodocumentos($id,$tipodocumento); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarTipodocumentos($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarTipodocumentos($id); 
echo $res; 
} 
function insertarTipojugadores($serviciosReferencias) { 
$tipojugador = $_POST['tipojugador']; 
$abreviatura = $_POST['abreviatura']; 
$res = $serviciosReferencias->insertarTipojugadores($tipojugador,$abreviatura); 
if ((integer)$res > 0) { 
echo ''; 
} else { 
echo 'Huvo un error al insertar datos';	 
} 
} 
function modificarTipojugadores($serviciosReferencias) { 
$id = $_POST['id']; 
$tipojugador = $_POST['tipojugador']; 
$abreviatura = $_POST['abreviatura']; 
$res = $serviciosReferencias->modificarTipojugadores($id,$tipojugador,$abreviatura); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarTipojugadores($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarTipojugadores($id); 
echo $res; 
} 




function insertarValoreshabilitacionestransitorias($serviciosReferencias) { 
	$refdocumentaciones = $_POST['refdocumentaciones']; 
	$descripcion = $_POST['descripcion']; 
	
	if (isset($_POST['habilita'])) { 
		$habilita	= 1; 
	} else { 
		$habilita = 0; 
	} 
	
	if (isset($_POST['predeterminado'])) { 
		$default	= 1; 
		$serviciosReferencias->noPredeterminarTodo($refdocumentaciones);
	} else { 
		$default = 0; 
	} 
	
	
	$res = $serviciosReferencias->insertarValoreshabilitacionestransitorias($refdocumentaciones,$descripcion,$habilita,$default); 
	if ((integer)$res > 0) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al insertar datos';	 
	} 
} 


function modificarValoreshabilitacionestransitorias($serviciosReferencias) { 
$id = $_POST['id']; 
$refdocumentaciones = $_POST['refdocumentaciones']; 
$descripcion = $_POST['descripcion']; 
if (isset($_POST['habilita'])) { 
$habilita	= 1; 
} else { 
$habilita = 0; 
} 
if (isset($_POST['predeterminado'])) { 
$default	= 1; 
$serviciosReferencias->noPredeterminarTodo($refdocumentaciones);
} else { 
$default = 0; 
} 
$res = $serviciosReferencias->modificarValoreshabilitacionestransitorias($id,$refdocumentaciones,$descripcion,$habilita,$default); 
if ($res == true) { 
echo ''; 
} else { 
echo 'Huvo un error al modificar datos'; 
} 
} 
function eliminarValoreshabilitacionestransitorias($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarValoreshabilitacionestransitorias($id); 
echo $res; 
} 



/**************  ETAPA 3 Y 4 **************************************/
/* PARA Torneos */

 
function insertarTorneos($serviciosReferencias) { 
	$descripcion = $_POST['descripcion']; 
	$reftipotorneo = $_POST['reftipotorneo']; 
	$reftemporadas = $_POST['reftemporadas']; 
	$refcategorias = $_POST['refcategorias']; 
	$refdivisiones = $_POST['refdivisiones']; 
	$cantidadascensos = $_POST['cantidadascensos']; 
	$cantidaddescensos = $_POST['cantidaddescensos']; 
	if (isset($_POST['respetadefiniciontipojugadores'])) { 
		$respetadefiniciontipojugadores	= 1; 
	} else { 
		$respetadefiniciontipojugadores = 0; 
	} 
	if (isset($_POST['respetadefinicionhabilitacionestransitorias'])) { 
		$respetadefinicionhabilitacionestransitorias	= 1; 
	} else { 
		$respetadefinicionhabilitacionestransitorias = 0; 
	} 
	if (isset($_POST['respetadefinicionsancionesacumuladas'])) { 
		$respetadefinicionsancionesacumuladas	= 1; 
	} else { 
		$respetadefinicionsancionesacumuladas = 0; 
	} 
	if (isset($_POST['acumulagoleadores'])) { 
		$acumulagoleadores	= 1; 
	} else { 
		$acumulagoleadores = 0; 
	} 
	if (isset($_POST['acumulatablaconformada'])) { 
		$acumulatablaconformada	= 1; 
	} else { 
		$acumulatablaconformada = 0; 
	} 
	$observaciones = $_POST['observaciones']; 
	if (isset($_POST['activo'])) { 
		$activo	= 1; 
	} else { 
		$activo = 0; 
	} 
	
	$fechainicio = $_POST['fechainicio'];
	$fechainicio = formatearFechas($fechainicio);
	
	if ($fechainicio != '***') {
		$res = $serviciosReferencias->insertarTorneos($descripcion,$reftipotorneo,$reftemporadas,$refcategorias,$refdivisiones,$cantidadascensos,$cantidaddescensos,$respetadefiniciontipojugadores,$respetadefinicionhabilitacionestransitorias,$respetadefinicionsancionesacumuladas,$acumulagoleadores,$acumulatablaconformada,$observaciones,$activo); 
		if ((integer)$res > 0) { 
			$serviciosReferencias->desactivarTorneos($res,$reftipotorneo,$reftemporadas,$refcategorias,$refdivisiones);
			echo $res; 
		} else { 
			echo 'Huvo un error al insertar datos';	 
		} 
	} else {
		echo 'Formato de fecha incorrecto';	
	}
} 

function modificarTorneos($serviciosReferencias) { 
	$id = $_POST['id']; 
	$descripcion = $_POST['descripcion']; 
	$reftipotorneo = $_POST['reftipotorneo']; 
	$reftemporadas = $_POST['reftemporadas']; 
	$refcategorias = $_POST['refcategorias']; 
	$refdivisiones = $_POST['refdivisiones']; 
	$cantidadascensos = $_POST['cantidadascensos']; 
	$cantidaddescensos = $_POST['cantidaddescensos']; 
	if (isset($_POST['respetadefiniciontipojugadores'])) { 
		$respetadefiniciontipojugadores	= 1; 
	} else { 
		$respetadefiniciontipojugadores = 0; 
	} 
	if (isset($_POST['respetadefinicionhabilitacionestransitorias'])) { 
		$respetadefinicionhabilitacionestransitorias	= 1; 
	} else { 
		$respetadefinicionhabilitacionestransitorias = 0; 
	} 
	if (isset($_POST['respetadefinicionsancionesacumuladas'])) { 
		$respetadefinicionsancionesacumuladas	= 1; 
	} else { 
		$respetadefinicionsancionesacumuladas = 0; 
	} 
	if (isset($_POST['acumulagoleadores'])) { 
		$acumulagoleadores	= 1; 
	} else { 
		$acumulagoleadores = 0; 
	} 
	if (isset($_POST['acumulatablaconformada'])) { 
		$acumulatablaconformada	= 1; 
	} else { 
		$acumulatablaconformada = 0; 
	} 
	$observaciones = $_POST['observaciones']; 
	if (isset($_POST['activo'])) { 
		$activo	= 1; 
	} else { 
		$activo = 0; 
	} 
	
	$res = $serviciosReferencias->modificarTorneos($id,$descripcion,$reftipotorneo,$reftemporadas,$refcategorias,$refdivisiones,$cantidadascensos,$cantidaddescensos,$respetadefiniciontipojugadores,$respetadefinicionhabilitacionestransitorias,$respetadefinicionsancionesacumuladas,$acumulagoleadores,$acumulatablaconformada,$observaciones,$activo); 
	if ($res == true) { 
		if ($activo == 1) {
			$serviciosReferencias->desactivarTorneos($id,$reftipotorneo,$reftemporadas,$refcategorias,$refdivisiones);	
		}
		echo ''; 
	} else { 
		echo 'Huvo un error al modificar datos'; 
	} 
} 
	
function eliminarTorneos($serviciosReferencias) { 
	$id = $_POST['id']; 
	$res = $serviciosReferencias->eliminarTorneos($id); 
	echo $res; 
} 



function insertarEquipos($serviciosReferencias) { 
	$refcountries = $_POST['refcountries']; 
	$nombre = $_POST['nombre']; 
	$refcategorias = $_POST['refcategorias']; 
	$refdivisiones = $_POST['refdivisiones']; 
	$refcontactos = $_POST['refcontactos']; 
	$fechaalta = $_POST['fechaalta']; 
	$fachebaja = $_POST['fachebaja']; 
	if (isset($_POST['activo'])) { 
		$activo	= 1; 
	} else { 
		$activo = 0; 
	} 
	$res = $serviciosReferencias->insertarEquipos($refcountries,$nombre,$refcategorias,$refdivisiones,$refcontactos,$fechaalta,$fachebaja,$activo); 
	if ((integer)$res > 0) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al insertar datos';	 
	} 
} 

function modificarEquipos($serviciosReferencias) { 
	$id = $_POST['id']; 
	$refcountries = $_POST['refcountries']; 
	$nombre = $_POST['nombre']; 
	$refcategorias = $_POST['refcategorias']; 
	$refdivisiones = $_POST['refdivisiones']; 
	$refcontactos = $_POST['refcontactos']; 
	$fechaalta = $_POST['fechaalta']; 
	$fachebaja = $_POST['fachebaja']; 
	if (isset($_POST['activo'])) { 
		$activo	= 1; 
	} else { 
		$activo = 0; 
	} 
	$res = $serviciosReferencias->modificarEquipos($id,$refcountries,$nombre,$refcategorias,$refdivisiones,$refcontactos,$fechaalta,$fachebaja,$activo); 
	if ($res == true) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al modificar datos'; 
	} 
} 

function eliminarEquipos($serviciosReferencias) { 
	$id = $_POST['id']; 
	$res = $serviciosReferencias->eliminarEquipos($id); 
	echo $res; 
} 


function traerEquiposPorCountries($serviciosFunciones,$serviciosReferencias) {
	$id = $_POST['id']; 
	
	$resEquipo			=	$serviciosReferencias->traerEquiposPorCountries($id);
	$cadRefEquipo		=	$serviciosFunciones->devolverSelectBox($resEquipo,array(2),'');
	
	echo $cadRefEquipo;	
}

function traerEquipoPorCategoria($serviciosFunciones,$serviciosReferencias) {
	$id = $_POST['id']; 
	$idCountrie = $_POST['idCountrie']; 
	
	$resCategoria		=	$serviciosReferencias->traerEquipoPorCategoriaCountrie($id, $idCountrie);
	$cadRefCategoria	=	$serviciosFunciones->devolverSelectBox($resCategoria,array(1),'');
	
	echo $cadRefCategoria;	
}



function insertarPuntobonus($serviciosReferencias) { 
	$descripcion = $_POST['descripcion']; 
	$cantidadfechas = $_POST['cantidadfechas']; 
	
	if (isset($_POST['consecutivas'])) { 
		$consecutivas	= 1; 
	} else { 
		$consecutivas = 0; 
	} 
 
	$comparacion = $_POST['comparacion']; 
	$valoracomparar = $_POST['valoracomparar']; 
	$puntosextra = $_POST['puntosextra']; 
	
	$res = $serviciosReferencias->insertarPuntobonus($descripcion,$cantidadfechas,$consecutivas,$comparacion,$valoracomparar,$puntosextra); 
	if ((integer)$res > 0) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al insertar datos';	 
	} 
} 

function modificarPuntobonus($serviciosReferencias) { 
	$id = $_POST['id']; 
	$descripcion = $_POST['descripcion']; 
	$cantidadfechas = $_POST['cantidadfechas']; 
	
	if (isset($_POST['consecutivas'])) { 
		$consecutivas	= 1; 
	} else { 
		$consecutivas = 0; 
	} 
 
	$comparacion = $_POST['comparacion']; 
	$valoracomparar = $_POST['valoracomparar']; 
	$puntosextra = $_POST['puntosextra']; 
	
	$res = $serviciosReferencias->modificarPuntobonus($id,$descripcion,$cantidadfechas,$consecutivas,$comparacion,$valoracomparar,$puntosextra); 
	if ($res == true) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al modificar datos'; 
	} 
} 

function eliminarPuntobonus($serviciosReferencias) { 
	$id = $_POST['id']; 
	$res = $serviciosReferencias->eliminarPuntobonus($id); 
	echo $res; 
} 




function insertarTiposanciones($serviciosReferencias) { 
	if (isset($_POST['expulsion'])) { 
		$expulsion	= 1; 
	} else { 
		$expulsion = 0; 
	} 
	
	if (isset($_POST['amonestacion'])) { 
		$amonestacion	= 1; 
	} else { 
		$amonestacion = 0; 
	} 
	
	$descripcion = $_POST['descripcion']; 
	$cantminfechas = $_POST['cantminfechas']; 
	$abreviatura = $_POST['abreviatura']; 
	$cantmaxfechas = $_POST['cantmaxfechas']; 
	
	if (isset($_POST['cumpletodascategorias'])) { 
		$cumpletodascategorias	= 1; 
	} else { 
		$cumpletodascategorias = 0; 
	} 
	
	if (isset($_POST['llevapendiente'])) { 
		$llevapendiente	= 1; 
	} else { 
		$llevapendiente = 0; 
	} 
	
	if (isset($_POST['ocultardetallepublico'])) { 
		$ocultardetallepublico	= 1; 
	} else { 
		$ocultardetallepublico = 0; 
	} 
	
	$res = $serviciosReferencias->insertarTiposanciones($expulsion,$amonestacion,$descripcion,$cantminfechas,$abreviatura,$cantmaxfechas,$cumpletodascategorias,$llevapendiente,$ocultardetallepublico); 
	if ((integer)$res > 0) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al insertar datos';	 
	} 
} 

function modificarTiposanciones($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	if (isset($_POST['expulsion'])) { 
		$expulsion	= 1; 
	} else { 
		$expulsion = 0; 
	} 
	
	if (isset($_POST['amonestacion'])) { 
		$amonestacion	= 1; 
	} else { 
		$amonestacion = 0; 
	} 
	
	$descripcion = $_POST['descripcion']; 
	$cantminfechas = $_POST['cantminfechas']; 
	$abreviatura = $_POST['abreviatura']; 
	$cantmaxfechas = $_POST['cantmaxfechas']; 
	
	if (isset($_POST['cumpletodascategorias'])) { 
		$cumpletodascategorias	= 1; 
	} else { 
		$cumpletodascategorias = 0; 
	} 
	
	if (isset($_POST['llevapendiente'])) { 
		$llevapendiente	= 1; 
	} else { 
		$llevapendiente = 0; 
	} 
	
	if (isset($_POST['ocultardetallepublico'])) { 
		$ocultardetallepublico	= 1; 
	} else { 
		$ocultardetallepublico = 0; 
	} 
	
	$res = $serviciosReferencias->modificarTiposanciones($id,$expulsion,$amonestacion,$descripcion,$cantminfechas,$abreviatura,$cantmaxfechas,$cumpletodascategorias,$llevapendiente,$ocultardetallepublico); 
	if ($res == true) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al modificar datos'; 
	} 
}  

function eliminarTiposanciones($serviciosReferencias) { 
	$id = $_POST['id']; 
	$res = $serviciosReferencias->eliminarTiposanciones($id); 
	echo $res; 
} 



function insertarFechasexcluidas($serviciosReferencias) { 
	$fecha = formatearFechas($_POST['fecha']); 
	$descripcion = $_POST['descripcion']; 
	
	if ($fecha == '***') {
		echo 'Formato de fecha incorrecto';
	} else {
		$res = $serviciosReferencias->insertarFechasexcluidas($fecha,$descripcion); 
		if ((integer)$res > 0) { 
			echo ''; 
		} else { 
			echo 'Huvo un error al insertar datos';	 
		} 
	}
} 

function modificarFechasexcluidas($serviciosReferencias) { 
	$id = $_POST['id']; 
	$fecha = formatearFechas($_POST['fecha']); 
	$descripcion = $_POST['descripcion']; 
	
	if ($fecha == '***') {
		echo 'Formato de fecha incorrecto';
	} else {
		$res = $serviciosReferencias->modificarFechasexcluidas($id,$fecha,$descripcion); 
		if ($res == true) { 
			echo ''; 
		} else { 
			echo 'Huvo un error al modificar datos'; 
		} 
	}
} 
function eliminarFechasexcluidas($serviciosReferencias) { 
	$id = $_POST['id']; 
	$res = $serviciosReferencias->eliminarFechasexcluidas($id); 
	echo $res; 
} 




function insertarEstadospartidos($serviciosReferencias) { 
	$descripcion = $_POST['descripcion']; 
	
	if (isset($_POST['defautomatica'])) { 
		$defautomatica	= 1; 
	} else { 
		$defautomatica = 0; 
	} 
	
	$goleslocalauto = $_POST['goleslocalauto']; 
	
	if (isset($_POST['goleslocalborra'])) { 
		$goleslocalborra	= 1; 
	} else { 
		$goleslocalborra = 0; 
	} 
	
	$golesvisitanteauto = $_POST['golesvisitanteauto']; 
	
	if (isset($_POST['golesvisitanteborra'])) { 
		$golesvisitanteborra	= 1; 
	} else { 
		$golesvisitanteborra = 0; 
	} 
	
	$puntoslocal = $_POST['puntoslocal']; 
	$puntosvisitante = $_POST['puntosvisitante']; 
	
	if (isset($_POST['finalizado'])) { 
		$finalizado	= 1; 
	} else { 
		$finalizado = 0; 
	} 
	
	if (isset($_POST['ocultardetallepublico'])) { 
		$ocultardetallepublico	= 1; 
	} else { 
		$ocultardetallepublico = 0; 
	} 
	
	if (isset($_POST['visibleparaarbitros'])) { 
		$visibleparaarbitros	= 1; 
	} else { 
		$visibleparaarbitros = 0; 
	} 

	
	$res = $serviciosReferencias->insertarEstadospartidos($descripcion,$defautomatica,$goleslocalauto,$goleslocalborra,$golesvisitanteauto,$golesvisitanteborra,$puntoslocal,$puntosvisitante,$finalizado,$ocultardetallepublico,$visibleparaarbitros); 
	if ((integer)$res > 0) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al insertar datos';	 
	} 
} 

function modificarEstadospartidos($serviciosReferencias) { 
	$id = $_POST['id']; 
	$descripcion = $_POST['descripcion']; 
	
	if (isset($_POST['defautomatica'])) { 
		$defautomatica	= 1; 
	} else { 
		$defautomatica = 0; 
	} 
	
	$goleslocalauto = $_POST['goleslocalauto']; 
	
	if (isset($_POST['goleslocalborra'])) { 
		$goleslocalborra	= 1; 
	} else { 
		$goleslocalborra = 0; 
	} 
	
	$golesvisitanteauto = $_POST['golesvisitanteauto']; 
	
	if (isset($_POST['golesvisitanteborra'])) { 
		$golesvisitanteborra	= 1; 
	} else { 
		$golesvisitanteborra = 0; 
	} 
	
	$puntoslocal = $_POST['puntoslocal']; 
	$puntosvisitante = $_POST['puntosvisitante']; 
	
	if (isset($_POST['finalizado'])) { 
		$finalizado	= 1; 
	} else { 
		$finalizado = 0; 
	} 
	
	if (isset($_POST['ocultardetallepublico'])) { 
		$ocultardetallepublico	= 1; 
	} else { 
		$ocultardetallepublico = 0; 
	} 
	
	if (isset($_POST['visibleparaarbitros'])) { 
		$visibleparaarbitros	= 1; 
	} else { 
		$visibleparaarbitros = 0; 
	}  
	
	$res = $serviciosReferencias->modificarEstadospartidos($id,$descripcion,$defautomatica,$goleslocalauto,$goleslocalborra,$golesvisitanteauto,$golesvisitanteborra,$puntoslocal,$puntosvisitante,$finalizado,$ocultardetallepublico,$visibleparaarbitros); 
	if ($res == true) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al modificar datos'; 
	} 
} 

function eliminarEstadospartidos($serviciosReferencias) { 
	$id = $_POST['id']; 
	$res = $serviciosReferencias->eliminarEstadospartidos($id); 
	echo $res; 
} 





function insertarDefinicionescategoriastemporadas($serviciosReferencias) {
	$refcategorias = $_POST['refcategorias'];
	$reftemporadas = $_POST['reftemporadas'];
	$cantmaxjugadores = $_POST['cantmaxjugadores'];
	$cantminjugadores = $_POST['cantminjugadores'];
	$refdias = $_POST['refdias'];
	$hora = $_POST['hora'];
	$minutospartido = $_POST['minutospartido'];
	$cantidadcambiosporpartido = $_POST['cantidadcambiosporpartido'];
	
	if (isset($_POST['conreingreso'])) {
		$conreingreso = 1;
	} else {
		$conreingreso = 0;
	}
	
	$observaciones = $_POST['observaciones'];
	
	$res = $serviciosReferencias->insertarDefinicionescategoriastemporadas($refcategorias,$reftemporadas,$cantmaxjugadores,$cantminjugadores,$refdias,$hora,$minutospartido,$cantidadcambiosporpartido,$conreingreso,$observaciones);
	
	if ((integer)$res > 0) {
		echo '';
	} else {
		echo 'Huvo un error al insertar datos';
	}
}

function modificarDefinicionescategoriastemporadas($serviciosReferencias) {
	$id = $_POST['id'];
	$refcategorias = $_POST['refcategorias'];
	$reftemporadas = $_POST['reftemporadas'];
	$cantmaxjugadores = $_POST['cantmaxjugadores'];
	$cantminjugadores = $_POST['cantminjugadores'];
	$refdias = $_POST['refdias'];
	$hora = $_POST['hora'];
	$minutospartido = $_POST['minutospartido'];
	$cantidadcambiosporpartido = $_POST['cantidadcambiosporpartido'];
	
	if (isset($_POST['conreingreso'])) {
		$conreingreso = 1;
	} else {
		$conreingreso = 0;
	}
	
	$observaciones = $_POST['observaciones'];
	
	$res = $serviciosReferencias->modificarDefinicionescategoriastemporadas($id,$refcategorias,$reftemporadas,$cantmaxjugadores,$cantminjugadores,$refdias,$hora,$minutospartido,$cantidadcambiosporpartido,$conreingreso,$observaciones);
	
	if ($res == true) {
		echo '';
	} else {
		echo 'Huvo un error al modificar datos';
	}
} 

function eliminarDefinicionescategoriastemporadas($serviciosReferencias) { 
	$id = $_POST['id']; 
	$res = $serviciosReferencias->eliminarDefinicionescategoriastemporadas($id); 
	echo $res; 
} 

function insertarDefinicionescategoriastemporadastipojugador($serviciosReferencias) { 
	$refdefinicionescategoriastemporadas = $_POST['refdefinicionescategoriastemporadas']; 
	$reftipojugadores = $_POST['reftipojugadores']; 
	$edadmaxima = $_POST['edadmaxima']; 
	$edadminima = $_POST['edadminima']; 
	$cantjugadoresporequipo = $_POST['cantjugadoresporequipo']; 
	$jugadorescancha = $_POST['jugadorescancha']; 
	$observaciones = $_POST['observaciones']; 
	
	$res = $serviciosReferencias->insertarDefinicionescategoriastemporadastipojugador($refdefinicionescategoriastemporadas,$reftipojugadores,$edadmaxima,$edadminima,$cantjugadoresporequipo,$jugadorescancha,$observaciones); 
	
	if ((integer)$res > 0) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al insertar datos';	 
	} 
} 

function modificarDefinicionescategoriastemporadastipojugador($serviciosReferencias) { 
	$id = $_POST['id']; 
	$refdefinicionescategoriastemporadas = $_POST['refdefinicionescategoriastemporadas']; 
	$reftipojugadores = $_POST['reftipojugadores']; 
	$edadmaxima = $_POST['edadmaxima']; 
	$edadminima = $_POST['edadminima']; 
	$cantjugadoresporequipo = $_POST['cantjugadoresporequipo']; 
	$jugadorescancha = $_POST['jugadorescancha']; 
	$observaciones = $_POST['observaciones']; 
	
	$res = $serviciosReferencias->modificarDefinicionescategoriastemporadastipojugador($id,$refdefinicionescategoriastemporadas,$reftipojugadores,$edadmaxima,$edadminima,$cantjugadoresporequipo,$jugadorescancha,$observaciones); 
	
	if ($res == true) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al modificar datos'; 
	} 
} 

function eliminarDefinicionescategoriastemporadastipojugador($serviciosReferencias) { 
	$id = $_POST['id']; 
	$res = $serviciosReferencias->eliminarDefinicionescategoriastemporadastipojugador($id); 
	echo $res; 
} 

function traerDefinicionesPorTemporadaCategoriaTipoJugador($serviciosReferencias) {
	$idTemporada 	= $_POST['resTemporada'];
	$idCategoria 	= $_POST['resCategoria'];
	$idTipoJugador 	= $_POST['resTipoJugador'];
	
	$res = $serviciosReferencias->traerDefinicionesPorTemporadaCategoriaTipoJugador($idTemporada, $idCategoria, $idTipoJugador);	
	$cad = '';
	
	if (mysql_num_rows($res)>0) {
		$cad = 'Edad Minima: '.mysql_result($res,0,'edadminima').' - Edad Maxima: '.mysql_result($res,0,'edadmaxima');
		echo $cad;
	} else {
		echo $cad;	
	}
	
}


function insertarDefinicionessancionesacumuladastemporadas($serviciosReferencias) { 
	$reftiposanciones = $_POST['reftiposanciones']; 
	$reftemporadas = $_POST['reftemporadas']; 
	$cantidadacumulada = $_POST['cantidadacumulada']; 
	$cantidadfechasacumplir = $_POST['cantidadfechasacumplir']; 
	
	$res = $serviciosReferencias->insertarDefinicionessancionesacumuladastemporadas($reftiposanciones,$reftemporadas,$cantidadacumulada,$cantidadfechasacumplir); 
	if ((integer)$res > 0) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al insertar datos';	 
	} 
} 

function modificarDefinicionessancionesacumuladastemporadas($serviciosReferencias) { 
	$id = $_POST['id']; 
	$reftiposanciones = $_POST['reftiposanciones']; 
	$reftemporadas = $_POST['reftemporadas']; 
	$cantidadacumulada = $_POST['cantidadacumulada']; 
	$cantidadfechasacumplir = $_POST['cantidadfechasacumplir']; 
	
	$res = $serviciosReferencias->modificarDefinicionessancionesacumuladastemporadas($id,$reftiposanciones,$reftemporadas,$cantidadacumulada,$cantidadfechasacumplir); 
	if ($res == true) { 
		echo ''; 
	} else { 
		echo 'Huvo un error al modificar datos'; 
	} 
} 

function eliminarDefinicionessancionesacumuladastemporadas($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarDefinicionessancionesacumuladastemporadas($id); 
echo $res; 
} 
/* Fin */
/* /* Fin de la Tabla: dbtorneos*/

function insertarJugadoresmotivoshabilitacionestransitoriasA($serviciosReferencias) { 
	
	$reftemporadas = $_POST['reftemporadasA']; 
	$refjugadores = $_POST['refjugadores']; 
	$refdocumentaciones = $_POST['refdocumentacionesA']; 
	$refmotivoshabilitacionestransitorias = $_POST['refmotivoshabilitacionestransitoriasA']; 
	$refequipos = $_POST['refequiposA']; 
	$refcategorias = $_POST['refcategoriasA']; 
	$fechalimite = formatearFechas($_POST['fechalimiteA']); 
	$observaciones = $_POST['observacionesA']; 
	
	if ($fechalimite == '***') {
		echo 'Formato de fecha incorrecto';
	} else {
		if ($serviciosReferencias->existeJugadoresMotivosHabilitacionesTransitorias($reftemporadas, $refcategorias, $refequipos, $refjugadores, $refdocumentaciones,$refmotivoshabilitacionestransitorias) == 0) {
			$res = $serviciosReferencias->insertarJugadoresmotivoshabilitacionestransitorias($reftemporadas,$refjugadores,$refdocumentaciones,$refmotivoshabilitacionestransitorias,$refequipos,$refcategorias,$fechalimite,$observaciones); 
			
			if ((integer)$res > 0) { 
				echo ''; 
			} else { 
				echo 'Huvo un error al insertar datos';	 
			} 
		} else {
			echo 'Ya existe esta habilitación';	
		}
	}
} 

function insertarJugadoresmotivoshabilitacionestransitoriasB($serviciosReferencias) { 
	
	$reftemporadas = $_POST['reftemporadasB']; 
	$refjugadores = $_POST['refjugadores']; 
	$refdocumentaciones = $_POST['refdocumentacionesB']; 
	$refmotivoshabilitacionestransitorias = $_POST['refmotivoshabilitacionestransitoriasB']; 
	$refequipos = formatearEntero(''); 
	$refcategorias = $_POST['refcategoriasB']; 
	$fechalimite = formatearFechas($_POST['fechalimiteB']); 
	$observaciones = $_POST['observacionesB']; 
	
	if ($fechalimite == '***') {
		echo 'Formato de fecha incorrecto';
	} else {
		if ($serviciosReferencias->existeJugadoresMotivosHabilitacionesTransitorias($reftemporadas, $refcategorias, $refequipos, $refjugadores, $refdocumentaciones,$refmotivoshabilitacionestransitorias) == 0) {
			$res = $serviciosReferencias->insertarJugadoresmotivoshabilitacionestransitorias($reftemporadas,$refjugadores,$refdocumentaciones,$refmotivoshabilitacionestransitorias,$refequipos,$refcategorias,$fechalimite,$observaciones); 
			
			if ((integer)$res > 0) { 
				echo ''; 
			} else { 
				echo 'Huvo un error al insertar datos';	 
			} 
		} else {
			echo 'Ya existe esta habilitación';	
		}
	}
}

function modificarJugadoresmotivoshabilitacionestransitorias($serviciosReferencias) { 
$id = $_POST['id']; 
$reftemporadas = $_POST['reftemporadas']; 
$refjugadores = $_POST['refjugadores']; 
$refdocumentaciones = $_POST['refdocumentaciones']; 
$refmotivoshabilitacionestransitorias = $_POST['refmotivoshabilitacionestransitorias']; 
$refequipos = $_POST['refequipos']; 
$refcategorias = $_POST['refcategorias']; 
$fechalimite = formatearFechas($_POST['fechalimite']); 
$observaciones = $_POST['observaciones']; 
	
	if ($fechalimite == '***') {
		echo 'Formato de fecha incorrecto';
	} else {
		$res = $serviciosReferencias->modificarJugadoresmotivoshabilitacionestransitorias($id,$reftemporadas,$refjugadores,$refdocumentaciones,$refmotivoshabilitacionestransitorias,$refequipos,$refcategorias,$fechalimite,$observaciones); 
		if ($res == true) { 
			echo ''; 
		} else { 
			echo 'Huvo un error al modificar datos'; 
		} 
	}
} 

function eliminarJugadoresmotivoshabilitacionestransitorias($serviciosReferencias) { 
$id = $_POST['id']; 
$res = $serviciosReferencias->eliminarJugadoresmotivoshabilitacionestransitorias($id); 
echo $res; 
} 



/**************** FIN *********************************************/

////////////////////////// FIN DE TRAER DATOS ////////////////////////////////////////////////////////////

//////////////////////////  BASICO  /////////////////////////////////////////////////////////////////////////

function toArray($query)
{
    $res = array();
    while ($row = @mysql_fetch_array($query)) {
        $res[] = $row;
    }
    return $res;
}


function entrar($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	echo $serviciosUsuarios->loginUsuario($email,$pass);
}


function registrar($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroll'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';	
	} else {
		echo $res;	
	}
}


function insertarUsuario($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';	
	} else {
		echo $res;	
	}
}


function modificarUsuario($serviciosUsuarios) {
	$id					=	$_POST['id'];
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	echo $serviciosUsuarios->modificarUsuario($id,$usuario,$password,$refroll,$email,$nombre);
}


function enviarMail($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	//$idempresa  =	$_POST['idempresa'];
	
	echo $serviciosUsuarios->login($email,$pass);
}


function devolverImagen($nroInput) {
	
	if( $_FILES['archivo'.$nroInput]['name'] != null && $_FILES['archivo'.$nroInput]['size'] > 0 ){
	// Nivel de errores
	  error_reporting(E_ALL);
	  $altura = 100;
	  // Constantes
	  # Altura de el thumbnail en píxeles
	  //define("ALTURA", 100);
	  # Nombre del archivo temporal del thumbnail
	  //define("NAMETHUMB", "/tmp/thumbtemp"); //Esto en servidores Linux, en Windows podría ser:
	  //define("NAMETHUMB", "c:/windows/temp/thumbtemp"); //y te olvidas de los problemas de permisos
	  $NAMETHUMB = "c:/windows/temp/thumbtemp";
	  # Servidor de base de datos
	  //define("DBHOST", "localhost");
	  # nombre de la base de datos
	  //define("DBNAME", "portalinmobiliario");
	  # Usuario de base de datos
	  //define("DBUSER", "root");
	  # Password de base de datos
	  //define("DBPASSWORD", "");
	  // Mime types permitidos
	  $mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
	  // Variables de la foto
	  $name = $_FILES["archivo".$nroInput]["name"];
	  $type = $_FILES["archivo".$nroInput]["type"];
	  $tmp_name = $_FILES["archivo".$nroInput]["tmp_name"];
	  $size = $_FILES["archivo".$nroInput]["size"];
	  // Verificamos si el archivo es una imagen válida
	  if(!in_array($type, $mimetypes))
		die("El archivo que subiste no es una imagen válida");
	  // Creando el thumbnail
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  $img = imagecreatefromjpeg($tmp_name);
		  break;
		case $mimetypes[2]:
		  $img = imagecreatefromgif($tmp_name);
		  break;
		case $mimetypes[3]:
		  $img = imagecreatefrompng($tmp_name);
		  break;
	  }
	  
	  $datos = getimagesize($tmp_name);
	  
	  $ratio = ($datos[1]/$altura);
	  $ancho = round($datos[0]/$ratio);
	  $thumb = imagecreatetruecolor($ancho, $altura);
	  imagecopyresized($thumb, $img, 0, 0, 0, 0, $ancho, $altura, $datos[0], $datos[1]);
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  imagejpeg($thumb, $NAMETHUMB);
			  break;
		case $mimetypes[2]:
		  imagegif($thumb, $NAMETHUMB);
		  break;
		case $mimetypes[3]:
		  imagepng($thumb, $NAMETHUMB);
		  break;
	  }
	  // Extrae los contenidos de las fotos
	  # contenido de la foto original
	  $fp = fopen($tmp_name, "rb");
	  $tfoto = fread($fp, filesize($tmp_name));
	  $tfoto = addslashes($tfoto);
	  fclose($fp);
	  # contenido del thumbnail
	  $fp = fopen($NAMETHUMB, "rb");
	  $tthumb = fread($fp, filesize($NAMETHUMB));
	  $tthumb = addslashes($tthumb);
	  fclose($fp);
	  // Borra archivos temporales si es que existen
	  //@unlink($tmp_name);
	  //@unlink(NAMETHUMB);
	} else {
		$tfoto = '';
		$type = '';
	}
	$tfoto = utf8_decode($tfoto);
	return array('tfoto' => $tfoto, 'type' => $type);	
}


?>