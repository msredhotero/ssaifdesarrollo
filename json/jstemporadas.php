<?php




include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosReferencias 	= new ServiciosReferencias();

//$token = $_GET['token'];

$resTraerTemporadas = $serviciosReferencias->traerTemporadas();
/*
id: "'.$row[0].'",
				
*/
$cadTemporadas = '';
	while ($row = mysql_fetch_array($resTraerTemporadas)) {
		//$cadJugadores .= '"'.$row[0].'": "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'",';
		$cadTemporadas .= '
		      {
				"temporada": "'.$row['temporada'].'",
				"id": "'.$row[0].'"
			  },';
	}

echo "[".substr($cadTemporadas,0,-1)."]";

?>