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
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Jugadores",$_SESSION['refroll_predio'],'');


$id = $_GET['id'];
$idJugador = $_GET['idJugador'];

$resResultado = $serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorId($id);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Jugador";

$plural = "Jugadores";

$eliminar = "eliminarJugadoresmotivoshabilitacionestransitorias";

$modificar = "modificarJugadoresmotivoshabilitacionestransitorias";

$idTabla = "iddbjugadormotivohabilitaciontransitoria";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbjugadoresmotivoshabilitacionestransitorias";

$lblCambio	 	= array("reftemporadas","refjugadores","refdocumentaciones","refmotivoshabilitacionestransitorias","refequipos","refcategorias","fechalimite");
$lblreemplazo	= array("Temporadas","Jugadores","Documentaciones","Motivos Hab. Trans.","Equipos","Categorias","Fecha Limite");


$resTemp 	= $serviciosReferencias->traerTemporadas();
$cadRef 	= $serviciosFunciones->devolverSelectBoxActivo($resTemp,array(1),'', mysql_result($resResultado,0,'reftemporadas'));

$resJug 	= $serviciosReferencias->traerJugadoresPorId($idJugador);
$cadRef2 	= $serviciosFunciones->devolverSelectBoxActivo($resJug,array(2,3,4),' - ', mysql_result($resResultado,0,'refjugadores'));

$resDoc 	= $serviciosReferencias->traerDocumentaciones();
$cadRef3 	= $serviciosFunciones->devolverSelectBoxActivo($resDoc,array(1),'', mysql_result($resResultado,0,'refdocumentaciones'));

$resMot 	= $serviciosReferencias->traerMotivoshabilitacionestransitorias();
$cadRef4 	= $serviciosFunciones->devolverSelectBoxActivo($resMot,array(2,1),' - inhabilita:', mysql_result($resResultado,0,'refmotivoshabilitacionestransitorias'));

$resEqui 	= $serviciosReferencias->traerEquipos();
$cadRef5 	= $serviciosFunciones->devolverSelectBoxActivo($resEqui,array(1,2),' - ', mysql_result($resResultado,0,'refequipos'));

$resCat 	= $serviciosReferencias->traerCategorias();
$cadRef6 	= $serviciosFunciones->devolverSelectBoxActivo($resCat,array(1),' - ', mysql_result($resResultado,0,'refcategorias'));


$refdescripcion = array(0 => $cadRef,1 => $cadRef2,2=>$cadRef3,3=>$cadRef4,4=>$cadRef5,5=>$cadRef6);
$refCampo 	=  array("reftemporadas","refjugadores","refdocumentaciones","refmotivoshabilitacionestransitorias","refequipos","refcategorias");


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
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){

	$('.volver').click(function(event){
		 
		url = "habilitaciones.php?id="+<?php echo $idJugador; ?>;
		$(location).attr('href',url);
	});//fin del boton modificar
	
	function traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion(idDocumentacion,contenedor) {
		$.ajax({
			data:  {id: idDocumentacion, accion: 'traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
			
			},
			success:  function (response) {
				$(contenedor).html(response);
			}
		});	
	}
	
	traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion( $('#refdocumentaciones').val() ,'#refmotivoshabilitacionestransitorias' );

	$('#refdocumentaciones').change(function() {
		traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion($(this).val(),'#refmotivoshabilitacionestransitorias');
	});
	
	$('#documentaciones').click(function(event){
		 
		url = "documentaciones.php?id="+<?php echo $id; ?>;
		$(location).attr('href',url);
	});//fin del boton documentaciones
	
	
	$('#equipos').click(function(event){
		 
		url = "equipos.php?id="+<?php echo $id; ?>;
		$(location).attr('href',url);
	});//fin del boton equipos
	
	
	$('#habilitaciones').click(function(event){
		 
		url = "habilitaciones.php?id="+<?php echo $id; ?>;
		$(location).attr('href',url);
	});//fin del boton habilitaciones
	
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
<?php } ?>
</body>
</html>
