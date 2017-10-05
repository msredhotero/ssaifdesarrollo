<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

$datos = 0;
if ((isset($_GET['idcountry'])) && ($_GET['idcountry'] > 0)) {
	if ((isset($_GET['idcategoria'])) && ($_GET['idcategoria'] > 0)) {
		$resTraerDatos = $serviciosReferencias->traerEquiposPorCountriesCategorias($_GET['idcountry'], $_GET['idcategoria'] );
	} else {
		$resTraerDatos = $serviciosReferencias->traerEquiposPorCountries($_GET['idcountry']);
	}
	$datos = 1;
} else {
	$resTraerDatos = $serviciosReferencias->traerEquipos();	
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {
		//$cadJugadores .= '"'.$row[0].'": "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'",';
		if ($datos == 1) {
			  
			array_push($ar,array('equipo'=>$row[0].' - '.$row['nombre'], 'id'=> $row[0], 'iddivision'=>$row['division']));
		} else {

			array_push($ar,array('equipo'=>$row['nombre'].' - '.$row['categoria'].' - '.$row['division'], 'id'=> $row[0], 'iddivision'=>$row['division']));
		}
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>