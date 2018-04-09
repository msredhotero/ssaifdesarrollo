<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0)) {
	$resTorneo = $serviciosReferencias->traerTorneosPorEquipo($_GET['idequipo']);
	
	if (mysql_num_rows($resTorneo)>0) {
		$resTraerDatos = $serviciosReferencias->traerFixtureTodoPorCountryEquiposTorneos($_GET['idequipo'],mysql_result($resTorneo,0,0));
	} else {
		$resTraerDatos = $serviciosReferencias->traerFixtureTodoPorCountryEquiposTorneos(0,0);
	}
} else {
	$resTraerDatos = $serviciosReferencias->traerFixtureTodoPorCountryEquiposTorneos(0,0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
$i = 1;
	while ($row = mysql_fetch_array($resTraerDatos)) {
		if ($i == 4) {
			break;	
		}
		
		if ($row['estado'] == '') {
		array_push($ar,array('id'=> $row[0], 
							'equipolocal'=> $row['equipolocal'], 
							'equipovisitante'=> $row['equipovisitante'],
							'categoria'=> $row['categoria'],
							'arbitro'=> $row['arbitro'],
							'cancha'=> $row['cancha'],
							'fecha'=> $row['fecha'],
							'fechajuego'=> $row['fechajuego'],
							'hora'=> $row['hora'],
							'estado'=> $row['estado'],
							'juez1'=> $row['juez1'],
							'juez2'=> $row['juez2'],
							'refconectorlocal'=> $row['refconectorlocal'],
							'refconectorvisitante'=> $row['refconectorvisitante']));
		
							
		$i += 1;
		}
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';
?>