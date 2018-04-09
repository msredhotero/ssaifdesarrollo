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
$idTemporada		=	$_GET['reftemporada1'];
/////////////////////////////  fin parametross  ///////////////////////////


$resDatos = $serviciosReferencias->traerPromedioCanchas($idTemporada);

$resTemporadas = $serviciosReferencias->traerTemporadasPorId($idTemporada);

//echo $resEquipos;

$nombre 	= mysql_result($resTemporadas,0,'temporada');



$pdf = new FPDF();
$cantidadJugadores = 0;
#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(2, 2 , 2); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,1); 


	
	$pdf->AddPage();
	/***********************************    PRIMER CUADRANTE ******************************************/
	
	$pdf->Image('../imagenes/logoparainformes.png',2,2,40);

	/***********************************    FIN ******************************************/
	
	
	
	//////////////////// Aca arrancan a cargarse los datos de los equipos  /////////////////////////

	
	$pdf->SetFillColor(183,183,183);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetY(25);
	$pdf->SetX(5);
	$pdf->Cell(200,5,'Temporada '.utf8_decode($nombre),1,0,'C',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	

	$cantPartidos = 0;
	$i=0;
	
	$contadorY1 = 44;
	$contadorY2 = 44;

	$acumulador1 = 0;
	$acumulador2 = 0;

while ($rowE = mysql_fetch_array($resDatos)) {
	$i+=1;	
	$cantPartidos += 1;
	
	if ($i > 61) {
		$pdf->AddPage();
		$pdf->Image('../imagenes/logoparainformes.png',2,2,40);	
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetY(25);
		$pdf->SetX(5);
		$pdf->Cell(200,5,'Countrie '.utf8_decode($nombre),1,0,'C',false);
		$pdf->SetFont('Arial','',8);
		$pdf->Ln();
		$pdf->SetX(5);

		$i=0;
		
	}
	
	
	
	$canchas = $serviciosReferencias->traerPromedioCanchasPorCountrie($rowE['idcountrie'], $idTemporada);
	while ($rowC = mysql_fetch_array($canchas)) {
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(5,4,'',1,0,'C',True);
		$pdf->Cell(95,4,utf8_decode($rowC['cancha']),1,0,'L',false);
		$pdf->Cell(16,4,$rowC['promedio'],1,0,'C',false);

		$acumulador1 += $rowC['promedio'];
		$acumulador2 += 1;
	}
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,4,$cantPartidos,1,0,'C',True);
	$pdf->Cell(95,4,utf8_decode($rowE['countrie']),1,0,'L',True);
	$pdf->Cell(16,4,round(($acumulador2 == 0 ? 0 : $acumulador1 / $acumulador2),2,PHP_ROUND_HALF_UP),1,0,'C',True);
	$pdf->Ln();
	$pdf->Ln();
		
	$acumulador1 = 0;
	$acumulador2 = 0;

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}
//120 x 109



$nombreTurno = "PROMEDIO-CANCHAS-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

