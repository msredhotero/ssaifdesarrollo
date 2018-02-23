<?php

session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../../error.php');
} else {


include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

$busqueda = $_POST['busqueda'];

$resTraerJugadores = $serviciosReferencias->nuevoBuscador($busqueda);

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resTraerJugadores)) {

		array_push($ar,array('id'=>$row['idjugador'], 'apellido'=> $row['apellido'], 'nombres'=> $row['nombres'], 'nrodocumento'=> $row['nrodocumento']));
	}

//echo "[".substr($cad,0,-1)."]";
echo "[".json_encode($ar)."]";

}
?>