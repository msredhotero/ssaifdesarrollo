<?php

include ('includes/funciones.php');
include ('includes/funcionesUsuarios.php');
include ('includes/funcionesHTML.php');
include ('includes/funcionesReferencias.php');
include ('includes/funcionesDelegados.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$serviciosDelegados 	= new serviciosDelegados();


$id = 7;

$resEquipo = $serviciosDelegados->traerEquiposdelegadosPorId($id);

$sql = '';
$sqlIDjug = '';
$sqlConector = '';

	if ((mysql_result($resEquipo,0,'activo') == 'Si') && (mysql_result($resEquipo,0,'nuevo') == 'Si')) {
		// inserto todos los conectores sin los jugadores nuevos
		//$resInsertarConectores = $serviciosDelegados->insertarConectorMasivo(mysql_result($resEquipo,0,'idequipo'), mysql_result($resEquipo,0,'reftemporadas'));

		// traigo todos los jugadores nuevos del plantel y los inserto en jugadores
		$resJugadoresNuevos = $serviciosDelegados->traerJugadoresPreConectores(mysql_result($resEquipo,0,'idequipo'), mysql_result($resEquipo,0,'reftemporadas'));
		while ($row = mysql_fetch_array($resJugadoresNuevos)) {
			if ($serviciosDelegados->existeJugador($row['nrodocumento']) == 0) {
				
				$resIJ = $serviciosDelegados->insertarJugadorDocumentacionValores($row['refjugadorespre']);

				$sql .= $row['refjugadorespre']." <br><br>

				";

				$sqlIDjug .= $resIJ." <br>";
				
				$resConector = $serviciosDelegados->insertarConectorPorJugadorPre($row['refjugadorespre'], $resIJ, mysql_result($resEquipo,0,'reftemporadas'));
				$sqlConector .= $resConector.' <br>';
			} else {
				$sql .= 'nada <br><br>';
				//$serviciosDelegados->insertarConectorPorJugadorPre($row['refjugadorespre'], $resIJ, mysql_result($resEquipo,0,'reftemporadas'));
			}

		}

		echo "ID insert: ".$sql;
		echo "ID insert jugadores: ".$sqlIDjug;
		echo "ID insert conectores: ".$sqlConector;
	}


?>