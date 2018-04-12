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
$resDetalles	=	$serviciosReferencias->traerSancionesjugadoresPorIdDetalles($id);

$resFix			=	$serviciosReferencias->traerFixturePorId(mysql_result($resResultado,0,'reffixture'));
$resTor			=	$serviciosReferencias->traerTorneosPorId(mysql_result($resFix,0,'reftorneos'));

$idTipoTorneo	=	mysql_result($resTor,0,'reftipotorneo');

$resFallo		=	$serviciosReferencias->traerSancionesJugadoresConFallosPorSancion($id, $idTipoTorneo);

$cumplidas		=	mysql_num_rows($serviciosReferencias->traerSancionesfechascumplidasPorSancionJugadorEnSuCategoria($id));


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Fallo";

$plural = "Fallos";

$eliminar = "eliminarSancionesfallos";

$insertar = "modificarSancionesfallos";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbsancionesfallos";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////



$fallo	= '';

$amarillas		=	mysql_result($resFallo,0,'amarillas');
$cantidadfechas	=	mysql_result($resFallo,0,'cantidadfechas');
$fechadesde		=	mysql_result($resFallo,0,'fechadesde');
$fechahasta		=	mysql_result($resFallo,0,'fechahasta');
$pendiente		=	mysql_result($resFallo,0,'pendientesfallo');
$observaciones	=	mysql_result($resFallo,0,'observaciones');

if ($amarillas > 0) {
	$fallo = 'Amarillas';
} else {
	if (($fechadesde != '00/00/0000') && ($fechadesde != '01/01/1900')) {
		$fallo = 'Dias';
	} else {
		if ($pendiente == 'Si') {
			$fallo = 'Pendiente';
			
		} else {
			$fallo = 'Cantidad';	
		}
	}
}
$resCambio = $serviciosReferencias->traerSancionesfallosacumuladasCambioPorEquipoFechaDesdeHasta(mysql_result($resResultado,0,'refequipos'),mysql_result($resResultado,0,'fecha'),date('Y-m-d'),mysql_result($resResultado,0,'refcategorias'));


$resCategorias  = $serviciosReferencias->traerCategorias();
$cadRef3    = $serviciosFunciones->devolverSelectBoxActivo($resCategorias,array(1),'', mysql_result($resDetalles,0,'refcategorias'));


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
        	<p style="color: #fff; font-size:18px; height:16px;">Modificar <?php echo $plural; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<ul class="list-group">
              <li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-user"></span> Jugador</li>
              <li class="list-group-item list-group-item-default">Nombre Completo: <?php echo mysql_result($resDetalles,0,'jugador'); ?></li>
              <li class="list-group-item list-group-item-default">Nro Documento: <?php echo mysql_result($resDetalles,0,'nrodocumento'); ?></li>
              <li class="list-group-item list-group-item-default">Fecha de la sación: <?php echo mysql_result($resDetalles,0,'fecha'); ?></li>
              <li class="list-group-item list-group-item-default">Sanción: <?php echo mysql_result($resDetalles,0,'tiposancion'); ?></li>
              <li class="list-group-item list-group-item-default">Cumplidas: <?php echo $cumplidas; ?></li>
              <li class="list-group-item list-group-item-default">
                <ul class="list-inline">
                    <li>Modificar Categoria:</li>
                    <li><select id="categoriaNueva" name="categoriaNueva" class="form-control"><?php echo $cadRef3; ?></select></li>
                    <li><button type="button" class="btn btn-warning" id="modificarCategoriaFallo" style="margin-left:0px;">Modificar</button></li>
                </ul>
              </li>
              <li class="list-group-item list-group-item-default"><a href="../estadisticas/estadisticas.php?id=<?php echo mysql_result($resResultado,0,'reffixture'); ?>">Ir Estadistica</a></li>
              
            </ul>
        
        	<form class="form-inline formulario" role="form">
        	<div class="row">

                <div class="form-group col-md-3" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Fallo Por Fechas</label>
                    <div class="input-group col-md-12">
                        <input type="checkbox" class="form-control" <?php if ($fallo == 'Cantidad') echo 'checked=""'; ?> name="elegir[]" id="btnFechas" value="fallocantidad"/>
                    </div>
                </div>
                <div class="form-group col-md-4" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Cantidad de Fechas</label>
                    <div class="input-group col-md-12">
                        <input type="text" class="form-control" value="<?php echo $cantidadfechas; ?>" name="cantidadfechas" id="cantidadfechas"/>
                    </div>
                </div>
             </div>  
             <hr>
             <div class="row"> 
                <div class="form-group col-md-3" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Fallo Por Días</label>
                    <div class="input-group col-md-12">
                        <input type="checkbox" class="form-control" <?php if ($fallo == 'Dias') echo 'checked=""'; ?> name="elegir[]" id="btnDias" value="fallofechas"/>
                    </div>
                </div>
                <div class="form-group col-md-4" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Fecha Desde</label>
                    <div class="input-group col-md-10">
                        <input type="text" class="form-control" value="<?php echo $fechadesde; ?>" name="fechadesde" id="fechadesde"/>
                    </div>
                    
                </div>
                
                <div class="form-group col-md-4" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Fecha Hasta</label>
                    <div class="input-group col-md-10">
                        <input type="text" class="form-control" value="<?php echo $fechahasta; ?>" name="fechahasta" id="fechahasta"/>
                    </div>
                    
                </div>
                
                
            </div>  
            <hr>
            <div class="row">    
                
                <div class="form-group col-md-3" style="display:block">
                    <label for="reftipodocumentos" class="control-label" style="text-align:left">Fallo Por Amarillas</label>
                    <div class="input-group col-md-12">
                        <input type="checkbox" class="form-control" name="elegir[]" <?php if ($fallo == 'Amarillas') echo 'checked=""'; ?> id="btnAmarillas" value="falloamarillas"/>
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
                        <input type="checkbox" class="form-control" <?php if ($fallo == 'Pendiente') echo 'checked=""'; ?> name="elegir[]" id="btnPendiente" value="pendientesfallo"/>
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
                
                <div class="alert alert-warning">
                	<?php
						if (mysql_num_rows($resCambio)>0) {
					?>
                    	<p>Si modifica el estado de Pendiente para pasarlo a cantidad de fechas, las fechas que actualmente el jugador ya cumplio son:</p>
                        <ul style="margin-left:20px;">
                        	<?php
							$total = 0;
							while ($row = mysql_fetch_array($resCambio)) {
								$total += 1;
							?>
                            <li><?php echo $row[0].' - Fecha Juego: '.$row[1].' ('.$row[2].')'; ?></li>
                            <?php
							}
                            ?>
                            <?php echo '<li>Total Fechas: '.$total.'</li>'; ?>
                        </ul>
                    <?php	
						}
					?>
                
                </div>
                
                <input type="hidden" id="refsancionesjugadores" name="refsancionesjugadores" value="<?php echo $id; ?>"/>
                <input type="hidden" id="accion" name="accion" value="modificarFalloPorFecha"/>
             

            

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

    $('#modificarCategoriaFallo').click(function() {
        $.ajax({
            data:  {id: <?php echo $id; ?>, idcategoria: $('#categoriaNueva').val(), accion: 'modificarCategoriaFallo'},
            url:   '../../ajax/ajax.php',
            type:  'post',
            beforeSend: function () {
                    
            },
            success:  function (response) {
                    url = "modificar.php?id=<?php echo $id; ?>";
                    $(location).attr('href',url);
                    
            }
        });
    });

		
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
		
    });

});
</script>


<?php } ?>
</body>
</html>
