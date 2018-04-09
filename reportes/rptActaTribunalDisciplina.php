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

$datos		=	$serviciosReferencias->traerSancionesjugadoresSinFallos();

$datosP		=	$serviciosReferencias->traerSancionesJugadoresPendientesConFallos();

// Crea un nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();




$objPHPExcel->getProperties()
->setCreator("Exebin")
->setLastModifiedBy("Exebin")
->setTitle("Documento Excel")
->setSubject("Documento Excel")
->setDescription("Documento Excel Tribunal Disciplina.")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Excel");
 
$titulosColumnas = array("CATEGORIA", "DIV", "FECHA","ID PARTIDO","FECHA","NRO", "PARTIDO", "VERSUS", "JUGADOR","NRO.DOCUMENTO","EQUIPO","SANCION","MOTIVO","ART","INC");



$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:A2');
	
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('B1:B2');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('C1:C2');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('D1:E1');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('F1:F2');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('G1:G2');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('H1:H2');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('I1:I2');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('J1:J2');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('K1:K2');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('L1:M1');
	
	 
// Se agregan los titulos del reporte

$objPHPExcel->setActiveSheetIndex(0)
	
    ->setCellValue('A1',  utf8_encode($titulosColumnas[0]))  //Titulo de las columnas
    ->setCellValue('B1',  utf8_encode($titulosColumnas[1]))
    ->setCellValue('C1',  utf8_encode($titulosColumnas[2]))
    ->setCellValue('D1',  utf8_encode($titulosColumnas[3]))
	->setCellValue('D2',  utf8_encode($titulosColumnas[4]))
	->setCellValue('E2',  utf8_encode($titulosColumnas[5]))
    ->setCellValue('F1',  utf8_encode($titulosColumnas[6]))
    ->setCellValue('G1',  utf8_encode($titulosColumnas[7]))
    ->setCellValue('H1',  utf8_encode($titulosColumnas[8]))
    ->setCellValue('I1',  utf8_encode($titulosColumnas[9]))
    ->setCellValue('J1',  utf8_encode($titulosColumnas[10]))
	->setCellValue('K1',  utf8_encode($titulosColumnas[11]))
	->setCellValue('L1',  utf8_encode($titulosColumnas[12]))
	->setCellValue('L2',  utf8_encode($titulosColumnas[13]))
	->setCellValue('M2',  utf8_encode($titulosColumnas[14]));


// Agregar Informacion
/*$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'Valor 1')
->setCellValue('B1', 'Valor 2')
->setCellValue('C1', 'Total')
->setCellValue('A2', '10')
->setCellValue('C2', '=sum(A2:B2)');*/

$i = 3; //Numero de fila donde se va a comenzar a rellenar
 while ($fila = mysql_fetch_array($datos)) {

     $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, ($fila['categoria']))
		 ->setCellValue('B'.$i, '')
         ->setCellValue('C'.$i, ($fila['fecha']))
		 ->setCellValue('D'.$i, '')
		 ->setCellValue('E'.$i, '')
         ->setCellValue('F'.$i, ($fila['countrie']))
		 ->setCellValue('G'.$i, '')
         ->setCellValue('H'.$i, ($fila['jugador']))
         ->setCellValue('I'.$i, ($fila['nrodocumento']))
         ->setCellValue('J'.$i, ($fila['equipo']))
		 ->setCellValue('K'.$i, '')
		 ->setCellValue('L'.$i, '')
		 ->setCellValue('M'.$i, '');
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
            'rgb' => '000000'
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
         ->setCellValue('A'.$i, ($fila['categoria']))
		 ->setCellValue('B'.$i, '')
         ->setCellValue('C'.$i, ($fila['fecha']))
		 ->setCellValue('D'.$i, '')
		 ->setCellValue('E'.$i, '')
         ->setCellValue('F'.$i, ($fila['countrie']))
		 ->setCellValue('G'.$i, '')
         ->setCellValue('H'.$i, ($fila['jugador']))
         ->setCellValue('I'.$i, ($fila['nrodocumento']))
         ->setCellValue('J'.$i, ($fila['equipo']))
		 ->setCellValue('K'.$i, '')
		 ->setCellValue('L'.$i, '')
		 ->setCellValue('M'.$i, '');
	//$i++; 
 }
 




$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($estiloTituloColumnas);
$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->applyFromArray($estiloTituloColumnas);
// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Hoja1');
 
// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);
 
// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="rptActaTribunalDisciplina.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;





















 } 

