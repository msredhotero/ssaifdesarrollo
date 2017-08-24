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


/*
id: "'.$row[0].'",
				
*/
$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {
		//$cadJugadores .= '"'.$row[0].'": "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'",';
		if ($datos == 1) {
			$cad .= '
		      {
				"equipo": "'.$row[0].' - '.$row['nombre'].'",
				"id": "'.$row[0].'"
			  },';
		} else {
			$cad .= '
		      {
				"equipo": "'.$row['nombre'].' - '.$row['categoria'].' - '.$row['division'].'",
				"id": "'.$row[0].'"
			  },';
		}
	}

echo "[".substr($cad,0,-1)."]";

?>