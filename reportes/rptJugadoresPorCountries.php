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
$idCountries		=	$_GET['refcountries1'];
/////////////////////////////  fin parametross  ///////////////////////////


$resDatos = $serviciosReferencias->traerJugadoresClubPorCountrieActivos($idCountries);

if ($_GET['bajas1'] == 'true') {
	$resDatosBaja = $serviciosReferencias->traerJugadoresPorCountriesBaja($idCountries);
} else {
	$resDatosBaja = $serviciosReferencias->traerJugadoresPorCountriesBaja(0);
}

$resCountrie = $serviciosReferencias->traerCountriesPorId($idCountries);

$lstNuevosJugadores = $serviciosReferencias->traerJugadoresprePorCountries($idCountries);
//echo $resEquipos;

$nombre 	= mysql_result($resCountrie,0,'nombre');



$pdf = new FPDF();


function Footer($pdf)
{

$pdf->SetY(-10);

$pdf->SetFont('Arial','I',8);

$pdf->Cell(0,10,'Firma Presidente o Secretario: ______________________________________________  -  Pagina '.$pdf->PageNo()." - Fecha: ".date('Y-m-d'),0,0,'C');
}


$cantidadJugadores = 0;
#Establecemos los m�rgenes izquierda, arriba y derecha: 
//$pdf->SetMargins(2, 2 , 2); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(false,1); 


	
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
	$pdf->Cell(200,5,'Padron Socios Propietarios - '.utf8_decode($nombre),1,0,'C',true);
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->Cell(200,5,'Fecha: '.date('d-m-Y').' - Hora: '.date('H:i:s'),1,0,'C',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,4,'',1,0,'C',false);
	$pdf->Cell(60,4,'Apellido y Nombre',1,0,'C',false);
	$pdf->Cell(15,4,'Nro. Doc.',1,0,'C',false);
	$pdf->Cell(15,4,'Fec. Nac',1,0,'C',false);
	$pdf->Cell(40,4,'Numero Socio/Lote',1,0,'C',false);
	$pdf->Cell(16,4,'Baja',1,0,'C',false);
	$pdf->Cell(30,4,'Art 2 Inciso D',1,0,'C',false);

	$cantPartidos = 0;
	$i=0;
	
	$contadorY1 = 44;
	$contadorY2 = 44;
while ($rowE = mysql_fetch_array($resDatos)) {
	$i+=1;	
	$cantPartidos += 1;
	
	if ($i > 50) {
		Footer($pdf);
		$pdf->AddPage();
		$pdf->Image('../imagenes/logoparainformes.png',2,2,40);	
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetY(25);
		$pdf->SetX(5);
		$pdf->Cell(200,5,utf8_decode($nombre),1,0,'C',true);
		$pdf->SetFont('Arial','',8);
		$pdf->Ln();
		$pdf->SetX(5);

		$i=0;
		
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(5,4,'',1,0,'C',false);
		$pdf->Cell(60,4,'Apellido y Nombre',0,0,'C',false);
		$pdf->Cell(15,4,'Nro. Doc.',0,0,'C',false);
		$pdf->Cell(15,4,'Fec. Nac',1,0,'C',false);
		$pdf->Cell(40,4,'Numero de Socio/Lote',1,0,'C',false);
		$pdf->Cell(16,4,'Baja',1,0,'C',false);
		$pdf->Cell(30,4,'Art 2 Inciso D',1,0,'C',false);

	}
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(5,4,$cantPartidos,1,0,'C',false);
	$pdf->Cell(60,4,utf8_decode($rowE['apyn']),1,0,'L',false);
	$pdf->Cell(15,4,$rowE['nrodocumento'],1,0,'C',false);
	$pdf->Cell(15,4,$rowE['fechanacimiento'],1,0,'C',false);
	$pdf->Cell(40,4,$rowE['numeroserielote'],1,0,'C',false);
	$pdf->Cell(16,4,$rowE['fechabaja'],1,0,'C',false);
	$pdf->Cell(30,4,$rowE['articulo'],1,0,'C',false);

	
	
	
		

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}


