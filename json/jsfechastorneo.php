<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['idtorneo'])) && ($_GET['idtorneo'] > 0)) {
	$resTraerDatos = $serviciosReferencias->traerFechasFixturePorTorneo($_GET['idtorneo']);
} else {
	$resTraerDatos = $serviciosReferencias->traerFechasFixturePorTorneo(0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {

		array_push($ar,array('id'=> $row['reffechas'], 
							'fecha'=> $row['fecha']));
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';
?>