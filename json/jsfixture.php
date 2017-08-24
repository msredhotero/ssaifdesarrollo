<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if (((isset($_GET['idcountry'])) && ($_GET['idcountry'] > 0)) && ((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0)) && ((isset($_GET['idtorneo'])) && ($_GET['idtorneo'] > 0))) {
	$resTraerDatos = $serviciosReferencias->traerFixtureTodoPorCountryEquiposTorneos($_GET['idequipo'],$_GET['idtorneo']);
}


/*
id: "'.$row[0].'",
				
*/
$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {
		//$cadJugadores .= '"'.$row[0].'": "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'",';
		$cad .= '
		      {
				"division": "'.$row['division'].'",
				"id": "'.$row[0].'"
			  },';
	}

echo "[".substr($cad,0,-1)."]";

?>