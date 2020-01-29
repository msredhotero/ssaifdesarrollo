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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../categorias/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Categorias",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


$id = $_GET['id'];

$resTemporadas = $serviciosReferencias->traerUltimaTemporada();
$anioTemporada = 0;

if (mysql_num_rows($resTemporadas)>0) {
	 $ultimaTemporada = mysql_result($resTemporadas,0,0) - 1;
	 $anioTemporada = mysql_result($resTemporadas,0,1);
	 $idtemporada = mysql_result($resTemporadas,0,0);
} else {
	 $ultimaTemporada = 0;
	 $anioTemporada = 0;
	 $idtemporada = 0;
}

$resResultado = $serviciosReferencias->traerHabilitaciones10anios($id, $ultimaTemporada);
$resResultadoBaja = $serviciosReferencias->bajaJugadoresConPedidoHabilitacion($id, $ultimaTemporada);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Mantener antiguedad";

$plural = "Mantener antiguedad";

$eliminar = "eliminarJugadoresmotivoshabilitacionestransitorias";

$modificar = "modificarJugadoresmotivoshabilitacionestransitorias";

$idTabla = "iddbjugadormotivohabilitaciontransitoria";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "tbcategorias";

$lblCambio	 	= array("");
$lblreemplazo	= array("");


$cadRef 	= '';

$refdescripcion = array();
$refCampo 	=  array();
//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$cabeceras 		= "<th>Nro Doc</th>
					<th>Apellido</th>
					<th>Nombres</th>
					<th>Fecha Nac.</th>
					<th>Obs.</th>
					<th>Fecha Limite</th>";

$lstNuevosJugadores = $serviciosFunciones->camposTablaView($cabeceras,$resResultado,999);
$lstNuevosJugadoresB = $serviciosFunciones->camposTablaView($cabeceras,$resResultadoBaja,9998);


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
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;"><?php echo $singular; ?></p>

        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">

			<div class="row">
				<div class="col-xs-12">
					<?php echo $lstNuevosJugadores; ?>
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
                     <button type="button" class="btn btn-warning" id="cargar" style="margin-left:0px;">Generar Hab. Transitoria</button>
                 </li>

                 <li>
                     <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
                 </li>
             </ul>
             </div>
         </div>
			<input type="hidden" name="accion" id="accion" value="generarHabilitacionTransitoriaPor10"/>
         </form>
    	</div>
    </div>

	 <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Baja de Jugadores con Habilitaciones que no fueron generadas</p>

        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">

			<div class="row">
				<div class="col-xs-12">
					<?php echo $lstNuevosJugadoresB; ?>
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
                     <button type="button" class="btn btn-danger" id="cargar" style="margin-left:0px;">Baja a los Jugadores con fecha de hoy</button>
                 </li>

                 <li>
                     <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
                 </li>
             </ul>
             </div>
         </div>
			<input type="hidden" name="accion" id="accion" value="bajaHabilitacionTransitoriaPor10"/>
         </form>
    	</div>
    </div>



</div>


</div>

<div id="dialog2" title="Dar de Baja">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea dar de baja al jugador?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>El jugador no podra participar del torneo</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>

<div id="dialog3" title="Generar Habilitacion Transitoria">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea mantenerle la habilitacion transitoria para la nueva temporada?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Una vez generada la puede borrar entrando por Jugador->Habilitaciones</p>
        <input type="hidden" value="" id="idGenerar" name="idGenerar">
</div>


<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){

	$('.volver').click(function(event){

		url = "../reportes/";
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

	$( "#dialog2" ).dialog({
	   autoOpen: false,
	 	resizable: false,
		width:600,
		height:240,
		modal: true,
		buttons: {
		    "Baja": function() {

				$.ajax({
					data:  {id: $('#idEliminar').val(), accion: 'eliminarJugadoresBaja'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
						url = "antiguedad.php?id=<?php echo $id; ?>";
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


	$('.vargenerar').click(function(event){
	  usersid =  $(this).attr("id");
	  if (!isNaN(usersid)) {
		$("#idGenerar").val(usersid);
		$("#dialog3").dialog("open");


		//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
		//$(location).attr('href',url);
	  } else {
		alert("Error, vuelva a realizar la acción.");
	  }
	});//fin del boton eliminar

	$( "#dialog3" ).dialog({
	   autoOpen: false,
	 	resizable: false,
		width:600,
		height:240,
		modal: true,
		buttons: {
		    "Generar": function() {

				$.ajax({
					data:  {
						reftemporadasA: <?php echo $idtemporada; ?>,
						refjugadores: $('#idGenerar').val(),
						refdocumentacionesA: 4,
						refmotivoshabilitacionestransitoriasA: 9,
						refequiposA: 'null',
						refcategoriasA: 'null',
						fechalimiteA: <?php echo "'31/12/".$anioTemporada."'"; ?>,
						observacionesA: 'Generada por sistema',
						accion: 'insertarJugadoresmotivoshabilitacionestransitoriasA'
					},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {
							url = "antiguedad.php?id=<?php echo $id; ?>";
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
<?php } ?>
</body>
</html>
