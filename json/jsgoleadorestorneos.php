<?php


include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

if ((isset($_GET['idtorneo'])) && ($_GET['idtorneo'] > 0)) {
	$resDatos = $serviciosReferencias->Goleadores($_GET['idtorneo']);
} else {
	$resDatos = $serviciosReferencias->Goleadores(0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

	while ($row = mysql_fetch_array($resDatos)) {
		
		array_push($ar,array('jugador'=>$row['apyn'], 'equipo'=>$row['equipo'],'goles'=>$row['goles'], 'idjugador'=>$row['idjugador'], 'idequipo'=>$row['refequipos']));
	}

//echo "[".substr($cadJugadores,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>