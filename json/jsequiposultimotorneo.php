<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0)) {
	$resTorneo = $serviciosReferencias->traerTorneosPorEquipo($_GET['idequipo']);
} else {
	$resTorneo = $serviciosReferencias->traerTorneosPorEquipo(0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
$i = 1;
	while ($row = mysql_fetch_array($resTorneo)) {
		if ($i == 2) {
			break;	
		}
		
		array_push($ar,array('idtorneo'=> $row[0], 'idtemporada'=> $row['reftemporadas'], 'idcategoria'=> $row['refcategorias'], 'iddivision'=> $row['refdivisiones']));
						
		$i += 1;

	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';
?>