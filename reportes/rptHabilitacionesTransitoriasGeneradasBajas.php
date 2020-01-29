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
$id = $_GET['id'];

$resTemporadas = $serviciosReferencias->traerUltimaTemporada();
$anioTemporada = 0;

if (mysql_num_rows($resTemporadas)>0) {
	 $ultimaTemporada = mysql_result($resTemporadas,0,0) - 1;
	 $anioTemporada = mysql_result($resTemporadas,0,1);
	 $idtemporada = mysql_result($resTemporadas,0,0);
} else {
	 $ultimaTemporada = 0;
	 $anioTemporada = 0;
	 $idtemporada = 0;
}

$resResultado = $serviciosReferencias->traerHabilitaciones10anios($id, $ultimaTemporada);
$resResultadoBaja = $serviciosReferencias->bajaJugadoresConPedidoHabilitacion($id, $ultimaTemporada);

/////////////////////////////  fin parametross  ///////////////////////////

$nombre 	= mysql_result($resTemporadas,0,'temporada');



$pdf = new FPDF();
$cantidadJugadores = 0;
#Establecemos los m�rgenes izquierda, arriba y derecha:
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
	$pdf->SetX(5);
	$pdf->Cell(200,5,'Habilitaciones que se mantendran '.date('Y-m-d'),1,0,'C',true);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);


	$cantPartidos = 0;
	$i=0;

	$contadorY1 = 44;
	$contadorY2 = 44;

	$acumulador1 = 0;
	$acumulador2 = 0;

	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(18,4,'Nro Doc',1,0,'C',false);
	$pdf->Cell(64,4,'Apellido y Nombre',1,0,'C',false);
	$pdf->Cell(20,4,'Fecha Nac.',1,0,'C',false);
	$pdf->Cell(78,4,'Obs.',1,0,'L',false);
	$pdf->Cell(20,4,'Fecha Limite',1,0,'C',false);

while ($rowE = mysql_fetch_array($resResultado)) {
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
		$pdf->Cell(200,5,'Temporada '.utf8_decode($nombre),1,0,'C',false);
		$pdf->SetFont('Arial','',8);
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(18,4,'Nro Doc',1,0,'C',false);
		$pdf->Cell(64,4,'Apellido y Nombre',1,0,'C',false);
		$pdf->Cell(20,4,'Fecha Nac.',1,0,'C',false);
		$pdf->Cell(78,4,'Obs.',1,0,'L',false);
		$pdf->Cell(20,4,'Fecha Limite',1,0,'C',false);

		$i=0;

	}




	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',8);

	$pdf->Cell(18,4,$rowE['nrodocumento'],1,0,'C',false);
	$pdf->Cell(64,4,substr(utf8_decode($rowE['apellido']),0,30).' '.substr(utf8_decode($rowE['nombres']),0,30),1,0,'L',false);
	$pdf->Cell(20,4,$rowE['fechanacimiento'],1,0,'C',false);
	$pdf->Cell(78,4,substr($rowE['observaciones'],0,40),1,0,'L',false);
	$pdf->Cell(20,4,$rowE['fechalimite'],1,0,'C',false);

	$acumulador1 = 0;
	$acumulador2 = 0;

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);


}
//120 x 109


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
$pdf->SetX(5);
$pdf->Cell(200,5,'Habilitaciones que seran bajas '.date('Y-m-d'),1,0,'C',true);
$pdf->Ln();
$pdf->Ln();
$pdf->SetX(5);


$cantPartidos = 0;
$i=0;

$contadorY1 = 44;
$contadorY2 = 44;

$acumulador1 = 0;
$acumulador2 = 0;

$pdf->Ln();
$pdf->SetX(5);
$pdf->Cell(18,4,'Nro Doc',1,0,'C',false);
$pdf->Cell(64,4,'Apellido y Nombre',1,0,'C',false);
$pdf->Cell(20,4,'Fecha Nac.',1,0,'C',false);
$pdf->Cell(78,4,'Obs.',1,0,'L',false);

while ($rowE = mysql_fetch_array($resResultadoBaja)) {
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
	$pdf->Cell(200,5,'Temporada '.utf8_decode($nombre),1,0,'C',false);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(18,4,'Nro Doc',1,0,'C',false);
	$pdf->Cell(64,4,'Apellido y Nombre',1,0,'C',false);
	$pdf->Cell(20,4,'Fecha Nac.',1,0,'C',false);
	$pdf->Cell(78,4,'Obs.',1,0,'L',false);


	$i=0;

}




$pdf->Ln();
$pdf->SetX(5);
$pdf->SetFont('Arial','',8);

$pdf->Cell(18,4,$rowE['nrodocumento'],1,0,'C',false);
$pdf->Cell(64,4,substr(utf8_decode($rowE['apellido']),0,30).' '.substr(utf8_decode($rowE['nombres']),0,30),1,0,'L',false);
$pdf->Cell(20,4,$rowE['fechanacimiento'],1,0,'C',false);
$pdf->Cell(78,4,utf8_decode(substr($rowE['observaciones'],0,40)),1,0,'L',false);


$acumulador1 = 0;
$acumulador2 = 0;

$contadorY1 += 4;

//$pdf->SetY($contadorY1);


}



$nombreTurno = "rptHabilitacionesTransitorios-".$nombre.".pdf";

$pdf->Output($nombreTurno,'I');


?>
