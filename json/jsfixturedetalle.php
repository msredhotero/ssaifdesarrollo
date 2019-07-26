<?php


include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesReferenciasRemoto.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();
$serviciosReferenciasRemoto 	= new ServiciosReferenciasRemoto();

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

$refEstadoPartido = 0;
$idEstadoPartido = 0;
$resFixture = 0;
$golesAfavor = 0;
$golesAdescontar = 0;
$esDefinicionAutomatica = 0;

$ladoGanador = 0;

if ((isset($_GET['idfixture'])) && ($_GET['idfixture'] > 0)) {
	if ((isset($_GET['idtorneo'])) && ($_GET['idtorneo'] > 0)) {
		$resTorneo = $serviciosReferencias->traerTorneosPorId($_GET['idtorneo']);
		if (mysql_num_rows($resTorneo) > 0) {
			$resTraerDatos = $serviciosReferencias->traerInicidenciasPorFixtureDetalle($_GET['idfixture']);


		} else {
			$resTraerDatos = $serviciosReferenciasRemoto->traerInicidenciasPorFixtureDetalle($_GET['idfixture']);
		}
	} else {
		$resTraerDatos = $serviciosReferencias->traerInicidenciasPorFixtureDetalle($_GET['idfixture']);

		$resFixture = $serviciosReferencias->traerFixturePorId($_GET['idfixture']);

		$idEstadoPartido = mysql_result($resFixture,0,'refestadospartidos');

		$refEstadoPartido = $serviciosReferencias->traerEstadospartidosPorId($idEstadoPartido);
		if ( mysql_result($refEstadoPartido,0,'defautomatica') == 'Si') {

			$esDefinicionAutomatica = 1;
			$golesAfavor = 2;
			$golesAdescontar = 1;
			if (mysql_result($refEstadoPartido, 0,'puntoslocal') == 3) {
				$ladoGanador = 1;
			} else {
				if (mysql_result($refEstadoPartido, 0,'puntosvisitante') == 3) {
					$ladoGanador = 2;
				} else {
					$ladoGanador = 0;
					$golesAfavor = 0;
					$golesAdescontar = 1;
				}
			}
		} else {
			$esDefinicionAutomatica = 0;
		}
	}

} else {
	$resTraerDatos = $serviciosReferencias->traerInicidenciasPorFixtureDetalle(0);
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$golesL = 0;
$golesV = 0;

$cad = '';
	while ($row = mysql_fetch_array($resTraerDatos)) {

		if ($row['localia'] == 'local') {
			$golesL += $row['goles'];
		} else {
			$golesV += $row['goles'];
		}


		array_push($ar,array('jugador'=> $row['apyn'],
							'goles'=> $row['goles'],
							'encontra'=> $row['encontra'],
							'amonestados'=> $row['amarillas'],
							'expulsados'=> $row['rojas'],
							'informados'=> $row['informados'],
							'dobleamarilla'=> $row['dobleamarilla'],
							'penalesconvertidos'=> $row['pc'],
							'golesvisitantes'=> 0, //$row['golesvisitantes']
							'localia'=> $row['localia'],
							'idjugador'=>$row['refjugadores'],
							'pcd'=>$row['pcd'],
							'ped'=>$row['ped'],
							'od'=>$row['od']
						));


	}


	if (($esDefinicionAutomatica == 1) && ($ladoGanador == 1) && $golesL < 2)
	{

		array_push($ar,array('jugador'=> 'Sin informar',
						'goles'=> 2 - $golesL,
						'encontra'=> 0,
						'amonestados'=> 0,
						'expulsados'=> 0,
						'informados'=> 0,
						'dobleamarilla'=> 0,
						'penalesconvertidos'=> 0,
						'golesvisitantes'=> 0,
						'localia'=> 'local',
						'idjugador'=>0));
	}


	if (($esDefinicionAutomatica == 1) && ($ladoGanador == 2) && $golesV < 2)
	{

		array_push($ar,array('jugador'=> 'Sin informar',
						'goles'=> 2 - $golesV,
						'encontra'=> 0,
						'amonestados'=> 0,
						'expulsados'=> 0,
						'informados'=> 0,
						'dobleamarilla'=> 0,
						'penalesconvertidos'=> 0,
						'golesvisitantes'=> 0,
						'localia'=> 'visitante',
						'idjugador'=>0));
	}

//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';
?>
