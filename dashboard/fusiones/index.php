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

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../fusiones/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Fusiones",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Fusion";

$plural = "Fusiones";

$eliminar = "eliminarFusionequipos";

$insertar = "insertarFusionequipos";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////

$resTemporada = $serviciosReferencias->traerUltimaTemporada();
$idtemporada = mysql_result($resTemporada,0,0);

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbfusionequipos";

$lblCambio	 	= array("refequiposdelegados","refcountries","refestados","viejo","entregoformulario");
$lblreemplazo	= array("Equipo","Club","Estado","Temporada Anterior","Entrego Formulario");


$resCountries 	= $serviciosReferencias->traerCountries();
$cadRef		= '<option value="0">-- Seleccionar --</option>';
$cadRef 	.= $serviciosFunciones->devolverSelectBox($resCountries,array(1),'');

$resEstados 	= $serviciosReferencias->traerEstados();
$cadRef2 	= $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');

$resEquipos 	= $serviciosReferencias->traerEquiposDelegadosPorTemporada($idtemporada);
$cadRef3 	= $serviciosFunciones->devolverSelectBox($resEquipos,array(1,2,3),' - ');

$cadRef4 = "<option value='0'>No</option><option value='1'>Si</option>";


$refdescripcion = array(0 => $cadRef,1 => $cadRef2,2 => $cadRef3,3=>$cadRef4);
$refCampo 	=  array("refcountries","refestados","refequiposdelegados","entregoformulario");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "<th>Equipo</th>
					<th>Categoria</th>
					<th>Division</th>
					<th>Club</th>
					<th>Origen</th>
					<th>Entrego Formulario</th>
					<th>Temp.</th>
					<th>Estado</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////




$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerFusionesEquiposCompleto(),8);




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

<body>

 <?php echo $resMenu; ?>

<div id="content">

<h3><?php echo $plural; ?></h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de <?php echo $plural; ?></p>

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



<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	var table = $('#example').DataTable({
		order: [[ 0, "asc" ]],
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ],
		language: {
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

	table.buttons().container()
        .appendTo( '#example_wrapper .col-sm-6:eq(0)' );

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

	$("#example").on("click",'.varmodificar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {

			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");
		  }
	});//fin del boton modificar

	$("#example").on("click",'.varver', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {

			url = "ver.php?id=" + usersid;
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


	//al enviar el formulario
    $('#cargar').click(function(){

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
               $(".alert").html('<strong>Ok!</strong> Se cargo exitosamente el <strong><?php echo $singular; ?></strong>. ');
					$(".alert").delay(3000).queue(function(){
						/*aca lo que quiero hacer
						  después de los 2 segundos de retraso*/
						$(this).dequeue(); //continúo con el siguiente ítem en la cola

					});
					$("#load").html('');
					url = "index.php";
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
