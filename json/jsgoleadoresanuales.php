<?php


include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesReferenciasRemoto.php');


$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$serviciosReferenciasRemoto 	= new ServiciosReferenciasRemoto();

$fecha = date('Y-m-d');


if ((isset($_GET['idtorneo'])) && ($_GET['idtorneo'] > 0)) {
	$resTorneo= $serviciosReferencias->traerTorneosPorId($_GET['idtorneo']);
	$resDatos = $serviciosReferencias->GoleadoresConformada(mysql_result($resTorneo,0,'reftemporadas'),mysql_result($resTorneo,0,'refcategorias'),mysql_result($resTorneo,0,'refdivisiones'));
	if (mysql_num_rows($resDatos) > 0) {
		$resDatos = $serviciosReferencias->GoleadoresConformada(mysql_result($resTorneo,0,'reftemporadas'),mysql_result($resTorneo,0,'refcategorias'),mysql_result($resTorneo,0,'refdivisiones'));
	} else {
		$resDatos = $serviciosReferenciasRemoto->Goleadores($_GET['idtorneo']);
	}
} else {
	$resDatos = $serviciosReferencias->Goleadores(0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

	while ($row = mysql_fetch_array($resDatos)) {
		
		array_push($ar,array('jugador'=>$row['apyn'], 'equipo'=>$row['equipo'],'goles'=>$row['goles'], 'idjugador'=>$row['idjugador'], 'idequipo'=>$row['refequipos']));
	}

//echo "[".substr($cadJugadores,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>