<?php

session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../../error.php');
} else {


include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

$countries = $_GET['countrie'];

$resTraerJugadores = $serviciosReferencias->traerJugadores();

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cadJugadores = '';
	while ($row = mysql_fetch_array($resTraerJugadores)) {
		//$cadJugadores .= '"'.$row[0].'": "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'",';
		$cadJugadores .= '
		      {
				"name": "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'",
				"id": "'.$row[0].'"
			  },';
	}

//echo "[".substr($cadJugadores,0,-1)."]";
echo $token.'('.json_encode($ar).');';
}
?>