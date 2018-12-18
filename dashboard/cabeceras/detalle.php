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
include ('../../includes/funcionesDelegados.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$serviciosDelegados 	= new serviciosDelegados();

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../cabeceras/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Cabeceras",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


$id = $_GET['id'];

$resCabecera = $serviciosDelegados->traerCabeceraconfirmacionPorId($id);

$idcountries = mysql_result($resCabecera,0,'refcountries');
$idtemporada = mysql_result($resCabecera,0,'reftemporadas');

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Division";

$plural = "Divisiones";

$eliminar = "eliminarDivisiones";

$insertar = "insertarDivisiones";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbcabeceraconfirmacion";

$lblCambio	 	= array("");
$lblreemplazo	= array("");


$cadRef 	= '';

$refdescripcion = array();
$refCampo 	=  array();
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "	<th>Temporada</th>
					<th>Countrie</th>
					<th>Estado</th>
					<th>Fecha Crea.</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////




//$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

//$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosDelegados->traerCabeceraconfirmacionGrid(),4);

$resEstados = $serviciosReferencias->traerEstados();
$cadRef 	= $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');


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
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Equipos Cargados</p>
        	
        </div>
    	<div class="cuerpoBox">
    		<button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
    		<br>
    		<br>
        	<table class="table table-striped table-responsive" id="example">
				<thead>
					<tr>
						<th>Countrie</th>
						<th>Nombre</th>
						<th>Categoria</th>
						<th>Division</th>
						<th>Estado</th>
						<th>Activo</th>
						<th>Nuevo</th>
						<th>Es Fusión</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody id="resultados">
					
				</tbody>
			</table>

    	</div>
    </div>
    
    

    
    
   
</div>


</div>



<div class="modal fade" id="myModal3" tabindex="1" style="z-index:500000;" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<form class="form-inline formulario" role="form">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modificar Estado</h4>
			</div>
			<div class="modal-body">
				<label class="label-control">Seleccione el Estado</label>
			    <select class="form-control" id="refestados" name="refestados">
			    	<?php echo $cadRef; ?>
			    </select>
			    <input type="hidden" name="idequiposdelegados" id="idequiposdelegados" value="0">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal" id="btnModificarEstado">Modificar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

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

	$('.volver').click(function(event){
		 
		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar

	function traerEquiposDelagados() {
		$.ajax({
			data:  {dato: 'equiposdelegados', 
					param1: <?php echo $idcountries; ?>,
					param2: <?php echo $idtemporada; ?>,
					cabecerasdatos: 'countrie,nombre,categoria,division,estado,activo,nuevo,esfusion',
					id: 'idequipodelegado',
					accion: 'armarTable'},
			url:   '../../ajax/ajaxdelegados.php',
			type:  'post',
			beforeSend: function () {
			
			},
			success:  function (response) {
				
				$('#resultados').html(response);
				
			}
		});	
	}

	traerEquiposDelagados();

	function modificarEstadoCabecera(id,estado) {
		$.ajax({
			data:  {id: id, 
					idestado: estado,
					accion: 'modificarEstadoEquiposDelegados'},
			url:   '../../ajax/ajaxdelegados.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
				traerEquiposDelagados();
			}
		});
	}

	$('#btnModificarEstado').click(function() {
		modificarEstadoCabecera($('#idequiposdelegados').val(), $('#refestados').val() );
	});
	
	$('#activo').prop('checked',true);

	$("#resultados").on("click",'.varver', function(){
		usersid =  $(this).attr("id");

		url = "jugadores.php?id=" + usersid;
		$(location).attr('href',url);

	});//fin del boton plantel

	$("#resultados").on("click",'.varfusion', function(){

		usersid =  $(this).attr("id");

		url = "fusion.php?id=" + usersid;
		$(location).attr('href',url);

	});//fin del boton plantel
	
	$("#resultados").on("click",'.varmodificarestado', function(){
		usersid =  $(this).attr("id");
		$('#idequiposdelegados').val(usersid);
		$('#myModal3').modal();

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
