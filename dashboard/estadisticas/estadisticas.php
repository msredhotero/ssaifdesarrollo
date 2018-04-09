<?php

session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../../error.php');
} else {


include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../estadisticas/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Carga de Partidos",$_SESSION['refroll_predio'],$_SESSION['email_predio']);

$idFixture = $_GET['id'];

$resFix = $serviciosReferencias->TraerFixturePorId($idFixture);
$resFixDetalle	= $serviciosReferencias->traerFixtureDetallePorId($idFixture);

$equipoLocal		=	mysql_result($resFix,0,'refconectorlocal');
$equipoVisitante	=	mysql_result($resFix,0,'refconectorvisitante');

$refFecha = mysql_result($resFix,0,'reffechas');
$refJugo = mysql_result($resFix,0,'fecha');
$resultadoA = mysql_result($resFix,0,'puntoslocal');
$resultadoB = mysql_result($resFix,0,'puntosvisita');

$resFecha	=	$serviciosReferencias->traerFechasPorId($refFecha);


if (($equipoLocal != 0) && ($equipoVisitante != 0)) {
	

$equipoA = mysql_result($serviciosReferencias->traerEquiposPorId($equipoLocal),0,'nombre');
$equipoB = mysql_result($serviciosReferencias->traerEquiposPorId($equipoVisitante),0,'nombre');

$resTorneo	=	$serviciosReferencias->traerTorneosPorId(mysql_result($resFix,0,'reftorneos'));

////////////  TRAIGO EL TIPO DE TORNEO  //////////////////////////////
$idTipoTorneoTorneo	= mysql_result($resTorneo,0,'reftipotorneo');
/////////////  FIN TIPO TORNEO ///////////////////////////////////////

//todas las fechas del torneo del equipo local (Fechas Local y Visitante)
$resTodasFechasL = $serviciosReferencias->traerFechasFixturePorTorneoEquipoLocal(mysql_result($resFix,0,'reftorneos'), $equipoLocal);
$resTodasFechasLV = $serviciosReferencias->traerFechasFixturePorTorneoEquipoVisitante(mysql_result($resFix,0,'reftorneos'), $equipoLocal);

//todas las fechas del torneo del equipo visitante
$resTodasFechasV = $serviciosReferencias->traerFechasFixturePorTorneoEquipoVisitante(mysql_result($resFix,0,'reftorneos'), $equipoVisitante);
$resTodasFechasVL = $serviciosReferencias->traerFechasFixturePorTorneoEquipoLocal(mysql_result($resFix,0,'reftorneos'), $equipoVisitante);

$idCategoria	=	mysql_result($resTorneo,0,'refcategorias');
$idDivisiones	=	mysql_result($resTorneo,0,'refdivisiones');

///////////////   traigo la utima temporada  ///////////////////
$refTemporada = $serviciosReferencias->traerUltimaTemporada();

if (mysql_num_rows($refTemporada)>0) {
	$idTemporada = mysql_result($refTemporada,0,0);	
} else {
	$idTemporada = 0;
}
////////////////// fin  ////////////////////////////////////////

/////////////		traigo los minutos del partido   ////////////////
$resDefCategTemp		=	$serviciosReferencias->traerDefinicionescategoriastemporadasPorTemporadaCategoria($idTemporada, $idCategoria);

if (mysql_num_rows($resDefCategTemp)>0) {
	$minutos				=	mysql_result($resDefCategTemp,0,'minutospartido');
} else {
	$minutos				=	80;
}
/////////////			fin				/////////////////////////////

/////////////////////// Opciones de la pagina  ////////////////////

$lblTitulosingular	= "Estadistica";
$lblTituloplural	= "Estadisticas";
$lblEliminarObs		= "Si elimina la Estadistica se eliminara todo el contenido de este";
$accionEliminar		= "eliminarEstadisticas";

/////////////////////// Fin de las opciones /////////////////////



/////////////////////// Opciones para la creacion del view  /////////////////////
$cabeceras 		= "<th>Nombre</th>
				<th>DNI</th>
				<th>Equipo</th>
				<th>Fecha</th>
				<th>Goles</th>";

$cabeceras2 		= "<th>Nombre</th>
				<th>DNI</th>
				<th>Equipo</th>
				<th>Fecha</th>
				<th>Amarillas</th>";
//////////////////////////////////////////////  FIN de los opciones //////////////////////////



$resJugadoresA = $serviciosReferencias->traerConectorActivosPorEquiposCategorias($equipoLocal, $idCategoria);
$resJugadoresB = $serviciosReferencias->traerConectorActivosPorEquiposCategorias($equipoVisitante, $idCategoria);

$resDetalleIncidenciasLocal = $serviciosReferencias->traerSancionesjugadoresPorFixtureEquipoTotales($idFixture,$equipoLocal);
$resDetalleIncidenciasVisit = $serviciosReferencias->traerSancionesjugadoresPorFixtureEquipoTotales($idFixture,$equipoVisitante);

$incidenciaALocal	=	0;
$incidenciaRLocal	=	0;
$incidenciaILocal	=	0;
$incidenciaDALocal	=	0;
$incidenciaCDTDLocal =	0;

$incidenciaAVisit	=	0;
$incidenciaRVisit	=	0;
$incidenciaIVisit	=	0;
$incidenciaDAVisit	=	0;
$incidenciaCDTDVisit =	0;

if (mysql_num_rows($resDetalleIncidenciasLocal)>0) {
	$incidenciaALocal	=	mysql_result($resDetalleIncidenciasLocal,0,'amarillas');
	$incidenciaRLocal	=	mysql_result($resDetalleIncidenciasLocal,0,'rojas');
	$incidenciaILocal	=	mysql_result($resDetalleIncidenciasLocal,0,'informados');
	$incidenciaDALocal	=	mysql_result($resDetalleIncidenciasLocal,0,'dobleamarilla');
	$incidenciaCDTDLocal =	mysql_result($resDetalleIncidenciasLocal,0,'cdtd');	
}

if (mysql_num_rows($resDetalleIncidenciasVisit)>0) {
	$incidenciaAVisit	=	mysql_result($resDetalleIncidenciasVisit,0,'amarillas');
	$incidenciaRVisit	=	mysql_result($resDetalleIncidenciasVisit,0,'rojas');
	$incidenciaIVisit	=	mysql_result($resDetalleIncidenciasVisit,0,'informados');
	$incidenciaDAVisit	=	mysql_result($resDetalleIncidenciasVisit,0,'dobleamarilla');
	$incidenciaCDTDVisit =	mysql_result($resDetalleIncidenciasVisit,0,'cdtd');	
}



$existe			= $serviciosReferencias->existe( "select refestadospartidos from dbfixture where refestadospartidos is not null and idfixture = ".$idFixture);

//die(print_r($existe));
if ($_SESSION['idroll_predio'] == 1) {
	if ($existe == 0) {
		$resEstados		= $serviciosReferencias->traerEstadospartidos();
		$cadEstados		= $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');
	} else {
		$resEstados		= $serviciosReferencias->traerEstadospartidos();
		$cadEstados		= $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resFix,0,'refestadospartidos'));
		
		$estadoPartido	=	$serviciosReferencias->traerEstadospartidosPorId(mysql_result($resFix,0,'refestadospartidos'));
	
		$defAutomatica			= mysql_result($estadoPartido,0,'defautomatica');
	
		$golesLocalAuto			= mysql_result($estadoPartido,0,'goleslocalauto');
		$golesLocalBorra		= mysql_result($estadoPartido,0,'goleslocalborra');
		
		$golesvisitanteauto		= mysql_result($estadoPartido,0,'golesvisitanteauto');
		$golesvisitanteborra	= mysql_result($estadoPartido,0,'golesvisitanteborra');
		
		$puntosLocal			= mysql_result($estadoPartido,0,'puntoslocal');
		$puntosVisitante		= mysql_result($estadoPartido,0,'puntosvisitante');
		
		$finalizado				= mysql_result($estadoPartido,0,'finalizado');
		
		$ocultaDetallePublico	= mysql_result($estadoPartido,0,'ocultardetallepublico');
		
		$visibleParaArbitros	= mysql_result($estadoPartido,0,'visibleparaarbitros');
		
		$contabilizaLocal		= mysql_result($estadoPartido,0,'contabilizalocal');
		$contabilizaVisitante	= mysql_result($estadoPartido,0,'contabilizavisitante');
		

	}
} else {
	if ($existe == 0) {
		$resEstados		= $serviciosReferencias->traerEstadospartidosArbitros();
		$cadEstados		= $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');
	} else {
		$resEstados		= $serviciosReferencias->traerEstadospartidosArbitros();
		$cadEstados		= $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resFix,0,'refestadospartidos'));
		
		$estadoPartido	=	$serviciosReferencias->traerEstadospartidosPorId(mysql_result($resFix,0,'refestadospartidos'));
		
		if (mysql_result($estadoPartido,0,'visibleparaarbitros') == 'No') {
			
			header('Location: index.php');	
		}
		$defAutomatica			= mysql_result($estadoPartido,0,'defautomatica');
	
		$golesLocalAuto			= mysql_result($estadoPartido,0,'goleslocalauto');
		$golesLocalBorra		= mysql_result($estadoPartido,0,'goleslocalborra');
		
		$golesvisitanteauto		= mysql_result($estadoPartido,0,'golesvisitanteauto');
		$golesvisitanteborra	= mysql_result($estadoPartido,0,'golesvisitanteborra');
		
		$puntosLocal			= mysql_result($estadoPartido,0,'puntoslocal');
		$puntosVisitante		= mysql_result($estadoPartido,0,'puntosvisitante');
		
		$finalizado				= mysql_result($estadoPartido,0,'finalizado');
		
		$ocultaDetallePublico	= mysql_result($estadoPartido,0,'ocultardetallepublico');
		
		$visibleParaArbitros	= mysql_result($estadoPartido,0,'visibleparaarbitros');
		
		$contabilizaLocal		= mysql_result($estadoPartido,0,'contabilizalocal');
		$contabilizaVisitante	= mysql_result($estadoPartido,0,'contabilizavisitante');
		

	}
}

