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
	$resDatos = $serviciosReferencias->PosicionesConformada(mysql_result($resTorneo,0,'reftemporadas'),mysql_result($resTorneo,0,'refcategorias'),mysql_result($resTorneo,0,'refdivisiones'));

} else {
	$resDatos = $serviciosReferencias->PosicionesConformada(0,0,0);

}


$token = $_GET['callback'];
/*
foreach ($resDatos as $row) {
echo $row['idequipo'].'<br>';
}
*/

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$i = 1;
$arResultados = array('','','');
$k = 0;
$y = 0;

	foreach ($resDatos as $row) {

		//traigo los ultimos tres partidos
		$resResultadosAnteriores = $serviciosReferencias->ResultadosPartidosAnterioresPorCategoriaDivision(mysql_result($resTorneo,0,'refcategorias'),mysql_result($resTorneo,0,'refdivisiones') , $row['idequipo']);
		//die(print_r($resResultadosAnteriores));
		//completo los arrays con los resultados
		while ($rowR = mysql_fetch_array($resResultadosAnteriores)) {
			$arResultados[$k] = $rowR['resultado'];
			$k += 1;
		}

		//obtengo el indice de la fecha anterior
		//$indice = array_search($row['idequipo'],$resDatosExtra['idequipo'],true);
		/*
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
		*/


		if (($y == 2) || ($y == 3)) {
			array_push($ar,array('posicion'=>$i, 'equipos'=>$row['equipo'],'pts'=>$row['puntos'],'ptsb'=>$row['puntobonus'],'ptsn'=>$row['puntos'] - $row['puntobonus'],'pj'=>$row['pj'],'pg'=>$row['pg'],'pe'=>$row['pe'],'pp'=>$row['pp'],'gf'=>$row['goles'],'gc'=>$row['golescontra'],'amonestados'=>$row['amarillas'],'expulsados'=>$row['rojas'],'ultimoresultado1'=>$arResultados[0],'ultimoresultado2'=>$arResultados[1],'ultimoresultado3'=>$arResultados[2], 'asterisco'=>1, 'observacion'=> 'Se suspende el partido por lluevia', 'idequipo'=>$row['idequipo']));
		} else {
			array_push($ar,array('posicion'=>$i, 'equipos'=>$row['equipo'],'pts'=>$row['puntos'],'ptsb'=>$row['puntobonus'],'ptsn'=>$row['puntos'] - $row['puntobonus'],'pj'=>$row['pj'],'pg'=>$row['pg'],'pe'=>$row['pe'],'pp'=>$row['pp'],'gf'=>$row['goles'],'gc'=>$row['golescontra'],'amonestados'=>$row['amarillas'],'expulsados'=>$row['rojas'],'ultimoresultado1'=>$arResultados[0],'ultimoresultado2'=>$arResultados[1],'ultimoresultado3'=>$arResultados[2], 'asterisco'=>0, 'observacion'=> $row['observacionesgenerales'], 'idequipo'=>$row['idequipo']));
		}
		$i += 1;

	}

//echo "[".substr($cadJugadores,0,-1)."]";
echo $token.'('.json_encode($ar).');';
//die(var_dump($ar));

?>
