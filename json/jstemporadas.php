<?php




include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosReferencias 	= new ServiciosReferencias();

$token = $_GET['callback'];

$resTraerTemporadas = $serviciosReferencias->traerTemporadas();

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();
$cadTemporadas = '';
	while ($row = mysql_fetch_array($resTraerTemporadas)) {
			  
		array_push($ar,array('temporada'=>$row['temporada'], 'id'=> $row[0]));
		
		
	}

echo $token.'('.json_encode($ar).');';
?>