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


$resDatos = $serviciosReferencias->traerJugadoresClubPorCountrie($idCountries);

if ($_GET['bajas1'] == 'true') {
	$resDatosBaja = $serviciosReferencias->traerJugadoresPorCountriesBaja($idCountries);
} else {
	$resDatosBaja = $serviciosReferencias->traerJugadoresPorCountriesBaja(0);
}

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
	$pdf->Cell(200,5,'Padron Socios Propietarios - Club '.utf8_decode($nombre),1,0,'C',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,4,'',1,0,'C',false);
	$pdf->Cell(60,4,'Apellido y Nombre',1,0,'C',false);
	$pdf->Cell(15,4,'Nro. Doc.',1,0,'C',false);
	$pdf->Cell(15,4,'Fec. Nac',1,0,'C',false);
	$pdf->Cell(40,4,'Nro Serie Lote',1,0,'C',false);
	$pdf->Cell(16,4,'Baja',1,0,'C',false);
	$pdf->Cell(16,4,'Art 2',1,0,'C',false);

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
		$pdf->Cell(15,4,'Fec. Nac',1,0,'C',false);
		$pdf->Cell(40,4,'Nro Serie Lote',1,0,'C',false);
		$pdf->Cell(16,4,'Baja',1,0,'C',false);
		$pdf->Cell(16,4,'Art 2',1,0,'C',false);

	}
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(5,4,$cantPartidos,1,0,'C',false);
	$pdf->Cell(60,4,utf8_decode($rowE['apyn']),1,0,'L',false);
	$pdf->Cell(15,4,$rowE['nrodocumento'],1,0,'C',false);
	$pdf->Cell(15,4,$rowE['fechanacimiento'],1,0,'C',false);
	$pdf->Cell(40,4,$rowE['numeroserielote'],1,0,'C',false);
	$pdf->Cell(16,4,$rowE['fechabaja'],1,0,'C',false);
	$pdf->Cell(16,4,$rowE['articulo'],1,0,'C',false);

	
	
	
		

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}



///////////////***************************  para las bajas  *****************************************//////

//$pdf->AddPage();
	/***********************************    PRIMER CUADRANTE ******************************************/
	
//	$pdf->Image('../imagenes/logoparainformes.png',2,2,40);

	/***********************************    FIN ******************************************/
	
	
	
	//////////////////// Aca arrancan a cargarse los datos de los equipos  /////////////////////////

	/*
	$pdf->SetFillColor(183,183,183);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetY(25);
	$pdf->SetX(5);
	$pdf->Cell(200,5,'Bajas - Countrie '.utf8_decode($nombre),1,0,'C',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,4,'',1,0,'C',false);
	$pdf->Cell(60,4,'Apellido y Nombre',1,0,'C',false);
	$pdf->Cell(15,4,'Nro. Doc.',1,0,'C',false);
	$pdf->Cell(16,4,'Fecha Nac.',1,0,'C',false);
	$pdf->Cell(16,4,'Fecha Baja',1,0,'C',false);
	$cantPartidos = 0;
	$i=0;
	
	$contadorY1 = 44;
	$contadorY2 = 44;
while ($rowE = mysql_fetch_array($resDatosBaja)) {
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
		$pdf->Cell(16,4,'Fecha Nac.',1,0,'C',false);
		$pdf->Cell(16,4,'Fecha Baja',1,0,'C',false);
	}
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(5,4,$cantPartidos,1,0,'C',false);
	$pdf->Cell(60,4,utf8_decode($rowE['apyn']),1,0,'L',false);
	$pdf->Cell(15,4,$rowE['nrodocumento'],1,0,'C',false);
	$pdf->Cell(16,4,$rowE['fechanacimiento'],1,0,'C',false);
	$pdf->Cell(16,4,$rowE['fechabaja'],1,0,'C',false);

	
	
	
		

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}
*/
//120 x 109

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(190, 3, 'Certifico que los arriba Inscriptos son Socios-Propietarios de Lotes del Country (titulares, cónyugues, ascendientes, descendientes o yernos únicamente), y/o jugadores que se enmarcan dentro del artículo 2 incisos "a", "b" y "d" de vuestro reglamento de torneos, estando estatutariamente habilitados para representar a la Institución en competencias deportivas. Manifiesto conocer y aceptar en todas sus partes el Reglamento de los Torneos y el Reglamento del Tribunal de Disciplina, comprometiéndose el Country al que represento, a cumplir y hacer cumplir los derechos y obligaciones obrantes en los mismos y a comunicar a la Asociación, en forma inmediata, cualquier modificación en la condición o categoría de los socios-propietarios y/o familiares inscriptos en la presente lista.',0,'','');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','b',8);
$pdf->MultiCell(190, 4, 'Nota: El Padrón deberá estar firmado por el Presidente y/o Secretario de la Institución, con sellos aclaratorios y certificación Bancaria o de un Escribano público acerca de las identidades de los Firmantes, adjuntando además un elemento probatorio del carácter de su función (fotocopia certificada del libro de Actas, certificación Bancaria u otras).',0,'','');



$nombreTurno = "JUGADORES-COUNTRIES-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

