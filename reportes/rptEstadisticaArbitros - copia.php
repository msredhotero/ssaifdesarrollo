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


$resDatos = $serviciosReferencias->traerEstadisticaArbitrosPorTemporadaWhere($idTemporada, $where);

//die(print_r($resDatos));
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

	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(70,4,'Apellido y Nombre',1,0,'L',false);
	$pdf->Cell(25,4,'Partidos',1,0,'C',false);
	$pdf->Cell(25,4,'Amonestaciones',1,0,'C',false);
	$pdf->Cell(25,4,'Rojas',1,0,'C',false);
	$pdf->Cell(25,4,'% Amarillas',1,0,'C',false);
	$pdf->Cell(25,4,'% Rojas',1,0,'C',false);

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
		$pdf->Cell(200,5,'Temporada '.utf8_decode($nombre),1,0,'C',false);
		$pdf->SetFont('Arial','',8);
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(70,4,'Apellido y Nombre',1,0,'L',false);
		$pdf->Cell(25,4,'Partidos',1,0,'C',false);
		$pdf->Cell(25,4,'Amonestaciones',1,0,'C',false);
		$pdf->Cell(25,4,'Rojas',1,0,'C',false);
		$pdf->Cell(25,4,'% Amarillas',1,0,'C',false);
		$pdf->Cell(25,4,'% Rojas',1,0,'C',false);

		$i=0;
		
	}
	
	
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(70,4,utf8_decode($rowE['nombrecompleto']),1,0,'L',false);
	$pdf->Cell(25,4,($rowE['cantidad']),1,0,'C',false);
	$pdf->Cell(25,4,($rowE['amarillas']),1,0,'C',false);
	$pdf->Cell(25,4,($rowE['rojas']),1,0,'C',false);
	$pdf->Cell(25,4,($rowE['porcentajeamarillas']),1,0,'C',false);
	$pdf->Cell(25,4,($rowE['porcentajerojas']),1,0,'C',false);

		
	$acumulador1 = 0;
	$acumulador2 = 0;

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}
//120 x 109



$nombreTurno = "PROMEDIO-CANCHAS-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

