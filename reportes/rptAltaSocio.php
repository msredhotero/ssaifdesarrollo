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
$id		=	$_GET['id'];
/////////////////////////////  fin parametross  ///////////////////////////


$resSocio = $serviciosReferencias->traerJugadoresprePorIdCompleto($id);

$resFoto = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacion($id,1);
$urlImg1 = "../data/".mysql_result($resFoto,0,0)."/".mysql_result($resFoto,0,'imagen');

$resFotoDocumento = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacion($id,2);
$urlImg2 = "../data/".mysql_result($resFotoDocumento,0,0)."/".mysql_result($resFotoDocumento,0,'imagen');

$resFotoDocumentoDorso = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacion($id,99);
$urlImg3 = "../data/".mysql_result($resFotoDocumentoDorso,0,0)."/".mysql_result($resFotoDocumentoDorso,0,'imagen');


$pdf = new FPDF();

#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(2, 2 , 2); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,1); 


	
	$pdf->AddPage('L','A4','mm');
	/***********************************    PRIMER CUADRANTE ******************************************/
	
	

	/***********************************    FIN ******************************************/

	//////////////////// Aca arrancan a cargarse los datos de los equipos  /////////////////////////

	
	$pdf->SetFillColor(183,183,183);
	$pdf->SetFont('Arial','U',18);

	$pdf->SetX(5);
	$pdf->Cell(50,5,mysql_result($resSocio,0,'nrodocumento'),0,0,'L',false);

	$pdf->Image('../imagenes/logoparainformes.png',5,10,40);
	
	$pdf->SetFont('Arial','',14);
	$pdf->SetXY(60,15);
	$pdf->Cell(120,5,'ASOCIACION INTERCOUNTRY DE FUTBOL ZONA NORTE',0,0,'C',false);
	$pdf->SetFont('Arial','U',10);

	$pdf->SetY(30);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',12);
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(180,5,'APELLIDO: '.mysql_result($resSocio,0,'apellido'),0,0,'L',false);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(180,5,'NOMBRE: '.mysql_result($resSocio,0,'nombres'),0,0,'L',false);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(180,5,'TIPO Y NRO DE DOCUMENTO: '.mysql_result($resSocio,0,'tipodocumento').' '.mysql_result($resSocio,0,'nrodocumento'),0,0,'L',false);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(180,5,'FECHA NACIMIENTO: '.mysql_result($resSocio,0,'fechanacimiento'),0,0,'L',false);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(180,5,'COUNTRY: '.mysql_result($resSocio,0,'country'),0,0,'L',false);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(180,5,'NRO DE LOTE: '.mysql_result($resSocio,0,'numeroserielote'),0,0,'L',false);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(180,5,'EMAIL: '.mysql_result($resSocio,0,'email'),0,0,'L',false);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(180,5,'FECHA DE ALTA: '.mysql_result($resSocio,0,'fechaalta'),0,0,'L',false);

	$pdf->Image($urlImg1,210,10,50,67);

	$pdf->Image($urlImg2,190,80,80);

	$pdf->Image($urlImg3,190,140,80);


	$pdf->SetXY(20,150);
	$pdf->Cell(110,5,'Registre en el recuadro la firma a utilizar en la planilla del partido',0,0,'L',false);
	$pdf->Ln();
	$pdf->SetXY(20,160);
	$pdf->Cell(110,25,'',1,0,'L',false);





$nombreTurno = "ALTA-JUGADOR-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

