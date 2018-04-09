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

$fecha = date('Y-m-d');

require('fpdf.php');

//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

////***** Parametros ****////////////////////////////////

$fechaDesde = '';
$fechaHasta = '';


if (isset($_GET['reffechadesde1'])) {
	$fechaDesde = $_GET['reffechadesde1'];
}

if (isset($_GET['reffechahasta1'])) {
	$fechaHasta = $_GET['reffechahasta1'];
}

$fechaDesde = $_GET['reffechadesde1'];
$fechaHasta = $_GET['reffechahasta1'];

/////////////////////////////  fin parametross  ///////////////////////////

if (($fechaDesde != '') && ($fechaHasta != '')) {
	$resDatos = $serviciosReferencias->traerProximaFechaTodosReal($fechaDesde,$fechaHasta);
} else {
	$resDatos = $serviciosReferencias->traerProximaFechaTodos();
}



if (($fechaDesde != '') && ($fechaHasta != '')) {
	$resDesdeHasta = $serviciosReferencias->traerProximaFechaDesdeHastaReal($fechaDesde,$fechaHasta);
} else {
	$resDesdeHasta = $serviciosReferencias->traerProximaFechaDesdeHasta();
	$fechaDesde 	= mysql_result($resDesdeHasta,0,'fechajuegodesde');
	$fechaHasta 	= mysql_result($resDesdeHasta,0,'fechajuegohasta');
}
//echo $resEquipos;



$resTemporadas = $serviciosReferencias->traerUltimaTemporada();	

if (mysql_num_rows($resTemporadas)>0) {
	$ultimaTemporada = mysql_result($resTemporadas,0,1);	
} else {
	$ultimaTemporada = 0;	
}

$pdf = new FPDF();
$cantidadJugadores = 0;
#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(2, 10 , 2); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,1); 


	
	$pdf->AddPage();
	/***********************************    PRIMER CUADRANTE ******************************************/
	
	$pdf->Image('../imagenes/logoparainformes.png',2,2,40);

	/***********************************    FIN ******************************************/
	
	
	
	//////////////////// Aca arrancan a cargarse los datos de los equipos  /////////////////////////
	$dateD = new DateTime($fechaDesde);
	$dateH = new DateTime($fechaHasta);
	
	$pdf->SetFillColor(183,183,183);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetY(25);
	$pdf->SetX(5);
	$pdf->Cell(200,5,'Partidos del '.$dateD->format('d-m-Y')." al ".$dateH->format('d-m-Y')." - Temporada: ".$ultimaTemporada,1,0,'C',true);

	$pdf->SetFont('Arial','',8);
	$pdf->SetX(5);
	
	$torneo		= '';
	$categoria  = '';
	$division	= '';
	$fecha		= '';
	
	$cantPartidos = 0;
	$i=0;
	
	$contadorY1 = 44;
	$contadorY2 = 44;
while ($rowE = mysql_fetch_array($resDatos)) {
	$i+=1;	
	$cantPartidos += 1;
	/*
	if ($i > 61) {
		$pdf->AddPage();
		$pdf->Image('../imagenes/logoparainformes.png',2,2,40);	
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetY(25);
		$pdf->SetX(5);
		$pdf->Cell(200,5,'Partidos del '.$fechaDesde." al ".$fechaHasta." - Temporada: ".$ultimaTemporada,1,0,'C',true);
		$pdf->SetFont('Arial','',8);
		$pdf->Ln();
		$pdf->SetX(5);

		$i=0;
		
	}
	*/
	
	if ($torneo != $rowE['torneo']) {
		$torneo = $rowE['torneo'];
		$division = '';

	}
	
	if ($categoria != $rowE['categoria']) {
		$categoria = $rowE['categoria'];
		$division = '';
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(200,5,utf8_decode($rowE['categoria']),1,0,'C',true);

	}
	
	if ($division != $rowE['division']) {	
		$division = $rowE['division'];
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(60,4,'Division: '.utf8_decode($rowE['division']),0,0,'L',false);
		$pdf->Cell(60,4,'Torneo: '.utf8_decode($rowE['torneo']),0,0,'L',false);

	}
	
	if ($fecha != $rowE['fecha']) {	
		$fecha = $rowE['fecha'];
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(100,4,'Fecha: '.utf8_decode($rowE['fecha']),0,0,'L',false);
		$pdf->Cell(100,4,'Cancha: ',0,0,'L',false);
		
		
	}
	
	
	$date = new DateTime($rowE['fechajuego']);
	$dia = '';
	switch (date('N', strtotime( $rowE['fechajuego']))) {
		case 1:
			$dia = 'Lunes';
			break;
		case 2:
			$dia = 'Martes';
			break;
		case 3:
			$dia = 'Miercoles';
			break;
		case 4:
			$dia = 'Jueves';
			break;
		case 5:
			$dia = 'Viernes';
			break;
		case 6:
			$dia = 'Sabado';
			break;
		case 7:
			$dia = 'Domingo';
			break;
	}
	$pdf->Ln();
	$pdf->SetX(5);
	
	if ($rowE['esresaltado'] == 'Si') {
		$pdf->SetFillColor(255,255,0);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(47,4,utf8_decode($rowE['equipoLocal']),1,0,'L',true);
		$pdf->Cell(6,4,'vs',1,0,'L',true);
		$pdf->Cell(47,4,utf8_decode($rowE['equipoVisitante']),1,0,'L',true);
		if (($rowE['equipoLocal'] != 'Libre') && ($rowE['equipoVisitante'] != 'Libre')) {
			$pdf->Cell(50,4,utf8_decode(($rowE['cancha']== '' ? 'A confirmar' : $rowE['cancha'])),0,0,'L',true);
			$pdf->Cell(15,4,$dia,0,0,'L',true);
			$pdf->Cell(20,4,$date->format('d-m-Y'),0,0,'L',true);
			$pdf->Cell(15,4,utf8_decode($rowE['hora']),0,0,'L',true);
		}
	} else {
		$pdf->SetFillColor(183,183,183);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(47,4,utf8_decode($rowE['equipoLocal']),1,0,'L',false);
		$pdf->Cell(6,4,'vs',1,0,'L',false);
		$pdf->Cell(47,4,utf8_decode($rowE['equipoVisitante']),1,0,'L',false);
		if (($rowE['equipoLocal'] != 'Libre') && ($rowE['equipoVisitante'] != 'Libre')) {
			$pdf->Cell(50,4,utf8_decode(($rowE['cancha']== '' ? 'A confirmar' : $rowE['cancha'])),0,0,'L',false);
			$pdf->Cell(15,4,$dia,0,0,'L',false);
			$pdf->Cell(20,4,$date->format('d-m-Y'),0,0,'L',false);
			$pdf->Cell(15,4,utf8_decode($rowE['hora']),0,0,'L',false);
		}

	}
	
		

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}
//120 x 109



$nombreTurno = "PROXIMA-FECHA-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

