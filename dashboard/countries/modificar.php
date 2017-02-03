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

$lstContactos	= $serviciosFunciones->devolverSelectBox($serviciosReferencias->traerContactos(),array(1,2),' - ');
$resContactos = $serviciosReferencias->traerContactos();

$resContactosCountries = $serviciosReferencias->traerCountriecontactosPorCountries($id);


	while ($subrow = mysql_fetch_array($resContactosCountries)) {
			$arrayFS[] = $subrow;
	}



$cadUser = '<ul class="list-inline" id="lstContact">';
while ($rowFS = mysql_fetch_array($resContactos)) {
	$check = '';
	if (mysql_num_rows($resContactosCountries)>0) {
		foreach ($arrayFS as $item) {
			if (stripslashes($item['refcontactos']) == $rowFS[0]) {
				$check = 'checked';	
				$cadUser = $cadUser.'<li class="user'.$rowFS[0].'">'.'<input id="user'.$rowFS[0].'" '.$check.' class="form-control checkLstContactos" type="checkbox" required="" style="width:50px;" name="user'.$rowFS[0].'"><p>'.$rowFS[1]." - ".$rowFS[2].'</p>'."</li>";
			}
		}
	}
	


}

$cadUser = $cadUser."</ul>";


$formulario 	= $serviciosFunciones->camposTablaModificar($id, $idTabla, $modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);


if ($_SESSION['refroll_predio'] != 1) {

} else {

	
}


