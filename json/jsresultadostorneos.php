<?php




include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

if (((isset($_GET['idtorneo'])) && ($_GET['idtorneo'] > 0)) && ((isset($_GET['idfecha'])) && ($_GET['idfecha'] > 0))) {
	$resTraerDatos = $serviciosReferencias->traerFixtureTodoPorTorneosFechas($_GET['idtorneo'],$_GET['idfecha']);
	$datos = 1;
} else {
	$resTraerDatos = $serviciosReferencias->traerFixtureTodoPorTorneosFechas(0,0);	
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cadJugadores = '';
	while ($row = mysql_fetch_array($resTraerJugadores)) {
		
		array_push($ar,array('id'=> $row[0], 
							'equipolocal'=> $row['equipolocal'], 
							'puntoslocal'=> $row['puntoslocal'],
							'puntosvisita'=> $row['puntosvisita'],
							'equipovisitante'=> $row['equipovisitante'],
							'categoria'=> $row['categoria'],
							'arbitro'=> $row['arbitro'],
							'goleslocal'=> $row['goleslocal'],
							'golesvisitantes'=> $row['golesvisitantes'],
							'cancha'=> $row['cancha'],
							'fecha'=> $row['fecha'],
							'fechajuego'=> $row['fechajuego'],
							'hora'=> $row['hora'],
							'estado'=> $row['estado'],
							'calificacioncancha'=> $row['calificacioncancha'],
							'juez1'=> $row['juez1'],
							'juez2'=> $row['juez2'],
							'refconectorlocal'=> $row['refconectorlocal'],
							'refconectorvisitante'=> $row['refconectorvisitante']));
	}

//echo "[".substr($cadJugadores,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>