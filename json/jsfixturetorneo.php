<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesReferenciasRemoto.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();
$serviciosReferenciasRemoto 	= new ServiciosReferenciasRemoto();

$definicionLocal = 0;
$definicionVisitante = 0;

$copa = 0;

if (((isset($_GET['idtorneo'])) && ($_GET['idtorneo'] > 0)) && ((isset($_GET['idfecha'])) && ($_GET['idfecha'] > 0))) {
	$resTraerDatos = $serviciosReferencias->traerFixtureTodoPorTorneosFechas($_GET['idtorneo'],$_GET['idfecha']);
	if (mysql_num_rows($resTraerDatos) > 0) {
		$resTraerDatos = $serviciosReferencias->traerFixtureTodoPorTorneosFechas($_GET['idtorneo'],$_GET['idfecha']);
	} else {
		$resTraerDatos = $serviciosReferenciasRemoto->traerFixtureTodoPorTorneosFechasPlayOff($_GET['idtorneo'],$_GET['idfecha']);

		$copa = 1;
	}

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

		if ($copa == 1) {
			$resDefinicion = $serviciosReferenciasRemoto->traerDefinicionPenalesPorTorneoFecha($_GET['idtorneo'],$_GET['idfecha'],$row['refconectorlocal'],$row['refconectorvisitante']);

			if (mysql_num_rows($resDefinicion)>0) {
				$definicionLocal = mysql_result($resDefinicion,0,0);
				$definicionVisitante = mysql_result($resDefinicion,0,1);
			} else {
				$definicionLocal = 0;
				$definicionVisitante = 0;
			}
		}

		if ($definicionLocal != 0 || $definicionVisitante != 0) {
			array_push($ar,array('id'=> $row[0],
								'equipolocal'=> $row['equipolocal'],
								'puntoslocal'=> $row['puntoslocal'],
								'puntosvisita'=> $row['puntosvisita'],
								'equipovisitante'=> $row['equipovisitante'],
								'categoria'=> $row['categoria'],
								'arbitro'=> $row['arbitro'],
								'goleslocal'=> $row['goleslocal'].'('.$definicionLocal.')',
								'golesvisitantes'=> $row['golesvisitantes'].'('.$definicionVisitante.')',
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
								'link'=>$row['linkfacebook'],
								'espendienterevision'=>$row['espendienterevision']));
		} else {
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
								'link'=>$row['linkfacebook'],
								'espendienterevision'=>$row['espendienterevision']));
		}


	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';
?>
