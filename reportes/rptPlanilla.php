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

$refTemporada = $serviciosReferencias->traerUltimaTemporada();

if (mysql_num_rows($refTemporada)>0) {
	$idTemporada = mysql_result($refTemporada,0,0);	
} else {
	$idTemporada = 0;
}

$idtorneo			=	$_GET['idtorneo'];
$reffechas			=	$_GET['reffechas'];

$resEquipos = $serviciosReferencias->traerFixtureTodoPorTorneoFecha($idtorneo,$reffechas);

$resTorneo = $serviciosReferencias->traerTorneosDetallePorId($idtorneo);

$resDefTemp= $serviciosReferencias->traerDefinicionescategoriastemporadasPorTemporadaCategoria(mysql_result($resTorneo,0,'reftemporadas'),mysql_result($resTorneo,0,'refcategorias'));
//echo $resEquipos;

$descripcion 	= mysql_result($resTorneo,0,'descripcion');
$temporada 		= mysql_result($resTorneo,0,'temporada');
$categoria		= mysql_result($resTorneo,0,'categoria');
$division		= mysql_result($resTorneo,0,'division');

$resFecha		= $serviciosReferencias->traerFechasPorId($reffechas);

$reingreso					= mysql_result($resDefTemp,0,'reingreso');
if ($reingreso == 'Si') {
	$descReintegro = 'CON REINGRESOS';
} else {
	$descReintegro = 'SIN REINGRESOS';
}
$minutospartido 			= mysql_result($resDefTemp,0,'minutospartido');
$cantidadcambiosporpartido	= mysql_result($resDefTemp,0,'cantidadcambiosporpartido');
$dia						= mysql_result($resDefTemp,0,'dia');
$hora						= mysql_result($resDefTemp,0,'hora');

$pdf = new FPDF();
$cantidadJugadores = 0;
#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(2, 2 , 2); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,1); 

