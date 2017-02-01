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

$resResultado = $serviciosReferencias->traerJugadoresPorId($id);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Jugador";

$plural = "Jugadores";

$eliminar = "eliminarJugadores";

$modificar = "modificarJugadores";

$idTabla = "idjugador";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbjugadores";

$lblCambio	 	= array("reftipodocumentos","nrodocumento","fechanacimiento","fechaalta","fechabaja","refcountries");
$lblreemplazo	= array("Tipo Documento","Nro Documento","Fecha Nacimiento","Fecha Alta","Fecha Baja","Countries");


$resTipoDoc 	= $serviciosReferencias->traerTipodocumentos();
$cadRef 	= $serviciosFunciones->devolverSelectBoxActivo($resTipoDoc,array(1),'', mysql_result($resResultado,0,'reftipodocumentos'));

$resCountries 	= $serviciosReferencias->traerCountries();
$cadRef2 	= $serviciosFunciones->devolverSelectBoxActivo($resCountries,array(1),'', mysql_result($resResultado,0,'refcountries'));

$refdescripcion = array(0 => $cadRef,1 => $cadRef2);
$refCampo 	=  array("reftipodocumentos","refcountries");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$formulario 	= $serviciosFunciones->camposTablaModificar($id, $idTabla, $modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$resJugadores = $serviciosReferencias->traerJugadoresdocumentacionPorJugador($id);

$resDocumentaciones	=	$serviciosReferencias->traerJugadoresdocumentacionPorJugadorValores($id);

$resCantidadConectoresActivos  =	$serviciosReferencias->traerConectorActivos($id);


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
    <script src="../../js/jquery.maskedinput.min.js" type="text/javascript"></script>
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	<style type="text/css">
		th {
		  color:#D5DDE5;;
		  background:#1b1e24;
		  border-bottom:4px solid #9ea7af;
		  border-right: 1px solid #343a45;
		  font-size:17px;
		  font-weight: 100;
		  padding:18px;
		  text-align:left;
		  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		  vertical-align:middle;
		  font-family: "Roboto", helvetica, arial, sans-serif;
		}
		
		th:first-child {
		  border-top-left-radius:3px;
		}
		 
		th:last-child {
		  border-top-right-radius:3px;
		  border-right:none;
		}
		
		tr {
		  border-top: 1px solid #C1C3D1;
		  border-bottom-: 1px solid #C1C3D1;
		  color:#666B85;
		  font-size:16px;
		  font-weight:normal;
		  text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
		}
  
		
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
                <hr>
                
                <div class='row' style="margin-left:25px; margin-right:25px;">
                    <h4 style="text-decoration:underline;">Documentaciones</h4>
                    <?php
                        while ($rowD = mysql_fetch_array($resDocumentaciones)) {
                        if ($rowD['obligatoria'] == 'Si') {
                            if (($rowD['valor'] == 'No') && ($rowD['contravalor'] == 'No')) {
                                $noHabilitaDocumentacion = array($rowD['refdocumentaciones']=>0);
                            }
                        }
                    ?>
                        <div class="col-md-4">
                            <?php
                                if ($rowD['valor'] == 'Si') {
                            ?>
                            <p><span style="color:#3C0;" class="glyphicon glyphicon-ok"></span> <?php echo $rowD['descripcion']; ?></p>
                            <?php 
                                } else { 
                                    if ($rowD['contravalor'] == 'Si') {
                            ?>
                                    <p><span style="color:#3C0;" class="glyphicon glyphicon-ok"></span> <?php echo $rowD['descripcion']; ?></p>
                            <?php
                                    } else {
                            ?>
                                    <p><span style="color:#F00;" class="glyphicon glyphicon-remove"></span> <?php echo $rowD['descripcion']; ?></p>
                            <?php		
                                    }
                                }
                            ?>
                        </div>
                    <?php
                        }
                    ?>
                </div>
                
                <div class="row" style="margin-left:25px; margin-right:25px;">
    
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            <label class="control-label" style="text-align:left; font-size:1.2em; text-decoration:underline; margin-bottom:4px;" for="fechas">Listado de Equipos Activos</label>
                            <div class="input-group col-md-12">
                                <table class="table table-bordered table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th>Equipo</th>
                                        <th>Countries</th>
                                        <th>Categoria</th>
                                        <th>Tipo Jugador</th>
                                        <th>Activo</th>
                                        <th style="text-align:center">Baja</th>
                                    </tr>
                                </thead>
                                <tbody id="lstjugadores">
                                <?php 
                                    $cantidad = 0;
                                    while ($rowC = mysql_fetch_array($resCantidadConectoresActivos)) {
                                    $cantidad += 1;
                                ?>
                                    <tr>
                                    <td><?php echo $rowC['equipo']; ?></td>
                                    <td><?php echo $rowC['countrie']; ?></td>
                                    <td><?php echo $rowC['categoria']; ?></td>
                                    <td><?php echo $rowC['tipojugador']; ?></td>
                                    <td><?php echo $rowC['activo']; ?></td>
                                    <td align="center"><img src="../../imagenes/eliminarIco.png" style="cursor:pointer;" id="<?php echo $rowC['idconector']; ?>" class="varEliminarJugador"></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                                <tfoot>
                                    <td colspan="4" align="right">Total Equipos:</td>
                                    <td><?php echo $cantidad; ?></td>
                                </tfoot>
                                </table>
                            </div>
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
                        <button type="button" class="btn btn-warning" id="cargar" style="margin-left:0px;">Modificar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-success" id="documentaciones" style="margin-left:0px;">Documentaciones</button>
                    </li>
                    <?php if (mysql_num_rows($resJugadores)>0) { ?>
                    <li>
                        <button type="button" class="btn btn-success" id="equipos" style="margin-left:0px;">Equipos</button>
                    </li>
                    <?php } ?>
                    <li>
                        <button type="button" class="btn btn-success" id="habilitaciones" style="margin-left:0px;">Habilitaciones</button>
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

<div id="dialog3" title="Quitar al jugador del Equipo">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea quitar el jugador?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si quitará el jugador del equipo pero no perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar3" name="idEliminar3">
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
	
	
	$(document).on('click', '.varEliminarJugador', function(e){

		  if (!isNaN($(this).attr("id"))) {
			$("#idEliminar3").val($(this).attr("id"));
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
			"Eliminar": function() {

				$.ajax({
							data:  {id: $('#idEliminar3').val(), accion: 'eliminarConectorDefinitivamente'},
							url:   '../../ajax/ajax.php',
							type:  'post',
							beforeSend: function () {
									
							},
							success:  function (response) {
									url = "modificar.php?id=" + <?php echo $id; ?>;
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
