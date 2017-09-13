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
	$resDatos = $serviciosReferencias->Posiciones($_GET['idtorneo']);
	$resDatosExtra = $serviciosReferencias->PosicionFechaAnterior($_GET['idtorneo']);
} else {
	$resDatos = $serviciosReferencias->Posiciones(0);
	$resDatosExtra = $serviciosReferencias->PosicionFechaAnterior(0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$posicion = 0;
$mejora = 0;

$arResultados = array('','','');
$k = 0;

	foreach ($resDatos as $row) {
		//traigo los ultimos tres partidos
		$resResultadosAnteriores = $serviciosReferencias->ResultadosPartidosAnteriores($_GET['idtorneo'], $row['idequipo']);
		//die(print_r($resResultadosAnteriores));
		//completo los arrays con los resultados
		while ($rowR = mysql_fetch_array($resResultadosAnteriores)) {
			$arResultados[$k] = $rowR['resultado'];	
			$k += 1;	
		}
		
		//obtengo el indice de la fecha anterior
		//$indice = array_search($row['idequipo'],$resDatosExtra['idequipo'],true);
		foreach ($resDatosExtra as $rowE) {
			if ($row['idequipo'] == $rowE['idequipo']) {
				if ($rowE['posicion'] == $row['posicion']) {
					$mejora = 0;	
				} else {
					if ($rowE['posicion'] > $row['posicion']) {
						$mejora = 1;	
					} else {
						$mejora = -1;
					}
				}
				break;
			}
		}

		
		array_push($ar,array('posicion'=>$row['posicion'], 'equipos'=>$row['equipo'],'mejora'=>$mejora,'pts'=>$row['puntos'],'ptsb'=>$row['puntobonus'],'ptsn'=>$row['puntos'] - $row['puntobonus'],'pj'=>$row['pj'],'pg'=>$row['pg'],'pe'=>$row['pe'],'pp'=>$row['pp'],'gf'=>$row['goles'],'gc'=>$row['golescontra'],'amonestados'=>$row['amarillas'],'expulsados'=>$row['rojas'],'ultimoresultado1'=>$arResultados[0],'ultimoresultado2'=>$arResultados[1],'ultimoresultado3'=>$arResultados[2], 'asterisco'=>0, 'observacion'=> ''));
		
		
		$arResultados[0] = '';
		$arResultados[1] = '';
		$arResultados[2] = '';
		$k = 0;
		$mejora = 0;
	}

//echo "[".substr($cadJugadores,0,-1)."]";
echo $token.'('.json_encode($ar).');';
//die(var_dump($ar));

?>