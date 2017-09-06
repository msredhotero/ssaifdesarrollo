<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();


if ((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0)) {
	$resTraerDatos = $serviciosReferencias->traerPartidosGPEporEquipo($_GET['idequipo']);

} else {
	$resTraerDatos = $serviciosReferencias->traerPartidosGPEporEquipo(0);	
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$porcGanado   = 0;
$porcPerdido  = 0;
$porcEmpatado = 0;

	while ($row = mysql_fetch_array($resTraerDatos)) {
		if ($row['partidos'] > 0) {
			$porcGanado = 	$row['ganados'] * 100 / $row['partidos'];	
			$porcPerdido = 	$row['perdidos'] * 100 / $row['partidos'];	
			$porcEmpatado = 	$row['empatados'] * 100 / $row['partidos'];		
			array_push($ar,array('porcentajeganados'=>round($porcGanado,0,PHP_ROUND_HALF_UP), 'porcentajeperdidos'=> round($porcPerdido,0,PHP_ROUND_HALF_UP), 'porcentajeempatados'=> round($porcEmpatado,0,PHP_ROUND_HALF_UP)));
		} else {
			array_push($ar,array('porcentajeganados'=>$porcGanado, 'porcentajeperdidos'=> $porcPerdido, 'porcentajeempatados'=> $porcEmpatado));
		}

	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>