<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0)) {
	$ultimaFecha = $serviciosReferencias->traerUltimaFechaJugadaEquipoPorId($_GET['idequipo'],1);
	if (mysql_num_rows($ultimaFecha)>0) {
		$resTraerDatos = $serviciosReferencias->traerInicidenciasPorFixtureDetalle(mysql_result($ultimaFecha,0,'idfixture'));
	} else {
		$resTraerDatos = $serviciosReferencias->traerInicidenciasPorFixtureDetalle(0);	
	}
} else {
	$resTraerDatos = $serviciosReferencias->traerInicidenciasPorFixtureDetalle(0);	
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {

		array_push($ar,array('jugador'=> $row['apyn'], 
							'goles'=> $row['goles'],
							'encontra'=> $row['encontra'],
							'amonestados'=> $row['amarillas'],
							'expulsados'=> $row['rojas'],
							'informados'=> $row['informados'],
							'dobleamarilla'=> $row['dobleamarilla'],
							'penalesconvertidos'=> $row['pc'],
							'golesvisitantes'=> $row['golesvisitantes'],
							'localia'=> $row['localia'],
							'idjugador'=>$row['refjugadores']));

	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>