<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

$datos = 0;
if (((isset($_GET['idcategoria'])) && ($_GET['idcategoria'] > 0)) && ((isset($_GET['iddivision'])) && ($_GET['iddivision'] > 0))) {
	$resTraerDatos = $serviciosReferencias->traerEquipoPorCategoriaDivision($_GET['idcategoria'],$_GET['iddivision']);
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

			array_push($ar,array('equipo'=>$row[0].' - '.$row['nombre'], 'id'=> $row[0]));
		} else {

			array_push($ar,array('equipo'=>$row[0].' - '.$row['nombre'].' - '.$row['categoria'].' - '.$row['division'], 'id'=> $row[0]));
		}
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>