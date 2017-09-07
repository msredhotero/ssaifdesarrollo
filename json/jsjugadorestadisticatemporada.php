<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');


if ((isset($_GET['idjugador'])) && ($_GET['idjugador'] > 0)) {
	$resTraerJugadores = $serviciosReferencias->SuspendidosTotalPorJugador($_GET['idjugador']);
} else {
	$resTraerJugadores = $serviciosReferencias->SuspendidosTotalPorJugador(0);	

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

	while ($row = mysql_fetch_array($resTraerJugadores)) {
		
		if ($row['pendientesfallo'] == 1) {
			array_push($ar,array('country'=>$row['nombre'], 'nombre'=>$row['apyn'],'fecha'=>$row['fecha'],'partido'=>$row['equiposcontra'],'tiposancion'=>'Pendiente','sancion'=>'Pendiente','cumplido'=>$row['fechascumplidas']));
		} else {
			array_push($ar,array('country'=>$row['nombre'], 'nombre'=>$row['apyn'],'fecha'=>$row['fecha'],'partido'=>$row['equiposcontra'],'tiposancion'=>'Expulsado','sancion'=>($row['dias']==0 ? $row['cantidadfechas'].' fechas' : $row['dias'].' dias'),'cumplido'=>$row['fechascumplidas']));
		}
	}

echo $token.'('.json_encode($ar).');';

}
?>