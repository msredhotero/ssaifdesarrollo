<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0)) {
	$resTraerDatos = $serviciosReferencias->traerPlantelEstadisticasPorEquipo($_GET['idequipo']);
} else {
	$resTraerDatos = $serviciosReferencias->traerPlantelEstadisticasPorEquipo(0);	
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {

		array_push($ar,array('apellido'=>$row['apellido'], 'nombre'=> $row['nombres'], 'goles'=> $row['goles'], 'amonestaciones'=> $row['amarillas'], 'expulsiones'=> $row['rojas']));

	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>