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
$idTemporada 		=	$_GET['reftemporada1'];

$where = '';
$fechaDesde = '';
$fechaHasta = '';
$refCategorias = '';
$refDivisiones = '';
$idtorneo = '';

if (isset($_GET['reftorneo3']) && ($_GET['reftorneo3'] != 0)) {
	$idtorneo			=	$_GET['reftorneo3'];
	$where	.=	' and tor.idtorneo ='.$idtorneo;
} else {
	$idtorneo = 0;
}
if (isset($_GET['reffechadesde1'])) {
	$fechaDesde = $_GET['reffechadesde1'];
}

if (isset($_GET['reffechahasta1'])) {
	$fechaHasta = $_GET['reffechahasta1'];
}
	
if ((isset($_GET['reffechas3'])) && ($_GET['reffechas3'] != 0)) {
	$reffechas			=	$_GET['reffechas3'];
	
} else {
	
	$reffechas = '';
}

if (isset($_GET['refcategorias1']) && $_GET['refcategorias1'] != 0) {
	$refCategorias		=	$_GET['refcategorias1'];
	$where	.=	' and ca.idtcategoria ='.$refCategorias;
}

if (isset($_GET['refdivision1']) && $_GET['refdivision1'] != 0) {
	$refDivisiones		=	$_GET['refdivision1'];
	$where	.=	' and di.iddivision ='.$refDivisiones;
}



/////////////////////////////  fin parametross  ///////////////////////////

if ($reffechas == '') {
	$resEquipos = $serviciosReferencias->traerFixtureTodoPorTorneoDesdeHastaWhere($idTemporada,$fechaDesde,$fechaHasta,$where);
} else {
	$resEquipos = $serviciosReferencias->traerFixtureTodoPorTorneoFecha($idtorneo,$reffechas);
}
//die(print_r($resEquipos));

if ($idtorneo != 0) {
	
}
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

	
	
	
	//$resJugadores = $serviciosJugadores->TraerJugadoresPorEquipoPlanillas($rowE['idequipo'],$reffecha, $idtorneo);
	
	$cantPartidos = 0;
	$i=0;
	
	$contadorY1 = 44;
	$contadorY2 = 44;

	$primero = 0;
	$fechasA = 0;
	$torneoA = 0;
	$categoriaA = 0;
	$divisionA = 0;

	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetY(25);