$fechaalta = '__-__-____';
$fechabaja = '__-__-____';
/*
if (mysql_result($resResultado,0,'fechaalta') == '0000-00-00') {
	$fechaalta = '__-__-____';
} else {
	$fechaalta = mysql_result($resResultado,0,'fechaalta');
}
if (mysql_result($resResultado,0,'fechabaja') == '0000-00-00') {
	$fechabaja = '__-__-____';
} else {
	$fechabaja = mysql_result($resResultado,0,'fechabaja');
}
*/
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
    <script src="../../js/jquery.number.min.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	<style type="text/css">
		
  
		
	</style>
    <link rel="stylesheet" href="../../css/chosen.css">
   
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
  
		
	</style>
    <script>
	/* AIzaSyBzxyoH5wuPmahQIZLUBjPfDuu_cUHUBQY */
		var map;
		var markers = [];
	 function localize() {

			
		var mapDiv = document.getElementById('map');
		var laPlata= {lat: <?php echo (mysql_result($resResultado,0,'latitud') == '' ? '-34.604041' : mysql_result($resResultado,0,'latitud')); ?>, lng: <?php echo (mysql_result($resResultado,0,'longitud') == '' ? '-58.3852793' : mysql_result($resResultado,0,'longitud')); ?>};
		var map = new google.maps.Map(mapDiv, {
			zoom: 13,
			center: new google.maps.LatLng(<?php echo (mysql_result($resResultado,0,'latitud') == '' ? '-34.604041' : mysql_result($resResultado,0,'latitud')); ?>, <?php echo (mysql_result($resResultado,0,'longitud') == '' ? '-58.3852793' : mysql_result($resResultado,0,'longitud')); ?>)
		});
		
		placeMarkerAndPanTo(laPlata, map);
		//var latitud = map.coords.latitude;
		//var longitud = map.coords.longitude;
		/*
		google.maps.event.addDomListener(mapDiv, 'click', function(e) {
			window.alert('click en el mapa');
		});
		*/
		map.addListener('click', function(e) {
			
			if (markers.length > 0) {
				clearMarkers();
			}
			$('#latitud').val(e.latLng.lat());
			$('#longitud').val(e.latLng.lng());	
			placeMarkerAndPanTo(e.latLng, map);
		});
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
        	<p style="color: #fff; font-size:18px; height:16px;">Modificar <?php echo $singular; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">
        	
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert alert-info'>
                	<span class="glyphicon glyphicon-info-sign"></span> El CUIT cargarlo son "-" o "/" solo numeros
                </div>
                
            </div>
            
			<div class="row">
			<?php echo $formulario; ?>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:0;">
                    <li>
                        <button type="button" class="btn btn-info" id="vermapa" style="margin-left:0px;"><span class="lblMapa">Ver Mapa</span></button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-info" id="vercontacto" style="margin-left:0px;"><span class="lblContacto">Ver Contactos</span></button>
                    </li>
                    <li>
                    	<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success" id="agregarContacto"><span class="glyphicon glyphicon-plus"></span> Cargar Contacto</button>
                    </li>
                </ul>
                </div>
            </div>
            
            <hr>
            
            <div class="row" id="contContacto" style="margin-left:0px; margin-right:25px;">
            	<div class="form-group col-md-6" style="display:'.$lblOculta.'">
                    <label for="buscarcontacto" class="control-label" style="text-align:left">Buscar Contactos</label>
                    <div class="input-group col-md-12">
                        
                        <select data-placeholder="selecione el Contacto..." id="buscarcontacto" name="buscarcontacto" class="chosen-select" tabindex="2" style="width:300px;">
                            <option value=""></option>
                            <?php echo $lstContactos; ?>
                        </select>
                        <button type="button" class="btn btn-success" id="asignarContacto"><span class="glyphicon glyphicon-share-alt"></span> Asignar Contacto</button>
                    </div>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="contactosasignados" class="control-label" style="text-align:left">Contactos Asignados</label>
                    <div class="input-group col-md-12">
                        <?php echo $cadUser; ?>
                        
                    </div>
                </div>
                
            </div>
            
            <div class="row" id="contMapa" style="margin-left:25px; margin-right:25px;">
            	<div id="map" ></div>

            </div>

            
            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert alertCargaU'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                        <button type="button" class="btn btn-warning" id="cargar" style="margin-left:0px;">Modificar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-danger varborrar" id="<?php echo $id; ?>" style="margin-left:0px;">Eliminar</button>
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

<div id="dialog2" title="Eliminar <?php echo $singular; ?>">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea eliminar el <?php echo $singular; ?>?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si elimina el equipo se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>

<div id="dialog3" title="Borrar imagen">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro de desea eliminar esta imagen?.
        </p>
        <div id="auxImg">
        
        </div>
        <input type="hidden" value="" id="idAgente" name="idAgente">
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="1" style="z-index:500000;" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form class="form-inline formulario" role="form">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Crear Contactos</h4>
      </div>
      <div class="modal-body userasignates">
        <?php echo $formularioContacto; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="cargarContacto">Agregar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="hidden" name="refcountries" id="refcountries" value="<?php echo $id; ?>"/>
      </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>
<script src="../../js/inputmask.js"></script>
    <script src="../../js/inputmask.date.Extensions.js"></script>
    <script src="../../js/jquery.inputmask.js"></script>
    
<script type="text/javascript">
$(document).ready(function(){
	
	//$("#fechaalta").inputmask("d/m/y",{ "placeholder": "<?php //echo $fechaalta; ?>"});
	//$("#fechabaja").inputmask("d/m/y",{ "placeholder": "<?php //echo $fechabaja; ?>" });
	$('#cuit').number( true, 0 , '', '');
	$("#cuit").attr('maxlength','11');
	
	$('.volver').click(function(event){
		 
		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar
	
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
	
	
	$('#asignarContacto').click(function(e) {
		//alert($('#buscarcontacto option:selected').html());
		if (existeAsiganado('user'+$('#buscarcontacto').chosen().val()) == 0) {
			$('#lstContact').prepend('<li class="user'+ $('#buscarcontacto').chosen().val() +'"><input id="user'+ $('#buscarcontacto').chosen().val() +'" class="form-control checkLstContactos" checked type="checkbox" required="" style="width:50px;" name="user'+ $('#buscarcontacto').chosen().val() +'"><p>' + $('#buscarcontacto option:selected').html() + ' </p></li>');
		}
	});
	
	
	function existeAsiganado(id) {
		var existe = 0;	
		$('#lstContact li input').each(function (index, value) { 
		  if (id == $(this).attr('id')) {
			return existe = 1;  
		  }
		});
		
		return existe;
	}
	
	$("#lstContact").on("click",'.checkLstContactos', function(){
		usersid =  $(this).attr("id");
		
		if  (!($(this).prop('checked'))) {
			$('.'+usersid).remove();	
		}
	});
	
	
	$('.eliminar').click(function(event){
                
			  usersid =  $(this).attr("id");
			  imagenId = 'img'+usersid;
			  
			  if (!isNaN(usersid)) {
				$("#idAgente").val(usersid);
                                //$('#vistaPrevia30').attr('src', e.target.result);
				$("#auxImg").html($('#'+imagenId).html());
				$("#dialog3").dialog("open");
				//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
				//$(location).attr('href',url);
			  } else {
				alert("Error, vuelva a realizar la acción.");	
			  }
			  
			  //post code
	});
	
	$( "#dialog3" ).dialog({
		 	
		autoOpen: false,
		resizable: false,
		width:600,
		height:340,
		modal: true,
		buttons: {
			"Eliminar": function() {

				$.ajax({
							data:  {id: $("#idAgente").val(), accion: 'eliminarFoto'},
							url:   '../../ajax/ajax.php',
							type:  'post',
							beforeSend: function () {
									
							},
							success:  function (response) {
									url = "modificar.php?id=<?php echo $id; ?>";
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
 
 
	});
	
	$('#vermapa').click(function(e) {
        if ($('.lblMapa').html() == 'Ver Mapa') {
			$('.lblMapa').html('Cerrar Mapa');
			$('#contMapa').show();
			$('#vermapa').addClass('btn-warning');
			$('#vermapa').removeClass('btn-info');
			
			if ($('.lblContacto').html() == 'Cerrar Contactos') {
				$('.lblContacto').html('Ver Contactos');
				$('#contContacto').hide();
				$('#vercontacto').addClass('btn-info');
				$('#vercontacto').removeClass('btn-warning');
			}
			
		} else {
			$('.lblMapa').html('Ver Mapa');
			$('#contMapa').hide();
			$('#vermapa').addClass('btn-info');
			$('#vermapa').removeClass('btn-warning');
			
			
			
		}
    });
	
	$('#contContacto').hide();
	
	$('#vercontacto').click(function(e) {
        if ($('.lblContacto').html() == 'Ver Contactos') {
			$('.lblContacto').html('Cerrar Contactos');
			$('#contContacto').show();
			$('#vercontacto').addClass('btn-warning');
			$('#vercontacto').removeClass('btn-info');
			
			if ($('.lblMapa').html() == 'Cerrar Mapa') {
				$('.lblMapa').html('Ver Mapa');
				$('#contMapa').hide();
				$('#vermapa').addClass('btn-info');
				$('#vermapa').removeClass('btn-warning');
			}
			
		} else {
			$('.lblContacto').html('Ver Contactos');
			$('#contContacto').hide();
			$('#vercontacto').addClass('btn-info');
			$('#vercontacto').removeClass('btn-warning');
			
			
			
		}
    });

	 $( "#dialog2" ).dialog({
		 	
			    autoOpen: false,
			 	resizable: false,
				width:600,
				height:240,
				modal: true,
				buttons: {
				    "Eliminar": function() {
	
						$.ajax({
									data:  {id: $('#idEliminar').val(), accion: '<?php echo $eliminar; ?>'},
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
	
	
	<?php 
		echo $serviciosHTML->validacion($tabla);
	
	?>
	

	
	
	//al enviar el formulario
    $('#cargar').click(function(){
		
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
                                            $(".alertCargaU").removeClass("alert-danger");
											$(".alertCargaU").removeClass("alert-info");
                                            $(".alertCargaU").addClass("alert-success");
                                            $(".alertCargaU").html('<strong>Ok!</strong> Se modifico exitosamente el <strong><?php echo $singular; ?></strong>. ');

											$("#load").html('');
											//url = "index.php";
											//$(location).attr('href',url);
                                            
											
                                        } else {
                                        	$(".alertCargaU").removeClass("alert-danger");
                                            $(".alertCargaU").addClass("alert-danger");
                                            $(".alertCargaU").html('<strong>Error!</strong> '+data);
                                            $("#load").html('');
                                        }
				},
				//si ha ocurrido un error
				error: function(){
					$(".alertCargaU").html('<strong>Error!</strong> Actualice la pagina');
                    $("#load").html('');
				}
			});
		}
    });
	
	
	//al enviar el formulario
    $('#cargarContacto').click(function(){
		
			//información del formulario
			var formData = new FormData($(".formulario")[1]);
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
                                            $(".alert").html('<strong>Ok!</strong> Se cargo exitosamente el <strong>Contacto</strong>. ');
											$(".alert").delay(3000).queue(function(){
												/*aca lo que quiero hacer 
												  después de los 2 segundos de retraso*/
												$(this).dequeue(); //continúo con el siguiente ítem en la cola
												
											});
											$("#load").html('');
											url = "modificar.php?id="+<?php echo $id; ?>;
											$(location).attr('href',url);
                                            
											
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
		
    });
	
	$('#contMapa').hide(1700);
	
	$('#imagen1').on('change', function(e) {
	  var Lector,
		  oFileInput = this;
	 
	  if (oFileInput.files.length === 0) {
		return;
	  };
	 
	  Lector = new FileReader();
	  Lector.onloadend = function(e) {
		$('#vistaPrevia1').attr('src', e.target.result);         
	  };
	  Lector.readAsDataURL(oFileInput.files[0]);
	 
	});

});
</script>

<script type="text/javascript">
$('.form_date').datetimepicker({
	language:  'es',
	weekStart: 1,
	todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 0,
	format: 'dd/mm/yyyy'
});
</script>
<script src="../../js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	
	
  </script>
<?php } ?>
</body>
</html>
