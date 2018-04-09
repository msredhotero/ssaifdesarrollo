<?php

date_default_timezone_set('America/Buenos_Aires');

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');

require_once '../excelClass/PHPExcel.php';

$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 			= new ServiciosReferencias();

$fecha = date('Y-m-d');


//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

////***** Parametros ****////////////////////////////////

/*
$idtorneo			=	$_GET['reftorneo3'];
$reffechas			=	$_GET['reffechas3'];
$refCategorias		=	$_GET['refcategorias1'];
$refDivisiones		=	$_GET['refdivision1'];
*/
$idtemporada		=	'';
$idtorneo			=	'';
$refCategorias		=	'';
$refDivisiones		=	'';

$where = '';
$whereAux = '';
if (($_GET['reftemporada1'] != 0) && (isset($_GET['reftemporada1']))) {
	$where .= " and tep.idtemporadas = ".$_GET['reftemporada1'];
}


if (($_GET['refcategorias1'] != 0) && (isset($_GET['refcategorias1']))) {
	$where .= " and tor.refcategorias = ".$_GET['refcategorias1'];
}

if (($_GET['refdivision1'] != 0) && (isset($_GET['refdivision1']))) {
	$where .= " and tor.refdivisiones = ".$_GET['refdivision1'];
}


if (($_GET['filtropartidos'] != 0) && (isset($_GET['filtropartidosvalor']))) {
	switch ($_GET['filtropartidos']) {
		case 1:
			$whereAux .= ' and r.partidos > '.$_GET['filtropartidosvalor'];
			break;
		case 2:
			$whereAux .= ' and r.partidos < '.$_GET['filtropartidosvalor'];
			break;
		case 3:
			$whereAux .= ' and r.partidos = '.$_GET['filtropartidosvalor'];
			break;
		case 4:
			$whereAux .= ' and r.partidos between '.$_GET['filtropartidosvalor'].' and '.$_GET['filtropartidosvalor2'];
			break;
	}
}


if (($_GET['filtroamarillas'] != 0) && (isset($_GET['filtroamarillasvalor']))) {
	switch ($_GET['filtroamarillas']) {
		case 1:
			$whereAux .= ' and coalesce(r.amarillas,0) > '.$_GET['filtroamarillasvalor'];
			break;
		case 2:
			$whereAux .= ' and coalesce(r.amarillas,0) < '.$_GET['filtroamarillasvalor'];
			break;
		case 3:
			$whereAux .= ' and coalesce(r.amarillas,0) = '.$_GET['filtroamarillasvalor'];
			break;
		case 4:
			$whereAux .= ' and coalesce(r.amarillas,0) between '.$_GET['filtroamarillasvalor'].' and '.$_GET['filtroamarillasvalor2'];
			break;
	}
}


if (($_GET['filtrorojas'] != 0) && (isset($_GET['filtrorojasvalor']))) {
	switch ($_GET['filtrorojas']) {
		case 1:
			$whereAux .= ' and coalesce(r.rojas,0) > '.$_GET['filtrorojasvalor'];
			break;
		case 2:
			$whereAux .= ' and coalesce(r.rojas,0) < '.$_GET['filtrorojasvalor'];
			break;
		case 3:
			$whereAux .= ' and coalesce(r.rojas,0) = '.$_GET['filtrorojasvalor'];
			break;
		case 4:
			$whereAux .= ' and coalesce(r.rojas,0) between '.$_GET['filtrorojasvalor'].' and '.$_GET['filtrorojasvalor2'];
			break;
	}
}



if (($_GET['filtrofechaalta'] != 0) && (isset($_GET['filtrofechaaltavalor']))) {
	switch ($_GET['filtrofechaalta']) {
		case 1:
			$where .= " and jug.fechaalta > '".$_GET['filtrofechaaltavalor']."'";
			break;
		case 2:
			$where .= " and jug.fechaalta < '".$_GET['filtrofechaaltavalor']."'";
			break;
		case 3:
			$where .= " and jug.fechaalta = '".$_GET['filtrofechaaltavalor']."'";
			break;
		case 4:
			$where .= " and jug.fechaalta between '".$_GET['filtrofechaaltavalor']."' and '".$_GET['filtrofechaaltavalor2']."'";
			break;
	}
}


