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


$idtemporada		=	'';
$idtorneo			=	'';
$refCategorias		=	'';
$refDivisiones		=	'';

$where = '';
$whereAux = '';
if (($_GET['reftemporada1'] != 0) && (isset($_GET['reftemporada1']))) {
	$where .= "tep.idtemporadas = ".$_GET['reftemporada1'];
} else {
	$where .= "tep.idtemporadas = 7";
}


if (($_GET['refcategorias1'] != 0) && (isset($_GET['refcategorias1']))) {
	$where .= " and tor.refcategorias = ".$_GET['refcategorias1'];
}

if (($_GET['refdivision1'] != 0) && (isset($_GET['refdivision1']))) {
	$where .= " and tor.refdivisiones = ".$_GET['refdivision1'];
}


$resDatos = $serviciosReferencias->traerFormacionPorFixtureDetalleWhere($where);

//die(print_r($resDatos));
//echo $resEquipos;




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
	$pdf->Cell(200,5,'Jugadores Por Partidos','C',true);
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

	$idfixture = 0;
	$primero = 0;

	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(20,4,'Fecha',1,0,'C',false);
	$pdf->Cell(40,4,'Equipo',1,0,'C',false);
	$pdf->Cell(30,4,'Categoria',1,0,'C',false);
	$pdf->Cell(20,4,'Division',1,0,'C',false);
	$pdf->Cell(70,4,'Apellido y Nombre',1,0,'L',false);
	$pdf->Cell(25,4,'Numero',1,0,'C',false);


while ($rowE = mysql_fetch_array($resDatos)) {
	$i+=1;	
	$cantPartidos += 1;

	if ($idfixture != $rowE['idfixture']) {
		$idfixture = $rowE['idfixture'];
		if ($primero != 0) {
			$pdf->Ln();
			$pdf->SetX(5);
			$pdf->Cell(205,4,'Cantidad de Jugadores: '.$cantPartidos,1,0,'R',false);
		}

		$primero = 1;
	}
	
	if ($i > 61) {
		$pdf->AddPage();
		$pdf->Image('../imagenes/logoparainformes.png',2,2,40);	
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetY(25);
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(20,4,'Fecha',1,0,'C',false);
		$pdf->Cell(40,4,'Equipo',1,0,'C',false);
		$pdf->Cell(30,4,'Categoria',1,0,'C',false);
		$pdf->Cell(20,4,'Division',1,0,'C',false);
		$pdf->Cell(70,4,'Apellido y Nombre',1,0,'L',false);
		$pdf->Cell(25,4,'Numero',1,0,'C',false);

		$i=0;
		
	}
	
	
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(20,4,$rowE['fechajuego'],1,0,'C',false);
	$pdf->Cell(40,4,$rowE['equipo'],1,0,'C',false);
	$pdf->Cell(30,4,$rowE['categoria'],1,0,'C',false);
	$pdf->Cell(20,4,$rowE['division'],1,0,'C',false);
	$pdf->Cell(70,4,$rowE['apyn'],1,0,'L',false);
	$pdf->Cell(25,4,$rowE['numero'],1,0,'C',false);

		
	$acumulador1 = 0;
	$acumulador2 = 0;

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}
//120 x 109



$nombreTurno = "CANTIDAD-JUGADORES-PARTIDOS-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

