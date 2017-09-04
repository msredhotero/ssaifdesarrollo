<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();



if ((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0)) {
	$resTorneo = $serviciosReferencias->traerTorneosPorEquipo($_GET['idequipo']);
	
	if (mysql_num_rows($resTorneo)>0) {
		$resDatos = $serviciosReferencias->Posiciones(mysql_result($resTorneo,0,0));
	} else {
		$resDatos = $serviciosReferencias->Posiciones(0);	
	}
} else {
	$resTraerDatos = $serviciosReferencias->Posiciones(0);	
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
$i=1;
	while ($row = mysql_fetch_array($resDatos)) {
		if ($i==3) {
			break;	
		}
		array_push($ar,array('posicion'=>$row['posicion'],'equipos'=>$row['equipos'],'pts'=>$row['pts'],'pj'=>$row['pj']));
		$i += 1;
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>