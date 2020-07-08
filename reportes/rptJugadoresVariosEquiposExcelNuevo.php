<?php

date_default_timezone_set('America/Buenos_Aires');

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 			= new ServiciosReferencias();

require_once '../excelClass/PHPExcel.php';

$fecha = date('Y-m-d');

//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

////***** Parametros ****////////////////////////////////
$idTemporadas		=	$_GET['reftemporada1'];
/////////////////////////////  fin parametross  ///////////////////////////


$resDatos = $serviciosReferencias->traerJugadoresVariosEquipos($idTemporadas);

$resTemporada = $serviciosReferencias->traerTemporadasPorId($idTemporadas);

//echo $resEquipos;

$nombre 	= mysql_result($resTemporada,0,'temporada');

$objPHPExcel = new PHPExcel();



$objPHPExcel->getProperties()
->setCreator("Exebin")
->setLastModifiedBy("Exebin")
->setTitle("Documento Excel")
->setSubject("Documento Excel")
->setDescription("Documento Excel Jugadores Varios Equipos Suspendidos.")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("Excel");

$tituloReporte = "Jugadores Varios Equipos Excel";
$tituloReporte2 = "Fecha: ".date('Y-m-d');
$titulosColumnas = array("Countrie", "Nro.Doc.", "Apellido y Nombre","Fecha Nac.", "Equipo","Categoria","Division","Habilita");

$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:H1');
$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A2:H2');



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
		->setCellValue('H3',  utf8_encode($titulosColumnas[7]));


	$i = 4; //Numero de fila donde se va a comenzar a rellenar
	while ($rowE = mysql_fetch_array($resDatos)) {

		//die(var_dump($rowE));
		  	/* todo para saber si esta o no inhabilitado */
		  	$cadCumpleEdad = '';
		  	$errorDoc = 'FALTA';
		  	$cadErrorDoc = '';
		  	$habilitacion= 'INHAB.';
		  	$transitoria= '';
		  	$valorDocumentacion = 0;
		  	$documentaciones = '';



		  	$edad = $serviciosReferencias->verificarEdad($rowE['idjugador']);

		  	$cumpleEdad = $serviciosReferencias->verificaEdadCategoriaJugador($rowE['idjugador'], $rowE['idtcategoria'], $rowE['reftipojugadores']);

		  	$documentaciones = $serviciosReferencias->traerJugadoresdocumentacionPorJugadorValores($rowE['idjugador']);

		  	if ($cumpleEdad == 1) {
		  		$cadCumpleEdad = "CUMPLE";
		  	} else {
		  		// VERIFICO SI EXISTE ALGUNA HABILITACION TRANSITORIA
		  		$habilitacionTransitoria = $serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorDeportiva($rowE['idjugador'], $idTemporadas, $rowE['idtcategoria'], $rowE['refequipos']);
		  		if (mysql_num_rows($habilitacionTransitoria)>0) {
		  			$cadCumpleEdad = "HAB. TRANS.";
		  			$habilitacion= 'HAB.';
		  		} else {
		  			$cadCumpleEdad = "NO CUMPLE";
		  		}
		  	}
         /*
		  	if (mysql_num_rows($documentaciones)>0) {
		  		while ($rowH = mysql_fetch_array($documentaciones)) {
		  			if (($rowH['valor'] == 'No') && ($rowH['contravalor'] == 'No')) {
		  				if ($rowH['obligatoria'] == 'Si') {
		  					$valorDocumentacion += 1;
		  					if (mysql_num_rows($serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorAdministrativaDocumentacion($rowE['idjugador'],$rowH['refdocumentaciones']))>0) {
		  						$valorDocumentacion -= 1;
		  					}
		  				}
		  				if ($rowH['contravalordesc'] == '') {
		  					$cadErrorDoc .= strtoupper($rowH['descripcion']).' - ';
		  				} else {
		  					$cadErrorDoc .= strtoupper($rowH['contravalordesc']).' - ';
		  				}
		  			}
		  		}
		  		if ($cadErrorDoc == '') {
		  			$cadErrorDoc = 'OK';
		  			$errorDoc = 'OK';
		  		} else {
		  			$cadErrorDoc = substr($cadErrorDoc,0,-3);
		  		}

		  	} else {
		  		$cadErrorDoc = 'FALTAN PRESENTAR TODAS LAS DOCUMENTACIONES';
		  	}

		  	if ($valorDocumentacion <= 0 && ($cadCumpleEdad == 'CUMPLE' || $cadCumpleEdad == "HAB. TRANS.")) {
		  		if ($cadErrorDoc == 'FALTAN PRESENTAR TODAS LAS DOCUMENTACIONES') {
		  			$habilitacion= 'INHAB.';
		  		} else {
		  			$habilitacion= 'HAB.';
		  		}
		  	} else {
		  		$habilitacion= 'INHAB.';
		  	}
         */
		  	/* fin todo para saber si esta o no inhabilitado */

			/*utf8_encode*/
		  	$objPHPExcel->setActiveSheetIndex(0)
		  		->setCellValue('A'.$i, ($rowE['country']))
		  		->setCellValue('B'.$i, ($rowE['nrodocumento']))
		  		->setCellValue('C'.$i, ($rowE['apyn']))
		  		->setCellValue('D'.$i, ($rowE['fechanacimiento']))
		  		->setCellValue('E'.$i, ($rowE['refequipos'].' '.$rowE['equipo']))
		  		->setCellValue('F'.$i, ($rowE['categoria']))
		  		->setCellValue('G'.$i, ($rowE['division']))
		  		->setCellValue('H'.$i, ($cadCumpleEdad));

		  	$i += 1;

		  	//$pdf->SetY($contadorY1);


	}
//120 x 109

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



$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($estiloTituloColumnas);

// Renombrar Hoja
$objPHPExcel->getActiveSheet()->setTitle('Hoja1');

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
header('Content-Disposition: attachment;filename="rptJugadoresVariosEquiposExcel.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;



?>