$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(190, 3, 'Certifico que los arriba Inscriptos son Socios-Propietarios de Lotes del Country (titulares, c�nyugues, ascendientes, descendientes o yernos �nicamente), y/o jugadores que se enmarcan dentro del art�culo 2 incisos "a", "b" y "d" de vuestro reglamento de torneos, estando estatutariamente habilitados para representar a la Instituci�n en competencias deportivas. Manifiesto conocer y aceptar en todas sus partes el Reglamento de los Torneos y el Reglamento del Tribunal de Disciplina, comprometi�ndose el Country al que represento, a cumplir y hacer cumplir los derechos y obligaciones obrantes en los mismos y a comunicar a la Asociaci�n, en forma inmediata, cualquier modificaci�n en la condici�n o categor�a de los socios-propietarios y/o familiares inscriptos en la presente lista.',0,'','');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','b',8);
$pdf->MultiCell(190, 4, 'Nota: El Padr�n deber� estar firmado por el Presidente y/o Secretario de la Instituci�n, con sellos aclaratorios y certificaci�n Bancaria o de un Escribano p�blico acerca de las identidades de los Firmantes, adjuntando adem�s un elemento probatorio del car�cter de su funci�n (fotocopia certificada del libro de Actas, certificaci�n Bancaria u otras).',0,'','');


Footer($pdf);

$pdf->AddPage();
//////////////////// Aca arrancan a cargarse los datos de los equipos  /////////////////////////
	
	$pdf->SetFillColor(183,183,183);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetY(25);
	$pdf->SetX(5);
	$pdf->Cell(200,5,'Nuevos Socios Propietarios - '.utf8_decode($nombre),1,0,'C',true);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,4,'',1,0,'C',false);
	$pdf->Cell(60,4,'Apellido y Nombre',1,0,'C',false);
	$pdf->Cell(15,4,'Nro. Doc.',1,0,'C',false);
	$pdf->Cell(15,4,'Fec. Nac',1,0,'C',false);
	$pdf->Cell(40,4,'Numero de Socio/Lote',1,0,'C',false);

	$cantPartidos = 0;
	$i=0;
	
	$contadorY1 = 44;
	$contadorY2 = 44;