$refCanchas		=	$serviciosReferencias->traerCanchas();
if (mysql_result($resFixDetalle,0,'refcanchas') == '') {
	$cadCanchas	=	$serviciosFunciones->devolverSelectBox($refCanchas,array(2),'');	
} else {
	$cadCanchas	=	$serviciosFunciones->devolverSelectBoxActivo($refCanchas,array(2),'',mysql_result($resFixDetalle,0,'refcanchas'));
}


$refArbitros	=	$serviciosReferencias->traerArbitros();
if (mysql_result($resFixDetalle,0,'refarbitros') == '') {
	$cadArbitros	=	$serviciosFunciones->devolverSelectBox($refArbitros,array(1),'');	
} else {
	$cadArbitros	=	$serviciosFunciones->devolverSelectBoxActivo($refArbitros,array(1),'',mysql_result($resFixDetalle,0,'refarbitros'));
}

$resCambioLocal 	= $serviciosReferencias->traerCambiosPorFixtureEquipo($idFixture, $equipoLocal);
$resCambioVisitante = $serviciosReferencias->traerCambiosPorFixtureEquipo($idFixture, $equipoVisitante);



if ($_SESSION['idroll_predio'] != 1) {

} else {

	
}

?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Gesti&oacute;n: AIF</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../js/jquery.number.min.js"></script>
    
	<style type="text/css">
		
  
		
	</style>
    
   <link rel="stylesheet" href="../../css/chosen.css">
   <link href="../../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../../js/jquery.mousewheel.js"></script>
      <script src="../../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
		
		
      });
    </script>
    
    <script type="text/javascript">
			
			$(function(){
				// Set up the number formatting.
				/*
				$('#goles3').number( true, 2 );
				$('#goles3').number( true, 2 );*/
				$('.golesEB').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.golescontraEB').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.golesEA').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.golescontraEA').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.amarillas').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.rojas').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.informados').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.dobleamarilla').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.cdtd').each(function(intIndex){
					$(this).number( true, 0 );
				});
				

				
				
				$('.golesEA').change(function(e) {
					var acumulado = 0;
					$('.golesEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					
					$('.resultadoA').html(acumulado);
				});
				
				
				$('.golescontraEB').change(function(e) {
					var acumulado = 0;
					$('.golesEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoA').html(acumulado);
				});
				
				
				$('.penalesconvertidosEA').change(function(e) {
					var acumulado = 0;
					$('.golesEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					
					$('.resultadoA').html(acumulado);
				});
				
				
				
				
				
				$('.golesEB').change(function(e) {
					var acumulado = 0;
					$('.golesEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoB').html(acumulado);
				});
				
				
				$('.golescontraEA').change(function(e) {
					var acumulado = 0;
					$('.golesEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoB').html(acumulado);
				});
				
				$('.penalesconvertidosEB').change(function(e) {
					var acumulado = 0;
					$('.golesEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoB').html(acumulado);
				});
				
				$('.minutos').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > <?php echo $minutos; ?>) {
							$(this).val(<?php echo $minutos; ?>);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.minutosEB').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > <?php echo $minutos; ?>) {
							$(this).val(<?php echo $minutos; ?>);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.amarillas').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(2);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.rojas').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.informados').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.dobleamarilla').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.cdtd').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.penalesconvertidos').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.penalesatajados').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.penaleserrados').each(function(intIndex){
					$(this).number( true, 0 );
				});

			});
		</script>
    

</head>

<body>

 
<?php echo $resMenu; ?>

