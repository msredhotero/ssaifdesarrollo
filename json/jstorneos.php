<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

$dato = 0;
if ((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0) && ((isset($_GET['idtemporada'])) && ($_GET['idtemporada'] > 0)) && ((isset($_GET['idcategoria'])) && ($_GET['idcategoria'] > 0)) && ((isset($_GET['iddivision'])) && ($_GET['iddivision'] > 0))) {
	$resTraerDatos = $serviciosReferencias->traerTorneosPorEquipoTemporadaCategoriaDivision($_GET['idequipo'], $_GET['idtemporada'], $_GET['idcategoria'], $_GET['iddivision']);
	$dato = 0;
} else {
	if (((isset($_GET['idtemporada'])) && ($_GET['idtemporada'] > 0)) && ((isset($_GET['idcategoria'])) && ($_GET['idcategoria'] > 0)) && ((isset($_GET['iddivision'])) && ($_GET['iddivision'] > 0))) {
		$dato = 1;
		$resTraerDatos = $serviciosReferencias->traerTorneosPorTemporadaCategoriaDivision($_GET['idtemporada'], $_GET['idcategoria'], $_GET['iddivision']);
	} else {
		$resTraerDatos = $serviciosReferencias->traerTorneosPorEquipo(99999999999);	
	}
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {
		if ($dato == 0) {
			array_push($ar,array('id'=>$row['idtorneo'], 'torneo'=> $row['descripcion']));
		} else {
			array_push($ar,array('id'=>$row['idtorneo'], 'torneo'=> $row['descripcion']));
		}
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>