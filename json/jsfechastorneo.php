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
$actual = 0;
$parar = 0;
$i=0;
$cantFechas = 0;
	while ($row = mysql_fetch_array($resTraerDatos)) {
		$cantFechas += 1;
		if ($parar == 0) {
			
			if ($row['idestadopartido'] != 0) {
				$i += 1;
				$actual = $i;				
			} else {
				$actual = $i;
				$parar = 1;
			}
		}
		array_push($ar,array('id'=> $row['reffechas'], 
							'fecha'=> $row['fecha'],
							'actual'=>0));
		
	}

if ($i == 1) {
	$ar[$i - 1]['actual'] = 1;
} else {
	if ($i == 0) {
		$ar[0]['actual'] = 1;
	} else {
		$ar[$i - 1]['actual'] = 1;
	}
	
}
//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';
?>