<div id="content">

    <div class="boxInfoLargoEstadisticas">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Cargar Partido - <?php echo mysql_result($resFecha,0,1); ?></p>
        	
        </div>
    	<div class="cuerpoBox" style="padding-right:10px;">
        
        <button data-toggle="collapse" data-target="#demo" class="btn btn-info" style="margin-bottom:5px;">Fechas de los equipos</button>
        <div id="demo" class="collapse">
        	<div class="col-md-12" align="center" style="text-align:center;">
                <ul class="list-inline" id="lstFechas">
                	<li><?php echo $equipoA; ?> - Local: </li>
                    <?php while ($row = mysql_fetch_array($resTodasFechasL)) { ?>
                    <li style="padding-bottom:8px;">
                        <a href="estadisticas.php?id=<?php echo $row[0]; ?>"><button type="button" class="btn btn-success" style="margin-left:0px;"><?php echo $row[1]; ?></button></a>
                    </li>
                    <?php } ?>
                    <li>Visitante: </li>
                    <?php while ($row = mysql_fetch_array($resTodasFechasLV)) { ?>
                    <li style="padding-bottom:8px;">
                        <a href="estadisticas.php?id=<?php echo $row[0]; ?>"><button type="button" class="btn btn-success" style="margin-left:0px;"><?php echo $row[1]; ?></button></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            
            <div class="col-md-12" align="center" style="text-align:center;">
                <ul class="list-inline" id="lstFechas">
                	<li><?php echo $equipoB; ?> - Visitante: </li>
                    <?php while ($row = mysql_fetch_array($resTodasFechasV)) { ?>
                    <li style="padding-bottom:8px;">
                        <a href="estadisticas.php?id=<?php echo $row[0]; ?>"><button type="button" class="btn btn-danger" style="margin-left:0px;"><?php echo $row[1]; ?></button></a>
                    </li>
                    <?php } ?>
                    <li>Local: </li>
                    <?php while ($row = mysql_fetch_array($resTodasFechasVL)) { ?>
                    <li style="padding-bottom:8px;">
                        <a href="estadisticas.php?id=<?php echo $row[0]; ?>"><button type="button" class="btn btn-danger" style="margin-left:0px;"><?php echo $row[1]; ?></button></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>                
                        
    		<form class="form-inline formulario" id="target" role="form" method="post" action="cargarestadisticas.php">
        	<div class="row">
                <div class="col-md-3">
                	<p>Descripción: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'descripcion'); ?></span></p>
                </div>

                <div class="col-md-3">
                	<p>Tipo Torneo: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'tipotorneo'); ?></span></p>
                </div>
                <div class="col-md-3">
                	<p>Temporadas: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'temporada'); ?></span></p>
                </div>

                <div class="col-md-3">
                	<p>Categorias: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'categoria'); ?></span></p>
                </div>

                <div class="col-md-3">
                	<p>Divisiones: <span style="color:#00F"><?php echo mysql_result($resFixDetalle,0,'division'); ?></span></p>
                </div>

                <div class="col-md-3">
                	<p>Resp.Def. Tipo Jugadores <?php if (mysql_result($resFixDetalle,0,'respetadefiniciontipojugadores') == 'Si') { 
								?>
										<span style="color:#3C0;" class="glyphicon glyphicon-ok"></span>
								<?php
										} else {
								?>
										<span style="color:#F00;" class="glyphicon glyphicon-remove"></span>
								<?php		
										}
								?>
					
					</p>
                </div>
                <div class="col-md-3">
                	<p>Resp.Def. Habilitaciones Trans.<?php if (mysql_result($resFixDetalle,0,'respetadefinicionhabilitacionestransitorias') == 'Si') { 
								?>
										<span style="color:#3C0;" class="glyphicon glyphicon-ok"></span>
								<?php
										} else {
								?>
										<span style="color:#F00;" class="glyphicon glyphicon-remove"></span>
								<?php		
										}
								?></p>
                </div>
                <div class="col-md-3">
                	<p>Resp.Def. Sanciones Acumuladas<?php if (mysql_result($resFixDetalle,0,'respetadefinicionsancionesacumuladas') == 'Si') { 
								?>
										<span style="color:#3C0;" class="glyphicon glyphicon-ok"></span>
								<?php
										} else {
								?>
										<span style="color:#F00;" class="glyphicon glyphicon-remove"></span>
								<?php		
										}
								?></p>
                </div>
                <div class="col-md-3">
                	<p>Acumula Goleadores<?php if (mysql_result($resFixDetalle,0,'acumulagoleadores') == 'Si') { 
								?>
										<span style="color:#3C0;" class="glyphicon glyphicon-ok"></span>
								<?php
										} else {
								?>
										<span style="color:#F00;" class="glyphicon glyphicon-remove"></span>
								<?php		
										}
								?></p>
                </div>
                <div class="col-md-3">
                	<p>Acumula Tabla Conformada<?php if (mysql_result($resFixDetalle,0,'acumulatablaconformada') == 'Si') { 
								?>
										<span style="color:#3C0;" class="glyphicon glyphicon-ok"></span>
								<?php
										} else {
								?>
										<span style="color:#F00;" class="glyphicon glyphicon-remove"></span>
								<?php		
										}
								?></p>
                </div>
				<div class="col-md-3">
                	<p>Arbitro: <select data-placeholder="selecione el Arbitro..." id="refarbitros" name="refarbitros" class="chosen-select" tabindex="2" style="width:210px;">
            								<option value=""></option>
											<?php echo $cadArbitros; ?>
                                            </select></p>
                </div>
                <div class="col-md-3">
                	<p>Cancha: <select data-placeholder="selecione la cancha..." id="refcanchas" name="refcanchas" class="chosen-select" tabindex="2" style="width:210px;">
            								<option value=""></option>
											<?php echo $cadCanchas; ?>
                                            </select></p>
                </div>
                
                <div class="col-md-6 col-xs-offset-6">
                	<p style="color:#F03;">* Sino se encuentra cargado el Arbitro puede dar de alta haciendo click <a href="arbitros.php?idfixture=<?php echo $idFixture; ?>">aqui</a></p>
                </div>
                
                <div class="col-md-4">
                	<p>Juez 1: <input type="text" class="form-control" id="juez1" name="juez1" value="<?php echo mysql_result($resFixDetalle,0,'juez1'); ?>"/></p>
                </div>
                <div class="col-md-4">
                	<p>Juez 2: <input type="text" class="form-control" id="juez2" name="juez2" value="<?php echo mysql_result($resFixDetalle,0,'juez2'); ?>"/></p>
                </div>
                
                <div class="col-md-4">
                	<p>Calificación Cancha: <input type="number" class="form-control" id="calificacioncancha" name="calificacioncancha" value="<?php echo mysql_result($resFixDetalle,0,'calificacioncancha'); ?>"/></p>
                </div>
                
                <div class="col-md-6">
                	<p style="font-size:2.2em">Resultado <?php echo $equipoA; ?>: <span class="resultadoA"><?php echo (mysql_result($resFixDetalle,0,'goleslocal') == '' ? 0 : mysql_result($resFixDetalle,0,'goleslocal')); ?></span></p>
                </div>
                <div class="col-md-6">
                	<p style="font-size:2.2em">Resultado <?php echo $equipoB; ?>: <span class="resultadoB"><?php echo (mysql_result($resFixDetalle,0,'golesvisitantes') == '' ? 0 : mysql_result($resFixDetalle,0,'golesvisitantes')); ?></span></p>
                </div>
                
                
                <div class='row' style="margin-left:15px; margin-right:15px;">
                    <div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Estado Partido</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refestadospartidos" name="refestadospartidos">
                                <option value="0">-- Seleccionar --</option>
                                <?php echo $cadEstados; ?>
                            </select>    
                        </div>
                    </div>
                </div>
                	
                </div>
            
            <div class="row">

                <div style="margin-left:5px;padding-left:10px; border-left:12px solid #0C0; border-bottom:1px solid #eee;border-top:1px solid #CCC; margin-right:5px;">
                <h4 style="color: #fff; background-color:#333; padding:6px;margin-left:-10px; margin-top:0;"><span class="glyphicon glyphicon-signal"></span> Datos Partido</h4>
                
                <!--		detalles del partido			---->
                
                <!--		detalles fin			---->
                
                
                
                
                <table class="table table-striped table-bordered table-responsive" id="example">
                	<caption style="font-size:1.5em; font-style:italic;">Equipo Local: <?php echo $equipoA; ?></caption>
                    <thead>
                    	<tr>
                        	<th style="text-align:center">DRSL</th>
                        	<th>Jugador</th>
                            <th>DNI</th>
                            <th style="text-align:center">GA</th>
                            <th style="text-align:center">GC</th>
                            <th style="text-align:center">MIN</th>
                            <th style="text-align:center">PC</th>
                            <th style="text-align:center">PA</th>
                            <th style="text-align:center">PE</th>
                            <th style="text-align:center">MJ</th>
                            <th style="text-align:center; background-color:#FF0;">A <span class="badge"><?php echo $incidenciaALocal; ?></span></th>
                            <th style="text-align:center; background-color:#F00;">E <span class="badge"><?php echo $incidenciaRLocal; ?></span></th>
                            <th style="text-align:center; background-color:#09F;">I <span class="badge"><?php echo $incidenciaILocal; ?></span></th>
                            <th style="text-align:center; background-color:#0C0;">A+A <span class="badge"><?php echo $incidenciaDALocal; ?></span></th>
                            <th style="text-align:center; background-color:#333; color:#FFF;">CDTD <span class="badge"><?php echo $incidenciaCDTDLocal; ?></span></th>
                            <?php

							if ($_SESSION['idroll_predio'] == 1) {

							?>
                            <th style="text-align:center">Fallo</th>
                            <th style="text-align:center">Ver</th>
                            <?php
							}
							?>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
							$tabulador = 15;
							while ($row = mysql_fetch_array($resJugadoresA)) {
								$tabulador += 1;
								$estadisticas	= $serviciosReferencias->traerEstadisticaPorFixtureJugadorCategoriaDivision($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones);
								
								$sancionAmarilla		=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 1);
								
								$sancionRoja			=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 2);
								
								$sancionInformados		=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 3);
								
								$sancionDobleAmarilla	=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 4);
								
								$sancionCDTD			=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 5);
								
								$suspendidoDias				=	$serviciosReferencias->suspendidoPorDias($row['refjugadores'], $idTipoTorneoTorneo);
								
								$suspendidoCategorias		=	$serviciosReferencias->hayMovimientos($row['refjugadores'],$idFixture, $idTipoTorneoTorneo);
								$suspendidoCategoriasAA		=	$serviciosReferencias->hayMovimientosAmarillasAcumuladas($row['refjugadores'],$idFixture, $idCategoria, $idTipoTorneoTorneo);
								
								$falloA					=	$serviciosReferencias->traerSancionesjugadoresPorJugadorFixtureConValor($row['refjugadores'],$idFixture);
								
								$pendiente				=	$serviciosReferencias->hayPendienteDeFallo($row['refjugadores'],$idFixture, $idTipoTorneoTorneo);
								
								$yaCumpli				=	$serviciosReferencias->estaFechaYaFueCumplida($row['refjugadores'],$idFixture);
								
								/* todo para saber si esta o no inhabilitado */
								$cadCumpleEdad = '';
								$errorDoc = 'FALTA';
								$cadErrorDoc = '';
								$habilitacion= 'INHAB.';
								$transitoria= '';
								$valorDocumentacion = 0;
								$documentaciones = '';
							
					
								
								$edad = $serviciosReferencias->verificarEdad($row['refjugadores']);
								
								$cumpleEdad = $serviciosReferencias->verificaEdadCategoriaJugador($row['refjugadores'], $idCategoria, $row['idtipojugador']);
								
								$documentaciones = $serviciosReferencias->traerJugadoresdocumentacionPorJugadorValores($row['refjugadores']);
								
								if ($cumpleEdad == 1) {
									$cadCumpleEdad = "CUMPLE";	
								} else {
									// VERIFICO SI EXISTE ALGUNA HABILITACION TRANSITORIA
									$habilitacionTransitoria = $serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorDeportiva($row['refjugadores'], $idTemporada, $idCategoria, $equipoLocal);
									if (mysql_num_rows($habilitacionTransitoria)>0) {
										$cadCumpleEdad = "HAB. TRANS.";	
										$habilitacion= 'HAB.';	
									} else {
										$cadCumpleEdad = "NO CUMPLE";	
									}
								}
								
								if (mysql_num_rows($documentaciones)>0) {
									while ($rowH = mysql_fetch_array($documentaciones)) {
										if (($rowH['valor'] == 'No') && ($rowH['contravalor'] == 'No')) {
											if ($rowH['obligatoria'] == 'Si') {
												$valorDocumentacion += 1;
												if (mysql_num_rows($serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorAdministrativaDocumentacion($row['refjugadores'],$rowH['refdocumentaciones']))>0) {
													$valorDocumentacion -= 1;	
												}
											}
											if ($rowH['contravalordesc'] == '') {
												$cadErrorDoc .= strtoupper($rowH['descripcion']).' - ';
											} else {
												$cadErrorDoc .= strtoupper($rowH['contravalordesc']).' - ';
											}
										}
									}
									if ($cadErrorDoc == '') {
										$cadErrorDoc = 'OK';
										$errorDoc = 'OK';
									} else {
										$cadErrorDoc = substr($cadErrorDoc,0,-3);
									}
									
								} else {
									$cadErrorDoc = 'FALTAN PRESENTAR TODAS LAS DOCUMENTACIONES';
								}
								
								if ($valorDocumentacion <= 0 && ($cadCumpleEdad == 'CUMPLE' || $cadCumpleEdad == "HAB. TRANS.")) {
									if ($cadErrorDoc == 'FALTAN PRESENTAR TODAS LAS DOCUMENTACIONES') {
										$habilitacion= 'INHAB.';	
									} else {
										$habilitacion= 'HAB.';	
									}
								} else {
									$habilitacion= 'INHAB.';
								}
								
								/* fin todo para saber si esta o no inhabilitado */
					
						if (($habilitacion != 'HAB.')) {
							
						?>
                        <tr class="<?php echo $row[0]; ?>">
							<th style="background-color:#FC0;">
                            	
                            </th>
                        	<th style="background-color: #FC0;">
								<?php echo $row['nombrecompleto']; ?>
                            </th>
                            <th style="background-color:#FC0;">
								<?php echo $row['nrodocumento']; ?>
                            </th>
                            
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            
                            <?php

								if ($_SESSION['idroll_predio'] == 1) {
								
							?>
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            
                            <?php
								} else {
									
							?>	
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            <?php	
								} 
							
							?>
                        
                        </tr>
                        <?php	
						} else {
					
						if (($suspendidoDias == 0) && ($suspendidoCategorias == 0) && ($suspendidoCategoriasAA == 0) && ($yaCumpli == 0) && ($pendiente == 0)) {	
						
						?>
                        <tr class="<?php echo $row[0]; ?>">
							<th>
                            	<div align="center">
                                	<input type="text" tabindex="<?php echo $tabulador; ?>" class="form-control input-sm dorsalEA" name="dorsal<?php echo $row['refjugadores']; ?>" id="dorsal<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'dorsal'); ?>"/>
                                </div>
                            </th>
                        	<th>
								<?php echo $row['nombrecompleto']; ?>
                            </th>
                            <th>
								<?php echo $row['nrodocumento']; ?>
                            </th>
                            
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm golesEA" name="goles<?php echo $row['refjugadores']; ?>" id="goles<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'goles'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm golescontraEA" name="encontra<?php echo $row['refjugadores']; ?>" id="encontra<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'encontra'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm minutos" name="minutos<?php echo $row['refjugadores']; ?>" id="minutos<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php if (mysql_result($estadisticas,0,'minutosjugados')==-1) { echo $minutos; } else { echo mysql_result($estadisticas,0,'minutosjugados'); } ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesconvertidosEA" name="penalesconvertidos<?php echo $row['refjugadores']; ?>" id="penalesconvertidos<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'penalconvertido'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesatajados" name="penalesatajados<?php echo $row['refjugadores']; ?>" id="penalesatajados<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'penalatajado'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penaleserrados" name="penaleserrados<?php echo $row['refjugadores']; ?>" id="penaleserrados<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'penalerrado'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="checkbox" class="form-control input-sm mejor" id="mejorjugador<?php echo $row['refjugadores']; ?>" name="mejorjugador<?php echo $row['refjugadores']; ?>" <?php if (mysql_result($estadisticas,0,'mejorjugador')== 'Si') { echo 'checked'; } ?> style="width:30px;"/>
                                </div>
                            </th>
                            <th style="text-align:center; background-color:#FF0">
                            	<div align="center">
                                	<input type="text" class="form-control input-sm amarillas" name="amaLrillas<?php echo $row['refjugadores']; ?>" id="amaLrillas<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionAmarilla; ?>"/>
                                </div>
                            </th>
                            <th style="text-align:center; background-color:#F00">
                            	<div align="center">
                                	<input type="text" class="form-control input-sm rojas" name="roLjas<?php echo $row['refjugadores']; ?>" id="roLjas<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionRoja; ?>"/>
                                </div>
                            </th>
                            <th style="text-align:center; background-color:#09F">
                            	<div align="center">
                                	<input type="text" class="form-control input-sm informados" name="inforLmados<?php echo $row['refjugadores']; ?>" id="inforLmados<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionInformados; ?>"/>
                                </div>
                            </th>
                            <th style="text-align:center; background-color:#0C0">
                            	<div align="center">
                                	<input type="text" class="form-control input-sm dobleamarilla" name="dobleLamarilla<?php echo $row['refjugadores']; ?>" id="dobleLamarilla<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionDobleAmarilla; ?>"/>
                                </div>
                            </th>
                            <th style="text-align:center; background-color:#333; color:#FFF;">
                            	<div align="center">
                                	<input type="text" class="form-control input-sm cdtd" name="cdLtd<?php echo $row['refjugadores']; ?>" id="cdLtd<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionCDTD; ?>"/>
                                </div>
                            </th>
                            
                            <?php

							if ($_SESSION['idroll_predio'] == 1) {
								if ($falloA > 0) {
									$resFallo = $serviciosReferencias->traerSancionesJugadoresConFallosPorSancion($falloA, $idTipoTorneoTorneo);
									//die(var_dump($falloA));
									$fallo	= '';

									$amarillas		=	mysql_result($resFallo,0,'amarillas');
									$cantidadfechas	=	mysql_result($resFallo,0,'cantidadfechas');
									$fechadesde		=	mysql_result($resFallo,0,'fechadesde');
									$fechahasta		=	mysql_result($resFallo,0,'fechahasta');
									$pendiente		=	mysql_result($resFallo,0,'pendientesfallo');
									$observaciones	=	mysql_result($resFallo,0,'observaciones');
									
									if ($amarillas > 0) {
										$fallo = 'Doble Amarilla';
									} else {
										if ($fechadesde != '00/00/0000') {
											$fallo = 'Dias: desde '.$fechadesde.' hasta '.$fechahasta;
										} else {
											if ($pendiente == 'Si') {
												$fallo = 'Pendiente';
											} else {
												$fallo = 'Cantidad de Fechas:'.$cantidadfechas;	
											}
										}
									}
							?>
                            <th style="text-align:center"><?php echo $fallo; ?></th>
                            <th style="text-align:center"><a href="../sancionesfechascumplidas/index.php?id=<?php echo $falloA; ?>">Ver</a></th>
                            <?php
								} else {
									
							?>	
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            <?php	
								}
							}
						
							?>
                            
                        
                        </tr>
                        
                        <?php
							/* else del suspendidos */	
							} else {
								
						?>
                        <tr class="<?php echo $row[0]; ?>">
							<th style="background-color:#F00;">
                            	
                            </th>
                        	<th style="background-color:#F00;">
								<?php echo $row['nombrecompleto']; ?>
                            </th>
                            <th style="background-color:#F00;">
								<?php echo $row['nrodocumento']; ?>
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>

                            
                            <?php

							if ($_SESSION['idroll_predio'] == 1) {
								if ($falloA > 0) {
									$resFallo = $serviciosReferencias->traerSancionesJugadoresConFallosPorSancion($falloA, $idTipoTorneoTorneo);
									
									$fallo	= '';

									$amarillas		=	mysql_result($resFallo,0,'amarillas');
									$cantidadfechas	=	mysql_result($resFallo,0,'cantidadfechas');
									$fechadesde		=	mysql_result($resFallo,0,'fechadesde');
									$fechahasta		=	mysql_result($resFallo,0,'fechahasta');
									$pendiente		=	mysql_result($resFallo,0,'pendientesfallo');
									$observaciones	=	mysql_result($resFallo,0,'observaciones');
									
									if ($amarillas > 0) {
										$fallo = 'Doble Amarilla';
									} else {
										if ($fechadesde != '00/00/0000') {
											$fallo = 'Dias: desde '.$fechadesde.' hasta '.$fechahasta;
										} else {
											if ($pendiente == 'Si') {
												$fallo = 'Pendiente';
											} else {
												$fallo = 'Cantidad de Fechas:'.$cantidadfechas;	
											}
										}
									}
							?>
                            <th style="text-align:center"><?php echo $fallo; ?></th>
                            <th style="text-align:center"><a href="../sancionesfechascumplidas/index.php?id=<?php echo $falloA; ?>">Ver</a></th>
                            <input type="hidden" id="sancionJugadores<?php echo $row['refjugadores']; ?>" name="sancionJugadores<?php echo $row['refjugadores']; ?>" value="1"/>
                            <?php
								} else {
									
							?>	
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            <?php	
								}
							} 
							
							?>
                        
                        
                        </tr>
                        

                        
                        
                        <?php } ?>
                        <?php
								}
								$goles = 0;
							}
						?>
                    </tbody>
                </table>
                
                <!-- parte para los cambios -->
                <p>Cambios equipo Local</p>
                <?php
					$iC = 1;
					while ($rowCambio = mysql_fetch_array($resCambioLocal)) {
				?>
                <div class="row" style="margin-left:25px;">
                	
                    
                    <div class="col-md-3">
						<p>Entra: <input class="form-control localentra" type="text" name="entracambioLocal<?php echo $iC; ?>" id="entracambioLocal<?php echo $iC; ?>" value="<?php echo $rowCambio['refdorsalentra']; ?>"/></p>
                    </div>
                    <div class="col-md-3">
                    	<p>Sale: <input class="form-control localsale" type="text" name="salecambioLocal<?php echo $iC; ?>" id="salecambioLocal<?php echo $iC; ?>" value="<?php echo $rowCambio['refdorsalsale']; ?>"/></p>
                    </div>
                    <div class="col-md-3">
						<p>Minuto: <input class="form-control localminu" type="text" name="minutocambioLocal<?php echo $iC; ?>" id="minutocambioLocal<?php echo $iC; ?>" value="<?php echo $rowCambio['minuto']; ?>"/></p>
                    </div>
                    
                </div>
                <?php
					$iC += 1;
					}
                ?>
                
                <?php
					for ($k = $iC;$k<= 7;$k++) {
				?>
                <div class="row" style="margin-left:25px;">
                    
                    <div class="col-md-3">
						<p>Entra: <input class="form-control localentra" type="text" name="entracambioLocal<?php echo $k; ?>" id="entracambioLocal<?php echo $k; ?>" value=""/></p>
                    </div>
                    <div class="col-md-3">
                    	<p>Sale: <input class="form-control localsale" type="text" name="salecambioLocal<?php echo $k; ?>" id="salecambioLocal<?php echo $k; ?>" value=""/></p>
                    </div>
                    <div class="col-md-3">
						<p>Minuto: <input class="form-control localminu" type="text" name="minutocambioLocal<?php echo $k; ?>" id="minutocambioLocal<?php echo $k; ?>" value=""/></p>
                    </div>
                    
                </div>
                <?php
					}
                ?>
                
                
                <!-- fin -->
                </div>
  
                
                
                <hr>
                
                <div style="margin-left:5px;padding-left:10px;border-left:12px solid #C00; border-bottom:1px solid #eee; border-top:1px solid #CCC;margin-right:5px;">
                <h4 style="color: #fff; background-color:#333; padding:6px;margin-left:-10px; margin-top:0;"><span class="glyphicon glyphicon-signal"></span> Datos Partido</h4>
                <table class="table table-striped table-bordered table-responsive" id="example2">
                	<caption style="font-size:1.5em; font-style:italic;">Equipo Visitante: <?php echo $equipoB; ?></caption>
                    <thead>
                    	<tr>
							<th style="text-align:center">DRSL</th>
                        	<th>Jugador</th>
                            <th>DNI</th>
                            <th style="text-align:center">GA</th>
                            <th style="text-align:center">GC</th>
                            <th style="text-align:center">MIN</th>
                            <th style="text-align:center">PC</th>
                            <th style="text-align:center">PA</th>
                            <th style="text-align:center">PE</th>
                            <th style="text-align:center">MJ</th>
                            <th style="text-align:center; background-color:#FF0;">A <span class="badge"><?php echo $incidenciaAVisit; ?></span></th>
                            <th style="text-align:center; background-color:#F00;">E <span class="badge"><?php echo $incidenciaRVisit; ?></span></th>
                            <th style="text-align:center; background-color:#09F;">I <span class="badge"><?php echo $incidenciaIVisit; ?></span></th>
                            <th style="text-align:center; background-color:#0C0;">A+A <span class="badge"><?php echo $incidenciaDAVisit; ?></span></th>
                            <th style="text-align:center; background-color:#333; color:#FFF;">CDTD <span class="badge"><?php echo $incidenciaCDTDVisit; ?></span></th>
                            
                            <?php

							if ($_SESSION['idroll_predio'] == 1) {

							?>
                            <th style="text-align:center">Fallo</th>
                            <th style="text-align:center">Ver</th>
                            <?php
							}
							?>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
							
							while ($rowB = mysql_fetch_array($resJugadoresB)) {
								$tabulador += 1;
								$estadisticasB = $serviciosReferencias->traerEstadisticaPorFixtureJugadorCategoriaDivisionVisitante($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones);
								
								$sancionAmarilla		=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 1);
								
								$sancionRoja			=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 2);
								
								$sancionInformados		=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 3);
								
								$sancionDobleAmarilla	=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 4);
								
								$sancionCDTD			=	$serviciosReferencias->traerSancionesjugadoresPorJugadorConValor($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones, 5);
								
								$suspendidoDiasB			=	$serviciosReferencias->suspendidoPorDias($rowB['refjugadores'], $idTipoTorneoTorneo);
								
								$suspendidoCategoriasB		=	$serviciosReferencias->hayMovimientos($rowB['refjugadores'],$idFixture, $idTipoTorneoTorneo);
								$suspendidoCategoriasAAB	=	$serviciosReferencias->hayMovimientosAmarillasAcumuladas($rowB['refjugadores'],$idFixture, $idCategoria, $idTipoTorneoTorneo);
								
								//die(var_dump($suspendidoCategoriasAAB));
								$falloB					=	$serviciosReferencias->traerSancionesjugadoresPorJugadorFixtureConValor($rowB['refjugadores'],$idFixture);
								
								$pendienteB				=	$serviciosReferencias->hayPendienteDeFallo($rowB['refjugadores'],$idFixture, $idTipoTorneoTorneo);
								
								$yaCumpliB				=	$serviciosReferencias->estaFechaYaFueCumplida($rowB['refjugadores'],$idFixture);
								
								/* todo para saber si esta o no inhabilitado */
								$cadCumpleEdad = '';
								$errorDoc = 'FALTA';
								$cadErrorDoc = '';
								$habilitacion= 'INHAB.';
								$transitoria= '';
								$valorDocumentacion = 0;
								$documentaciones = '';
							
					
								
								$edad = $serviciosReferencias->verificarEdad($rowB['refjugadores']);
								
								$cumpleEdad = $serviciosReferencias->verificaEdadCategoriaJugador($rowB['refjugadores'], $idCategoria, $rowB['idtipojugador']);
								
								$documentaciones = $serviciosReferencias->traerJugadoresdocumentacionPorJugadorValores($rowB['refjugadores']);
								
								if ($cumpleEdad == 1) {
									$cadCumpleEdad = "CUMPLE";	
								} else {
									// VERIFICO SI EXISTE ALGUNA HABILITACION TRANSITORIA
									$habilitacionTransitoria = $serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorDeportiva($rowB['refjugadores'], $idTemporada, $idCategoria, $equipoVisitante);
									if (mysql_num_rows($habilitacionTransitoria)>0) {
										$cadCumpleEdad = "HAB. TRANS.";	
										$habilitacion= 'HAB.';	
									} else {
										$cadCumpleEdad = "NO CUMPLE";	
									}
								}
								
								if (mysql_num_rows($documentaciones)>0) {
									while ($rowH = mysql_fetch_array($documentaciones)) {
										if (($rowH['valor'] == 'No') && ($rowH['contravalor'] == 'No')) {
											if ($rowH['obligatoria'] == 'Si') {
												$valorDocumentacion += 1;
												if (mysql_num_rows($serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorAdministrativaDocumentacion($rowB['refjugadores'],$rowH['refdocumentaciones']))>0) {
													$valorDocumentacion -= 1;	
												}
											}
											if ($rowH['contravalordesc'] == '') {
												$cadErrorDoc .= strtoupper($rowH['descripcion']).' - ';
											} else {
												$cadErrorDoc .= strtoupper($rowH['contravalordesc']).' - ';
											}
										}
									}
									if ($cadErrorDoc == '') {
										$cadErrorDoc = 'OK';
										$errorDoc = 'OK';
									} else {
										$cadErrorDoc = substr($cadErrorDoc,0,-3);
									}
									
								} else {
									$cadErrorDoc = 'FALTAN PRESENTAR TODAS LAS DOCUMENTACIONES';
								}
								
								if ($valorDocumentacion <= 0 && ($cadCumpleEdad == 'CUMPLE' || $cadCumpleEdad == "HAB. TRANS.")) {
									if ($cadErrorDoc == 'FALTAN PRESENTAR TODAS LAS DOCUMENTACIONES') {
										$habilitacion= 'INHAB.';	
									} else {
										$habilitacion= 'HAB.';	
									}
								} else {
									$habilitacion= 'INHAB.';
								}
								
								/* fin todo para saber si esta o no inhabilitado */
								
						if (($habilitacion != 'HAB.')) {		
						?>
						<tr class="<?php echo $row[0]; ?>">
							<th style="background-color:#FC0;">
                            	
                            </th>
                            
                        	<th style="background-color:#FC0;">
								<?php echo $rowB['nombrecompleto']; ?>
                            </th>
                            <th style="background-color:#FC0;">
								<?php echo $rowB['nrodocumento']; ?>
                            </th>
                            
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            <th style="background-color:#FC0;">
                            	
                            </th>
                            
                            <?php

								if ($_SESSION['idroll_predio'] == 1) {
								
							?>
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            
                            <?php
								} else {
									
							?>	
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            <?php	
								} 
							
							?>
                         </tr>
                        <?php } else { 

						if (($suspendidoDiasB == 0) && ($suspendidoCategoriasB == 0) && ($suspendidoCategoriasAAB == 0) && ($yaCumpliB == 0) && ($pendienteB == 0)) {		
						?>
                        <tr class="<?php echo $rowB[0]; ?>">
							<th>
                            	<div align="center">
                                	<input type="text" tabindex="<?php echo $tabulador; ?>" class="form-control input-sm dorsalEB" name="dorbsal<?php echo $rowB['refjugadores']; ?>" id="dorbsal<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'dorsal'); ?>"/>
                                </div>
                            </th>
                            
                        	<th>
								<?php echo $rowB['nombrecompleto']; ?>
                            </th>
                            <th>
								<?php echo $rowB['nrodocumento']; ?>
                            </th>
                            
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm golesEB" name="gobles<?php echo $rowB['refjugadores']; ?>" id="gobles<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'goles'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm golescontraEB" name="enbcontra<?php echo $rowB['refjugadores']; ?>" id="enbcontra<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'encontra'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm minutosEB" name="minbutos<?php echo $rowB['refjugadores']; ?>" id="minbutos<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php if (mysql_result($estadisticasB,0,'minutosjugados')==-1) { echo $minutos; } else { echo mysql_result($estadisticasB,0,'minutosjugados'); } ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesconvertidosEB" name="penalesbconvertidos<?php echo $rowB['refjugadores']; ?>" id="penalesbconvertidos<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'penalconvertido'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesatajados" name="penalesbatajados<?php echo $rowB['refjugadores']; ?>" id="penalesbatajados<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'penalatajado'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penaleserrados" name="penalesberrados<?php echo $rowB['refjugadores']; ?>" id="penalesberrados<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'penalerrado'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="checkbox" class="form-control input-sm mejor" id="mejorbjugador<?php echo $rowB['refjugadores']; ?>" name="mejorbjugador<?php echo $rowB['refjugadores']; ?>" <?php if (mysql_result($estadisticasB,0,'mejorjugador')== 'Si') { echo 'checked'; } ?> style="width:30px;"/>
                                </div>
                            </th>
                            <th style="text-align:center; background-color:#FF0">
                            	<div align="center">
                                	<input type="text" class="form-control input-sm amarillas" name="amaVrillas<?php echo $rowB['refjugadores']; ?>" id="amaVrillas<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionAmarilla; ?>"/>
                                </div>
                            </th>
                            <th style="text-align:center; background-color:#F00">
                            	<div align="center">
                                	<input type="text" class="form-control input-sm rojas" name="roVjas<?php echo $rowB['refjugadores']; ?>" id="roVjas<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionRoja; ?>"/>
                                </div>
                            </th>
                            <th style="text-align:center; background-color:#09F">
                            	<div align="center">
                                	<input type="text" class="form-control input-sm informados" name="inforVmados<?php echo $rowB['refjugadores']; ?>" id="inforVmados<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionInformados; ?>"/>
                                </div>
                            </th>
                            <th style="text-align:center; background-color:#0C0">
                            	<div align="center">
                                	<input type="text" class="form-control input-sm dobleamarilla" name="dobleVamarilla<?php echo $rowB['refjugadores']; ?>" id="dobleVamarilla<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionDobleAmarilla; ?>"/>
                                </div>
                            </th>
                            <th style="text-align:center; background-color:#333; color:#FFF;">
                            	<div align="center">
                                	<input type="text" class="form-control input-sm cdtd" name="cdVtd<?php echo $rowB['refjugadores']; ?>" id="cdVtd<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo $sancionCDTD; ?>"/>
                                </div>
                            </th>
                            
                            
                            <?php

							if ($_SESSION['idroll_predio'] == 1) {
								if ($falloB > 0) {
									$resFallo = $serviciosReferencias->traerSancionesJugadoresConFallosPorSancion($falloB, $idTipoTorneoTorneo);
									
									$fallo	= '';

									$amarillas		=	mysql_result($resFallo,0,'amarillas');
									$cantidadfechas	=	mysql_result($resFallo,0,'cantidadfechas');
									$fechadesde		=	mysql_result($resFallo,0,'fechadesde');
									$fechahasta		=	mysql_result($resFallo,0,'fechahasta');
									$pendiente		=	mysql_result($resFallo,0,'pendientesfallo');
									$observaciones	=	mysql_result($resFallo,0,'observaciones');
									
									if ($amarillas > 0) {
										$fallo = 'Doble Amarilla';
									} else {
										if ($fechadesde != '00/00/0000') {
											$fallo = 'Dias: desde '.$fechadesde.' hasta '.$fechahasta;
										} else {
											if ($pendiente == 'Si') {
												$fallo = 'Pendiente';
											} else {
												$fallo = 'Cantidad de Fechas:'.$cantidadfechas;	
											}
										}
									}
							?>
                            <th style="text-align:center"><?php echo $fallo; ?></th>
                            <th style="text-align:center"><a href="../sancionesfechascumplidas/index.php?id=<?php echo $falloB; ?>">Ver</a></th>
                            <input type="hidden" id="sancionBJugadores<?php echo $rowB['refjugadores']; ?>" name="sancionBJugadores<?php echo $rowB['refjugadores']; ?>" value="1"/>
                            <?php
								} else {
									
							?>	
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            <?php	
								}
							}
							?>
                            
                        </tr>
                        
                        <?php
							/* else del suspendidos */	
							} else {
								
						?>
                        <tr class="<?php echo $rowB[0]; ?>">
							<th style="background-color:#F00;">
                            	
                            </th>
                            
                        	<th style="background-color:#F00;">
								<?php echo $rowB['nombrecompleto']; ?>
                            </th>
                            <th style="background-color:#F00;">
								<?php echo $rowB['nrodocumento']; ?>
                            </th>
                            
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <th style="background-color:#F00;">
                            	
                            </th>
                            <?php

							if ($_SESSION['idroll_predio'] == 1) {
								if ($falloB > 0) {
									$resFallo = $serviciosReferencias->traerSancionesJugadoresConFallosPorSancion($falloB, $idTipoTorneoTorneo);
									
									$fallo	= '';

									$amarillas		=	mysql_result($resFallo,0,'amarillas');
									$cantidadfechas	=	mysql_result($resFallo,0,'cantidadfechas');
									$fechadesde		=	mysql_result($resFallo,0,'fechadesde');
									$fechahasta		=	mysql_result($resFallo,0,'fechahasta');
									$pendiente		=	mysql_result($resFallo,0,'pendientesfallo');
									$observaciones	=	mysql_result($resFallo,0,'observaciones');
									
									if ($amarillas > 0) {
										$fallo = 'Doble Amarilla';
									} else {
										if ($fechadesde != '00/00/0000') {
											$fallo = 'Dias: desde '.$fechadesde.' hasta '.$fechahasta;
										} else {
											if ($pendiente == 'Si') {
												$fallo = 'Pendiente';
											} else {
												$fallo = 'Cantidad de Fechas:'.$cantidadfechas;	
											}
										}
									}
							?>
                            <th style="text-align:center"><?php echo $fallo; ?></th>
                            <th style="text-align:center"><a href="../sancionesfechascumplidas/index.php?id=<?php echo $falloB; ?>">Ver</a></th>
                            <?php
								} else {
									
							?>	
                            <th style="text-align:center"></th>
                            <th style="text-align:center"></th>
                            <?php	
								}
							} 
							
							?>
                        
                        
                        </tr>
                        

                        
                        
                        <?php } ?>
                        <?php
								}
								$goles = 0;
							}
						?>
                    </tbody>
                </table>
                
                <!-- parte para los cambios -->
                <p>Cambios equipo Visitante</p>
                
                <?php
					$iC = 1;
					while ($rowCambioV = mysql_fetch_array($resCambioVisitante)) {
				?>
                <div class="row" style="margin-left:25px;">
                	
                    
                    <div class="col-md-3">
						<p>Entra: <input class="form-control visitentra" type="text" name="entracambioVisitante<?php echo $iC; ?>" id="entracambioVisitante<?php echo $iC; ?>" value="<?php echo $rowCambioV['refdorsalentra']; ?>"/></p>
                    </div>
                    <div class="col-md-3">
                    	<p>Sale: <input class="form-control visitsale" type="text" name="salecambioVisitante<?php echo $iC; ?>" id="salecambioVisitante<?php echo $iC; ?>" value="<?php echo $rowCambioV['refdorsalsale']; ?>"/></p>
                    </div>
                    <div class="col-md-3">
						<p>Minuto: <input class="form-control visitminu" type="text" name="minutocambioVisitante<?php echo $iC; ?>" id="minutocambioVisitante<?php echo $iC; ?>" value="<?php echo $rowCambioV['minuto']; ?>"/></p>
                    </div>
                    
                </div>
                <?php
					$iC += 1;
					}
                ?>
                
                <?php
					$iC = 1;
					for ($k = $iC;$k<= 7;$k++) {
				?>
                <div class="row" style="margin-left:25px;">
                    
                    <div class="col-md-3">
						<p>Entra: <input class="form-control visitentra" type="text" name="entracambioVisitante<?php echo $k; ?>" id="entracambioVisitante<?php echo $k; ?>" value=""/></p>
                    </div>
                    <div class="col-md-3">
                    	<p>Sale: <input class="form-control visitsale" type="text" name="salecambioVisitante<?php echo $k; ?>" id="salecambioVisitante<?php echo $k; ?>" value=""/></p>
                    </div>
                    <div class="col-md-3">
						<p>Minuto: <input class="form-control visitminu" type="text" name="minutocambioVisitante<?php echo $k; ?>" id="minutocambioVisitante<?php echo $k; ?>" value=""/></p>
                    </div>
                    
                </div>
                <?php
					}
                ?>
                
                <!-- fin -->
				</div>
                
                
            
            
            
            
            
            <div class='row' style="margin-left:15px; margin-right:15px;">
                <div class='alert'>
                
                </div>
                <div class='alert alert2'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
			
            
            <div class="row" style="margin-left:15px; margin-right:15px;">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">

                    <li>
                        <button type="button" class="btn btn-primary" id="cargamasiva">Guardar Masivo</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-success" id="calcularMinutos">Calcular Minutos</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            <input type="hidden" id="accion" name="accion" value="insertarEstadisticaMasiva" />
            <input type="hidden" id="idfixture" name="idfixture" value="<?php echo $idFixture; ?>" />
            </form>
    	</div>
    </div>

   
