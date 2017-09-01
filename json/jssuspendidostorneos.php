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

if (((isset($_GET['idtemporada'])) && ($_GET['idtemporada'] > 0)) && ((isset($_GET['idcategoria'])) && ($_GET['idcategoria'] > 0)) && ((isset($_GET['iddivision'])) && ($_GET['iddivision'] > 0))){
	$resDatos = $serviciosReferencias->SuspendidosTotalPorTemporadaCategoriaDivision($_GET['idtemporada'],$_GET['idcategoria'],$_GET['iddivision']);
} else {
	$resDatos = $serviciosReferencias->SuspendidosTotalPorTemporadaCategoriaDivision(0,0,0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

	while ($row = mysql_fetch_array($resDatos)) {
		if ($row['pendientesfallo'] == 1) {
			array_push($ar,array('country'=>$row['nombre'], 'nombre'=>$row['apyn'],'fecha'=>$row['fecha'],'partido'=>$row['equiposcontra'],'tiposancion'=>'Pendiente','sancion'=>'Pendiente','cumplido'=>$row['fechascumplidas']));
		} else {
			array_push($ar,array('country'=>$row['nombre'], 'nombre'=>$row['apyn'],'fecha'=>$row['fecha'],'partido'=>$row['equiposcontra'],'tiposancion'=>'Expulsado','sancion'=>($row['dias']==0 ? $row['cantidadfechas'].' fechas' : $row['dias'].' dias'),'cumplido'=>$row['fechascumplidas']));
		}
	}

//echo "[".substr($cadJugadores,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>