while ($rowE = mysql_fetch_array($lstNuevosJugadores)) {
	$i+=1;	
	$cantPartidos += 1;
	
	if ($i > 50) {
		Footer($pdf);
		$pdf->AddPage();
		$pdf->Image('../imagenes/logoparainformes.png',2,2,40);	
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln();
		$pdf->Ln();
		$pdf->SetY(25);
		$pdf->SetX(5);
		$pdf->Cell(200,5,utf8_decode($nombre),1,0,'C',true);
		$pdf->SetFont('Arial','',8);
		$pdf->Ln();
		$pdf->SetX(5);

		$i=0;
		
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(5,4,'',1,0,'C',false);
		$pdf->Cell(60,4,'Apellido y Nombre',0,0,'C',false);
		$pdf->Cell(15,4,'Nro. Doc.',0,0,'C',false);
		$pdf->Cell(15,4,'Fec. Nac',1,0,'C',false);
		$pdf->Cell(40,4,'Nro Serie Lote',1,0,'C',false);

	}
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(5,4,$cantPartidos,1,0,'C',false);
	$pdf->Cell(60,4,utf8_decode($rowE['apellido']).' '.utf8_decode($rowE['nombres']),1,0,'L',false);
	$pdf->Cell(15,4,$rowE['nrodocumento'],1,0,'C',false);
	$pdf->Cell(15,4,$rowE['fechanacimiento'],1,0,'C',false);
	$pdf->Cell(40,4,$rowE['numeroserielote'],1,0,'C',false);	

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(190, 3, 'Certifico que los arriba Inscriptos son Socios-Propietarios de Lotes del Country (titulares, c�nyugues, ascendientes, descendientes o yernos �nicamente), y/o jugadores que se enmarcan dentro del art�culo 2 incisos "a", "b" y "d" de vuestro reglamento de torneos, estando estatutariamente habilitados para representar a la Instituci�n en competencias deportivas. Manifiesto conocer y aceptar en todas sus partes el Reglamento de los Torneos y el Reglamento del Tribunal de Disciplina, comprometi�ndose el Country al que represento, a cumplir y hacer cumplir los derechos y obligaciones obrantes en los mismos y a comunicar a la Asociaci�n, en forma inmediata, cualquier modificaci�n en la condici�n o categor�a de los socios-propietarios y/o familiares inscriptos en la presente lista.',0,'','');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','b',8);
$pdf->MultiCell(190, 4, 'Nota: El Padr�n deber� estar firmado por el Presidente y/o Secretario de la Instituci�n, con sellos aclaratorios y certificaci�n Bancaria o de un Escribano p�blico acerca de las identidades de los Firmantes, adjuntando adem�s un elemento probatorio del car�cter de su funci�n (fotocopia certificada del libro de Actas, certificaci�n Bancaria u otras).',0,'','');


Footer($pdf);


$pdf->AddPage();

$pdf->SetFont('Arial','',12);
$pdf->Cell(200,5,'ACTUALIZACI�N DE DATOS A�O 2017',0,0,'C',false);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(200,5,'COUNTRY:',0,0,'L',false);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(200,5,'1� DELEGADO:',0,0,'L',false);
$pdf->Ln();
$pdf->Cell(200,5,'N�MERO PARTICULAR:',0,0,'L',false);
$pdf->Ln();
$pdf->Cell(200,5,'N�MERO LABORAL:',0,0,'L',false);
$pdf->Ln();
$pdf->Cell(200,5,'N�MERO DE CELULAR:',0,0,'L',false);
$pdf->Ln();
$pdf->Cell(200,5,'E-MAIL:',0,0,'L',false);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(200,5,'2� DELEGADO:',0,0,'L',false);
$pdf->Ln();
$pdf->Cell(200,5,'N�MERO PARTICULAR:',0,0,'L',false);
$pdf->Ln();
$pdf->Cell(200,5,'N�MERO LABORAL:',0,0,'L',false);
$pdf->Ln();
$pdf->Cell(200,5,'N�MERO DE CELULAR:',0,0,'L',false);
$pdf->Ln();
$pdf->Cell(200,5,'E-MAIL:',0,0,'L',false);

Footer($pdf);


$pdf->AddPage();

$pdf->SetFont('Arial','b',10);
$pdf->Cell(200,5,'DATOS COMPLEMENTARIOS ALTA DE EQUIPO',0,0,'C',false);$pdf->Ln();
$pdf->Cell(200,5,'A�o: _____		',0,0,'L',false);$pdf->Ln();
$pdf->Cell(200,5,'Country: ______________________________',0,0,'L',false);$pdf->Ln();
$pdf->Cell(200,5,'Nombre del equipo : ______________________________',0,0,'L',false);$pdf->Ln();
$pdf->Cell(200,5,'Categor�a: ______________________________',0,0,'L',false);$pdf->Ln();
$pdf->Ln();
$pdf->Cell(200,5,'Direcci�n de la Administraci�n: _________________________________________________________________________',0,0,'L',false);$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(200,5,'Localidad: __________________________  C�digo Postal: _____  Tel.: __________________  Fax: ___________________',0,0,'L',false);$pdf->Ln(); 
$pdf->Cell(200,5,'E-mail: _________________________________________________',0,0,'L',false);$pdf->Ln();
$pdf->SetFont('Arial','b',10);
$pdf->Cell(200,5,'Direcci�n del Country: _________________________________________________________________________________',0,0,'L',false);$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(200,5,'Localidad: __________________________  C�digo Postal: _____  Tel.: __________________  Fax: ___________________',0,0,'L',false);$pdf->Ln(); 
$pdf->Cell(200,5,'E-mail: _________________________________________________',0,0,'L',false);$pdf->Ln();$pdf->Ln();
$pdf->Cell(200,5,'Condici�n de IVA: _____________________	CUIT: ______________________',0,0,'L',false);$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','b',10);
$pdf->Cell(200,5,'Servicio de Emergencias (nombre y tel.): ________________________________________________________________',0,0,'L',false);$pdf->Ln();
$pdf->Cell(200,5,' ___________________________________________________________________________________________________',0,0,'L',false);$pdf->Ln();$pdf->Ln();                                
$pdf->Cell(200,5,'Camisetas (detallar colores y descripci�n):',0,0,'L',false);$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','',10);
$pdf->Cell(200,5,'	Juego 1: ___________________________________________________________________________',0,0,'L',false);$pdf->Ln();
$pdf->Cell(200,5,'	Juego 2: ___________________________________________________________________________',0,0,'L',false);$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','b',10);
$pdf->Cell(50,5,'CANCHAS HABILITADAS',0,0,'L',false);
$pdf->Cell(50,5,'Primera',0,0,'L',false);
$pdf->Cell(50,5,'Segunda',0,0,'L',false);
$pdf->Cell(50,5,'Tercera',0,0,'L',false);
$pdf->Ln();$pdf->Ln();

$pdf->SetFont('Arial','',10);
$pdf->Cell(50,5,'Domicilio',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Ln();

$pdf->Cell(50,5,'Localidad',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Ln();

$pdf->Cell(50,5,'Tel�fono',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Ln();

$pdf->Cell(50,5,'Largo x Ancho (mts.)',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Ln();

$pdf->Cell(50,5,'Largo x Alto Arco(mts.)',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Ln();


$pdf->Cell(50,5,'Ubicaci�n dentro del club',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Cell(50,5,'____________________',0,0,'L',false);
$pdf->Ln();

$pdf->SetFont('Arial','b',8);
$pdf->Cell(200,5,'Nota: Se deber� adjuntar un croquis con la ubicaci�n de las canchas habilitadas dentro del country',0,0,'L',false);$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','b',10);
$pdf->Ln();
$pdf->Cell(60,5,'DELEGADOS DEL COUNTRY',0,0,'L',false);
$pdf->Cell(70,5,'Titular',0,0,'L',false);
$pdf->Cell(70,5,'Suplente',0,0,'L',false);
$pdf->Ln();

$pdf->SetFont('Arial','',10);
$pdf->Cell(60,5,'Apellido y Nombre',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Ln();


$pdf->Cell(60,5,'Doc. Identidad',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Ln();


$pdf->Cell(60,5,'Tel�fono y e-mail',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Ln();


$pdf->Cell(60,5,'Firma',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','b',8);
$pdf->Cell(60,5,'SOCIOS RESPONSABLES DEL EQUIPO',0,0,'L',false);
$pdf->SetFont('Arial','b',10);
$pdf->Cell(70,5,'Uno',0,0,'L',false);
$pdf->Cell(70,5,'Dos',0,0,'L',false);
$pdf->Ln();

$pdf->SetFont('Arial','',10);
$pdf->Cell(60,5,'Apellido y Nombre',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Ln();


$pdf->Cell(60,5,'Doc. Identidad',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Ln();


$pdf->Cell(60,5,'Tel�fono y e-mail',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Ln();


$pdf->Cell(60,5,'Firma',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Cell(70,5,'______________________________',0,0,'L',false);
$pdf->Ln();
$pdf->Ln();


Footer($pdf);



$pdf->AddPage();

$pdf->SetFont('Arial','',14);
$pdf->MultiCell(200,6,'Recuerde presentar junto con el padron de socios/propietarios la nota institucional especificando los datos del servicio medico brindados por el country, el acta de designaci�n de autoridades y controlar que todas las hojas esten firmadas (con una sola certificaci�n basta), caso contrario no se recibira el mismo',0,'L',false);

Footer($pdf);


///////////////***************************  para las bajas  *****************************************//////

//$pdf->AddPage();
	/***********************************    PRIMER CUADRANTE ******************************************/
	
//	$pdf->Image('../imagenes/logoparainformes.png',2,2,40);

	/***********************************    FIN ******************************************/
	
	
	
	//////////////////// Aca arrancan a cargarse los datos de los equipos  /////////////////////////

	/*
	$pdf->SetFillColor(183,183,183);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetY(25);
	$pdf->SetX(5);
	$pdf->Cell(200,5,'Bajas - Countrie '.utf8_decode($nombre),1,0,'C',true);
	$pdf->SetFont('Arial','',8);
	$pdf->Ln();
	$pdf->Ln();
	$pdf->SetX(5);
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(5,4,'',1,0,'C',false);
	$pdf->Cell(60,4,'Apellido y Nombre',1,0,'C',false);
	$pdf->Cell(15,4,'Nro. Doc.',1,0,'C',false);
	$pdf->Cell(16,4,'Fecha Nac.',1,0,'C',false);
	$pdf->Cell(16,4,'Fecha Baja',1,0,'C',false);
	$cantPartidos = 0;
	$i=0;
	
	$contadorY1 = 44;
	$contadorY2 = 44;
while ($rowE = mysql_fetch_array($resDatosBaja)) {
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
		$pdf->Cell(200,5,'Countrie '.utf8_decode($nombre),1,0,'C',false);
		$pdf->SetFont('Arial','',8);
		$pdf->Ln();
		$pdf->SetX(5);

		$i=0;
		
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(5,4,'',1,0,'C',false);
		$pdf->Cell(60,4,'Apellido y Nombre',0,0,'C',false);
		$pdf->Cell(15,4,'Nro. Doc.',0,0,'C',false);
		$pdf->Cell(16,4,'Fecha Nac.',1,0,'C',false);
		$pdf->Cell(16,4,'Fecha Baja',1,0,'C',false);
	}
	
	
	$pdf->Ln();
	$pdf->SetX(5);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(5,4,$cantPartidos,1,0,'C',false);
	$pdf->Cell(60,4,utf8_decode($rowE['apyn']),1,0,'L',false);
	$pdf->Cell(15,4,$rowE['nrodocumento'],1,0,'C',false);
	$pdf->Cell(16,4,$rowE['fechanacimiento'],1,0,'C',false);
	$pdf->Cell(16,4,$rowE['fechabaja'],1,0,'C',false);

	
	
	
		

	$contadorY1 += 4;

	//$pdf->SetY($contadorY1);		


}
*/
//120 x 109


$nombreTurno = "JUGADORES-COUNTRIES-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>

