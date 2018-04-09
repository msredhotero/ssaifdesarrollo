<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0)) {
	$resTraerDatos = $serviciosReferencias->traerUltimosResultadosPorEquipo($_GET['idequipo']);
} else {
	$resTraerDatos = $serviciosReferencias->traerUltimosResultadosPorEquipo(0);	
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {

		array_push($ar,array('resultado'=>$row['resultado'], "equipolocal"=>$row['equipolocal'], "goleslocal"=>$row['goleslocal'], "equipovisitante"=>$row['equipovisitante'], "golesvisitantes"=>$row['golesvisitantes'], 'fechajuego'=>$row['fechajuego'], 'idequipolocal'=> $row['idequipolocal'],'idequipovisitante'=> $row['idequipovisitante']));

	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>