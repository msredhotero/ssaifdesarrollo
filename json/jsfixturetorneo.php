<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if (((isset($_GET['idtorneo'])) && ($_GET['idtorneo'] > 0)) && ((isset($_GET['idfecha'])) && ($_GET['idfecha'] > 0))) {
	$resTraerDatos = $serviciosReferencias->traerFixtureTodoPorTorneosFechas($_GET['idtorneo'],$_GET['idfecha']);
} else {
	$resTraerDatos = $serviciosReferencias->traerFixtureTodoPorTorneosFechas(0,0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();
$dia = '';
$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {

		switch (date('N', strtotime( $row['fechajuego']))) {
			case 1:
				$dia = 'Lunes';
				break;
			case 2:
				$dia = 'Martes';
				break;
			case 3:
				$dia = 'Miércoles';
				break;
			case 4:
				$dia = 'Jueves';
				break;
			case 5:
				$dia = 'Viernes';
				break;
			case 6:
				$dia = 'Sábado';
				break;
			case 7:
				$dia = 'Domingo';
				break;
		}
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
							'refconectorvisitante'=> $row['refconectorvisitante'],
							'dia' => $dia,
							'esfinalizado'=>$row['esfinalizado'],
							'espendienterevision'=>$row['espendienterevision']));
							
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';
?>