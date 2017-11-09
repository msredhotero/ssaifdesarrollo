<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');


if ((isset($_GET['idjugador'])) && ($_GET['idjugador'] > 0)) {
	$resTraerJugadores = $serviciosReferencias->traerJugadoresEquiposPorJugador($_GET['idjugador']);
} else {
	$resTraerJugadores = $serviciosReferencias->traerJugadoresEquiposPorJugador(0);	
}
$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

	while ($row = mysql_fetch_array($resTraerJugadores)) {
		
		array_push($ar,array('equipo'=>$row['equipo'], 'categoria'=>$row['categoria'],'division'=>$row['division'], 'idequipo'=>$row['refequipos']));

	}

echo $token.'('.json_encode($ar).');';


?>