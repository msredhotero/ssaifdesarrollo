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

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../equipos/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Equipos",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


$id = $_GET['id'];

$resResultado = $serviciosReferencias->traerEquiposPorId($id);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Equipo";

$plural = "Equipos";

$eliminar = "eliminarEquipos";

$modificar = "modificarEquipos";

$idTabla = "idequipo";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbequipos";

$lblCambio	 	= array("refcountries","refcontactos","refcategorias","refdivisiones","fechaalta","fachebaja");
$lblreemplazo	= array("Countrie","Contacto","Categoria","Division","Fecha Alta","Fecha Baja");


$resCountries 	= $serviciosReferencias->traerCountries();
$cadRef 	= $serviciosFunciones->devolverSelectBoxActivo($resCountries,array(1),'', mysql_result($resResultado,0,'refcountries'));

$resContactos 	= $serviciosReferencias->traerContactos();
$cadRef2 	= $serviciosFunciones->devolverSelectBoxActivo($resContactos,array(1,2),' - ', mysql_result($resResultado,0,'refcontactos'));

$resCategorias 	= $serviciosReferencias->traerCategorias();
$cadRef3 	= $serviciosFunciones->devolverSelectBoxActivo($resCategorias,array(1),'', mysql_result($resResultado,0,'refcategorias'));

$resDivisiones 	= $serviciosReferencias->traerDivisiones();
$cadRef4 	= $serviciosFunciones->devolverSelectBoxActivo($resDivisiones,array(1),'', mysql_result($resResultado,0,'refdivisiones'));

$refdescripcion = array(0 => $cadRef,1 => $cadRef2,2 => $cadRef3,3 => $cadRef4);
$refCampo 	=  array("refcountries","refcontactos","refcategorias","refdivisiones");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$formulario 	= $serviciosFunciones->camposTablaModificar($id, $idTabla, $modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);


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
	<link href="../../css/dropzone.css" rel="stylesheet">
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
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

<h3><?php echo $plural; ?></h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Modificar <?php echo $singular; ?></p>

        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">

			<div class="row">
			<?php echo $formulario; ?>
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
                        <button type="button" class="btn btn-warning" id="cargar" style="margin-left:0px;">Modificar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-danger varborrar" id="<?php echo $id; ?>" style="margin-left:0px;">Eliminar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-warning" id="ver" style="margin-left:0px;">Ver</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>

            <div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12">
					<a href="javascript:void(0);" class="thumbnail">
						<img class="img-responsive">
					</a>
				</div>
			</div>
            </form>
    	</div>
    </div>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Modificar Imagen <?php echo $singular; ?></p>

        </div>
    	<div class="cuerpoBox">
    		<form action="subir.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
				<div class="dz-message">

					<h3>Arrastre y suelte una imagen aqui o haga click y busque una imagen en su ordenador.</h3>
				</div>
				<div class="fallback">
					<input name="file" type="file" id="archivos" />
					<input type="hidden" id="idequipo" name="idequipo" value="<?php echo $id; ?>" />
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



<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<!-- Dropzone Plugin Js -->
<script src="../../js/dropzone.js"></script>

<script type="text/javascript">

$(document).ready(function(){

	function traerImagen() {
		$.ajax({
			data:  {idequipo: <?php echo $id; ?>,
					accion: 'traerImagenEquipo'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {

			},
			success:  function (response) {

				$(".thumbnail img").attr("src",response.datos.imagen);
				$('#idFoto').val(response.datos.idFoto);

			}
		});
	}

	traerImagen();




	Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

	Dropzone.options.frmFileUpload = {
		maxFilesize: 30,
		acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
		accept: function(file, done) {
			done();
		},
		init: function() {
			this.on("sending", function(file, xhr, formData){
               formData.append("idequipo", '<?php echo $id; ?>');
         });
			this.on('success', function( file, resp ){
				traerImagen();
				swal("Correcto!", resp.replace("1", ""), "success");
				$('.btnPresentar').show();
			});

			this.on('error', function( file, resp ){
				swal("Error!", resp.replace("1", ""), "warning");
			});
		}
	};

	var myDropzone = new Dropzone("#archivos", {
		params: {
          idequipo: <?php echo $id; ?>
      },
		url: 'subir.php'
	});

	if ('<?php echo mysql_result($resResultado,0,'activo'); ?>' == 'Si') {
		$('#activo').prop('checked',true);
	} else {
		$('#activo').prop('checked',false);
	}

	$('.volver').click(function(event){

		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar

	$('#ver').click(function(event){

		url = "ver.php?id="+<?php echo $id; ?>;
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

	function traerContactosPorCountries(id) {
		$.ajax({
				data:  {id: id,
						accion: 'traerContactosPorCountries'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {

				},
				success:  function (response) {
					$('#refcontactos').html(response);
				}
		});
	}

	$('#refcountries').change(function() {
		traerContactosPorCountries($(this).val());
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
                                            $(".alert").removeClass("alert-danger");
											$(".alert").removeClass("alert-info");
                                            $(".alert").addClass("alert-success");
                                            $(".alert").html('<strong>Ok!</strong> Se modifico exitosamente el <strong><?php echo $singular; ?></strong>. ');
											$(".alert").delay(3000).queue(function(){
												/*aca lo que quiero hacer
												  después de los 2 segundos de retraso*/
												$(this).dequeue(); //continúo con el siguiente ítem en la cola

											});
											$("#load").html('');
											//url = "index.php";
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
