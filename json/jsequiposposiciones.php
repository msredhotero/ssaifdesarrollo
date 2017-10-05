<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();



if ((isset($_GET['idequipo'])) && ($_GET['idequipo'] > 0)) {
	$resTorneo = $serviciosReferencias->traerTorneosPorEquipo($_GET['idequipo']);
	//die(var_dump(mysql_result($resTorneo,0,0)));
	if (mysql_num_rows($resTorneo)>0) {
		$resDatos = $serviciosReferencias->Posiciones(mysql_result($resTorneo,0,0));
	} else {
		$resDatos = $serviciosReferencias->Posiciones(0);	
	}
} else {
	$resTraerDatos = $serviciosReferencias->Posiciones(0);	
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();
$arAux = array();

$cad = '';
$i=0;
	foreach ($resDatos as $row) {
		if ($_GET['idequipo'] == $row['idequipo']) {
			$posicion = $i;	
		}
		array_push($ar,array('posicion'=>$i + 1,'equipos'=>$row['equipo'],'pts'=>$row['puntos'],'pj'=>$row['pj'],'id'=>$row['idequipo']));
		$i += 1;
	}

$i -= 1;
if ($posicion == 0) {
	array_push($arAux,$ar[0]);
	array_push($arAux,$ar[1]);
	array_push($arAux,$ar[2]);
	
} else {
	if ($posicion == $i) {
		array_push($arAux,$ar[$i - 2]);
		array_push($arAux,$ar[$i - 1]);
		array_push($arAux,$ar[$i]);
	} else {
		array_push($arAux,$ar[$posicion - 1]);
		array_push($arAux,$ar[$posicion]);
		array_push($arAux,$ar[$posicion + 1]);
	}
}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($arAux).');';

?>