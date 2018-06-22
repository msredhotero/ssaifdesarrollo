<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['idfixture'])) && ($_GET['idfixture'] > 0)) {
	$resTraerDatos = $serviciosReferencias->traerFormacionCambiosPorFixtureDetalle($_GET['idfixture']);
} else {
	$resTraerDatos = $serviciosReferencias->traerFormacionCambiosPorFixtureDetalle(0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {

		array_push($ar,array('jugadorsale'=> $row['apynsale'],
							'jugadorentra'=> $row['apynentra'], 
							'dorsalsale'=> $row['numerosale'],
							'dorsalentra'=> $row['numeroentra'],
							'equipo'=> $row['equipo']));
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';
?>