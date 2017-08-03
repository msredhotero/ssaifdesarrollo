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
$idCountries		=	$_GET['refcountries1'];
/////////////////////////////  fin parametross  ///////////////////////////


$resDatos = $serviciosReferencias->traerJugadoresPorCountries($idCountries);

$resCountrie = $serviciosReferencias->traerCountriesPorId($idCountries);

//echo $resEquipos;

$nombre 	= mysql_result($resCountrie,0,'nombre');



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
	$pdf->Cell(200,5,'Countrie '.utf8_decode($nombre),1,0,'C',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,4,'',1,0,'C',false);
	$pdf->Cell(60,4,'Apellido y Nombre',1,0,'C',false);
	$pdf->Cell(15,4,'Nro. Doc.',1,0,'C',false);
	$pdf->Cell(20,4,'Email',1,0,'C',false);
	$pdf->Cell(16,4,'Fecha Nac.',1,0,'C',false);
	$pdf->Cell(84,4,'Observaciones',1,0,'C',false);
	$cantPartidos = 0;
	$i=0;
	
	$contadorY1 = 44;
	$contadorY2 = 44;
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
		
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(5,4,'',1,0,'C',false);
		$pdf->Cell(60,4,'Apellido y Nombre',0,0,'C',false);
		$pdf->Cell(15,4,'Nro. Doc.',0,0,'C',false);
		$pdf->Cell(20,4,'Email',0,0,'C',false);
		$pdf->Cell(16,4,'Fecha Nac.',1,0,'C',false);
		$pdf->Cell(84,4,'Observaciones',1,0,'C',false);
	}
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(5,4,$cantPartidos,1,0,'C',false);
	$pdf->Cell(60,4,utf8_decode($rowE['apyn']),1,0,'L',false);
	$pdf->Cell(15,4,$rowE['nrodocumento'],1,0,'C',false);
	$pdf->Cell(20,4,$rowE['email'],1,0,'C',false);
	$pdf->Cell(16,4,$rowE['fechanacimiento'],1,0,'C',false);
	$pdf->Cell(84,4,substr(utf8_decode($rowE['observaciones']),0,56),1,0,'L',false);
	
	
	
		

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}
//120 x 109



$nombreTurno = "JUGADORES-COUNTRIES-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