while ($rowE = mysql_fetch_array($resEquipos)) {
	
	$pdf->AddPage();
	/***********************************    PRIMER CUADRANTE ******************************************/
	
	$pdf->Image('../imagenes/aif_logo.png',2,2,25);

	/***********************************    FIN ******************************************/
	
	
	
	//////////////////// Aca arrancan a cargarse los datos de los equipos  /////////////////////////

	
	$pdf->Ln();
	$pdf->SetX(40);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(155,155,155);
	$pdf->Cell(35,5,'Temporada:',1,0,'L',true);
	$pdf->Cell(70,5,'Temporada '.$temporada,1,0,'L',false);
	$pdf->Cell(50,5,$dia." ".date('d-m-Y')." ".$hora,1,0,'L',false);
	
	
	$pdf->Ln();
	$pdf->SetX(40);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(155,155,155);
	$pdf->Cell(35,5,'Torneo:',1,0,'L',true);
	$pdf->Cell(70,5,$descripcion,1,0,'L',false);
	$pdf->Cell(50,5,$descReintegro,1,0,'L',false);
	
	$pdf->Ln();
	$pdf->SetX(40);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(155,155,155);
	$pdf->Cell(35,5,'Categoria:',1,0,'L',true);
	$pdf->Cell(70,5,$categoria,1,0,'L',false);
	$pdf->Cell(50,5,($minutospartido / 2)." MINUTOS POR TIEMPO",1,0,'L',false);
	
	$pdf->Ln();
	$pdf->SetX(40);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(155,155,155);
	$pdf->Cell(35,5,'Division:',1,0,'L',true);
	$pdf->Cell(40,5,$division,1,0,'L',false);
	$pdf->Cell(80,5,"CAMBIOS PER.: ".$cantidadcambiosporpartido." JUGAD.",1,0,'L',false);
	
	$pdf->Ln();
	$pdf->SetX(40);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(155,155,155);
	$pdf->Cell(35,5,'Fecha:',1,0,'L',true);
	$pdf->Cell(40,5,mysql_result($resFecha,0,'fecha'),1,0,'L',false);
	$pdf->Cell(40,5,'Partido:',1,0,'L',true);
	$pdf->Cell(40,5,mysql_result($resFecha,0,'fecha'),1,0,'L',false);
	
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,5,'PLANILLA DEL PARTIDO',1,0,'C',true);
	$pdf->SetFont('Arial','',9);
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,5,'CANCHA: '.$rowE['canchas']." - ".$rowE['arbitro']." // ".$rowE['telefono'],0,0,'L',FALSE); 
	//$resJugadores = $serviciosJugadores->TraerJugadoresPorEquipoPlanillas($rowE['idequipo'],$reffecha, $idtorneo);
	
	$resJugadoresA = $serviciosReferencias->traerConectorActivosPorEquiposCategorias($rowE['refconectorlocal'], mysql_result($resTorneo,0,'refcategorias'));
	$resJugadoresB = $serviciosReferencias->traerConectorActivosPorEquiposCategorias($rowE['refconectorvisitante'], mysql_result($resTorneo,0,'refcategorias'));
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(79,5,'Local: ('.$rowE['refconectorlocal'].") ".$rowE['equipolocal'],1,0,'C',false);
	$pdf->Cell(19,5,'Goles:',1,0,'C',false);
	$pdf->Cell(4,5,'',0,0,'C',false);
	$pdf->Cell(79,5,'Visitante: ('.$rowE['refconectorvisitante'].") ".$rowE['equipovisitante'],1,0,'C',false);
	$pdf->Cell(19,5,'Goles:',1,0,'C',false);
	
	
	$i = 0;
	while ($rowJ = mysql_fetch_array($resJugadoresA))
	{
		$pdf->SetFillColor(183,183,183);
		$i = $i+1;
		$pdf->Ln();
		$pdf->SetX(5);
		
		if ($rowJ['suspendido'] == '0') {
			$pdf->Cell(49.5,5,strtoupper(utf8_decode($rowJ['apyn'])),1,0,'L',false);
			$pdf->Cell(20,5,$rowJ['dni'],1,0,'C',false);
			$pdf->Cell(25,5,'',1,0,'C',false);
			$pdf->Cell(17.5,5,'',1,0,'C',false);
			$pdf->Cell(15,5,'',1,0,'C',false);
			$pdf->Cell(20,5,'',1,0,'C',false);
			$pdf->Cell(20,5,$serviciosDatos->traerAcumuladosAmarillasPorTorneoZonaJugador($rowE['idtipotorneo'],$rowE['idgrupo'],$reffecha,$rowJ['idjugador']),1,0,'C',false);
			$pdf->Cell(20,5,'',1,0,'C',false);
			$pdf->Cell(13,5,'Si/No',1,0,'C',false);
		} else {
			$pdf->Cell(49.5,5,strtoupper(utf8_decode($rowJ['apyn'])),1,0,'L',true);
			$pdf->Cell(20,5,$rowJ['dni'],1,0,'C',true);
			$pdf->Cell(25,5,'',1,0,'C',true);
			$pdf->Cell(17.5,5,'',1,0,'C',true);
			$pdf->Cell(15,5,'',1,0,'C',true);
			$pdf->Cell(20,5,'',1,0,'C',true);
			$pdf->Cell(20,5,$serviciosDatos->traerAcumuladosAmarillasPorTorneoZonaJugador($rowE['idtipotorneo'],$rowE['idgrupo'],$reffecha,$rowJ['idjugador']),1,0,'C',false);
			$pdf->Cell(20,5,'',1,0,'C',true);
			$pdf->Cell(13,5,'(Susp.)',1,0,'C',true);	
		}
		if ($i == 28) {
			break;	
		}
	}
	
	if ($i < 29) {
		for ($j=$i+1;$j<29;$j++) {
			$pdf->Ln();
			$pdf->SetX(5);
			$pdf->Cell(49.5,5,'',1,0,'C',false);
			$pdf->Cell(20,5,'',1,0,'C',false);
			$pdf->Cell(25,5,'',1,0,'C',false);
			$pdf->Cell(17.5,5,'',1,0,'C',false);
			$pdf->Cell(15,5,'',1,0,'C',false);
			$pdf->Cell(20,5,'',1,0,'C',false);
			$pdf->Cell(20,5,'',1,0,'C',false);
			$pdf->Cell(20,5,'',1,0,'C',false);
			$pdf->Cell(13,5,'',1,0,'C',false);
		}
	}
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(56,5,'Total Goles:',1,0,'L',false);
	$pdf->Cell(56,5,'Total Amarillas:',1,0,'L',false);
	$pdf->Cell(55,5,'Total Rojas:',1,0,'L',false);
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(167,25,'OBSERVACIONES',1,0,'L',false);
	$pdf->Cell(16.5,5,'ENTRO',1,0,'C',false);
	$pdf->Cell(16.5,5,'SALIO',1,0,'C',false);
	$pdf->Ln();
	$pdf->SetX(172);
	$pdf->Cell(16.5,5,'',1,0,'L',false);
	$pdf->Cell(16.5,5,'',1,0,'L',false);
	$pdf->Ln();
	$pdf->SetX(172);
	$pdf->Cell(16.5,5,'',1,0,'L',false);
	$pdf->Cell(16.5,5,'',1,0,'L',false);
	
	$pdf->Ln();
	$pdf->SetX(172);
	$pdf->Cell(16.5,5,'',1,0,'L',false);
	$pdf->Cell(16.5,5,'',1,0,'L',false);
	
	$pdf->Ln();
	$pdf->SetX(172);
	$pdf->Cell(16.5,5,'',1,0,'L',false);
	$pdf->Cell(16.5,5,'',1,0,'L',false);

	
	
	/********* LA FECHA **************////////////////
	$pdf->SetXY(5,260);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(90,6,'FECHA:',0,0,'L',false);
	
	
	
	/********* LAS FIRMAS **************////////////////
	$pdf->SetXY(20,278);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(90,6,'FIRMA DELEGADO:',0,0,'L',false);
	$pdf->Cell(50,6,'ACLARACION:',0,0,'L',false);
}
//120 x 109



$nombreTurno = "Planillas-".$fecha.".pdf";

$pdf->Output($nombreTurno,'D');


?>

