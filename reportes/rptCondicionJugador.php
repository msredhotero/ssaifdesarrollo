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

$id				=	$_GET['id'];

$datos		=	$serviciosReferencias->traerConectorActivosPorEquipos($id);

$equipo		=	$serviciosReferencias->traerEquiposPorEquipo($id);

$idCategoria=	mysql_result($equipo,0,'refcategorias');

class PDF extends FPDF
{
// Cargar los datos




// Tabla coloreada
function ingresosFacturacion($header, $data, &$TotalIngresos, $servicios, $refcategoria)
{

	$this->Ln();

	$this->SetFont('Arial','',11);
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
	$this->Ln();
	
	
    // Cabecera
    $w = array(16,35,25,35,18,35,20,20);
    for($i=0;$i<count($header);$i++) {
		if (($i == 5) || ($i == 6)) {
			$this->SetFont('Arial','',8);
		} else {
			$this->SetFont('Arial','',11);
		}
        $this->Cell($w[$i],6,$header[$i],1,0,'C',true);
	}
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
	
	$total = 0;
	$totalcant = 0;
	$sumSaldos = 0;
	$sumAbonos = 0;
	$cadCumpleEdad = '';
	
	$this->SetFont('Arial','',9);
    while ($row = mysql_fetch_array($data))
    {
		$edad = $servicios->verificarEdad($row['refjugadores']);
		
		$cumpleEdad = $servicios->verificaEdadCategoriaJugador($row['refjugadores'], $refcategoria, $row['idtipojugador']);
		
		if ($cumpleEdad == 1) {
			$cadCumpleEdad = "Cumple";	
		} else {
			// VERIFICO SI EXISTE ALGUNA HABILITACION TRANSITORIA
			$cadCumpleEdad = "No Cumple";	
		}
		
        $this->Cell($w[0],5,$row['nrodocumento'],'LR',0,'C',$fill);
		$this->Cell($w[1],5,substr($row['nombrecompleto'],0,60),'LR',0,'L',$fill);
        $this->Cell($w[2],5,$row['fechanacimiento']." (".$edad.")",'LR',0,'C',$fill);
		$this->Cell($w[3],5,$row['countrie'],'LR',0,'L',$fill);
		$this->Cell($w[4],5,'','LR',0,'C',$fill);
		$this->Cell($w[5],5,'','LR',0,'L',$fill);
		$this->Cell($w[6],5,$cadCumpleEdad,'LR',0,'C',$fill);
		$this->Cell($w[7],5,'','LR',0,'C',$fill);
        $this->Ln();
        
		
		if ($totalcant == 25) {
			$this->AddPage();
			$this->SetFont('Arial','',11);
			// Colores, ancho de línea y fuente en negrita
			$this->SetFillColor(255,0,0);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
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
		}
    }
	

	$fill = !$fill;
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
	$this->SetFont('Arial','',12);
	$this->Ln();

}

}






$pdf = new PDF();


// Títulos de las columnas

$headerFacturacion = array("Carnet", "Jugador", "Fec. Nac.", "Country","Est. Doc.", "Obs. Doc.", "Cumple Edad", "Condición");
// Carga de datos

$pdf->AddPage();

$pdf->SetMargins(3, 5 , 3); 

$pdf->Image('../imagenes/aif_logo.png',2,2,40);
$pdf->SetFont('Arial','U',17);
$pdf->Cell(188,7,strtoupper('Condicion de Jugador'),0,0,'C',false);
$pdf->Ln();
$pdf->Cell(200,7,'Fecha: '.date('Y-m-d'),0,0,'C',false);
$pdf->Ln();
$pdf->Cell(200,7,'Equipo: '.mysql_result($equipo,0,'nombre'),0,0,'C',false);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->Cell(35,5,'Temporada: 2016',1,0,'L',false);
$pdf->Cell(55,5,'Country: '.mysql_result($equipo,0,'countrie'),1,0,'L',false);
$pdf->Cell(55,5,'Categoria: '.mysql_result($equipo,0,'categoria'),1,0,'L',false);
$pdf->Cell(55,5,'División: '.mysql_result($equipo,0,'division'),1,0,'L',false);
$pdf->Ln();
$pdf->Cell(35,5,'Jugadores: ',1,0,'L',false);
$pdf->Cell(55,5,'Edad Min.: '.mysql_result($equipo,0,'countrie'),1,0,'L',false);
$pdf->Cell(55,5,'Edad Max.: '.mysql_result($equipo,0,'categoria'),1,0,'L',false);
$pdf->Cell(55,5,'Promedio: '.mysql_result($equipo,0,'division'),1,0,'L',false);

$pdf->SetFont('Arial','',10);

$pdf->ingresosFacturacion($headerFacturacion,$datos,$TotalFacturacion,$serviciosReferencias, $idCategoria);

$pdf->Ln();

$pdf->SetFont('Arial','',9);

$nombreTurno = "rptCondicionJugador-".$fecha.".pdf";

$pdf->Output($nombreTurno,'D');


?>