</div>


</div>



<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>
<script src="../../js/fnFilterClear.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	$('#colapsarMenu').click();
	var minutosPartido = <?php echo $minutos; ?>;
	/*var table = $('#example dataTables_filter input');*/
	
	var table = $('#example').dataTable({
		"lengthMenu": [[30, 60 -1], [30, 60, "All"]],
		"order": [[ 1, "asc" ]],
		"language": {
			"emptyTable":     "No hay datos cargados",
			"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
			"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
			"infoFiltered":   "(filtrados del total de _MAX_ filas)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Mostrar _MENU_ filas",
			"loadingRecords": "Cargando...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"zeroRecords":    "No se encontraron resultados",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activate to sort column ascending",
				"sortDescending": ": activate to sort column descending"
			}
		  }
	} );
	
	
	var table2 = $('#example2').dataTable({
		"lengthMenu": [[30, 60 -1], [30, 60, "All"]],
		"order": [[ 1, "asc" ]],
		"language": {
			"emptyTable":     "No hay datos cargados",
			"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
			"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
			"infoFiltered":   "(filtrados del total de _MAX_ filas)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Mostrar _MENU_ filas",
			"loadingRecords": "Cargando...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"zeroRecords":    "No se encontraron resultados",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activate to sort column ascending",
				"sortDescending": ": activate to sort column descending"
			}
		  }
	} );
	
	$('.volver').click(function(e) {
        url = "index.php";
		$(location).attr('href',url);
    });
	
	function existeCambioSaleLocal(dorsal, lblEach, lblBuscar, lblValor) {
		nuevoSale = 0;
		$('.'+lblEach).each(function(intIndex){
			idCambio = $(this).attr("id");
			idCambio = idCambio.replace(lblBuscar, "");
			if ($(this).val()==dorsal) {
				nuevoSale = $('#'+lblValor+idCambio).val();
				return false;
			}
		});
		return nuevoSale;
	}
	
	function existeCambioEntraLocal(dorsal, minutosPartido, lblEach, lblBuscar, lblValor) {
		nuevoEntra = 0;
		$('.'+lblEach).each(function(intIndex){
			idCambio = $(this).attr("id");
			idCambio = idCambio.replace(lblBuscar, "");
			if ($(this).val()==dorsal) {
				nuevoEntra = minutosPartido - $('#'+lblValor+idCambio).val();
				return false;
			}
		});
		return nuevoEntra;
	}
	
	
	
	function calcularMinutos() {
		
		
		// para restarle los minutos jugados al que sale y entra
		/* localsale - salecambioLocal - minutocambioLocal */
		$('.dorsalEA').each(function(intIndex){
			idJugador = $(this).attr("id");
			idJugador = idJugador.replace("dorsal", "");
			if ($(this).val()==0) {
				$('#minutos'+idJugador).val(0);	
			} else {
				
				if (existeCambioSaleLocal($(this).val(),'localsale','salecambioLocal','minutocambioLocal')>0) {
					$('#minutos'+idJugador).val(existeCambioSaleLocal($(this).val(),'localsale','salecambioLocal','minutocambioLocal'));
				}
				
				if (existeCambioEntraLocal($(this).val(),minutosPartido,'localentra','entracambioLocal','minutocambioLocal')>0) {
					$('#minutos'+idJugador).val(existeCambioEntraLocal($(this).val(),minutosPartido,'localentra','entracambioLocal','minutocambioLocal'));
				}
				
			}
		});
		
		
		// para restarle los minutos jugados al que sale
		/* visitsale - salecambioVisitante - minutocambioVisitante */
		$('.dorsalEB').each(function(intIndex){
			idJugador = $(this).attr("id");
			idJugador = idJugador.replace("dorbsal", "");
			if ($(this).val()==0) {
				$('#minbutos'+idJugador).val(0);	
			} else {
				
				if (existeCambioSaleLocal($(this).val(),'visitsale','salecambioVisitante','minutocambioVisitante')>0) {
					$('#minbutos'+idJugador).val(existeCambioSaleLocal($(this).val(),'visitsale','salecambioVisitante','minutocambioVisitante'));
				}
				
				if (existeCambioEntraLocal($(this).val(),minutosPartido,'visitentra','entracambioVisitante','minutocambioVisitante')>0) {
					$('#minbutos'+idJugador).val(existeCambioEntraLocal($(this).val(),minutosPartido,'visitentra','entracambioVisitante','minutocambioVisitante'));
				}
				
			}
		});
	}
	
	$('#calcularMinutos').click(function(e) {
        calcularMinutos();
    });
	
	
	$('#cargamasiva').click(function(e) {
		table.fnFilter('Win');
      	table.fnFilter('Trident', 0);
 
      	// Remove all filtering
      	table.fnFilterClear(); 
		
		table2.fnFilter('Win');
      	table2.fnFilter('Trident', 0);
 
      	// Remove all filtering
      	table2.fnFilterClear();  
		
		calcularMinutos();
		
		if (($('#refestadospartidos').val() == '') || ($('#refestadospartidos').val() == '0')) {
			alert('Atencion, debe seleccionar un estado para el partido');
		} else {
			$( "#target" ).submit();
		}
       
    });
	
	$(document).on('change','#example_filter input', function(e){

		var acumulado = 0;
		$('.golesEA').each(function(intIndex){
			acumulado += parseInt($(this).val());	
		});
		$('.golescontraEB').each(function(intIndex){
			acumulado += parseInt($(this).val());	
		});
		$('.penalesconvertidosEA').each(function(intIndex){
			acumulado += parseInt($(this).val());	
		});
		
		$('.resultadoA').html(acumulado);

	});
	
	
	$(document).on('change','#example2_filter input', function(e){

		
		var acumuladoB = 0;
		$('.golesEB').each(function(intIndex){
			acumuladoB += parseInt($(this).val());	
		});
		$('.golescontraEA').each(function(intIndex){
			acumuladoB += parseInt($(this).val());	
		});
		$('.penalesconvertidosEB').each(function(intIndex){
			acumuladoB += parseInt($(this).val());	
		});
		$('.resultadoB').html(acumuladoB);
	});

	
	//al enviar el formulario
    $('#cargar').click(function(){

			//informaciï¿½n del formulario
		var formData = new FormData($(".formulario")[0]);
		var message = "";
		//hacemos la peticiï¿½n ajax  
		$.ajax({
			url: '../../ajax/ajax.php',  
			type: 'POST',
			// Form data
			//datos del formulario
			data: formData,
			//necesario para subir archivos via ajax
			cache: false,
			contentType: false,
			processData: false,
			//mientras enviamos el archivo
			beforeSend: function(){
				$("#load").html('<img src="../../imagenes/load13.gif" width="50" height="50" />');       
			},
			//una vez finalizado correctamente
			success: function(data){

				if (data == '') {
					$(".alert").removeClass("alert-danger");
					$(".alert").removeClass("alert-info");
					$(".alert").addClass("alert-success");
					$(".alert").html('<strong>Ok!</strong> Se cargo exitosamente las <strong>Estadisticas</strong>. ');
					$(".alert").delay(3000).queue(function(){
						/*aca lo que quiero hacer 
						  despuï¿½s de los 2 segundos de retraso*/
						$(this).dequeue(); //continï¿½o con el siguiente ï¿½tem en la cola
						
					});
					$("#load").html('');
					url = "estadisticas.php?id="+<?php echo $idFixture; ?>;
					$(location).attr('href',url);
					
					
				} else {
					$(".alert").removeClass("alert-danger");
					$(".alert").addClass("alert-danger");
					$(".alert").html('<strong>Error!</strong> '+data);
					$("#load").html('');
				}
			},
			//si ha ocurrido un error
			error: function(){
				$(".alert").html('<strong>Error!</strong> Actualice la pagina');
				$("#load").html('');
			}
		});
		
    });

});
</script>
<script src="../../js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	
	
  </script>
  
