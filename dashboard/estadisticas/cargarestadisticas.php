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

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Fixture",$_SESSION['refroll_predio'],'');

$idFixture = $_POST['idfixture'];

$resFix = $serviciosReferencias->TraerFixturePorId($idFixture);

$equipoLocal		=	mysql_result($resFix,0,'refconectorlocal');
$equipoVisitante	=	mysql_result($resFix,0,'refconectorvisitante');

$refFecha = mysql_result($resFix,0,'reffechas');
$refJugo = mysql_result($resFix,0,'fecha');
$resultadoA = mysql_result($resFix,0,'puntoslocal');
$resultadoB = mysql_result($resFix,0,'puntosvisita');

$equipoA = mysql_result($serviciosReferencias->traerEquiposPorId($equipoLocal),0,'nombre');
$equipoB = mysql_result($serviciosReferencias->traerEquiposPorId($equipoVisitante),0,'nombre');

$resTorneo	=	$serviciosReferencias->traerTorneosPorId(mysql_result($resFix,0,'reftorneos'));

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

$minutos				=	mysql_result($resDefCategTemp,0,'minutospartido');
/////////////			fin				/////////////////////////////


$numero = count($_POST);
	$tags = array_keys($_POST);// obtiene los nombres de las varibles
	$valores = array_values($_POST);// obtiene los valores de las varibles
	$cantEncontrados = 0;
	$cantidad = 1;
	$idEquipos = 0;
	
	$cadWhere = '';
	$cantEquipos = array();
	
	for($i=0;$i<$numero;$i++){
		
		
		/////////////////////			EQUIPO LOCAL				////////////////////////////////////////////////
		if (strpos($tags[$i],"goles") !== false) {

			$idJugador = str_replace("goles","",$tags[$i]);

			//////////////		logica GOLEADORES		///////////////////////////////////////////////////////
			$existeGoleadores = $serviciosReferencias->existeFixturePorGoleadores($idJugador, $idFixture);
			
			if ($existeGoleadores == 0) {
				//inserto
				$serviciosReferencias->insertarGoleadores($idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones,$valores[$i], $_POST['encontra'.$idJugador]);
			} else {
				//modifico	
				
				$serviciosReferencias->modificarGoleadores($existeGoleadores, $idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones,$valores[$i], $_POST['encontra'.$idJugador]);
			}
			//////////////			fin logica			/////////////////////////////////////////////////////////
			
			//////////////		logica MINUTOS		///////////////////////////////////////////////////////
			$existeMinutos = $serviciosReferencias->existeFixturePorMinutosJugados($idJugador, $idFixture);
			
			if ($existeMinutos == 0) {
				//inserto
				$serviciosReferencias->insertarMinutosjugados($idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones, $_POST['minutos'.$idJugador]);
			} else {
				//modifico	
				
				$serviciosReferencias->modificarMinutosjugados($existeMinutos, $idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones,$_POST['minutos'.$idJugador]);
			}
			//////////////			fin logica			/////////////////////////////////////////////////////////

		
		}
		
		if (strpos($tags[$i],"mejorjugador") !== false) {
			if (isset($valores[$i])) {
				//////////////		logica mejor jugador		///////////////////////////////////////////////////////
				$existeMejorJugador = $serviciosReferencias->existeFixturePorMejorJugador($idJugador, $idFixture);
				
				if ($existeGoleadores == 0) {
					//borro los anteriores y cargos el nuevo
					$serviciosReferencias->eliminarMejorjugadorMasivo($idFixture);
					//inserto
					$serviciosReferencias->insertarMejorjugador($idJugador, $idFixture, $equipoLocal, $idCategoria, $idDivisiones);
				}
				//////////////			fin logica			/////////////////////////////////////////////////////////	
			}
		}
		
		////********************		FIN EQUIPO LOCAL		*************************************************//////
		
		
		
		/////////////////////			EQUIPO VISITANTE				////////////////////////////////////////////////
		if (strpos($tags[$i],"gobles") !== false) {
			
			if (isset($valores[$i])) {
				
				$idJugador = str_replace("gobles","",$tags[$i]);

				//////////////		logica GOLEADORES		///////////////////////////////////////////////////////
				$existeGoleadores = $serviciosReferencias->existeFixturePorGoleadores($idJugador, $idFixture);
				
				if ($existeGoleadores == 0) {
					//inserto
					$serviciosReferencias->insertarGoleadores($idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones,$valores[$i], $_POST['enbcontra'.$idJugador]);
				} else {
					//modifico	
					
					$serviciosReferencias->modificarGoleadores($existeGoleadores, $idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones,$valores[$i], $_POST['enbcontra'.$idJugador]);
				}
				//////////////			fin logica			/////////////////////////////////////////////////////////
				
				//////////////		logica MINUTOS		///////////////////////////////////////////////////////
				$existeMinutos = $serviciosReferencias->existeFixturePorMinutosJugados($idJugador, $idFixture);
				
				if ($existeMinutos == 0) {
					//inserto
					$serviciosReferencias->insertarMinutosjugados($idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones, $_POST['minbutos'.$idJugador]);
				} else {
					//modifico	
					
					$serviciosReferencias->modificarMinutosjugados($existeMinutos, $idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones,$_POST['minbutos'.$idJugador]);
				}
				//////////////			fin logica			/////////////////////////////////////////////////////////

			}
		}
		
		if (strpos($tags[$i],"mejorbjugador") !== false) {
			if (isset($valores[$i])) {
				//////////////		logica mejor jugador		///////////////////////////////////////////////////////
				$existeMejorJugador = $serviciosReferencias->existeFixturePorMejorJugador($idJugador, $idFixture);
				
				if ($existeGoleadores == 0) {
					//borro los anteriores y cargos el nuevo
					$serviciosReferencias->eliminarMejorjugadorMasivo($idFixture);
					//inserto
					$serviciosReferencias->insertarMejorjugador($idJugador, $idFixture, $equipoVisitante, $idCategoria, $idDivisiones);
				}
				//////////////			fin logica			/////////////////////////////////////////////////////////	
			}
		}
		
		////********************		FIN EQUIPO LOCAL		*************************************************//////
		
	}
	
	
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



