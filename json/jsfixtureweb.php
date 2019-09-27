<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();


$resTemporadas = $serviciosReferencias->traerUltimaTemporada();

if (mysql_num_rows($resTemporadas)>0) {
   $ultimaTemporada = mysql_result($resTemporadas,0,0);
} else {
   $ultimaTemporada = 0;
}

if (isset($_GET['idcategoria'])) {
   $idcategoria = ' and tor.refcategorias ='.$_GET['idcategoria'];
} else {
   $idcategoria = '';
}

if (isset($_GET['iddivision'])) {
   $iddivision = ' and tor.refdivisiones ='.$_GET['iddivision'];
} else {
   $iddivision = '';
}

if (isset($_GET['idtorneo'])) {
   $idtorneo = ' and tor.idtorneo ='.$_GET['idtorneo'];
} else {
   $idtorneo = '';
}


if (isset($_GET['idtemporada'])) {
   $idtemporada = $_GET['idtemporada'];
} else {
   $idtemporada = $ultimaTemporada;
}



$resDatos = $serviciosReferencias->traerFixtureWebFiltros($idtemporada, $idcategoria, $iddivision, $idtorneo);

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resDatos)) {

		array_push($ar,array('idfixture'=>$row['idfixture'],
                           'categoria'=>$row['categoria'],
                           'division'=>$row['division'],
                           'torneo'=>$row['torneo'],
                           'equipoLocal'=>$row['equipoLocal'],
                           'equipoVisitante'=>$row['equipoVisitante'],
                           'dia'=>$row['dia'],
                           'hora'=>$row['hora'],
                           'cancha'=>$row['cancha'],
                           'fecha'=>$row['fecha'],
                           'fechajuego'=>$row['fechajuego'],
                           'arbitro'=>$row['arbitro'],
                           'goleslocal'=>$row['goleslocal'],
                           'golesvisitantes'=>$row['golesvisitantes']
                        ));
	}


echo $token.'('.json_encode($ar).');';

?>