<?php } else { ?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Gesti&oacute;n: AIF</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../js/jquery.number.min.js"></script>
    
	<style type="text/css">
		
  
		
	</style>
    
   <link rel="stylesheet" href="../../css/chosen.css">
   <link href="../../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../../js/jquery.mousewheel.js"></script>
      <script src="../../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
		
		
      });
    </script>
    
    <script type="text/javascript">
			
			$(function(){
				// Set up the number formatting.
				/*
				$('#goles3').number( true, 2 );
				$('#goles3').number( true, 2 );*/
				$('.golesEB').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.golescontraEB').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.golesEA').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.golescontraEA').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.amarillas').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.rojas').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.informados').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.dobleamarilla').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.cdtd').each(function(intIndex){
					$(this).number( true, 0 );
				});
				

				
				
				$('.golesEA').change(function(e) {
					var acumulado = 0;
					$('.golesEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					
					$('.resultadoA').html(acumulado);
				});
				
				
				$('.golescontraEB').change(function(e) {
					var acumulado = 0;
					$('.golesEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoA').html(acumulado);
				});
				
				
				$('.penalesconvertidosEA').change(function(e) {
					var acumulado = 0;
					$('.golesEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					
					$('.resultadoA').html(acumulado);
				});
				
				
				
				
				
				$('.golesEB').change(function(e) {
					var acumulado = 0;
					$('.golesEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoB').html(acumulado);
				});
				
				
				$('.golescontraEA').change(function(e) {
					var acumulado = 0;
					$('.golesEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoB').html(acumulado);
				});
				
				$('.penalesconvertidosEB').change(function(e) {
					var acumulado = 0;
					$('.golesEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.golescontraEA').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.penalesconvertidosEB').each(function(intIndex){
						acumulado += parseInt($(this).val());	
					});
					$('.resultadoB').html(acumulado);
				});
				
				$('.minutos').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > <?php echo $minutos; ?>) {
							$(this).val(<?php echo $minutos; ?>);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.minutosEB').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > <?php echo $minutos; ?>) {
							$(this).val(<?php echo $minutos; ?>);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.amarillas').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 2) {
							$(this).val(2);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.rojas').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.informados').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.dobleamarilla').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.cdtd').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > 1) {
							$(this).val(1);
						}
						if ($(this).val() < 0) {
							$(this).val(0);
						}
					});
				});
				
				$('.penalesconvertidos').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.penalesatajados').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.penaleserrados').each(function(intIndex){
					$(this).number( true, 0 );
				});

			});
		</script>
    

</head>

<body>

 
<?php echo $resMenu; ?>

<div id="content">

    <div class="boxInfoLargoEstadisticas">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Cargar Estadisticas - <?php echo mysql_result($resFecha,0,1); ?></p>
        	
        </div>
    	<div class="cuerpoBox" style="padding-right:10px;">

            <div class="row" style="margin-left:15px; margin-right:15px;">
                <div class="col-md-12">
                <h4>Esta fecha no puede ser cargada, a falta de un equipo</h4>
                <ul class="list-inline" style="margin-top:15px;">


                    <li>
                        <a href="index.php"><button type="button" class="btn btn-default volver">Volver</button></a>
                    </li>
                </ul>
                </div>
            </div>
            <input type="hidden" id="accion" name="accion" value="insertarEstadisticaMasiva" />
            <input type="hidden" id="idfixture" name="idfixture" value="<?php echo $idFixture; ?>" />
            </form>
    	</div>
    </div>

   
</div>


</div>

<?php } ?>  
  
<?php } ?>
</body>
</html>
