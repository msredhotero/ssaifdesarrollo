<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if (((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0)) && ((isset($_GET['limite'])) && ($_GET['limite'] > 0))) {
	$resTraerDatos = $serviciosReferencias->traerUltimaFechaJugadaEquipoPorId($_GET['idequipo'],$_GET['limite']);
} else {
	$resTraerDatos = $serviciosReferencias->traerUltimaFechaJugadaEquipoPorId(0,1);	
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {

		array_push($ar,array('equipo'=>$row['equipo'],'contra'=>$row['contra'], 'arbitro'=> $row['arbitro'], 'juez1'=> $row['juez1'], 'juez2'=> $row['juez2'], 'cancha'=> $row['cancha'], 'estado'=> $row['estado'], 'resultado'=> $row['resultado'], 'imagenlocal'=>$row['imagenlocal'], 'imagenvisitante'=>$row['imagenvisitante']));

	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>