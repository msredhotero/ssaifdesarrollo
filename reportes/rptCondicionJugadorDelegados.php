<?php

date_default_timezone_set('America/Buenos_Aires');

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesDelegados.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 			= new ServiciosReferencias();
$serviciosDelegados				= new serviciosDelegados();

$fecha = date('Y-m-d');

require('fpdf.php');

//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

$generalTotalJugadores = 0;
$generalTotalJugadoresHabilitados = 0;

$idTemporada = $_GET['reftemporada'];

if ((isset($_GET['id'])) || ($_GET['id'] != 0)) {
	$id				=	$_GET['id'];
} else {
	$id				=	0;
}



class PDF extends FPDF
{
// Cargar los datos




// Tabla coloreada
function ingresosFacturacion($header, $data, &$TotalIngresos, $servicios, $refcategoria, $idTemporada)
{

	$totalhabilitadoscuenta = 0;
	$totalJugadores = 0;
	$this->Ln();

	$this->SetFont('Arial','',11);
    // Colores, ancho de l�nea y fuente en negrita
    $this->SetFillColor(72,72,72);
    $this->SetTextColor(255);
    $this->SetDrawColor(85,85,85);
    $this->SetLineWidth(.3);
	$this->Ln();


    // Cabecera
    $w = array(18,40,25,30,18,35,20,20);
    for($i=0;$i<count($header);$i++) {
		if (($i == 6) || ($i == 7)) {
        	$this->SetFont('Arial','',9);
		} else {
			$this->SetFont('Arial','',11);
		}
		$this->Cell($w[$i],6,$header[$i],1,0,'C',true);
	}
    $this->Ln();
    // Restauraci�n de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;

	$total = 0;
	$totalcant = 1;
	$sumSaldos = 0;
	$sumAbonos = 0;


	$x = 0;
	$y = 0;
	$yN = 0;
	$yInicial = 0;

	$x = $this->GetX();
	$y = $this->GetY();

	$aumentoNombre = 0;

	$tieneAlgunaHabilitacionTrans = 0;

    while ($row = mysql_fetch_array($data))
    {

    	$totalJugadores += 1;

		$cadCumpleEdad = '';
		$errorDoc = 'FALTA';
		$cadErrorDoc = '';
		$habilitacion= 'INHAB.';
		$transitoria= '';
		$valorDocumentacion = 0;
		$documentaciones = '';
		$tieneAlgunaHabilitacionTrans = 0;

		$yInicial = $this->GetY();

		$edad = $servicios->verificarEdad($row['refjugadores']);

		$cumpleEdad = $servicios->verificaEdadCategoriaJugador($row['refjugadores'], $refcategoria, $row['idtipojugador']);

		$documentaciones = $servicios->traerJugadoresdocumentacionPorJugadorValores($row['refjugadores']);

		if ($cumpleEdad == 1) {
			$cadCumpleEdad = "CUMPLE";
		} else {
			// VERIFICO SI EXISTE ALGUNA HABILITACION TRANSITORIA
			$habilitacionTransitoria = $servicios->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorDeportiva($row['refjugadores'], $idTemporada, $refcategoria, $row['refequipos']);
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
						if (mysql_num_rows($servicios->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorAdministrativaDocumentacion($row['refjugadores'],$rowH['refdocumentaciones']))>0) {
							$valorDocumentacion -= 1;
							$tieneAlgunaHabilitacionTrans = 1;
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

		if (($row['fechabaja'] != '1900-01-01') && ($row['fechabaja'] != '') && ($row['fechabaja'] < date('Y-m-d'))) {
			$habilitacion= 'INHAB/Baja';
		} else {
			if ($valorDocumentacion <= 0 && ($cadCumpleEdad == 'CUMPLE' || $cadCumpleEdad == "HAB. TRANS.")) {
				if ($cadErrorDoc == 'FALTAN PRESENTAR TODAS LAS DOCUMENTACIONES') {
					$habilitacion= 'INHAB.';
				} else {
					$habilitacion= 'HAB.';
					$totalhabilitadoscuenta += 1;
				}
			} else {
				$habilitacion= 'INHAB.';
			}
		}

		$resSuspendido = $servicios->SuspendidosTotalPorJugador($row['refjugadores']);
		if (mysql_num_rows($resSuspendido) > 0) {
			if (mysql_result($resSuspendido,0,'poracumulacion') == 1) {
				if (mysql_result($resSuspendido,0,'idtcategoria') == $row['refcategorias']) {
					$habilitacion .= '/Susp.';
				}
			} else {
				$habilitacion .= '/Susp.';
			}
		}



		$this->SetXY($x, $y);
		$yN = $y;
        $this->MultiCell($w[0],5,$row['nrodocumento'],'','C');
		if ($this->GetY() > $yN + 5) {
			$yN = $this->GetY();
		}
		$this->SetXY($x + $w[0] , $y);
		$this->MultiCell($w[1],5,strtoupper(substr($row['nombrecompleto'],0,60)),'','L');
        if ($this->GetY() > $yN + 5) {
			$yN = $this->GetY();
		}
		$this->SetXY($x + $w[0] + $w[1] , $y);
		$this->MultiCell($w[2],5,$row['fechanacimiento']." (".$edad.")",'','C');
		if ($this->GetY() > $yN + 5) {
			$yN = $this->GetY();
		}
		$this->SetXY($x + $w[0] + $w[1] + $w[2], $y);
		$this->MultiCell($w[3],5,strtoupper($row['countrie']),'','L');
		if ($this->GetY() > $yN + 4) {
			$yN = $this->GetY();
		}
		$this->SetXY($x + $w[0] + $w[1] + $w[2] + $w[3], $y);

		if ($tieneAlgunaHabilitacionTrans == 1) {
			$this->SetFont('Arial','',6);
			$this->MultiCell($w[4],5,'HAB TRANSi.','','C');
			if ($this->GetY() > $yN + 5) {
				$yN = $this->GetY();
			}
		} else {
			$this->SetFont('Arial','',8);
			$this->MultiCell($w[4],5,$errorDoc,'','C');
			if ($this->GetY() > $yN + 5) {
				$yN = $this->GetY();
			}
		}

		$this->SetXY($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4], $y);
		$this->MultiCell($w[5],5,$cadErrorDoc,'','L');
		if ($this->GetY() >= $yN + 5) {

			$totalcant = $yN;

			$yN = $this->GetY();
		}
		$this->SetXY($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5], $y);
		$this->SetFont('Arial','',8);
		$this->MultiCell($w[6],5,$cadCumpleEdad,'','L');
		if ($this->GetY() > $yN + 5) {
			$yN = $this->GetY();
		}
		$this->SetXY($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5] + $w[6], $y);
		$this->SetFont('Arial','',9);


		$this->MultiCell($w[7],5,$habilitacion,'','C');
        if ($this->GetY() > $yN + 5) {
			$yN = $this->GetY();
		}


		if ($yN >= 250) {
			$this->AddPage();



			$this->SetFont('Arial','',11);
			// Colores, ancho de l�nea y fuente en negrita
			$this->SetFillColor(72,72,72);
			$this->SetTextColor(255);
			$this->SetDrawColor(85,85,85);
			$this->SetLineWidth(.3);
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],6,$header[$i],1,0,'C',true);
			$this->Ln();
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('');
			// Datos
			$fill = false;
			$this->SetFont('Arial','',9);
			$this->SetXY(5, 20);
			$y = 22;
			$x=3;
			$yN=11;
			$totalcant = 1;
			$this->SetY(11);
		}

		$aumentoNombre = 0;
		$y = $yN;
		$documentaciones = '';
		$cadErrorDoc = '';
		$this->SetXY($x, $yN);
		$this->Cell(array_sum($w),0,'','T');

    }


	$fill = !$fill;
    // L�nea de cierre
	$this->SetXY($x, $yN);
    $this->Cell(array_sum($w),0,'','T');
	$this->SetFont('Arial','',12);
	$this->Ln();

	return array(0=>$totalJugadores, $totalhabilitadoscuenta);

}


}