while ($rowE = mysql_fetch_array($resEquipos)) {
	$i=0;	
	$cantPartidos += 1;
	
	if (($fechasA != $rowE['reffechas']) || ($torneoA != $rowE['reftorneos']) || ($categoriaA != $rowE['refcategorias']) || ($divisionA != $rowE['refdivisiones'])) {

		if ($primero == 1) {
			$pdf->AddPage();

			$pdf->Image('../imagenes/logoparainformes.png',2,2,40);

			$cantPartidos = 0;
			$i=0;
			
			$contadorY1 = 44;
			$contadorY2 = 44;

			$pdf->Ln();
			$pdf->Ln();
			$pdf->SetY(25);
		}

		$fechasA = $rowE['reffechas'];
		$torneoA = $rowE['reftorneos'];
		$categoriaA = $rowE['refcategorias'];
		$divisionA = $rowE['refdivisiones'];

		$resTorneo = $serviciosReferencias->traerTorneosDetallePorId($rowE['reftorneos']);

		$resDefTemp= $serviciosReferencias->traerDefinicionescategoriastemporadasPorTemporadaCategoria(mysql_result($resTorneo,0,'reftemporadas'),mysql_result($resTorneo,0,'refcategorias'));
		//echo $resEquipos;

		$descripcion 	= mysql_result($resTorneo,0,'descripcion');
		$temporada 		= mysql_result($resTorneo,0,'temporada');
		$categoria		= mysql_result($resTorneo,0,'categoria');
		$division		= mysql_result($resTorneo,0,'division');


		$resFecha		= $serviciosReferencias->traerFechasPorId($rowE['reffechas']);
		$reffechas 		= $rowE['fecha'];

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

		$pdf->SetFont('Arial','B',10);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(200,5,'TABLA DE RESULTADOS AL '.date('Y-m-d'),1,0,'C',false);
		$pdf->SetFont('Arial','',8);
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(200,4,'Temporada: '.$temporada,0,0,'C',FALSE); 
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(200,4,'Torneo: '.$descripcion." - Categoria: ".$categoria." - División: ".$division." - Fecha: ".$reffechas." - ".$rowE['fechapartido'],0,0,'C',FALSE);

		$primero = 1;
	}


	if ($contadorY1 > 200) {
		$pdf->AddPage();
		$pdf->Image('../imagenes/logoparainformes.png',2,2,40);	
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetY(25);
		$pdf->SetX(5);
		$pdf->Cell(200,5,'TABLA DE RESULTADOS AL '.date('Y-m-d'),1,0,'C',false);
		$pdf->SetFont('Arial','',8);
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(200,4,'Temporada: '.$temporada,0,0,'C',FALSE); 
		$pdf->Ln();
		$pdf->SetX(5);
		$pdf->Cell(200,4,'Torneo: '.$descripcion." - Categoria: ".$categoria." - División: ".$division." - Fecha: ".$reffechas." - ".$rowE['fechapartido'],0,0,'C',FALSE);
		//$resJugadores = $serviciosJugadores->TraerJugadoresPorEquipoPlanillas($rowE['idequipo'],$reffecha, $idtorneo);
		
		$cantPartidos = 0;
		$i=0;
		
		$contadorY1 = 44;
		$contadorY2 = 44;
	}
	
	$resJugadoresA = $serviciosReferencias->traerIncidenciasPorFixtureEquipoLocal($rowE['idfixture'],$rowE['refconectorlocal']);
	$resJugadoresB = $serviciosReferencias->traerIncidenciasPorFixtureEquipoVisitante($rowE['idfixture'],$rowE['refconectorvisitante']);
	$pdf->SetFont('Arial','',9);
	$pdf->SetFillColor(155,155,155);
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(25,4,$cantPartidos,1,0,'C',true);
	$pdf->Cell(79,4,'('.$rowE['refconectorlocal'].") ".$rowE['equipolocal'],1,0,'R',true);
	$pdf->Cell(8,4,$rowE['goleslocal'],1,0,'C',true);
	$pdf->Cell(8,4,$rowE['golesvisitantes'],1,0,'C',true);
	$pdf->Cell(79,4,'('.$rowE['refconectorvisitante'].") ".$rowE['equipovisitante'],1,0,'L',true);
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,4,'Estado Partido: '.$rowE['estado']." - Arbitro: ".$rowE['arbitro'],0,0,'L',FALSE);
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,4,"Juez1: ".$rowE['juez1']." - Juez2: ".$rowE['juez2'],0,0,'L',FALSE);
	$pdf->SetFont('Arial','',7);
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(15,4,'Nro',0,0,'C',false);
	$pdf->Cell(40,4,'Apellido y Nombre',0,0,'C',false);
	$pdf->Cell(6,4,'GF',0,0,'C',false);
	$pdf->Cell(6,4,'GC',0,0,'C',false);
	$pdf->Cell(7,4,'A/E/I',0,0,'C',false);
	$pdf->Cell(6,4,'PC',0,0,'C',false);
	$pdf->Cell(6,4,'PA',0,0,'C',false);
	$pdf->Cell(6,4,'PE',0,0,'C',false);
	
	$pdf->Cell(8,4,'',0,0,'C',false);
	$pdf->Cell(15,4,'Nro',0,0,'C',false);
	$pdf->Cell(40,4,'Apellido y Nombre',0,0,'C',false);
	$pdf->Cell(6,4,'GF',0,0,'C',false);
	$pdf->Cell(6,4,'GC',0,0,'C',false);
	$pdf->Cell(7,4,'A/E/I',0,0,'C',false);
	$pdf->Cell(6,4,'PC',0,0,'C',false);
	$pdf->Cell(6,4,'PA',0,0,'C',false);
	$pdf->Cell(6,4,'PE',0,0,'C',false);
	
	
	$inicializaY = $pdf->GetY();
	$contadorY1 = $inicializaY;
	$contadorY2 = $inicializaY;
	$i = 0;
	while ($rowJ = mysql_fetch_array($resJugadoresA))
	{
						
		$pdf->SetFillColor(183,183,183);
		$i = $i+1;
		$pdf->Ln();
		
		$pdf->SetX(5);
		
		$pdf->Cell(15,4,$rowJ['nrodocumento'],0,0,'C',false);
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(40,4,substr($rowJ['apyn'],0,20),0,0,'L',false);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(6,4,$rowJ['goles'],0,0,'C',false);
		$pdf->Cell(6,4,$rowJ['encontra'],0,0,'C',false);
		$pdf->Cell(7,4,($rowJ['aei'] == '0' ? '' : $rowJ['aei']),0,0,'C',false);
		$pdf->Cell(6,4,$rowJ['pc'],0,0,'C',false);
		$pdf->Cell(6,4,$rowJ['pa'],0,0,'C',false);
		$pdf->Cell(6,4,$rowJ['pe'],0,0,'C',false);
		

		$contadorY1 += 4;

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
		
		$pdf->Cell(15,4,$rowV['nrodocumento'],0,0,'C',false);
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(40,4,substr($rowV['apyn'],0,20),0,0,'L',false);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(6,4,$rowV['goles'],0,0,'C',false);
		$pdf->Cell(6,4,$rowV['encontra'],0,0,'C',false);
		$pdf->Cell(7,4,($rowV['aei'] == '0' ? '' : $rowV['aei']),0,0,'C',false);
		$pdf->Cell(6,4,$rowV['pc'],0,0,'C',false);
		$pdf->Cell(6,4,$rowV['pa'],0,0,'C',false);
		$pdf->Cell(6,4,$rowV['pe'],0,0,'C',false);

		$contadorY2 += 4;
		if ($i == 27) {
			break;	
		}
	}
	

	
	
	if ($contadorY1 > $contadorY2) {
		$pdf->SetY($contadorY1);		
	} else {
		$pdf->SetY($contadorY2);
	}

}
//120 x 109



$nombreTurno = "INFORME-RESULTADOS-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

