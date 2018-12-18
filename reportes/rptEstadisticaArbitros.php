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

require('fpdf.php');

//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

////***** Parametros ****////////////////////////////////
$idTemporada		=	$_GET['reftemporada1'];
/////////////////////////////  fin parametross  ///////////////////////////



// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();


$resTemporadas = $serviciosReferencias->traerTemporadasPorId($idTemporada);

$fpartidos = '';
$famarillas = '';
$frojas = '';

$fpartidosvalor = '';
$famarillasvalor = '';
$frojasvalor = '';

$where  = '';

if (($_GET['filtropartidos'] != 0) && (isset($_GET['filtropartidosvalor']))) {
	switch ($_GET['filtropartidos']) {
		case 1:
			$where .= ' and r.cantidad > '.$_GET['filtropartidosvalor'];
			break;
		case 2:
			$where .= ' and r.cantidad < '.$_GET['filtropartidosvalor'];
			break;
		case 3:
			$where .= ' and r.cantidad = '.$_GET['filtropartidosvalor'];
			break;
		case 4:
			$where .= ' and r.cantidad between '.$_GET['filtropartidosvalor'].' and '.$_GET['filtropartidosvalor2'];
			break;
	}
}


if (($_GET['filtroamarillas'] != 0) && (isset($_GET['filtroamarillasvalor']))) {
	switch ($_GET['filtroamarillas']) {
		case 1:
			$where .= ' and coalesce(r.amarillas,0) > '.$_GET['filtroamarillasvalor'];
			break;
		case 2:
			$where .= ' and coalesce(r.amarillas,0) < '.$_GET['filtroamarillasvalor'];
			break;
		case 3:
			$where .= ' and coalesce(r.amarillas,0) = '.$_GET['filtroamarillasvalor'];
			break;
		case 4:
			$where .= ' and coalesce(r.amarillas,0) between '.$_GET['filtroamarillasvalor'].' and '.$_GET['filtroamarillasvalor2'];
			break;
	}
}


if (($_GET['filtrorojas'] != 0) && (isset($_GET['filtrorojasvalor']))) {
	switch ($_GET['filtrorojas']) {
		case 1:
			$where .= ' and coalesce(r.rojas,0) > '.$_GET['filtrorojasvalor'];
			break;
		case 2:
			$where .= ' and coalesce(r.rojas,0) < '.$_GET['filtrorojasvalor'];
			break;
		case 3:
			$where .= ' and coalesce(r.rojas,0) = '.$_GET['filtrorojasvalor'];
			break;
		case 4:
			$where .= ' and coalesce(r.rojas,0) between '.$_GET['filtrorojasvalor'].' and '.$_GET['filtrorojasvalor2'];
			break;
	}
}


$resDatos = $serviciosReferencias->traerEstadisticaArbitrosPorTemporadaExcelWhere($idTemporada, $where);

//die(print_r($resDatos));
//echo $resEquipos;

$nombre 	= mysql_result($resTemporadas,0,'temporada');



$objPHPExcel->getProperties()
->setCreator("Exebin")
->setLastModifiedBy("Exebin")
->setTitle("Documento Excel")
->setSubject("Documento Excel")
->setDescription("Documento Excel Habilitaciones Transitorias.")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Excel");
 
$tituloReporte = "Est. Arbitro";
$tituloReporte2 = "Temporada: ".$nombre;
$titulosColumnas = array("Id Arbitro", "Nombre Completo","Nro Partido","Categoria","Division","Partido", "Amarillas","Rojas", "Porc. Amarillas","Porc. Rojas");

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:J1');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A2:J2');

	
	 
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
    ->setCellValue('J3',  utf8_encode($titulosColumnas[9]));


// Agregar Informacion
/*$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Valor 1')
->setCellValue('B1', 'Valor 2')
->setCellValue('C1', 'Total')
->setCellValue('A2', '10')
->setCellValue('C2', '=sum(A2:B2)');*/

$i = 4; //Numero de fila donde se va a comenzar a rellenar
$idarbitro = 0;
$primero = 0;
$amarillas = 0;
$rojas = 0;
$partidos = 0;


 while ($fila = mysql_fetch_array($resDatos)) {
    if ($idarbitro != $fila[0]) {
        $idarbitro = $fila[0];
        if ($primero != 0) {
            $objPHPExcel->setActiveSheetIndex(0)
                         ->setCellValue('A'.$i, '')
                         ->setCellValue('B'.$i, '')
                         ->setCellValue('C'.$i, '')
                         ->setCellValue('D'.$i, '')
                         ->setCellValue('E'.$i, '')
                         ->setCellValue('F'.$i, $partidos)
                         ->setCellValue('G'.$i, $amarillas)
                         ->setCellValue('H'.$i, $rojas)
                         ->setCellValue('I'.$i, ($amarillas / $partidos) )
                         ->setCellValue('J'.$i, ($rojas / $partidos) );

            $i++;
        }
        $primero = 1;
        $amarillas = 0;
        $rojas = 0;
        $partidos = 0;
    }
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, ($fila[0]))
         ->setCellValue('B'.$i, ($fila[1]))
         ->setCellValue('C'.$i, ($fila[2]))
         ->setCellValue('D'.$i, ($fila[5]))
         ->setCellValue('E'.$i, ($fila[6]))
         ->setCellValue('F'.$i, ($fila[7].' vs '.$fila[8]))
         ->setCellValue('G'.$i, ($fila[3]))
         ->setCellValue('H'.$i, ($fila[4]));
     $i++;

    $partidos++;
    $amarillas += $fila[3];
    $rojas += $fila[4];

 }

 $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue('A'.$i, '')
             ->setCellValue('B'.$i, '')
             ->setCellValue('C'.$i, '')
             ->setCellValue('D'.$i, '')
             ->setCellValue('E'.$i, '')
             ->setCellValue('F'.$i, $partidos)
             ->setCellValue('G'.$i, $amarillas)
             ->setCellValue('H'.$i, $rojas)
             ->setCellValue('I'.$i, ($amarillas / $partidos) )
             ->setCellValue('J'.$i, ($rojas / $partidos) );


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

$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->applyFromArray($estiloTituloColumnas);

// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
 
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);
 
// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="rptEstadisticaArbitro.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;


?>

