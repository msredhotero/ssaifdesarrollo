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
$idTemporadas		=	$_GET['reftemporada1'];
/////////////////////////////  fin parametross  ///////////////////////////


$resDatos = $serviciosReferencias->traerJugadoresVariosEquipos($idTemporadas);

$resTemporada = $serviciosReferencias->traerTemporadasPorId($idTemporadas);

//echo $resEquipos;

$nombre 	= mysql_result($resTemporada,0,'temporada');



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
	

	$cantPartidos = 0;
	$i=0;
	
	$idJugador = 0;
	$idcountry = 0;

	$contadorY1 = 44;
	$contadorY2 = 44;
	$primero = 0;
while ($rowE = mysql_fetch_array($resDatos)) {

	if ($idcountry != $rowE['idcountrie']) {

		if ($primero == 1) {
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

			$i=0;
		}

		$primero = 1;

		$idcountry = $rowE['idcountrie'];
		$pdf->SetFillColor(183,183,183);
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(200,5,'Country: '.utf8_decode($rowE['country']),1,0,'C',true);
		$pdf->SetFont('Arial','',8);
	}

	if ($idJugador != $rowE['idjugador']) {
		$idJugador = $rowE['idjugador'];
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(5);
		
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(5,4,'',1,0,'C',false);
		$pdf->Cell(60,4,'Apellido y Nombre',1,0,'C',false);
		$pdf->Cell(15,4,'Nro. Doc.',1,0,'C',false);
		$pdf->Cell(40,4,'Email',1,0,'C',false);
		$pdf->Cell(16,4,'Fecha Nac.',1,0,'C',false);

		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(5,4,$cantPartidos,1,0,'C',false);
		$pdf->Cell(60,4,utf8_decode($rowE['apyn']),1,0,'L',false);
		$pdf->Cell(15,4,$rowE['nrodocumento'],1,0,'C',false);
		$pdf->Cell(40,4,$rowE['email'],1,0,'C',false);
		$pdf->Cell(16,4,$rowE['fechanacimiento'],1,0,'C',false);

		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(10,4,'Hab.',1,0,'C',false);
		$pdf->Cell(40,4,'Equipos',1,0,'C',false);
		$pdf->Cell(40,4,'Categorias',1,0,'C',false);
		$pdf->Cell(30,4,'Divisiones',1,0,'C',false);
		
	}
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
	
	/* fin todo para saber si esta o no inhabilitado */


	$i+=1;	
	$cantPartidos += 1;
	

	
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	if (($habilitacion != 'HAB.')) {
		$pdf->Cell(10,4,'No',1,0,'C',false);
	} else {
		$pdf->Cell(10,4,'Si',1,0,'C',false);
	}
	$pdf->Cell(40,4,$rowE['equipo'],1,0,'C',false);
	$pdf->Cell(40,4,$rowE['categoria'],1,0,'C',false);
	$pdf->Cell(30,4,$rowE['division'],1,0,'C',false);
	
	
		

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}
//120 x 109



$nombreTurno = "JUGADORES-COUNTRIES-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