if ($_SESSION['refroll_predio'] != 1) {

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
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../js/jquery.number.min.js"></script>
    
	<style type="text/css">
		
  
		
	</style>
    
   
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
				$('.goles').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.golescontra').each(function(intIndex){
					$(this).number( true, 0 );
				});
				
				$('.minutos').each(function(intIndex){
					$(this).number( true, 0 );
					$(this).change( function() {
						if ($(this).val() > <?php echo $minutos; ?>) {
							$(this).val(<?php echo $minutos; ?>);
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

<h3>Estadisticas</h3>

    <div class="boxInfoLargoEstadisticas">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Cargar Estadisticas</p>
        	
        </div>
    	<div class="cuerpoBox" style="padding-right:10px;">
    		<form class="form-inline formulario" id="target" role="form" method="post" action="cargarestadisticas.php">
        	<div class="row">
				<div align="center">
                <ul class="list-inline">
                	<li>
                    	<input type="text" class="form-control" name="filtro" id="filtro"/>
                	</li>
                    <li>
                    	<button type="button" class="btn btn-info buscar" style="margin-left:0px;">Filtrar</button>
                    </li>
                </ul>
                </div>
                <div style="margin-left:5px;padding-left:10px; border-left:12px solid #0C0; border-bottom:1px solid #eee;border-top:1px solid #CCC; margin-right:5px;">
                <h4 style="color: #fff; background-color:#333; padding:6px;margin-left:-10px; margin-top:0;"><span class="glyphicon glyphicon-signal"></span> Datos Estadísticos</h4>
                
                <table class="table table-striped table-bordered table-responsive" id="example">
                	<caption style="font-size:1.5em; font-style:italic;">Equipo Local: <?php echo $equipoA; ?></caption>
                    <thead>
                    	<tr>
                        	<th>Jugador</th>
                            <th>DNI</th>
                            <th style="text-align:center">GA</th>
                            <th style="text-align:center">GC</th>
                            <th style="text-align:center">MIN</th>
                            <th style="text-align:center">PC</th>
                            <th style="text-align:center">PA</th>
                            <th style="text-align:center">PE</th>
                            <th style="text-align:center">MJ</th>
                            <th style="text-align:center">A</th>
                            <th style="text-align:center">E</th>
                            <th style="text-align:center">I</th>
                            <th style="text-align:center">A+A</th>
                            <th style="text-align:center">CDTD</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
							
							while ($row = mysql_fetch_array($resJugadoresA)) {
								$estadisticas = $serviciosReferencias->traerEstadisticaPorFixtureJugadorCategoriaDivision($row['refjugadores'],$idFixture, $idCategoria, $idDivisiones);

								
						?>
                        <tr class="<?php echo $row[0]; ?>">

                        	<th>
								<?php echo $row['nombrecompleto']; ?>
                            </th>
                            <th>
								<?php echo $row['nrodocumento']; ?>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm goles" name="goles<?php echo $row['refjugadores']; ?>" id="goles<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'goles'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm golescontra" name="encontra<?php echo $row['refjugadores']; ?>" id="encontra<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'encontra'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm minutos" name="minutos<?php echo $row['refjugadores']; ?>" id="minutos<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php if (mysql_result($estadisticas,0,'minutosjugados')==-1) { echo $minutos; } else { echo mysql_result($estadisticas,0,'minutosjugados'); } ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesconvertidos" name="penalesconvertidos<?php echo $row['refjugadores']; ?>" id="penalesconvertidos<?php echo $row['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticas,0,'penalconvertido'); ?>"/>
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
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm" name="amarillas<?php echo $row['refjugadores']; ?>" id="amarillas<?php echo $row['refjugadores']; ?>" style="width:45px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm" name="rojas<?php echo $row['refjugadores']; ?>" id="rojas<?php echo $row['refjugadores']; ?>" style="width:45px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm" name="informados<?php echo $row['refjugadores']; ?>" id="informados<?php echo $row['refjugadores']; ?>" style="width:45px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm" name="dobleamarilla<?php echo $row['refjugadores']; ?>" id="dobleamarilla<?php echo $row['refjugadores']; ?>" style="width:45px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm" name="cdtd<?php echo $row['refjugadores']; ?>" id="cdtd<?php echo $row['refjugadores']; ?>" style="width:45px;" value=""/>
                                </div>
                            </th>
                            
                        </tr>
                        
                        <?php
							
							
							$goles = 0;
							}
						?>
                    </tbody>
                </table>
                </div>
  
                
                
                <hr>
                
                <div style="margin-left:5px;padding-left:10px;border-left:12px solid #0C0; border-bottom:1px solid #eee; border-top:1px solid #CCC;margin-right:5px;">
                <h4 style="color: #fff; background-color:#333; padding:6px;margin-left:-10px; margin-top:0;"><span class="glyphicon glyphicon-signal"></span> Datos Estadísticos</h4>
                <table class="table table-striped table-bordered table-responsive" id="example2">
                	<caption style="font-size:1.5em; font-style:italic;">Equipo Visitante: <?php echo $equipoB; ?></caption>
                    <thead>
                    	<tr>

                        	<th>Jugador</th>
                            <th>DNI</th>
                            <th style="text-align:center">GA</th>
                            <th style="text-align:center">GC</th>
                            <th style="text-align:center">MIN</th>
                            <th style="text-align:center">PC</th>
                            <th style="text-align:center">PA</th>
                            <th style="text-align:center">PE</th>
                            <th style="text-align:center">MJ</th>
                            <th style="text-align:center">A</th>
                            <th style="text-align:center">E</th>
                            <th style="text-align:center">I</th>
                            <th style="text-align:center">A+A</th>
                            <th style="text-align:center">CDTD</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php 
							
							while ($rowB = mysql_fetch_array($resJugadoresB)) {
								$estadisticasB = $serviciosReferencias->traerEstadisticaPorFixtureJugadorCategoriaDivisionVisitante($rowB['refjugadores'],$idFixture, $idCategoria, $idDivisiones);
						?>
                        <tr class="<?php echo $row[0]; ?>">

                        	<th>
								<?php echo $rowB['nombrecompleto']; ?>
                            </th>
                            <th>
								<?php echo $rowB['nrodocumento']; ?>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm goles" name="gobles<?php echo $rowB['refjugadores']; ?>" id="gobles<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'goles'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm golescontra" name="enbcontra<?php echo $rowB['refjugadores']; ?>" id="enbcontra<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'encontra'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm minutos" name="minbutos<?php echo $rowB['refjugadores']; ?>" id="minbutos<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php if (mysql_result($estadisticasB,0,'minutosjugados')==-1) { echo $minutos; } else { echo mysql_result($estadisticasB,0,'minutosjugados'); } ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesconvertidos" name="penalesconvertidosb<?php echo $rowB['refjugadores']; ?>" id="penalesconvertidosb<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'penalconvertido'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penalesatajados" name="penalesatajadosb<?php echo $rowB['refjugadores']; ?>" id="penalesatajadosb<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'penalatajado'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="text" class="form-control input-sm penaleserrados" name="penaleserradosb<?php echo $rowB['refjugadores']; ?>" id="penaleserradosb<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value="<?php echo mysql_result($estadisticasB,0,'penalerrado'); ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="checkbox" class="form-control input-sm mejor" id="mejorbjugador<?php echo $rowB['refjugadores']; ?>" name="mejorbjugador<?php echo $rowB['refjugadores']; ?>" <?php if (mysql_result($estadisticasB,0,'mejorjugador')== 'Si') { echo 'checked'; } ?> style="width:30px;"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm" name="amarillas<?php echo $rowB['refjugadores']; ?>" id="amarillas<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm" name="rojas<?php echo $rowB['refjugadores']; ?>" id="rojas<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm" name="informados<?php echo $rowB['refjugadores']; ?>" id="informados<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm" name="dobleamarilla<?php echo $rowB['refjugadores']; ?>" id="dobleamarilla<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="text" class="form-control input-sm" name="cdtd<?php echo $rowB['refjugadores']; ?>" id="cdtd<?php echo $rowB['refjugadores']; ?>" style="width:45px;" value=""/>
                                </div>
                            </th>
                        </tr>
                        
                        <?php

							}
						?>
                    </tbody>
                </table>
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
<script src="https://cdn.datatables.net/plug-ins/1.10.13/api/fnFilterClear.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	$('#colapsarMenu').click();
	
	/*var table = $('#example dataTables_filter input');*/
	
	var table = $('#example').dataTable({
		"order": [[ 0, "asc" ]],
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
		"order": [[ 0, "asc" ]],
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
        url = "estadisticas.php?id="+<?php echo $idFixture; ?>;
		$(location).attr('href',url);
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
		
		$( "#target" ).submit();
       
    });
	
	

	
	//al enviar el formulario
    $('#cargar').click(function(){

			//información del formulario
		var formData = new FormData($(".formulario")[0]);
		var message = "";
		//hacemos la petición ajax  
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
						  después de los 2 segundos de retraso*/
						$(this).dequeue(); //continúo con el siguiente ítem en la cola
						
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
<?php } ?>
</body>
</html>