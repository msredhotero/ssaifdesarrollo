<?php

session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../../error.php');
} else {


include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');
include ('../../includes/generadorfixturefijo.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$Generar = new GenerarFixture();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Fixture",$_SESSION['refroll_predio'],'');



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
				
				$cadWhere .= $idEquipos.",";
				array_push($cantEquipos,$cantidad);
				$cantidad += 1;
			}
		}
	}
	
	if (($cantidad%2)==0) {
		array_push($cantEquipos,$cantidad);
	}
	
	//die(var_dump($cantEquipos));

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbfixture";

$lblCambio	 	= array("refconectorlocal","goleslocal","refconectorvisitante","golesvisitantes","fecha","reffechas","refcanchas","refarbitros","refestadospartidos","reftorneos");
$lblreemplazo	= array("Equipo Local","Resultado 1","Equipo Visitante","Resultado 2","Fecha Juego","Fecha","Cancha","Arbitros","Estados Partidos","Torneo");

$resConectorL	=	$serviciosReferencias->traerEquipos();
$cadRef			=	$serviciosFunciones->devolverSelectBox($resConectorL,array(1,2)," - ");

$resFechas		=	$serviciosReferencias->traerFechas();
$cadRef2		=	$serviciosFunciones->devolverSelectBox($resFechas,array(1),'');

$resCanchas		=	$serviciosReferencias->traerCanchas();
$cadRef3		=	$serviciosFunciones->devolverSelectBox($resCanchas,array(1),'');

$resArbitros	=	$serviciosReferencias->traerArbitros();
$cadRef4		=	$serviciosFunciones->devolverSelectBox($resArbitros,array(1),'');

$resEstadosP	=	$serviciosReferencias->traerEstadospartidos();
$cadRef5		=	'<option value="">-- seleccionar --</option>';
$cadRef5		.=	$serviciosFunciones->devolverSelectBox($resEstadosP,array(1),'');

$resTorneos		=	$serviciosReferencias->traerTorneos();
$cadRef6		=	$serviciosFunciones->devolverSelectBox($resTorneos,array(1,2),' - ');

$refdescripcion = array(0 => $cadRef,1=>$cadRef,2=>$cadRef2,3=>$cadRef3,4=>$cadRef4,5=>$cadRef5,6=>$cadRef6);
$refCampo	 	= array("refconectorlocal","refconectorvisitante","reffechas","refcanchas","refarbitros","refestadospartidos","reftorneos"); 
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$lstEquipos		=	$serviciosReferencias->traerEquiposPorEquipoIn(substr($cadWhere,0,-1));



/////////////////////// Opciones para la creacion del view  /////////////////////
$cabeceras 		= "	<th>Equipo Local</th>
				<th>Resultado Local</th>
				<th>Resultado Visitante</th>
				<th>Equipo Visitante</th>
				<th>Categoria</th>
				<th>Arbitros</th>
				<th>Juez 1</th>
				<th>Juez 2</th>
				<th>Cancha</th>
				<th>Fecha Juego</th>
				<th>Fecha</th>
				<th>Hora</th>
				<th>Estado</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$idTorneo = $_POST['idtorneo'];
$fechainicio = $_POST['fechainicio'];
$hora = $_POST['hora'];

$formulario 	= $serviciosFunciones->camposTabla("insertarFixture",$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerFixtureTodo(),13);

$fixtureGenerardo = $Generar->generarAIF($idTorneo, $cantEquipos);

//die(print_r($fixtureGenerardo));
//die(var_dump($fixtureGenerardo));

if ((count($cantEquipos) % 2)==0) {
	$cantFechas = count($cantEquipos)-1;
} else {
	$cantFechas = count($cantEquipos);
}

//$array = $Generar->devolverCantFilas($idTorneo);

$filas = count($cantEquipos)/2;
//die(var_dump($fixtureGenerardo));

$fechaNueva = date_create($fechainicio);

?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Gesti&oacute;n: AIF</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<!--<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">-->
    

 
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<!--<link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../../css/bootstrap-timepicker.css">-->
    <script src="../../js/bootstrap-timepicker.min.js"></script>
	
    <style type="text/css">
	* {
	  margin:0;
	  padding:0;
	  font-family: robotoL;
	}
