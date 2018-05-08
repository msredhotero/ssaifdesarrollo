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
$numero = count($_POST);
    $tags = array_keys($_POST);// obtiene los nombres de las varibles
    $valores = array_values($_POST);// obtiene los valores de las varibles
    $cantEncontrados = 0;
    $cantidad = 1;
    $idEquipos = 0;
    
    $cadWhere = '';
    $cantEquipos = array();
    
    for($i=0;$i<$numero;$i++){
        
        if (strpos($tags[$i],"equipo") !== false) {
            
            if (isset($valores[$i])) {
                
                $idEquipos = str_replace("equipo","",$tags[$i]);
                
                $cadWhere .= $idEquipos.',';
                array_push($cantEquipos,$cantidad);
                $cantidad += 1;
            }
        }
    }
/////////////////////////////  fin parametross  ///////////////////////////



$resDatos = $serviciosReferencias->traerJugadoresPorWhere( substr( $cadWhere,0,-1));


$xAbs = 0;
$xMov = 101.5;
$xMov2 = 20.3;
$xMov3 = 50;

$yAbs = 0;
$yMov = 38.7;
$yMov2 = 33.8;

$pdf = new FPDF('P','mm',array(340,210));
$cantidadJugadores = 0;
#Establecemos los m�rgenes izquierda, arriba y derecha: 
$pdf->SetMargins(0, 3 , 0); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,1); 

	$pdf->AddPage();

$i=0;
$yPar = 0;

$contadorY1=0;
while ($rowE = mysql_fetch_array($resDatos)) {
	$i+=1;	

	if (($i % 2) == 1) {
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY($xMov2, $yMov2 + (($i - 1) * $yMov));
		$pdf->Cell(30,4,$rowE['nrodocumento'],1,0,'L',false);
		$pdf->SetXY($xMov2, $yMov2 + 4.8 + (($i - 1) * $yMov));
		$pdf->Cell(60,4,strtoupper($rowE['apellido']).' '.strtoupper($rowE['nombres']),1,0,'L',false);
		$pdf->SetXY($xMov2, $yMov2 + 9.8 + (($i - 1) * $yMov));
		$pdf->Cell(30,4,$rowE['nrodocumento'],1,0,'L',false);
		$pdf->SetXY($xMov3, $yMov2 + 9.8 + (($i - 1) * $yMov));
		$pdf->Cell(30,4,$rowE['fechanacimiento'],1,0,'R',false);
		$pdf->SetXY($xMov2, $yMov2 + 14.8 + (($i - 1) * $yMov));
		$pdf->Cell(60,4,$rowE['country'],1,0,'L',false);

		$yPar = (($i - 1) * $yMov);
	} else {
		$pdf->SetFont('Arial','',9);
		$pdf->SetXY($xMov2 + $xMov, $yMov2 + $yPar);
		$pdf->Cell(30,4,$rowE['nrodocumento'],1,0,'L',false);
		$pdf->SetXY($xMov2 + $xMov, $yMov2 + 4.8 + $yPar);
		$pdf->Cell(60,4,strtoupper($rowE['apellido']).' '.strtoupper($rowE['nombres']),1,0,'L',false);
		$pdf->SetXY($xMov2 + $xMov, $yMov2 + 9.8 + $yPar);
		$pdf->Cell(30,4,$rowE['nrodocumento'],1,0,'L',false);
		$pdf->SetXY($xMov3 + $xMov, $yMov2 + 9.8 + $yPar);
		$pdf->Cell(30,4,$rowE['fechanacimiento'],1,0,'R',false);
		$pdf->SetXY($xMov2 + $xMov, $yMov2 + 14.8 + $yPar);
		$pdf->Cell(60,4,$rowE['country'],1,0,'L',false);
	}
	

	$contadorY1 += 4;

	if ($i == 9) {
		$i=0;
		$pdf->AddPage();
	}
	//$pdf->SetY($contadorY1);		


}
//120 x 109


$nombreTurno = "CARNET.pdf";

$pdf->Output($nombreTurno,'I');


?>

