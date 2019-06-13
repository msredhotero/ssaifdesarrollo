<?php

session_start();

include ('includes/funcionesUsuarios.php');
include ('includes/funcionesHTML.php');
include ('includes/funciones.php');
include ('includes/funcionesReferencias.php');

$serviciosUsuario = new ServiciosUsuarios();
$serviciosHTML = new ServiciosHTML();
$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

/*
$res = $serviciosReferencias->traerConectorTodosActivosT(8);

while ($row = mysql_fetch_array($res)) {

   $resHabilita = $serviciosReferencias->deteterminaHabilitado($row['refjugadores'], $row['refcategorias'], $row['reftipojugadores'], $row['refequipos'], $row['fechabaja']);

   $serviciosReferencias->insertarJugadoreshabilitados($row['refjugadores'],$row['refequipos'],$resHabilita['habilita'],$resHabilita['observacion'],date('Y-m-d H:i:s'),$_SESSION['nombre_predio']);


}
*/

$resConectores = $serviciosReferencias->traerJugadoresEquiposPorJugador(17974);

echo 'aca';

while ($row = mysql_fetch_array($resConectores)) {
   echo 'aca2';
   $resHabilita = $serviciosReferencias->deteterminaHabilitado(17974, $row['idtcategoria'], $row['reftipojugadores'], $row['refequipos'], $row['fechabaja']);

   echo $resHabilita['habilita'].'<br><br>';
   echo $resHabilita['observacion'].'<br><br>';
   //$serviciosReferencias->insertarJugadoreshabilitados($id,$row['refequipos'],$resHabilita['habilita'],$resHabilita['observacion'],date('Y-m-d H:i:s'),$_SESSION['nombre_predio']);
}


?>
