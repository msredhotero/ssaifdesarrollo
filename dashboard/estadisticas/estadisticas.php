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

$idFixture = $_GET['id'];

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



$resJugadoresA = $serviciosReferencias->traerConectorActivosPorEquipos($equipoLocal);
$resJugadoresB = $serviciosReferencias->traerConectorActivosPorEquipos($equipoVisitante);



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
    		<form class="form-inline formulario" role="form">
        	<div class="row">
				<div align="center">
                <ul class="list-inline">
                	<li>
                    	<button type="button" class="btn btn-success marcar" style="margin-left:0px;">Marcar Todos</button>
                	</li>
                    <li>
                    	<button type="button" class="btn btn-danger desmarcar" style="margin-left:0px;">Desmarcar Todos</button>
                    </li>
                </ul>
                </div>
                <div style="margin-left:5px;padding-left:10px; border-left:12px solid #0C0; border-bottom:1px solid #eee;border-top:1px solid #CCC;">
                <h4 style="color: #fff; background-color:#333; padding:6px;margin-left:-10px; margin-top:0;"><span class="glyphicon glyphicon-signal"></span> Datos Estadísticos</h4>
                
                <table class="table table-striped table-bordered table-responsive" >
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
						?>
                        <tr>

                        	<th>
								<?php echo $row['nombrecompleto']; ?>
                            </th>
                            <th>
								<?php echo $row['nrodocumento']; ?>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="goles<?php echo $row[0]; ?>" id="goles<?php echo $row[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="golescontra<?php echo $row[0]; ?>" id="golescontra<?php echo $row[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="minitos<?php echo $row[0]; ?>" id="minitos<?php echo $row[0]; ?>" style="width:55px;" value="<?php echo $minutos; ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="number" class="form-control input-sm" name="penalesconvertidos<?php echo $row[0]; ?>" id="penalesconvertidos<?php echo $row[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="number" class="form-control input-sm" name="penalesatajados<?php echo $row[0]; ?>" id="penalesatajados<?php echo $row[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="number" class="form-control input-sm" name="penaleserrados<?php echo $row[0]; ?>" id="penaleserrados<?php echo $row[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="checkbox" class="form-control input-sm" id="mejorjugador<?php echo $row[0]; ?>" name="mejorjugador<?php echo $row[0]; ?>" style="width:30px;"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="amarillas<?php echo $row[0]; ?>" id="amarillas<?php echo $row[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="rojas<?php echo $row[0]; ?>" id="rojas<?php echo $row[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="informados<?php echo $row[0]; ?>" id="informados<?php echo $row[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="dobleamarilla<?php echo $row[0]; ?>" id="dobleamarilla<?php echo $row[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="cdtd<?php echo $row[0]; ?>" id="cdtd<?php echo $row[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            
                        </tr>
                        <tr style="display:none;" id="resultado<?php echo $row[0]; ?>"><th colspan='12'></th></tr>
                        <?php

							}
						?>
                    </tbody>
                </table>
                </div>
  
                
                
                <hr>
                
                <div style="margin-left:5px;padding-left:10px;border-left:12px solid #0C0; border-bottom:1px solid #eee; border-top:1px solid #CCC;">
                <h4 style="color: #fff; background-color:#333; padding:6px;margin-left:-10px; margin-top:0;"><span class="glyphicon glyphicon-signal"></span> Datos Estadísticos</h4>
                <table class="table table-striped table-bordered table-responsive" style="margin:10px;">
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
								
						?>
                        <tr>
                        	<th>
								<?php echo $rowB['nombrecompleto']; ?>
                            </th>
                            <th>
								<?php echo $rowB['nrodocumento']; ?>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="goles<?php echo $rowB[0]; ?>" id="goles<?php echo $rowB[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="golescontra<?php echo $rowB[0]; ?>" id="golescontra<?php echo $rowB[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="minitos<?php echo $rowB[0]; ?>" id="minitos<?php echo $rowB[0]; ?>" style="width:55px;" value="<?php echo $minutos; ?>"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="number" class="form-control input-sm" name="penalesconvertidos<?php echo $rowB[0]; ?>" id="penalesconvertidos<?php echo $rowB[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="number" class="form-control input-sm" name="penalesatajados<?php echo $rowB[0]; ?>" id="penalesatajados<?php echo $rowB[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">	
                                	<input type="number" class="form-control input-sm" name="penaleserrados<?php echo $rowB[0]; ?>" id="penaleserrados<?php echo $rowB[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="checkbox" class="form-control input-sm" id="mejorjugador<?php echo $rowB[0]; ?>" name="mejorjugador<?php echo $rowB[0]; ?>" style="width:30px;"/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="amarillas<?php echo $rowB[0]; ?>" id="amarillas<?php echo $rowB[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="rojas<?php echo $rowB[0]; ?>" id="rojas<?php echo $rowB[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="informados<?php echo $rowB[0]; ?>" id="informados<?php echo $rowB[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="dobleamarilla<?php echo $rowB[0]; ?>" id="dobleamarilla<?php echo $rowB[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                            <th>
                            	<div align="center">
                                	<input type="number" class="form-control input-sm" name="cdtd<?php echo $rowB[0]; ?>" id="cdtd<?php echo $rowB[0]; ?>" style="width:55px;" value=""/>
                                </div>
                            </th>
                        </tr>
                        <tr style="display:none;" id="resultado<?php echo $rowB[0]; ?>"><th colspan='12'></th></tr>
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






<script type="text/javascript">
$(document).ready(function(){
	
	$('#colapsarMenu').click();
	
	
	

});
</script>
<?php } ?>
</body>
</html>
