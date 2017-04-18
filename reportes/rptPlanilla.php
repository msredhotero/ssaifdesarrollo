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
#Establecemos los m�rgenes izquierda, arriba y derecha: 
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
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,4,'CANCHA: '.$rowE['canchas']." - ".$rowE['arbitro']." // ".$rowE['telefono'],0,0,'L',FALSE); 
	//$resJugadores = $serviciosJugadores->TraerJugadoresPorEquipoPlanillas($rowE['idequipo'],$reffecha, $idtorneo);
	
	$resJugadoresA = $serviciosReferencias->traerConectorActivosPorEquiposCategorias($rowE['refconectorlocal'], mysql_result($resTorneo,0,'refcategorias'));
	$resJugadoresB = $serviciosReferencias->traerConectorActivosPorEquiposCategorias($rowE['refconectorvisitante'], mysql_result($resTorneo,0,'refcategorias'));
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(79,4,'Local: ('.$rowE['refconectorlocal'].") ".$rowE['equipolocal'],1,0,'C',false);
	$pdf->Cell(19,4,'Goles:',1,0,'C',false);
	$pdf->Cell(4,4,'',0,0,'C',false);
	$pdf->Cell(79,4,'Visitante: ('.$rowE['refconectorvisitante'].") ".$rowE['equipovisitante'],1,0,'C',false);
	$pdf->Cell(19,4,'Goles:',1,0,'C',false);
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(6,4,'Nro',1,0,'C',false);
	$pdf->Cell(35,4,'Apellido y Nombre',1,0,'C',false);
	$pdf->Cell(6,4,'GF',1,0,'C',false);
	$pdf->Cell(6,4,'GC',1,0,'C',false);
	$pdf->Cell(7,4,'A/E',1,0,'C',false);
	$pdf->Cell(19,4,'Carnet',1,0,'C',false);
	$pdf->Cell(19,4,'Firma',1,0,'C',false);
	
	$pdf->Cell(4,4,'',0,0,'C',false);
	$pdf->Cell(6,4,'Nro',1,0,'C',false);
	$pdf->Cell(35,4,'Apellido y Nombre',1,0,'C',false);
	$pdf->Cell(6,4,'GF',1,0,'C',false);
	$pdf->Cell(6,4,'GC',1,0,'C',false);
	$pdf->Cell(7,4,'A/E',1,0,'C',false);
	$pdf->Cell(19,4,'Carnet',1,0,'C',false);
	$pdf->Cell(19,4,'Firma',1,0,'C',false);
	
	
	$inicializaY = $pdf->GetY();
	$i = 0;
	while ($rowJ = mysql_fetch_array($resJugadoresA))
	{
		
		$cadCumpleEdad = '';
		$errorDoc = 'FALTA';
		$cadErrorDoc = '';
		$habilitacion= 'INHAB.';
		$transitoria= '';
		$valorDocumentacion = 0;
		
		$edad = $serviciosReferencias->verificarEdad($rowJ['refjugadores']);

		$cumpleEdad = $serviciosReferencias->verificaEdadCategoriaJugador($rowJ['refjugadores'], $rowJ['refcategorias'], $rowJ['idtipojugador']);
		
		$documentaciones = $serviciosReferencias->traerJugadoresdocumentacionPorJugadorValores($rowJ['refjugadores']);
		
		if ($cumpleEdad == 1) {
			$cadCumpleEdad = "CUMPLE";	
		} else {
			// VERIFICO SI EXISTE ALGUNA HABILITACION TRANSITORIA
			$habilitacionTransitoria = $serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorDeportiva($rowJ['refjugadores'], $idTemporada, $rowJ['refcategorias'],$rowJ['refequipos']);
			if (mysql_num_rows($habilitacionTransitoria)>0) {
				$cadCumpleEdad = "HAB. TRANS.";	
			} else {
				$cadCumpleEdad = "NO CUMPLE";	
			}
		}
		
		if (mysql_num_rows($documentaciones)>0) {
			while ($rowH = mysql_fetch_array($documentaciones)) {
				if (($rowH['valor'] == 'No') && ($rowH['contravalor'] == 'No')) {
					if ($rowH['obligatoria'] == 'Si') {
						$valorDocumentacion += 1;	
					}
					$cadErrorDoc .= strtoupper($rowH['descripcion']).' - ';
				}
			}
			if ($cadErrorDoc == '') {
				$cadErrorDoc = 'OK';
				$errorDoc = 'OK';
			} else {
				$cadErrorDoc = substr($cadErrorDoc,0,-3);
			}
			
		} else {
			$cadErrorDoc = 'FALTA PRESENTAR DOCUMENTACIONES';
		}
		
		if ($valorDocumentacion == 0 && $cadCumpleEdad == 'CUMPLE') {
			if ($cadErrorDoc ==  'FALTA PRESENTAR DOCUMENTACIONES') {
				$habilitacion= 'INHAB.';	
			} else {
				$habilitacion= 'HAB.';	
			}
		}
									
									
		$pdf->SetFillColor(183,183,183);
		$i = $i+1;
		$pdf->Ln();
		
		$pdf->SetX(5);
		
		$pdf->Cell(6,4,'',1,0,'C',false);
		$pdf->Cell(35,4,$rowJ['nombrecompleto'],0,0,'L',false);
		$pdf->Cell(6,4,'',1,0,'C',false);
		$pdf->Cell(6,4,'',1,0,'C',false);
		$pdf->Cell(7,4,'',1,0,'C',false);
		$pdf->Cell(19,4,$rowJ['nrodocumento'],0,0,'C',false);
		if (($habilitacion == 'HAB.') || ($cadCumpleEdad == 'HAB. TRANS.')) { 
			$pdf->Cell(19,4,'___________',0,0,'C',false);
		} else {
			$pdf->Cell(19,4,'INHAB.',0,0,'C',false);	
		}


		if ($i == 27) {
			break;	
		}
	}
	
	if ($i < 28) {
		for ($j=$i+1;$j<28;$j++) {
			$pdf->Ln();
			$pdf->SetX(5);
			$pdf->Cell(98,5,'',0,0,'C',false);
			
		}
	}
	
	
	$i = 0;
	$pdf->SetX(107);
	$pdf->SetY($inicializaY - 1);
	while ($rowV = mysql_fetch_array($resJugadoresB))
	{
		$pdf->SetFillColor(183,183,183);
		$i = $i+1;
		$pdf->Ln();
		$pdf->SetX(107);
		
		$pdf->Cell(6,4,'',1,0,'C',false);
		$pdf->Cell(35,4,$rowV['nombrecompleto'],0,0,'L',false);
		$pdf->Cell(6,4,'',1,0,'C',false);
		$pdf->Cell(6,4,'',1,0,'C',false);
		$pdf->Cell(7,4,'',1,0,'C',false);
		$pdf->Cell(19,4,$rowV['nrodocumento'],0,0,'C',false);
		$pdf->Cell(19,4,'___________',0,0,'C',false);


		if ($i == 27) {
			break;	
		}
	}
	
	if ($i < 28) {
		for ($j=$i+1;$j<28;$j++) {
			$pdf->Ln();
			$pdf->SetX(107);
			$pdf->Cell(98,5,'',0,0,'C',false);
			
		}
	}
	
	

	$pdf->SetX(5);
	$pdf->SetY(240);
	$pdf->Cell(18,4,'Totales',0,0,'L',false);
	$pdf->Cell(40,4,'Amonestados _________',0,0,'L',false);
	$pdf->Cell(40,4,'Expulsados _________',0,0,'L',false);
	$pdf->Cell(4,4,'',0,0,'L',false);
	$pdf->Cell(18,4,'Totales',0,0,'L',false);
	$pdf->Cell(40,4,'Amonestados _________',0,0,'L',false);
	$pdf->Cell(40,4,'Expulsados _________',0,0,'L',false);
	
	/*******************  CAMBIOS  *************************/
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,5,'CAMBIOS',1,0,'C',true);
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(5,4,'',0,0,'L',false);
	$pdf->Cell(15,4,'Entro',0,0,'C',false);
	$pdf->Cell(15,4,'Salio',0,0,'C',false);
	$pdf->Cell(15,4,'Minuto',0,0,'C',false);
	$pdf->Cell(15,4,'Entro',0,0,'C',false);
	$pdf->Cell(15,4,'Salio',0,0,'C',false);
	$pdf->Cell(15,4,'Minuto',0,0,'C',false);
	
	$pdf->Cell(9,4,'',0,0,'C',false);
	
	$pdf->Cell(15,4,'Entro',0,0,'C',false);
	$pdf->Cell(15,4,'Salio',0,0,'C',false);
	$pdf->Cell(15,4,'Minuto',0,0,'C',false);
	$pdf->Cell(15,4,'Entro',0,0,'C',false);
	$pdf->Cell(15,4,'Salio',0,0,'C',false);
	$pdf->Cell(15,4,'Minuto',0,0,'C',false);
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(5,4,'',0,0,'L',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	
	$pdf->Cell(9,4,'',0,0,'C',false);
	
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(5,4,'',0,0,'L',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	
	$pdf->Cell(9,4,'',0,0,'C',false);
	
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(5,4,'',0,0,'L',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	
	$pdf->Cell(9,4,'',0,0,'C',false);
	
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	$pdf->Cell(15,4,'_______',0,0,'C',false);
	
	/******************** FIN CAMBIOS **********************************/
	
	
	/*******************  FIRMAS  *************************/
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,5,'CAMBIOS',1,0,'C',true);
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell(40,4,'Al inicio del partido:',0,0,'C',false);
	$pdf->SetFont('Arial','',8);
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,4,'Capitan: ____________ Delegado: ____________ Acl: ______________ Capitan: ____________ Delegado: ____________ Acl: ______________',0,0,'C',false);
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','U',8);
	$pdf->Cell(40,4,'Al finalizar el partido:',0,0,'C',false);
	$pdf->SetFont('Arial','',8);
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,4,'          Firma del Delegado: __________________________                Firma del Delegado: __________________________',0,0,'C',false);
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,4,'Nombre y Apellido del Arbitro: ____________________________________                Firma del Arbitro: __________________________',0,0,'C',false);
	
	
	
	/******************** FIN FIRMAS **********************************/
	
	

}
//120 x 109



$nombreTurno = "Planillas-".$fecha.".pdf";

$pdf->Output($nombreTurno,'D');


?>
