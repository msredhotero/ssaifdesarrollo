<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if (((isset($_GET['idcategoria'])) && ($_GET['idcategoria'] > 0)) && ((isset($_GET['idtemporada'])) && ($_GET['idtemporada'] > 0))) {
	$resTraerDatos = $serviciosReferencias->traerDivisionesPorCategoriasTemporadas($_GET['idtemporada'],$_GET['idcategoria']);
} else {
	$resTraerDatos = $serviciosReferencias->traerDivisiones();	
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {

		array_push($ar,array('division'=>$row['division'], 'id'=> $row[0]));
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>