html { height : 101%; } 
body {


	font-family: robotoL;
	background: url(../../imagenes/beige_paper.png) repeat;
}

#content {
	margin-left:21%;
}

body > h3 {
	border-bottom:1px solid #000;
	margin-left:100px;
	margin-right:80px;
	padding-top:10px;
	padding-left:15px;
	padding-bottom:16px;
	font-weight: bold;
	font-size:1.9em;
	color:#000;
}

h5 {
	margin-left:100px;
	margin-right:80px;
	padding-top:10px;
	padding-left:15px;
	padding-bottom:16px;
	font-weight: bold;
}

.fdizquierda {float: left; width: 29%;}

.fdderecha {float: right; width: 68%; }


header {
    background-image: -webkit-gradient(
	linear,
	left top,
	left bottom,
	color-stop(0, #454A4E),
	color-stop(1, #464F52)
);
background-image: -o-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: -moz-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: -webkit-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: -ms-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: linear-gradient(to bottom, #454A4E 0%, #464F52 100%);
	background-color:#454A4E;
	height:100px;
	margin:0;
	padding-left:100px;
}

#header {
    background-image: -webkit-gradient(
	linear,
	left top,
	left bottom,
	color-stop(0, #454A4E),
	color-stop(1, #464F52)
);
background-image: -o-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: -moz-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: -webkit-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: -ms-linear-gradient(bottom, #454A4E 0%, #464F52 100%);
background-image: linear-gradient(to bottom, #454A4E 0%, #464F52 100%);
	background-color:#454A4E;
	height:100px;
	margin:0;
	padding-left:100px;
}

.logueo {
	background-color:#2b2f32;
	height:800px;
	padding-left:100px;
}



body > footer{
background: url(../../imagenes/bg-bueno.jpg) repeat; text-align:center; font-family: "Prestige Elite Std"; font-size:0.9em; height:30px;
border-top:2px solid #085878;
width:100%;
padding-top:10px;
bottom: 0px;
font-size:1.1em;
padding-bottom: 10px;
}

.content {
    height: 100%;
    margin: 20px auto;
    padding: 16px;
    width: 1050px;
}

.donde {
    width: 700px;
    margin-left: 100px;
    margin-top: 20px;
}

#menu li.active a {
	font-weight: bold;
	color:#222;
	text-shadow: 0 0 0.1em #F6CED8, 0 0 0.2em #F6CED8;
}

#menu li a {
	color:#EBEBEB;
	font-weight: bold;
	text-shadow: 0.1em 0.1em 0.05em #333;
}

#menu li a:hover {
	color:#656565;
	font-weight: bold;
	text-shadow: -1px -1px white, 1px 1px #fff;

}



#navigation {
			height:100%;
			background-color: #303641;
			padding-top:15px;
			overflow-y: auto;
			position: fixed;
			top: 0;
			width: 20%;
			z-index: 9999;
			overflow: hidden;
			
		}
		
		#navigation #mobile-header {
			text-align:center;
			color: #7A0000;
			font-size:2.0em;
			font-family: robotoL;	
		}
		
		#navigation #mobile-header p {
			color: #fff;
			font-size:1em;
			font-family:  robotoL;
		}
		
		.todoMenu {

		}
		
		.nav {
			margin-top:-15px;
			/*border-bottom:1px solid #FFD2D2;*/
		}
		.nav ul {
			list-style:none;
		}
		.nav ul li {
			padding:8px 8px;
			height:44px;
			border-bottom:1px solid #3e444e;
			border-top:1px solid #303641;
			width:100%;
		}
		
		.nav ul li a {
			color:#FFF;
			font-family:robotoL;
			font-size:1.0em;
			text-decoration:none;
			/*width:100%;*/
			float: left;
			margin-top:5px;
		}
		
		.nav ul li:hover {
			background: #2b303a; /* Old browsers */
			text-indent:15px;
			-webkit-transition:all 1s ease;
		    -moz-transition:all 1s ease;
		    -o-transition:all 1s ease;
		    transition:all 1s ease;
			text-shadow:1px 1px 1px #006;
		}
		
		.triangulo {
			 width: 0; 
			 height: 0; 
			 border-left: 100px solid #f0ad4e;
			 border-top: 50px solid transparent;
			 border-bottom: 50px solid transparent; 
		}

		.nav .arriba {
			border-top:none;
		}
		.abajo {
			padding-top:-8px;
		}
		
		#infoMenu {
			margin-top:15px;
			padding:8px 2px 1px 10px;
			/*background-color:#7A0000;*/
			background-color: #248dc1; /* Old browsers */

			border-bottom:1px solid #d60000;
			border-top:1px solid #b20000;
		}
		
		#infoMenu p {	
			color: #000;
			font-family: robotoL;
			font-size:15px;
		}
		
		#infoDescrMenu {
			padding:8px;
		}
		
		#infoDescrMenu p {
			color:#FFF;
		}
		
		.icodashboard {
			background:url(../imagenes/iconmenu/dashboard.png)  no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:9px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icousuarios {
			background:url(../imagenes/iconmenu/usuarios.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icochart {
			background:url(../imagenes/iconmenu/chart.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icopagos {
			background:url(../imagenes/iconmenu/pagos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icosedes {
			background:url(../imagenes/iconmenu/sedes.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icocanchas {
			background:url(../imagenes/iconmenu/canchas.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icogoleadores {
			background:url(../imagenes/iconmenu/gym15.png) no-repeat;
			background-position: center center;
			width:25px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icosuspendidos {
			background:url(../imagenes/iconmenu/lightning38.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		.icojugadores {
			background:url(../imagenes/iconmenu/user82.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icovehiculos {
			background:url(../imagenes/iconmenu/icovehiculo.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		
		.icoreparacion {
			background:url(../imagenes/iconmenu/icoreparacion.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icomodelo {
			background:url(../../imagenes/iconmenu/icomodelo.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		
		.icomarca {
			background:url(../../imagenes/iconmenu/icomarca.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icoamonestados {
			background:url(../../imagenes/iconmenu/user84.png) no-repeat;
			background-position: center center;
			width:25px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		.icoequipos {
			background:url(../../imagenes/iconmenu/users6.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		.icozonasequipos {
			background:url(../../imagenes/iconmenu/users7.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		.icotorneos {
			background:url(../../imagenes/iconmenu/verification5.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icozonas {
			background:url(../../imagenes/iconmenu/conceptos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icofixture {
			background:url(../../imagenes/iconmenu/novedades.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icoplayoff {
			background:url(../../imagenes/iconmenu/playoff.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icofairplay {
			background:url(../../imagenes/iconmenu/exportar.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		/*
		gym15.png
		lightning38.png
		user82.png
		user84.png
		users6.png
		users7.png
		verification5.png
		*/
		.icoalquileres {
			background:url(../../imagenes/iconmenu/alquiler.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icoinmubles {
			background:url(../../imagenes/iconmenu/inmueble.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icoturnos {
			background:url(../../imagenes/iconmenu/turnos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icoventas {
			background:url(../../imagenes/iconmenu/compras.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icoproductos {
			background:url(../../imagenes/iconmenu/barras.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icoreportes {
			background:url(../../imagenes/iconmenu/reportes.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icocontratos {
			background:url(../../imagenes/iconmenu/contratos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}

        .icoconfiguracion {
			background:url(../../imagenes/iconmenu/configuracion.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icosalir {
			background:url(../../imagenes/iconmenu/salir.png) no-repeat;
			background-position: center center;
			width:40px;
			height:40px;
			float:left;
			margin-right:10px;
			margin-top:-4px;
			/* OKAY */
		   background-size: 25px 50px;
		   background-size: 50% 50%;
		}
		
		.icoproductos2 {
			background:url(../imagenes/iconmenu/barras.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:9px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		.icoventas2 {
			background:url(../imagenes/iconmenu/compras.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:9px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		
		.icopagos2 {
			background:url(../imagenes/iconmenu/pagos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:9px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		.icochart2 {
			background:url(../imagenes/iconmenu/chart.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:9px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		.icoturnos2 {
			background:url(../imagenes/iconmenu/turnos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:9px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		.icodashboard2 {
			background:url(../imagenes/iconmenu/dashboard.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:9px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		.icousuarios2 {
			background:url(../imagenes/iconmenu/usuarios.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:10px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		.icoalquileres2 {
			background:url(../imagenes/iconmenu/alquiler.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:10px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		.icoinmubles2 {
			background:url(../imagenes/iconmenu/inmueble.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:10px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		
		.icoreportes2 {
			background:url(../imagenes/iconmenu/reportes.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:10px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		.icocontratos2 {
			background:url(../../imagenes/iconmenu/contratos.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:10px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		.icosalir2 {
			background:url(../../imagenes/iconmenu/salir.png) no-repeat;
			background-position: center center;
			width:40px;
			height:25px;
			margin-right:10px;
			margin-bottom:25px;
			cursor:pointer;
		}
		
		
		.ulHober {
			list-style:none;
			width:40px;
			right:6px;
			position:absolute;
		}
		
		.ulHober li {
			right:0;
		}
		
		.tooltip-dash, .tooltip-inmu, .tooltip-alqui, .tooltip-usua, .tooltip-con, .tooltip-rep, .tooltip-sal{
		   position: fixed;
		   background: #c0df71;
		   color: #fff;
		   border-radius:10px;
		   font-family:  Verdana, sans-serif;
		   padding: 10px;
		   margin-top: -10px;
		   margin-left: 20px;
		   z-index: 9999999999;
		   display: none;
		   background-color: #333;
		}
		
		@font-face {
		  font-family: "robotoL";
		  src: url("../../fuentes/Roboto-Bold.ttf");
		}
	</style>
   
   <link href="../../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../../js/jquery.mousewheel.js"></script>
      <script src="../../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
      });
    </script>
<script>

  $(function() {

 //Array para dar formato en español

  $.datepicker.regional['es'] =
  {
  closeText: 'Cerrar',
  prevText: 'Previo',
  nextText: 'Próximo',

  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
  'Jul','Ago','Sep','Oct','Nov','Dic'],
  monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
  dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
  dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
  dateFormat: 'dd/mm/yy', firstDay: 0,
  initStatus: 'Selecciona la fecha', isRTL: false};

 $.datepicker.setDefaults($.datepicker.regional['es']);
 //miDate: fecha de comienzo D=días | M=mes | Y=año
 //maxDate: fecha tope D=días | M=mes | Y=año
    $( "#datepicker1" ).datepicker({ minDate: "", maxDate: "+2M +10D" });
	$( "#datepicker2" ).datepicker({ minDate: "", maxDate: "+3M +10D" });
	$( "#datepicker3" ).datepicker({ minDate: "", maxDate: "+4M +10D" });
	$( "#datepicker4" ).datepicker({ minDate: "", maxDate: "+5M +10D" });
	$( "#datepicker5" ).datepicker({ minDate: "", maxDate: "+6M +10D" });
	$( "#datepicker6" ).datepicker({ minDate: "", maxDate: "+7M +10D" });
	$( "#datepicker7" ).datepicker({ minDate: "", maxDate: "+8M +10D" });
	$( "#datepicker8" ).datepicker({ minDate: "", maxDate: "+9M +10D" });
	$( "#datepicker9" ).datepicker({ minDate: "", maxDate: "+10M +10D" });
	$( "#datepicker10" ).datepicker({ minDate: "", maxDate: "+11M +10D" });
	$( "#datepicker11" ).datepicker({ minDate: "", maxDate: "+12M +10D" });
	$( "#datepicker12" ).datepicker({ minDate: "", maxDate: "+13M +10D" });
	$( "#datepicker13" ).datepicker({ minDate: "", maxDate: "+14M +10D" });
	$( "#datepicker14" ).datepicker({ minDate: "", maxDate: "+15M +10D" });
	$( "#datepicker15" ).datepicker({ minDate: "", maxDate: "+16M +10D" });
	$( "#datepicker16" ).datepicker({ minDate: "", maxDate: "+17M +10D" });
	$( "#datepicker17" ).datepicker({ minDate: "", maxDate: "+18M +10D" });
	$( "#datepicker18" ).datepicker({ minDate: "", maxDate: "+19M +10D" });
	$( "#datepicker19" ).datepicker({ minDate: "", maxDate: "+20M +10D" });
	$( "#datepicker20" ).datepicker({ minDate: "", maxDate: "+21M +10D" });
  });
  </script>

</head>

<body>

 
<?php echo $resMenu; ?>

<div id="content">

<h3>Fixture</h3>

    <div class="panel panel-success" style="margin-right:50px;">
        <div class="panel-heading">
        	Carga del Fixture
        	
        </div>
    	<div class="panel-body">
    		<form class="form-inline formulario" role="form" method="post" action="finalizar.php">
            <div class="row" style="margin-left:5px; margin-right:5px;">
            	<div class="col-md-6">
            	<table class="table table-bordered table-responsive">
                	<thead>
                    	<tr>
                            <th>
                                Numero de Equipo
                            </th>
                            <th>
                                Equipo
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
							$canE = 1;
							while ($row = mysql_fetch_array($lstEquipos)) {
						?>
                    	<tr>
                        	<td>
                            	<input style="text-align:center;" type="text" id="modulo<?php echo $canE; ?>" name="modulo<?php echo $canE; ?>" value="<?php echo $canE; ?>"/>
                            </td>
                            <td>
                            	<select class="form-control" id="equipoModulo<?php echo $canE; ?>" name="equipoModulo<?php echo $canE; ?>">
                            		<option value="<?php echo $row[0]; ?>"><?php echo $row[2]; ?></option>
                                </select>
                            </td>
                        </tr>
                        <?php
							$canE += 1;
							}
							
							if (($cantidad%2)==0) {
						?>
                        	<tr>
                                <td>
                                    <input class="form-control" style="text-align:center;" type="text" id="modulo<?php echo $canE; ?>" name="modulo<?php echo $canE; ?>" value="<?php echo $canE; ?>"/>
                                </td>
                                <td>
                                    <select class="form-control" id="equipoModulo<?php echo $canE; ?>" name="equipoModulo<?php echo $canE; ?>">
                                        <option value="0">Vacio</option>
                                    </select>
                                </td>
                            </tr>
                        <?php		
							}
						?>
                    </tbody>
                </table>
                </div>
            </div>
            
            <div class="row" style="margin-left:5px; margin-right:5px; min-width:800px;">
				<input type="button" class="btn btn-info" id="invertir" value="Invertir Local - Visitante" />
    		<?php 
			//die(var_dump($fixtureGenerardo[0][0]));
			$total = 1;
			if (count($fixtureGenerardo)>0) {
			for ($i=0;$i<$cantFechas;$i++) {
			echo '

						<h3>Fecha '.($i + 1).'</h3>

					  <div class="form-group col-md-4 col-sm-4" style="border:1px solid #121212;">
					  	<label>Equipo Local</label>
					  </div>
					  <div class="form-group col-md-2 col-sm-2" style="border:1px solid #121212;">
					  	<label>Horario</label>
					  </div>
					  <div class="form-group col-md-2 col-sm-2" style="border:1px solid #121212;">
					  	<label>Cancha</label>
					  </div>
					  <div class="form-group col-md-4 col-sm-4" style="border:1px solid #121212;">
					  	<label>Equipo Visitante</label>
					  </div>';
			for ($k=0;$k<$filas;$k++) {
				//$lstEquipos = explode("***",$fixtureGenerardo[$i][$k]);
				
				echo '
					  	<div class="form-group col-md-4 col-sm-4" style="border:1px solid #121212; padding:5px;">
						<select id="equipoa'.$total.'" name="equipoa'.$total.'" class="form-control letraChica">
                                
                                <option value="'.$fixtureGenerardo['Local'][$total-1].'">'.$fixtureGenerardo['Local'][$total-1].'</option>
								
                         </select>
						 Equipo: <span id="equia'.$total.'" class="lbl'.$fixtureGenerardo['Local'][$total-1].'"></span>
						 </div>
						 
						 <div class="form-group col-md-2 col-sm-2" style="border:1px solid #121212; padding:5px;">
						 <input type="text" id="horario'.$total.'" name="horario'.$total.'" class="form-control letraChica" style="width:80%;" value="'.$hora.'">

						 </div>
						 
						 
						 <div class="form-group col-md-2 col-sm-2" style="border:1px solid #121212; padding:5px;">
						 <select id="cancha'.$total.'" name="cancha'.$total.'" class="form-control letraChica">
						 	<option value="">-- Seleccionar --</option>
                                '.$cadRef3.'
                         </select>
						 </div>
						 
						 
						 <div class="form-group col-md-4 col-sm-4" style="border:1px solid #121212; padding:5px;">
						<select id="equipob'.$total.'" name="equipob'.$total.'" class="form-control letraChica">
                                <option value="'.$fixtureGenerardo['Visitante'][$total-1].'">'.$fixtureGenerardo['Visitante'][$total-1].'</option>
								
                         </select>
						 Equipo: <span id="equib'.$total.'" class="lbl'.$fixtureGenerardo['Visitante'][$total-1].'"></span>
						 </div>';
						 $total += 1;
			}
			echo '
				
				
				Fecha Juego '.($i + 1).' <input type="text" class="form-control" id="datepicker'.($i + 1).'" name="datepicker'.($i + 1).'" value="'.$fechainicio.'" />
				
		
					';
				$fechainicio = strtotime ( '+7 day' , strtotime ( $fechainicio ) ) ;
				$fechainicio = date ( 'Y-m-d' , $fechainicio );
				echo "<hr><br>";
			}
			echo '<input type="hidden" id="cantfechas" name="cantfechas" value="'.($i + 1).'" />';
			echo '<input type="hidden" id="total" name="total" value="'.$total.'" />';
			echo '<input type="hidden" id="idtorneo" name="idtorneo" value="'.$_POST['idtorneo'].'" />';
	
			} else {
				echo '<h2>Ya fue Cargado el Fixture completo para este torneo';	
			}
			?>
            </div>
            
            <div class="row" style="margin-left:25px; margin-right:25px;">
                <div class="alert"> </div>
                <div id="load"> </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                    	<?php if (count($fixtureGenerardo)>0) { ?>
                        <button type="submit" class="btn btn-primary" id="cargar" style="margin-left:0px;">Guardar</button>
                        <?php } ?>
                        <button type="button" class="btn btn-default" id="volver" style="margin-left:0px;">Volver</button>
                    </li>

                </ul>
                </div>
            </div>
            </form>
    	</div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">
        	Fixture Cargados
        	
        </div>
    	<div class="panel-body">
        	<?php echo $lstCargados; ?>
    	</div>
    </div>
    
   
</div>


</div>
<div id="dialog2" title="Eliminar Fixture">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea eliminar el fixture?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si elimina el fixture se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>

<!--<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>-->



<script type="text/javascript">
$(document).ready(function(){
	$('#timepicker2').timepicker({
		minuteStep: 15,
		showSeconds: false,
		showMeridian: false,
		defaultTime: false
		});


	function invertirLocalVisitante() {
		var local = 0;
		var visitante = 0;
		for (i=1; i <= <?php echo $total; ?>; i++) {
			
			local 		= $('#equipoa'+i+' option:selected').val();
			visitante 	= $('#equipob'+i+' option:selected').val();
			
			$("#equipoa"+ i +" option[value='" + local + "']").remove();
			$("#equipob"+ i +" option[value='" + visitante + "']").remove();
			
			$("#equipob"+ i).append($('<option>', {
				value: local,
				text: local
			}));
			
			$("#equipoa"+ i).append($('<option>', {
				value: visitante,
				text: visitante
			}));
			
			$("#equia"+i).attr("class","lbl"+visitante); 
			$("#equib"+i).attr("class","lbl"+local); 
			
		}
	}
	
	$('#invertir').click(function() {
		invertirLocalVisitante();
		actualizarEquipos();
		//$("#equipoa1 option[value='1']").remove();
	});
	
	function actualizarEquipos() {
		var a = 0;
	<?php
		for ($m=1;$m <= count($cantEquipos); $m++) {
	?>
		a = $('#modulo'+<?php echo $m; ?>).val();
		$('.lbl'+a).html($('#equipoModulo'+<?php echo $m; ?>+' option:selected').text());
	<?php
		}
	?>
	}
	
	
	
	<?php
		for ($m=1;$m <= count($cantEquipos); $m++) {
	?>
		$('#modulo'+<?php echo $m; ?>).change(function() {
			if ($(this).val() != '') {
				actualizarEquipos();	
			}
		});

	<?php
		}
	?>
	
	
	actualizarEquipos();
	
	$('#chequearF').click( function() {
		url = "chequear.php";
		$(location).attr('href',url);
	});
	
	$('#volver').click( function() {
		url = "index.php";
		$(location).attr('href',url);
	});
	
	$('#conductaF').click( function() {
		url = "conductafixture.php";
		$(location).attr('href',url);
	});
	
	 $('.varborrar').click(function(event){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			$("#idEliminar").val(usersid);
			$("#dialog2").dialog("open");

			
			//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
			//$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton eliminar

	$("#example").on("click",'.varmodificar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar

	 $( "#dialog2" ).dialog({
		 	
			    autoOpen: false,
			 	resizable: false,
				width:600,
				height:240,
				modal: true,
				buttons: {
				    "Eliminar": function() {
	
						$.ajax({
									data:  {id: $('#idEliminar').val(), accion: 'eliminarFixture'},
									url:   '../../ajax/ajax.php',
									type:  'post',
									beforeSend: function () {
											
									},
									success:  function (response) {
											url = "index.php";
											$(location).attr('href',url);
											
									}
							});
						$( this ).dialog( "close" );
						$( this ).dialog( "close" );
							$('html, body').animate({
	           					scrollTop: '1000px'
	       					},
	       					1500);
				    },
				    Cancelar: function() {
						$( this ).dialog( "close" );
				    }
				}
		 
		 
	 		}); //fin del dialogo para eliminar
	
	
	//al enviar el formulario
    $('#cargar2').click(function(){
		
		if (validador() == "")
        {
			//información del formulario
			var formData = new FormData($(".formulario")[0]);
			var message = "";
			//hacemos la petición ajax  
			$.ajax({
				url: '../../ajax/ajax.php',  
				type: 'POST',
				// Form data
				//datos del formulario
				data: formData,
				//necesario para subir archivos via ajax
				cache: false,
				contentType: false,
				processData: false,
				//mientras enviamos el archivo
				beforeSend: function(){
					$("#load").html('<img src="../../imagenes/load13.gif" width="50" height="50" />');       
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
                                            $(".alert").removeClass("alert-danger");
											$(".alert").removeClass("alert-info");
                                            $(".alert").addClass("alert-success");
                                            $(".alert").html('<strong>Ok!</strong> Se cargo exitosamente el <strong>Fixture</strong>. ');
											$(".alert").delay(3000).queue(function(){
												/*aca lo que quiero hacer 
												  después de los 2 segundos de retraso*/
												$(this).dequeue(); //continúo con el siguiente ítem en la cola
												
											});
											$("#load").html('');
											//url = "index.php";
											var a = $('#reftorneoge_a option:selected').html();
											var b = $('#reftorneoge_b option:selected').html();
											a = a.split(' - ');
											b = b.split(' - ');
											
											$('#resultados').prepend('<tr><td>' + a[1] + '</td><td></td><td></td><td>' + 
																		+ b[1] + '</td><td>' + 
																		a[0] + '</td><td>' + 
																		$('#fechajuego option:selected').html() + '</td><td>' + 
																		$('#reffecha option:selected').html() + '</td><td>' + 
																		$('#hora option:selected').html() + '</td><td style="color:#f00;">Nuevo</td></tr>').fadeIn(300);
											
											//$(location).attr('href',url);
                                            
											
                                        } else {
                                        	$(".alert").removeClass("alert-danger");
                                            $(".alert").addClass("alert-danger");
                                            $(".alert").html('<strong>Error!</strong> '+data);
                                            $("#load").html('');
                                        }
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
                    $("#load").html('');
				}
			});
		}
    });
	

});
</script>



<?php } ?>
</body>
</html>
