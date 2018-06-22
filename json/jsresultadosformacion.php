<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['idfixture'])) && ($_GET['idfixture'] > 0)) {
	$resTraerDatos = $serviciosReferencias->traerFormacionPorFixtureDetalle($_GET['idfixture']);
} else {
	$resTraerDatos = $serviciosReferencias->traerFormacionPorFixtureDetalle(0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {

		array_push($ar,array('jugador'=> $row['apyn'], 
							'dorsal'=> $row['numero'],
							'equipo'=> $row['equipo'],
							'idjugador'=>$row['refjugadores']));
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';
?>