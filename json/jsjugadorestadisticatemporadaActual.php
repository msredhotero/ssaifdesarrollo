<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

$resTraerTemporadas = $serviciosReferencias->traerUltimaTemporada();

if (mysql_num_rows($resTraerTemporadas)>0) {
	$idTemporada = mysql_result($resTraerTemporadas,0,0);
}	else {
	$idTemporada = 0;
}


if ((isset($_GET['idjugador'])) && ($_GET['idjugador'] > 0)) {
	$resTraerJugadores = $serviciosReferencias->traerEstadisticaJugadorTemporadaActual($_GET['idjugador'],$idTemporada);
} else {
	$resTraerJugadores = $serviciosReferencias->traerEstadisticaJugadorTemporadaActual(0,$idTemporada);	
}
$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

	while ($row = mysql_fetch_array($resTraerJugadores)) {
		
		array_push($ar,array('goles'=>$row['goles'], 
							 'amonestaciones'=>$row['amarillas'],
							 'expulsiones'=>$row['rojas'],
							 'idequipo'=>$row['idequipo'],
							 'equipo'=>$row['nombreequipo'],
							 'categoria'=>$row['categoria'],
							 'division'=>$row['division']));
	}

echo $token.'('.json_encode($ar).');';


?>