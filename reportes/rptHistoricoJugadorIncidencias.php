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
$idJugador 		=	$_GET['idjugador'];
/*
$idtorneo			=	$_GET['reftorneo3'];
$reffechas			=	$_GET['reffechas3'];
$refCategorias		=	$_GET['refcategorias1'];
$refDivisiones		=	$_GET['refdivision1'];
*/
$idtemporada		=	'';
$idtorneo			=	'';
$refCategorias		=	'';
$refDivisiones		=	'';

$where = '';

if (isset($_GET['reftemporada1'])) {
	$where .= " and tep.idtemporadas = ".$_GET['reftemporada1'];
}

if (isset($_GET['reftorneo3'])) {
	$where .= " and tor.idtorneo = ".$_GET['reftorneo3'];
}

if (isset($_GET['refcategorias1'])) {
	$where .= " and tor.refcategorias = ".$_GET['refcategorias1'];
}

if (isset($_GET['refdivision1'])) {
	$where .= " and tor.refdivisiones = ".$_GET['refdivision1'];
}

$where = '';
if (($idtemporada != '') || ($idtorneo != '') || ($refCategorias != '') || ($refDivisiones != '')) {
	$where .= " and r.idtorneo = ".$idtorneo;
}

/////////////////////////////  fin parametross  ///////////////////////////


$resJugadores = $serviciosReferencias->traerJugadoresPorId($idJugador);

$resDatos = $serviciosReferencias->traerHistoricoIncidenciasPorJugador($idJugador, $where);
//die(print_r($resDatos));

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

	
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetY(25);
	$pdf->SetX(5);
	$pdf->Cell(200,5,'Legajo de Socio',1,0,'C',false);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,4,mysql_result($resJugadores,0,2).' - '.mysql_result($resJugadores,0,3).' '.mysql_result($resJugadores,0,4),0,0,'C',false);
	//$resJugadores = $serviciosJugadores->TraerJugadoresPorEquipoPlanillas($rowE['idequipo'],$reffecha, $idtorneo);

	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	
	$categoria  = '';
	$division	= '';
	$torneo		= '';
	$equipo		= '';
	$temporada	= '';
	
	$cantPartidos = 0;
	$i=0;
	
	$contadorY1 = 44;
	$contadorY2 = 44;
	
	$acuGoles = 0;
	$acuPartidos = 0;
	$acuAmarillas = 0;
	$acuRojas = 0;
	$acuPenales = 0;
	
	$primero = 0;
	
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
	
	if (($temporada != $rowE['temporada']) || ($categoria != $rowE['categoria']) || ($division != $rowE['division']) || ($torneo != $rowE['torneo']) || ($equipo != $rowE['equipo'])) {
		
		if ($primero == 1) {
			$pdf->Ln();
			$pdf->SetX(5);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,5,'SubTotales',0,0,'C',false);
			$pdf->Cell(30,5,'Partidos: '.$acuPartidos,0,0,'C',false);
			$pdf->Cell(30,5,'Goles: '.$acuGoles,0,0,'C',false);
			$pdf->Cell(30,5,'Amonestaciones: '.$acuAmarillas,0,0,'C',false);
			$pdf->Cell(30,5,'Rojas: '.$acuRojas,0,0,'C',false);
			$pdf->Cell(30,5,'Penales Conv.: '.$acuPenales,0,0,'C',false);
		}
		$primero = 1;
		$categoria = $rowE['categoria'];
		$division	= $rowE['division'];
		$torneo		= $rowE['torneo'];
		$equipo		= $rowE['equipo'];
		$temporada		= $rowE['temporada'];
		
		$acuGoles = 0;
		$acuPartidos = 0;
		$acuAmarillas = 0;
		$acuRojas = 0;
		$acuPenales = 0;
	
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetFont('Arial','U',8);
		$pdf->SetX(5);
		$pdf->Cell(20,5,utf8_decode($rowE['temporada']),0,0,'C',false);
		$pdf->Cell(38,5,utf8_decode($rowE['categoria']),0,0,'C',false);
		$pdf->Cell(38,5,utf8_decode($rowE['division']),0,0,'C',false);
		$pdf->Cell(104,5,utf8_decode($rowE['torneo']),0,0,'L',false);
		$pdf->Ln();
		$pdf->SetX(15);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(20,5,'Equipo:',0,0,'C',false);
		$pdf->Cell(12,5,utf8_decode($rowE['refequipos']),0,0,'C',false);
		$pdf->Cell(50,5,utf8_decode($rowE['equipo']),0,0,'L',false);
		$pdf->Ln();
		$pdf->SetFont('Arial','U',8);
		$pdf->Cell(20,5,'Fecha',0,0,'C',false);
		$pdf->Cell(20,5,'Fecha Nro.',0,0,'C',false);
		$pdf->Cell(24,5,'Goles A Favor',0,0,'C',false);
		$pdf->Cell(20,5,'Amonestado',0,0,'C',false);
		$pdf->Cell(20,5,'Expulsado',0,0,'C',false);
		$pdf->Cell(24,5,'Penales Convert.',0,0,'C',false);
		$pdf->Cell(64,5,'Contrario',0,0,'C',false);
	}
	
	
	

	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(20,5,utf8_decode($rowE['fecha']).' '.$rowE['localia'],0,0,'C',false);
	$pdf->Cell(20,5,utf8_decode($rowE['fechaaux']),0,0,'C',false);
	$pdf->Cell(24,5,utf8_decode($rowE['goles']),0,0,'C',false);
	$pdf->Cell(20,5,utf8_decode($rowE['amarillas']),0,0,'C',false);
	$pdf->Cell(20,5,utf8_decode($rowE['rojas']),0,0,'C',false);
	$pdf->Cell(24,5,utf8_decode($rowE['pc']),0,0,'C',false);
	$pdf->Cell(98,5,utf8_decode($rowE['visitante']),0,0,'L',false);

	$acuGoles += $rowE['goles'];
	$acuPartidos += 1;
	$acuAmarillas += $rowE['amarillas'];
	$acuRojas += $rowE['rojas'];
	$acuPenales += $rowE['pc'];
		

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}

$pdf->Ln();
$pdf->SetX(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,5,'SubTotales',0,0,'C',false);
$pdf->Cell(30,5,'Partidos: '.$acuPartidos,0,0,'C',false);
$pdf->Cell(30,5,'Goles: '.$acuGoles,0,0,'C',false);
$pdf->Cell(30,5,'Amonestaciones: '.$acuAmarillas,0,0,'C',false);
$pdf->Cell(30,5,'Rojas: '.$acuRojas,0,0,'C',false);
$pdf->Cell(30,5,'Penales Conv.: '.$acuPenales,0,0,'C',false);
//120 x 109



$nombreTurno = "Histirico Incidencias Jugadores-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

