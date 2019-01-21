<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesCopia.php');
include ('../includes/funcionesDelegados.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();
$serviciosCopia				= new ServiciosCopia();
$serviciosDelegados				= new serviciosDelegados();

$accion = $_POST['accion'];


	switch ($accion) {
		case 'modificarEstadoCabecera':
			modificarEstadoCabecera($serviciosDelegados);
		break;
		case 'modificarEstadoEquiposDelegados':
			modificarEstadoEquiposDelegados($serviciosDelegados);
		break;

		case 'armarTable':
			armarTable($serviciosDelegados, $serviciosReferencias, $serviciosFunciones);
		break;
		case 'aprobarMasivoEquiposDelagados':
			aprobarMasivoEquiposDelagados($serviciosDelegados);
		break;
		case 'modificarEstadoFusion':
			modificarEstadoFusion($serviciosDelegados);
		break;
	}

	function modificarEstadoFusion($serviciosDelegados) {
		$id = $_POST['id'];
		$idestado = $_POST['idestado'];

		$res = $serviciosDelegados->modificarEstadoFusion($id, $idestado);

		echo '';
	}

	function aprobarMasivoEquiposDelagados($serviciosDelegados) {
		$id = $_POST['idcabecera'];
		$idestado = $_POST['idestado'];

		$res = $serviciosDelegados->aprobarMasivoEquiposDelagados($id,$idestado);

		$verificar = $serviciosDelegados->verificarAprobadoCompletoFase1($id);
		echo '';
	}


	function modificarEstadoEquiposDelegados($serviciosDelegados) {
		$id = $_POST['id'];
		$idestado = $_POST['idestado'];

		$res = $serviciosDelegados->modificarEstadoEquiposDelegados($id, $idestado);

		$verificar = $serviciosDelegados->verificarAprobadoCompletoFase1($id);

		echo '';
	}


	function modificarEstadoCabecera($serviciosDelegados) {
		$id = $_POST['id'];
		$idestado = $_POST['idestado'];

		$res = $serviciosDelegados->modificarCabeceraconfirmacionEstado($id, $idestado);

		$verificar = $serviciosDelegados->verificarAprobadoCompletoFase1($id);

		echo '';
	}
 /*
 glyphicon-search
glyphicon-pencil
 */
	function armarDropDown($id, $modal='', $label, $class, $icon='') {
		$cad = '<td>
					<div class="btn-group">
						<button class="btn btn-success" type="button">Acciones</button>

						<button class="btn btn-success dropdown-toggle" data-toggle="dropdown" type="button">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
						</button>

						<ul class="dropdown-menu" role="menu">';

		for ($j=0; $j<count($label); $j++) {
			$cad .= '<li>
							<a href="javascript:void(0)" class="'.$class[$j].'" id="'.$id.'"><span class="glyphicon '.$icon[$j].'"></span> '.$label[$j].'</a>
							</li>';
		}



		$cad .= '				</ul>
					</div>
				</td>';

		return $cad;
	}

	function armarTable($serviciosDelegados, $serviciosReferencias, $serviciosFunciones) {
		$dato = $_POST['dato'];

		$cabecerasdatos = explode(',', $_POST['cabecerasdatos']);

		$id = $_POST['id'];

		if  (isset($_POST['param1'])) {
			$param1 = $_POST['param1'];
		}

		if  (isset($_POST['param2'])) {
			$param2 = $_POST['param2'];
		}

		switch ($dato) {
			case 'cabeceras':
				$res = $serviciosDelegados->traerCabeceraconfirmacionGrid();
				$label = array('Modificar Estado','Ver');
				$class = array('varmodificarestado','varver');
				$icon = array('glyphicon-pencil','glyphicon-search');
				break;
			case 'equiposdelegados':
				$res = $serviciosDelegados->traerEquiposdelegadosPorCountrieFinalizado($param1, $param2);
				$label = array('Modificar Estado','Ver','Fusion');
				$class = array('varmodificarestado','varver','varfusion');
				$icon = array('glyphicon-pencil','glyphicon-search','glyphicon-paperclip');
				break;
			case 'fusiones':
				$res = $serviciosDelegados->traerFusionesPorEquipo($param1);
				$label = array('Modificar Estado');
				$class = array('varmodificarestado');
				$icon = array('glyphicon-pencil');
				break;
			default:
				# code...
				break;
		}

		$cad = '';

		while ($row = mysql_fetch_array($res)) {

			$cad .= '<tr>';
			for ($i=0; $i<count($cabecerasdatos); $i++) {
				$cad .= '<td>'.$row[$cabecerasdatos[$i]].'</td>';
			}
			$cad .= armarDropDown($row[$id], '', $label, $class, $icon);


		}

		echo $cad;
	}



?>
