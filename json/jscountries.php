<?php




include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosReferencias 	= new ServiciosReferencias();

//$token = $_GET['token'];

$resTraerTemporadas = $serviciosReferencias->traerCountries();

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cadTemporadas = '';
	while ($row = mysql_fetch_array($resTraerTemporadas)) {

		array_push($ar,array('country'=>$row['nombre'], 'id'=> $row[0]));
	}

//echo "[".substr($cadTemporadas,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>