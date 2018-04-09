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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../fallos/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Fallos",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


$id		=	$_GET['id'];

$resResultado	=	$serviciosReferencias->traerSancionesjugadoresPorId($id);
$resDetalles	=	$serviciosReferencias->traerSancionesjugadoresPorIdDetallesSinFallo($id);
/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Fallo";

$plural = "Fallos";

$eliminar = "eliminarSancionesfallos";

$insertar = "insertarFalloPorFecha";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbsancionesfallos";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////




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

    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	
    
   
   <link href="../../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../../js/jquery.mousewheel.js"></script>
      <script src="../../js/perfect-scrollbar.js"></script>
      <script src="../../js/jquery.number.min.js"></script>
      <script type="text/javascript">
			
		$(function(){

			$('#cantidadfechas').each(function(intIndex){
				$(this).number( true, 0 );
				$(this).change( function() {
					if ($(this).val() > 100) {
						$(this).val(2);
					}
					if ($(this).val() < 1) {
						$(this).val(1);
					}
				});
			});


		});
		</script>
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
        	<ul class="list-group">
              <li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-user"></span> Jugador</li>
              <li class="list-group-item list-group-item-default">Nombre Completo: <?php echo mysql_result($resDetalles,0,'jugador'); ?></li>
              <li class="list-group-item list-group-item-default">Nro Documento: <?php echo mysql_result($resDetalles,0,'nrodocumento'); ?></li>
              <li class="list-group-item list-group-item-default">Fecha de la sación: <?php echo mysql_result($resDetalles,0,'fecha'); ?></li>
              <li class="list-group-item list-group-item-default">Sanción: <?php echo mysql_result($resDetalles,0,'tiposancion'); ?></li>
              
            </ul>
        
        	<form class="form-inline formulario" role="form">
        	<div class="row">

                <div class="form-group col-md-3" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Fallo Por Fechas</label>
                    <div class="input-group col-md-12">
                        <input type="checkbox" class="form-control" name="elegir[]" id="btnFechas" value="fallocantidad"/>
                    </div>
                </div>
                <div class="form-group col-md-4" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Cantidad de Fechas</label>
                    <div class="input-group col-md-12">
                        <input type="text" class="form-control" name="cantidadfechas" id="cantidadfechas" value="1"/>
                    </div>
                </div>
             </div>  
             <hr>
             <div class="row"> 
                <div class="form-group col-md-3" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Fallo Por Días</label>
                    <div class="input-group col-md-12">
                        <input type="checkbox" class="form-control" name="elegir[]" id="btnDias" value="fallofechas"/>
                    </div>
                </div>
                <div class="form-group col-md-4" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Fecha Desde</label>
                    <div class="input-group col-md-10">
                        <input type="text" class="form-control" name="fechadesde" id="fechadesde"/>
                    </div>
                    
                </div>
                
                <div class="form-group col-md-4" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Fecha Hasta</label>
                    <div class="input-group col-md-10">
                        <input type="text" class="form-control" name="fechahasta" id="fechahasta"/>
                    </div>
                    
                </div>
                
                
            </div>  
            <hr>
            <div class="row">    
                
                <div class="form-group col-md-3" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Fallo Por Amarillas</label>
                    <div class="input-group col-md-12">
                        <input type="checkbox" class="form-control" name="elegir[]" id="btnAmarillas" value="falloamarillas"/>
                    </div>
                </div>
                <div class="form-group col-md-4" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Cantidad de Amarillas</label>
                    <div class="input-group col-md-12">
                        <input type="text" class="form-control" name="amarillas" id="amarillas" value="2" readonly/>
                    </div>
                </div>
             </div>  
             <hr>
             <div class="row">   
                
                <div class="form-group col-md-3" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Dejar Pendiente de Fallo</label>
                    <div class="input-group col-md-12">
                        <input type="checkbox" class="form-control" name="elegir[]" id="btnPendiente" value="pendientesfallo"/>
                    </div>
                </div>
                
                <div class="form-group col-md-12" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Observaciones</label>
                    <div class="input-group col-md-12">
                        <textarea name="observaciones" id="observaciones" class="form-control" rows="10" cols="20">
                        
                        </textarea>
                    </div>
                </div>
			</div>
                
                 
        
                <div class='row' style="margin-left:25px; margin-right:25px;">
                    <div class='alert' id="errorFalloPorFechas">
                    
                    </div>
                    <div id='load'>
                    
                    </div>
                </div>
                
                
                
                <input type="hidden" id="refsancionesjugadores" name="refsancionesjugadores" value="<?php echo $id; ?>"/>
                <input type="hidden" id="accion" name="accion" value="insertarFalloPorFecha"/>
             

            

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
	
	$(document).on('click', '.panel-heading span.clickable', function(e){
		var $this = $(this);
		if(!$this.hasClass('panel-collapsed')) {
			$this.parents('.panel').find('.panel-body').slideUp();
			$this.addClass('panel-collapsed');
			$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		} else {
			$this.parents('.panel').find('.panel-body').slideDown();
			$this.removeClass('panel-collapsed');
			$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		}
	});
	
	$("#example").on("click",'.varmodificar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar

		
	$("#fechadesde").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
	$("#fechahasta").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
	
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
										url = "../prefallos/index.php";
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

});
</script>


<?php } ?>
</body>
</html>