if (($_GET['filtrofechanacimiento'] != 0) && (isset($_GET['filtrofechanacimientovalor']))) {
	switch ($_GET['filtrofechanacimiento']) {
		case 1:
			$where .= " and jug.fechanacimiento > '".$_GET['filtrofechanacimientovalor']."'";
			break;
		case 2:
			$where .= " and jug.fechanacimiento < '".$_GET['filtrofechanacimientovalor']."'";
			break;
		case 3:
			$where .= " and r.fechanacimiento = '".$_GET['filtrofechanacimientovalor']."'";
			break;
		case 4:
			$where .= " and jug.fechanacimiento between '".$_GET['filtrofechanacimientovalor']."' and '".$_GET['filtrofechanacimientovalor2']."'";
			break;
	}
}



if (($_GET['filtroedad'] != 0) && (isset($_GET['filtroedadvalor']))) {
	switch ($_GET['filtroedad']) {
		case 1:
			$where .= ' and year(now()) - year(jug.fechanacimiento) > '.$_GET['filtroedadvalor'];
			break;
		case 2:
			$where .= ' and year(now()) - year(jug.fechanacimiento) < '.$_GET['filtroedadvalor'];
			break;
		case 3:
			$where .= ' and year(now()) - year(jug.fechanacimiento) = '.$_GET['filtroedadvalor'];
			break;
		case 4:
			$where .= ' and year(now()) - year(jug.fechanacimiento) between '.$_GET['filtroedadvalor'].' and '.$_GET['filtroedadvalor2'];
			break;
	}
}


if (($_GET['filtrominutos'] != 0) && (isset($_GET['filtrominutosvalor']))) {
	switch ($_GET['filtrominutos']) {
		case 1:
			$whereAux .= ' and coalesce(r.minutos,0) > '.$_GET['filtrominutosvalor'];
			break;
		case 2:
			$whereAux .= ' and coalesce(r.minutos,0) < '.$_GET['filtrominutosvalor'];
			break;
		case 3:
			$whereAux .= ' and coalesce(r.minutos,0) = '.$_GET['filtrominutosvalor'];
			break;
		case 4:
			$whereAux .= ' and coalesce(r.minutos,0) between '.$_GET['filtrominutosvalor'].' and '.$_GET['filtrominutosvalor2'];
			break;
	}
}



if (($_GET['filtromejorjugador'] != 0) && (isset($_GET['filtromejorjugadorvalor']))) {
	switch ($_GET['filtromejorjugador']) {
		case 1:
			$whereAux .= ' and coalesce(r.mejorjugador,0) > '.$_GET['filtromejorjugadorvalor'];
			break;
		case 2:
			$whereAux .= ' and coalesce(r.mejorjugador,0) < '.$_GET['filtromejorjugadorvalor'];
			break;
		case 3:
			$whereAux .= ' and coalesce(r.mejorjugador,0) = '.$_GET['filtromejorjugadorvalor'];
			break;
		case 4:
			$whereAux .= ' and coalesce(r.mejorjugador,0) between '.$_GET['filtromejorjugadorvalor'].' and '.$_GET['filtromejorjugadorvalor2'];
			break;
	}
}


/////////////////////////////  fin parametross  ///////////////////////////

$resDatos = $serviciosReferencias->traerEstadisticaJugadorPorCategoria($where, $whereAux);
//die(print_r($resDatos));

// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();




$objPHPExcel->getProperties()
->setCreator("Exebin")
->setLastModifiedBy("Exebin")
->setTitle("Documento Excel")
->setSubject("Documento Excel")
->setDescription("Documento Excel Estadisticas Jugadores Por Categorias.")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Excel");
 
$tituloReporte = "Estadisticas Jugadores Por Categorias";
$tituloReporte2 = "Fecha: ".date('Y-m-d');
$titulosColumnas = array("Categoria","Division","Club","Nro.Doc.","Jugador", "Equipos", "Fecha Alta","Fecha Nac.", "Edad", "Goles a Favor", "Amonestaciones", "Expulsiones", "Mejor Jugador", "Partidos Jugados", "Minutos Jugados");

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:O1');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A2:O2');

	
	 
