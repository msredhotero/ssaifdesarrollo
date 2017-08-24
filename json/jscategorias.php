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


/*
id: "'.$row[0].'",
				
*/
$cad = '';
	while ($row = mysql_fetch_array($resTraerCategorias)) {
		//$cadJugadores .= '"'.$row[0].'": "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'",';
		$cad .= '
		      {
				"categoria": "'.$row['categoria'].'",
				"id": "'.$row[0].'"
			  },';
	}

echo "[".substr($cad,0,-1)."]";

?>