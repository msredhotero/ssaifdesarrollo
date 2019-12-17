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
	if (isset($_GET['idequipo'])) {
		$resTraerDatos = $serviciosReferencias->traerEquiposPorId($_GET['idequipo']);	
		$datos = 2;
	} else {
		$resTraerDatos = $serviciosReferencias->traerEquipos();	
		$datos = 0;
	}
	
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {
		//$cadJugadores .= '"'.$row[0].'": "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'",';
		if ($datos == 1) {

			array_push($ar,array('equipo'=>$row[0].' - '.$row['nombre'], 'id'=> $row[0], 'categoria'=>$row['categoria'], 'imagen'=>$row['imagen']));
		} else {
			if ($datos == 0) {
				array_push($ar,array('equipo'=>$row[0].' - '.$row['nombre'].' - '.$row['categoria'].' - '.$row['division'], 'id'=> $row[0], 'categoria'=>$row['categoria'], 'imagen'=>$row['imagen']));
			} else {
				array_push($ar,array('equipo'=>$row[0].' - '.$row['nombre'], 'id'=> $row[0], 'imagen'=>$row['imagen']));
			}

			
		}
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>