// Se agregan los titulos del reporte
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', htmlspecialchars(utf8_encode($tituloReporte))) // Titulo del reporte
	->setCellValue('A2', utf8_encode($tituloReporte2))
	
    ->setCellValue('A3',  utf8_encode($titulosColumnas[0]))  //Titulo de las columnas
    ->setCellValue('B3',  utf8_encode($titulosColumnas[1]))
    ->setCellValue('C3',  utf8_encode($titulosColumnas[2]))
    ->setCellValue('D3',  utf8_encode($titulosColumnas[3]))
	->setCellValue('E3',  utf8_encode($titulosColumnas[4]))
	->setCellValue('F3',  utf8_encode($titulosColumnas[5]))
	->setCellValue('G3',  utf8_encode($titulosColumnas[6]))
	->setCellValue('H3',  utf8_encode($titulosColumnas[7]))
	->setCellValue('I3',  utf8_encode($titulosColumnas[8]))
	->setCellValue('J3',  utf8_encode($titulosColumnas[9]))
	->setCellValue('K3',  utf8_encode($titulosColumnas[10]))
	->setCellValue('L3',  utf8_encode($titulosColumnas[11]))
	->setCellValue('M3',  utf8_encode($titulosColumnas[12]))
	->setCellValue('N3',  utf8_encode($titulosColumnas[13]))
	->setCellValue('O3',  utf8_encode($titulosColumnas[14]));


// Agregar Informacion
/*$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Valor 1')
->setCellValue('B1', 'Valor 2')
->setCellValue('C1', 'Total')
->setCellValue('A2', '10')
->setCellValue('C2', '=sum(A2:B2)');*/
/*
"Categoria","Division","Club","Nro.Doc.","Jugador", "Equipos", "Fecha Alta","Fecha Nac.", "Edad", "Goles a Favor", "Amonestaciones", "Expulsiones", "Mejor Jugador", "Partidos Jugados", "Minutos Jugados"
*/
$i = 4; //Numero de fila donde se va a comenzar a rellenar
 while ($fila = mysql_fetch_array($resDatos)) {

     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, ($fila['categoria']))
         ->setCellValue('B'.$i, ($fila['division']))
         ->setCellValue('C'.$i, ($fila['country']))
         ->setCellValue('D'.$i, ($fila['nrodocumento']))
		 ->setCellValue('E'.$i, ($fila['apyn']))
		 ->setCellValue('F'.$i, ($fila['equipo']))
		 ->setCellValue('G'.$i, ($fila['fechaalta']))
		 ->setCellValue('H'.$i, ($fila['fechanacimiento']))
		 ->setCellValue('I'.$i, ($fila['edad']))
		 ->setCellValue('J'.$i, ($fila['goles'] + $fila['pc']))
		 ->setCellValue('K'.$i, ($fila['amarillas']))
		 ->setCellValue('L'.$i, ($fila['rojas']))
		 ->setCellValue('M'.$i, ($fila['mejorjugador']))
		 ->setCellValue('N'.$i, ($fila['partidos']))
		 ->setCellValue('O'.$i, ($fila['minutos']));
     $i++;

 }


$estiloTituloReporte = array(
    'font' => array(
        'name'      => 'Verdana',
        'bold'      => true,
        'italic'    => false,
        'strike'    => false,
        'size' =>16,
        'color'     => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'argb' => '0B87A9')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    )
);
 
$estiloTituloColumnas = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'color' => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
        'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
    'rotation'   => 90,
        'startcolor' => array(
            'rgb' => '1ACEFF'
        ),
        'endcolor' => array(
            'argb' => '0AA3CE'
        )
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        )
    ),
    'alignment' =>  array(
        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => TRUE
    )
);
 
$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray( array(
    'font' => array(
        'name'  => 'Arial',
        'color' => array(
            'rgb' => '000000'
        )
    ),
    'fill' => array(
    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
    'color' => array(
            'argb' => 'B8FEFF')
    ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
        'color' => array(
                'rgb' => '2A4348'
            )
        )
    )
));

$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A2:O2')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A3:O3')->applyFromArray($estiloTituloColumnas);

// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
 
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);
 
// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="rptEstadisticasJugadoresPorCategoria.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;


?>