$pdf = new PDF();


// T�tulos de las columnas

$headerFacturacion = array("Carnet", "Jugador", "Fec. Nac.", "Country","Est. Doc.", "Obs. Doc.", "Cumple Edad", "Condici�n");
// Carga de datos


$idCountry  = 	$_GET['refcountries'];

$lstEquipos =	$serviciosReferencias->traerConectorActivosPorEquiposCountryEquipos($idCountry);


$resTemporada	=	$serviciosReferencias->traerTemporadasPorId($idTemporada);


while ($rowC = mysql_fetch_array($lstEquipos)) {
	$datos		=	$serviciosReferencias->traerConectorActivosPorEquiposCountry($idCountry,$rowC['idequipo']);

	$datosEdades=	$serviciosReferencias->traerConectorActivosPorEquiposCountryEquiposEdades($idCountry,$rowC['idequipo']);

	$equipo		=	$serviciosReferencias->traerEquiposdelegadosPorEquipo($rowC['idequipo']);

	$idCategoria=	mysql_result($equipo,0,'refcategorias');

	$definiciones=  $serviciosReferencias->traerDefinicionesPorTemporadaCategoria($idTemporada, $idCategoria);

	$pdf->AddPage();

	$pdf->SetMargins(3, 5 , 3);

	$pdf->Image('../imagenes/aif_logo.png',2,2,30);
	$pdf->SetFont('Arial','U',17);
	$pdf->Cell(188,7,strtoupper('Condicion de Jugador'),0,0,'C',false);
	$pdf->Ln();
	$pdf->Cell(200,7,'Fecha: '.date('Y-m-d'),0,0,'C',false);
	$pdf->Ln();
	$pdf->Cell(200,7,'Equipo: '.mysql_result($equipo,0,'nombre')." (".$rowC['idequipo'].")",0,0,'C',false);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(35,5,'Temporada: '.mysql_result($resTemporada,0,1),1,0,'L',false);
	$pdf->Cell(75,5,'Country: '.$rowC['countrie'],1,0,'L',false);
	$pdf->Cell(50,5,'Categoria: '.$rowC['categoria'],1,0,'L',false);
	$pdf->Cell(45,5,'Divisi�n: '.$rowC['division'],1,0,'L',false);
	$pdf->Ln();
	$pdf->Cell(35,5,'Jugadores: '.mysql_result($datosEdades,0,'cantidadJugadores'),1,0,'L',false);
	$pdf->Cell(75,5,'Edad Min.: '.mysql_result($datosEdades,0,'edadMinima'),1,0,'L',false);
	$pdf->Cell(50,5,'Edad Max.: '.mysql_result($datosEdades,0,'edadMaxima'),1,0,'L',false);
	$pdf->Cell(45,5,'Promedio: '.number_format(mysql_result($datosEdades,0,'edadPromedio'),2,',','.'),1,0,'L',false);

	$pdf->SetFont('Arial','',10);

	$res = $pdf->ingresosFacturacion($headerFacturacion,$datos,$TotalFacturacion,$serviciosReferencias, $idCategoria, $idTemporada);

	$generalTotalJugadores += $res[0];
	$generalTotalJugadoresHabilitados += $res[1];
	$pdf->Ln();
	$pdf->Cell(70,7,'Jugadores/Habilitados: '.$res[0].'/'.$res[1],1,0,'L',false);

}
$pdf->Ln();

$pdf->SetFont('Arial','',12);

$pdf->Cell(110,7,'Totales Generales Jugadores/Habilitados: '.$generalTotalJugadores.'/'.$generalTotalJugadoresHabilitados,1,0,'L',false);

$nombreTurno = "rptCondicionJugador-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>
