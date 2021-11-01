<?php

session_start();

include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesView.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();
$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosView  		= new ServiciosView();

$tabla = $_GET['tabla'];
$draw = $_GET['sEcho'];
$start = $_GET['iDisplayStart'];
$length = $_GET['iDisplayLength'];
$busqueda = $_GET['sSearch'];

$idcliente = 0;

if (isset($_GET['idcliente'])) {
	$idcliente = $_GET['idcliente'];
} else {
	$idcliente = 0;
}


$referencia1 = 0;

if (isset($_GET['referencia1'])) {
	$referencia1 = $_GET['referencia1'];
} else {
	$referencia1 = 0;
}

$colSort = (integer)$_GET['iSortCol_0'] + 2;
$colSortDir = $_GET['sSortDir_0'];

function armarAcciones($id,$label='',$class,$icon) {
	$cad = "";

	for ($j=0; $j<count($class); $j++) {
		$cad .= '<button type="button" class="btn '.$class[$j].' '.$label[$j].'" id="'.$id.'">
				<i class="material-icons">'.$icon[$j].'</i>
			</button> ';
	}

	return $cad;
}

switch ($tabla) {

	case 'usuarios':

		if ($_SESSION['idroll_predio'] != 1) {
			
			$datos = $serviciosView->traerUsuariosSimpleAjax($length, $start, $busqueda, $colSort,$colSortDir);
		} else {
			
			$datos = $serviciosView->traerUsuariosAjax($length, $start, $busqueda, $colSort,$colSortDir);
		}
		
		$label = array('varmodificar','varborrar');
		$class = array('btn-warning','btn-danger');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 8;

		$resAjax = $datos[0];
		$res = $datos[1];

	break;

	case 'arbitros':
		$datos = $serviciosView->traerArbitrosAjax($length, $start, $busqueda, $colSort,$colSortDir);
		
		$label = array('varmodificar','varborrar');
		$class = array('btn-warning','btn-danger');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 7;

		$resAjax = $datos[0];
		$res = $datos[1];

	break;


	default:
		// code...
		break;
}


$cantidadFilas = mysql_num_rows($res);


header("content-type: Access-Control-Allow-Origin: *");

$ar = array();
$arAux = array();
$cad = '';
$id = 0;
	while ($row = mysql_fetch_array($resAjax)) {
		//$id = $row[$indiceID];

		for ($i=$empieza;$i<=$termina;$i++) {
			array_push($arAux, utf8_encode($row[$i]));
		}

		array_push($arAux, armarAcciones($row[0],$label,$class,$icon));

		array_push($ar, $arAux);

		$arAux = array();
		//die(var_dump($ar));
	}

$cad = substr($cad, 0, -1);

$data = '{ "sEcho" : '.$draw.', "iTotalRecords" : '.$cantidadFilas.', "iTotalDisplayRecords" : 10, "aaData" : ['.$cad.']}';

//echo "[".substr($cad,0,-1)."]";
echo json_encode(array(
			"draw"            => $draw,
			"recordsTotal"    => $cantidadFilas,
			"recordsFiltered" => $cantidadFilas,
			"data"            => $ar
		));

?>
