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

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Countries",$_SESSION['refroll_predio'],'');


$id = $_GET['id'];

$resResultado = $serviciosReferencias->traerCountriesPorId($id);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Country";

$plural = "Countries";

$eliminar = "eliminarCountries";

$modificar = "modificarCountries";

$idTabla = "idcountrie";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbcountries";

$lblCambio	 	= array("fechaalta","fechabaja","refposiciontributaria","telefonoadministrativo","telefonocampo","codigopostal");
$lblreemplazo	= array("Fecha Alta","Fecha Baja","Posicion Tributaria","Tel. Administrativo","Tel. Campo","Cod.Postal");


$resPosTri 	= $serviciosReferencias->traerPosiciontributaria();
$cadRef 	= $serviciosFunciones->devolverSelectBoxActivo($resPosTri,array(1),'', mysql_result($resResultado,0,'refposiciontributaria'));


$refdescripcion = array(0 => $cadRef);
$refCampo 	=  array("refposiciontributaria");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla2 			= "dbcontactos";

$lblCambio2	 	= array("reftipocontactos","cp");
$lblreemplazo2	= array("Tipo Contacto","Cod. Postal");


$resTipoContacto 	= $serviciosReferencias->traerTipocontactos();
$cadRef3 	= $serviciosFunciones->devolverSelectBox($resTipoContacto,array(1),'');

$refdescripcion2 = array(0 => $cadRef3);
$refCampo2 	=  array("reftipocontactos");

$formularioContacto 	= $serviciosFunciones->camposTabla("insertarContactos" ,$tabla2,$lblCambio2,$lblreemplazo2,$refdescripcion2,$refCampo2);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resContactosCountries = $serviciosReferencias->traerCountriecontactosPorCountries($id);


$formulario 	= $serviciosFunciones->camposTablaVer($id, $idTabla,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);


if ($_SESSION['refroll_predio'] != 1) {

} else {

	
}


?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title><?php echo $tituloWeb; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	<style type="text/css">
		
  
		
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
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzxyoH5wuPmahQIZLUBjPfDuu_cUHUBQY"
  type="text/javascript"></script>
    <style type="text/css">
		#map
		{
			width: 100%;
			height: 600px;
			border: 1px solid #d0d0d0;
		}
  		body p {
			text-decoration:none;
			font-weight:normal;	
		}
		
	</style>
    <script>
	/* AIzaSyBzxyoH5wuPmahQIZLUBjPfDuu_cUHUBQY */
		var map;
		var markers = [];
	 function localize() {

			
		var mapDiv = document.getElementById('map');
		var laPlata= {lat: <?php echo mysql_result($resResultado,0,'latitud'); ?>, lng: <?php echo mysql_result($resResultado,0,'longitud'); ?>};
		var map = new google.maps.Map(mapDiv, {
			zoom: 13,
			center: new google.maps.LatLng(<?php echo mysql_result($resResultado,0,'latitud'); ?>, <?php echo mysql_result($resResultado,0,'longitud'); ?>)
		});
		
		//var latitud = map.coords.latitude;
		//var longitud = map.coords.longitude;
		/*
		google.maps.event.addDomListener(mapDiv, 'click', function(e) {
			window.alert('click en el mapa');
		});
		*/
		placeMarkerAndPanTo(laPlata, map);
		/*
		map.addListener('click', function(e) {
			
			if (markers.length > 0) {
				clearMarkers();
			}
			$('#latitud').val(e.latLng.lat());
			$('#longitud').val(e.latLng.lng());	
			placeMarkerAndPanTo(e.latLng, map);
		});
		*/
	 }
	 
		function placeMarkerAndPanTo(latLng, map) {
			var marker = new google.maps.Marker({
				position: latLng,
				map: map
			});
			markers.push(marker);
			map.panTo(latLng);
			
		}
	
	function clearMarkers() {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(null);
		}
	}
		

 </script>
</head>

<body onLoad="localize()">

 <?php echo $resMenu; ?>

<div id="content">

<h3><?php echo $plural; ?></h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Ver <?php echo $singular; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">
        	
			<div class="row">
			<?php echo $formulario; ?>
            </div>
            
            
            <div class="row" id="contMapa2" style="margin-left:25px; margin-right:25px;">
            	<div class="col-md-6">
                	<div id="map" ></div>
				</div>
                <div class="col-md-6">
                	<div class="form-group col-md-12">
                        <label class="control-label" style="text-align:left; font-size:1.2em; text-decoration:underline; margin-bottom:4px;" for="fechas">Lista de Contactos</label>
                        <div class="input-group col-md-12">
                            <ul>
							<?php 
								while ($rowC = mysql_fetch_array($resContactosCountries)) {
							
							?>
                            	<li><?php echo $rowC[1].' - Teléfono: '.$rowC['telefono'].' - Email: '.$rowC['email']; ?></li>
                            <?php
								}
							?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                        <button type="button" class="btn btn-warning modificar" id="<?php echo $id; ?>" style="margin-left:0px;">Modificar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            </form>
    	</div>
    </div>
    
    
   
</div>


</div>




<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){

	$('.volver').click(function(event){
		 
		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar
	

	$('.modificar').click(function(event){
		 
		usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar
	
	

});
</script>


<?php } ?>
</body>
</html>
