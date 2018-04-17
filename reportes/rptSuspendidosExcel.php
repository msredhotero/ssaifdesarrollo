<?php

session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../../error.php');
} else {
	
date_default_timezone_set('America/Buenos_Aires');

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');

require_once '../excelClass/PHPExcel.php';

$serviciosUsuarios          = new ServiciosUsuarios();
$serviciosFunciones         = new Servicios();
$serviciosHTML              = new ServiciosHTML();
$serviciosReferencias           = new ServiciosReferencias();

$fecha = date('Y-m-d');


//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");



//////////////////              PARA LAS FECHAS        /////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$datos		=	$serviciosReferencias->suspendidosTotal();

$datosP		=	$serviciosReferencias->traerSancionesJugadoresPendientesConFallos();
//$datosP		=	$serviciosReferencias->traerSancionesJugadoresPendientesConFallos();
// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();




$objPHPExcel->getProperties()
->setCreator("Exebin")
->setLastModifiedBy("Exebin")
->setTitle("Documento Excel")
->setSubject("Documento Excel")
->setDescription("Documento Excel Suspendidos.")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Excel");
 
$tituloReporte = "Suspendidos";
$tituloReporte2 = "Fecha: ".date('Y-m-d');
$titulosColumnas = array("Countrie", "Nro.Doc.", "Apellido y Nombre","Torneo", "Partido", "Equipo", "Fecha","Cant.Fechas","Cumplidas","Categoria");

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:G1');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A2:G2');

	
	 
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
 while ($fila = mysql_fetch_array($datos)) {
    $tipoSancion = '';
    $valor = 0;

    if ($fila[8] > 0) {
        $tipoSancion = $fila[8].' dias';
    } else {
        $tipoSancion = $fila[7].' fechas';
    }

    if ($fila[8] > 0) {
        $valor = $fila[10].' dias';
    } else {
        $valor = $fila[9].' fechas';
    }

	if ($fila[7] != $fila[9]) {
     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, ($fila[0]))
         ->setCellValue('B'.$i, ($fila[1]))
         ->setCellValue('C'.$i, ($fila[2]))
         ->setCellValue('D'.$i, ($fila[3]))
		 ->setCellValue('E'.$i, ($fila[4]))
         ->setCellValue('F'.$i, ($fila[5]))
         ->setCellValue('G'.$i, ($fila[6]))
         ->setCellValue('H'.$i, ($tipoSancion))
         ->setCellValue('I'.$i, ($valor))
         ->setCellValue('J'.$i, ($fila[11]));
     $i++;
	}
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


$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A'.$i.':M'.$i);
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i,  'Pendientes');
$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':M'.$i)->applyFromArray($estiloTituloColumnas);
$i++; 

while ($fila = mysql_fetch_array($datosP)) {

     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, ($fila['countrie']))
		 ->setCellValue('B'.$i, ($fila['nrodocumento']))
         ->setCellValue('C'.$i, ($fila['jugador']))
		 ->setCellValue('D'.$i, ($fila['torneo']))
		 ->setCellValue('E'.$i, ($fila['reffixture']))
         ->setCellValue('F'.$i, ($fila['equipo']))
		 ->setCellValue('G'.$i, ($fila['fecha']))
         ->setCellValue('H'.$i, '')
         ->setCellValue('I'.$i, '')
         ->setCellValue('J'.$i, ($fila['categoria']));
	$i++; 
 }


$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->applyFromArray($estiloTituloColumnas);

// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
 
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);
 
// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="rptSuspendidosTotales.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;





















 } 

