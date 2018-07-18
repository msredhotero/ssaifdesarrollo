<?php


include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosUsuario = new ServiciosUsuarios();
$serviciosHTML = new ServiciosHTML();
$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();


$res = $serviciosReferencias->traerImagenesRepetidas();


while ($row = mysql_fetch_array($res)) {
	echo "'".$row['iddocumentacionjugadorimagen']."/".str_replace('.pdf','.jpg', $row['imagen'])."',<br>";
}



?>