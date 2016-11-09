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

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Canchas",$_SESSION['refroll_predio'],'');


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Cancha";

$plural = "Canchas";

$eliminar = "eliminarCanchas";

$insertar = "insertarCanchas";

$eliminar2 = "eliminarCanchasuspenciones";

$insertar2 = "insertarCanchasuspenciones";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "tbcanchas";

$lblCambio	 	= array("refcountries");
$lblreemplazo	= array("Countries");

$cadRef		= '<option value="0">Libre</option>';
$resCountries 	= $serviciosReferencias->traerCountries();
$cadRef 	.= $serviciosFunciones->devolverSelectBox($resCountries,array(1),'');

$refdescripcion = array(0 => $cadRef);
$refCampo 	=  array("refcountries");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla2 			= "dbcanchasuspenciones";

$lblCambio2	 	= array("vigenciadesde","vigenciahasta","refcanchas");
$lblreemplazo2	= array("Vigencia Desde","Vigencia Hasta","Canchas");


$resCancha 	= $serviciosReferencias->traerCanchas();
$cadRef3 	= $serviciosFunciones->devolverSelectBox($resCancha,array(1,2),' - ');

$refdescripcion2 = array(0 => $cadRef3);
$refCampo2 	=  array("refcanchas");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////



/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "	<th>Countrie</th>
					<th>Nombre Cancha</th>";

$cabeceras2 		= "	<th>Countrie</th>
						<th>Nombre Cancha</th>
						<th>Vigencia Desde</th>
						<th>Vigencia Hasta</th>";
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$formularioSuspenciones 	= $serviciosFunciones->camposTabla($insertar2 ,$tabla2,$lblCambio2,$lblreemplazo2,$refdescripcion2,$refCampo2);

$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerCanchas(),94);

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
    

 
</head>

<body onLoad="localize()">

 <?php echo $resMenu; ?>

<div id="content">

<h3><?php echo $plural; ?></h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de <?php echo $plural; ?></p>
        	
        </div>
        
    	<div class="cuerpoBox">
        	<div class="alert alert-info">
                <p><span class="glyphicon glyphicon-info-sign"></span> La opción "Libre" as solo para las canchas que no pertenecen a un countrie</p>
            </div>
        	<form class="form-inline formulario" role="form">
        	<div class="row">
			<?php echo $formulario; ?>
            </div>
            <!--
            <div class="row">
            	<div id="map" ></div>

            </div>
            -->
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alertcanchas alert'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                        <button type="button" class="btn btn-primary" id="cargar" style="margin-left:0px;">Guardar</button>
                    </li>
                </ul>
                </div>
            </div>
            </form>
    	</div>
    </div>
    

    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;"><?php echo $plural; ?> Cargados</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<?php echo $lstCargados; ?>
    	</div>
    </div>

   
</div>


</div>
<div id="dialog2" title="Eliminar <?php echo $singular; ?>">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea eliminar el <?php echo $singular; ?>?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si elimina el <?php echo $singular; ?> se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>

<!-- Modal -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <form class="form-inline formulario" role="form">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Crear Suspenciones</h4>
      </div>
      <div class="modal-body" style="height:300px;">
        <?php echo $formularioSuspenciones; ?>
        
        <div class='row' style="margin-left:25px; margin-right:25px;">
            <div class='alert'>
            
            </div>
            <div id='load'>
            
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="cargarSuspenciones">Agregar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$('#example').dataTable({
		"order": [[ 0, "asc" ]],
		"language": {
			"emptyTable":     "No hay datos cargados",
			"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
			"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
			"infoFiltered":   "(filtrados del total de _MAX_ filas)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Mostrar _MENU_ filas",
			"loadingRecords": "Cargando...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"zeroRecords":    "No se encontraron resultados",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activate to sort column ascending",
				"sortDescending": ": activate to sort column descending"
			}
		  }
	} );
	
	$('.abrir2').click(function() {
		
		if ($('.abrir2').text() == '(Abrir)') {
			$('.filt2').show( "slow" );
			$('.abrir2').text('(Cerrar)');
			$('.abrir2').removeClass('glyphicon glyphicon-plus');
			$('.abrir2').addClass('glyphicon glyphicon-minus');
		} else {
			$('.filt2').slideToggle( "slow" );
			$('.abrir2').text('(Abrir)');
			$('.abrir2').addClass('glyphicon glyphicon-plus');
			$('.abrir2').removeClass('glyphicon glyphicon-minus');

		}
	});
	
	$('#usuacrea').val('<?php echo utf8_encode($_SESSION['nombre_predio']); ?>');
	
	$('.abrir2').click();
	
	$('.abrir2').click(function() {
		$('.filt2').show();
	});
	
	$('#activo').prop('checked',true);

	$("#example").on("click",'.varborrar', function(){
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
	
	
	$("#example").on("click",'.varversuspendidos', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "suspenciones.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar
	
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
                                            $(".alertcanchas").removeClass("alert-danger");
											$(".alertcanchas").removeClass("alert-info");
                                            $(".alertcanchas").addClass("alert-success");
                                            $(".alertcanchas").html('<strong>Ok!</strong> Se cargo exitosamente el <strong><?php echo $singular; ?></strong>. ');
											
											$("#load").html('');
											url = "index.php";
											$(location).attr('href',url);
                                            
											
                                        } else {
                                        	$(".alertcanchas").removeClass("alert-danger");
                                            $(".alertcanchas").addClass("alert-danger");
                                            $(".alertcanchas").html('<strong>Error!</strong> '+data);
                                            $("#load").html('');
                                        }
				},
				//si ha ocurrido un error
				error: function(){
					$(".alertcanchas").html('<strong>Error!</strong> Actualice la pagina');
                    $("#load").html('');
				}
			});
		}
    });
	
	
	//al enviar el formulario
    $('#cargarSuspenciones').click(function(){
		
		if ($('#vigenciadesde').val() != "")
        {
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
					$("#loadcancha").html('<img src="../../imagenes/load13.gif" width="50" height="50" />');       
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
                                            $(".alertcancha").removeClass("alert-danger");
											$(".alertcancha").removeClass("alert-info");
                                            $(".alertcancha").addClass("alert-success");
                                            $(".alertcancha").html('<strong>Ok!</strong> Se cargo exitosamente la <strong>Suspencion</strong>. ');
	
											$("#loadcancha").html('');
											url = "index.php";
											$(location).attr('href',url);
                                            
											
                                        } else {
                                        	$(".alertcancha").removeClass("alert-danger");
                                            $(".alertcancha").addClass("alert-danger");
                                            $(".alertcancha").html('<strong>Error!</strong> '+data);
                                            $("#loadcancha").html('');
                                        }
				},
				//si ha ocurrido un error
				error: function(){
					$(".alertcancha").html('<strong>Error!</strong> Actualice la pagina');
                    $("#loadcancha").html('');
				}
			});
		} else {
			$(".alertcancha").removeClass("alert-danger");
			$(".alertcancha").addClass("alert-danger");
			$(".alertcancha").html('<strong>Error!</strong> Debe cargar una vigencia desde');
			$("#loadcancha").html('');
		}
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
<?php } ?>
</body>
</html>
