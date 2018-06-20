<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['idtemporada'])) && ($_GET['idtemporada'] > 0)) {
	$resTraerCategorias = $serviciosReferencias->traerCategoriasPorTemporadas($_GET['idtemporada']);
} else {
	$resTraerCategorias = $serviciosReferencias->traerCategorias();	
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerCategorias)) {

		array_push($ar,array('categoria'=>$row['categoria'], 'id'=> $row[0]));
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>