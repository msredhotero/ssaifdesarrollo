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

if ((isset($_GET['idtorneo'])) && ($_GET['idtorneo'] > 0)) {
	$resTorneo= $serviciosReferencias->traerTorneosPorId($_GET['idtorneo']);
	$resDatos = $serviciosReferencias->PosicionesConformada(mysql_result($resTorneo,0,'reftemporadas'),mysql_result($resTorneo,0,'refcategorias'),mysql_result($resTorneo,0,'refdivisiones'));

} else {
	$resDatos = $serviciosReferencias->PosicionesConformada(0,0,0);

}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$i = 1;

	foreach ($resDatos as $row) {

		array_push($ar,array('posicion'=>$i, 'equipos'=>$row['equipo'],'pts'=>$row['puntos'],'ptsb'=>$row['puntobonus'],'ptsn'=>$row['puntos'] - $row['puntobonus'],'pj'=>$row['pj'],'pg'=>$row['pg'],'pe'=>$row['pe'],'pp'=>$row['pp'],'gf'=>$row['goles'],'gc'=>$row['golescontra'],'amonestados'=>$row['amarillas'],'expulsados'=>$row['rojas']));
		
		$i += 1;

	}

//echo "[".substr($cadJugadores,0,-1)."]";
echo $token.'('.json_encode($ar).');';
//die(var_dump($ar));

?>