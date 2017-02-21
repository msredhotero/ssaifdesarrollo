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
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Jugadores",$_SESSION['refroll_predio'],'');


	
if (!$_POST){
	if (!isset($_GET['id'])) {
		header('Location: index.php');
	}
	$id	= $_GET['id'];

} else {
	if (!isset($_POST['id'])) {
		header('Location: index.php');
	}
	
	
	$id	= $_POST['refjugadores'];
	//die(print_r($_POST));
	
	//$refjugadores = $_POST['refjugadores']; 
	
	//elimino todo y lo vuelvo a cargar
	$serviciosReferencias->eliminarJugadoresdocumentacionPorJugador($id);
	$serviciosReferencias->eliminarJugadoresvaloreshabilitacionestransitoriasPorJuagador($id);
	//// fin del eliminar //////
	
	$observaciones = '';
	
	$resDocu = $serviciosReferencias->traerDocumentaciones();
	$cad = 'docu';
	while ($rowFS = mysql_fetch_array($resDocu)) {
		if (isset($_POST[$cad.$rowFS[0]])) {
		
			$res = $serviciosReferencias->insertarJugadoresdocumentacion($id,$rowFS[0],1,$observaciones);
		} else {
			$res = $serviciosReferencias->insertarJugadoresdocumentacion($id,$rowFS[0],0,$observaciones);
		
		}
	}
	
	$resV = '';
	$resValores = $serviciosReferencias->traerValoreshabilitacionestransitorias();
	$cadV = 'multiselect';

	while ($rowV = mysql_fetch_array($resValores)) {
		$resV .= $cadV.$rowV[0];
		if (isset($_POST[$cadV.$rowV[0]])) {
			$resV .= $serviciosReferencias->insertarJugadoresvaloreshabilitacionestransitorias($id,$_POST[$cadV.$rowV[0]][0]);
		}
	}
	
}

$resResultado = $serviciosReferencias->traerJugadoresPorId($id);

$resJugadores = $serviciosReferencias->traerJugadoresdocumentacionPorJugador($id);

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Documentación del jugador";

$plural = "Documentaciones del jugador";

$eliminar = "eliminarJugadoresdocumentacion";

$insertar = "insertarJugadoresdocumentacion";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbjugadoresdocumentacion";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resDocumentaciones2	=	$serviciosReferencias->traerDocumentaciones();
$resDocumentaciones	=	$serviciosReferencias->traerDocumentaciones();
$cadRef4	=	$serviciosFunciones->devolverSelectBox($resDocumentaciones,array(1),'');

$existeDocumentacionCargada = 1;

if (mysql_num_rows($resJugadores)<1) {
	$existeDocumentacionCargada = 0;
}

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
	
    
   <style>
   	.clickable{
    cursor: pointer;   
	}
	
	.panel-heading span {
		margin-top: -20px;
		font-size: 15px;
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
    
    <link rel="stylesheet" href="../../css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="../../js/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="../../css/chosen.css">
    <script type="text/javascript">
		$(document).ready(function() {
			$('#example-post').multiselect({
				includeSelectAllOption: true,
				enableFiltering: true
			});
		});
	</script>
 	
    
    <style>
   	.dropdown-menu {
  max-height: 500px;
  overflow-y: auto;
  overflow-x: hidden;
  z-index:999999999999;
 }
	
	
   </style>
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">
	
		<div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">
                
            <div class="col-xs-3 bs-wizard-step complete">
              <div class="text-center bs-wizard-stepnum">Paso 1</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="modificar.php?id=<?php echo $id; ?>" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Carga del jugador (Nro Documento Unico).</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step active"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Paso 2</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Carga de la Documentación presentada.</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step disabled"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Paso 3</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Asignar al Jugador a un Equipo.</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step disabled"><!-- active -->
              <div class="text-center bs-wizard-stepnum">Paso 4</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center"> Carga de las Habilitaciones Transitorias (Deportivas y Documentaciones)</div>
            </div>
            

        </div>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de <?php echo $plural; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<ul class="list-group">
              <li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-user"></span> Jugador</li>
              <li class="list-group-item list-group-item-default">Nombre Completo: <?php echo mysql_result($resResultado,0,'apellido').', '.mysql_result($resResultado,0,'nombres'); ?></li>
              <li class="list-group-item list-group-item-default">Nro Documento: <?php echo mysql_result($resResultado,0,'nrodocumento'); ?></li>
              <li class="list-group-item list-group-item-default">Fecha de Nacimiento: <?php echo mysql_result($resResultado,0,'fechanacimiento'); ?></li>
              <li class="list-group-item list-group-item-default">Countrie: <?php echo mysql_result($serviciosReferencias->traerCountriesPorId(mysql_result($resResultado,0,'refcountries')),0,'nombre'); ?></li>
            </ul>
            
        	<form class="form-inline formulario" id="formulario" role="form" method="post" action="documentaciones.php">
        	<div class="row">
				<?php
				//***************  defino si entro a modificar o a cargar   ***********************///////////
				if (mysql_num_rows($resJugadores)<1) {
					while ($row = mysql_fetch_array($resDocumentaciones2)) {
						$resValores		=	$serviciosReferencias->traerValoreshabilitacionestransitoriasPorDocumentacion($row[0]);
				?>
					<?php
                        if ($row[2] == 'Si') { 
                    
                        $cadA = '<span class="glyphicon glyphicon-check"></span>';
                     } else { 
                        $cadA = '<span class="glyphicon glyphicon-remove"></span>';
                     } ?>
                    <div class="col-md-4" style="margin-bottom:7px;">
                        
                            
                            <?php
							if (mysql_num_rows($resValores)>0) {
							?>
                            	<div class="input-group">
                            	<span class="input-group-addon">
                                <input type="checkbox" aria-label="..." id="docu<?php echo $row[0]; ?>" name="docu[]">
                                </span>
                                <input type="text" class="form-control" aria-label="..." value="<?php echo $row[1]; ?>">
                                <span class="input-group-addon">
                                    <?php echo $cadA; ?>
                                </span>
								</div><!-- /input-group -->
                                <script type="text/javascript">
									$(document).ready(function() {
										$('#example-templates-button<?php echo $row[0]; ?>').multiselect({
											buttonContainer: '<div></div>',
											buttonClass: '',
											templates: {
												button: '<span class="multiselect<?php echo $row[0]; ?> dropdown-toggle" data-toggle="dropdown">(Valores)</span>'
											}
										});
										
										
									});
								</script>
								<style type="text/css">
									span.multiselect<?php echo $row[0]; ?> {
										padding: 2px 6px;
										font-weight: bold;
										cursor: pointer;
										z-index:99999999999999999999999;
									}
								</style>
                                <div class="FixedHeightContainer<?php echo $row[0]; ?>">
								<select id="example-templates-button<?php echo $row[0]; ?>" name="multiselect<?php echo $row[0]; ?>[]" required>
									<?php
										while ($rowV = mysql_fetch_array($resValores)) {
											if ($rowV['pordefecto'] == 1) {
												$chequeado = 'selected="selected"';	
											} else {
												$chequeado = '';	
											}
									?>
                                    <option value="<?php echo $rowV[0]; ?>" <?php echo $chequeado; ?>><?php echo $rowV[2]; ?> - Habilita: <?php echo $rowV[3]; ?></option>

                                    <?php
										}
									?>
								</select>
                                </div>
                            <?php
							} else {
							?>
                            <div class="input-group">
                            <span class="input-group-addon">
                            <input type="checkbox" aria-label="..." id="docu<?php echo $row[0]; ?>" name="docu<?php echo $row[0]; ?>">
                            </span>
                            <input type="text" class="form-control" aria-label="..." value="<?php echo $row[1]; ?>">
                            <span class="input-group-addon">
                            	<?php echo $cadA; ?>
                            </span>
                            </div><!-- /input-group -->
                            <?php
							} 
							?>
                        
                    </div><!-- /.col-lg-6 -->
                <?php
					}
				} else {
					while ($row = mysql_fetch_array($resJugadores)) {
						$resValores		=	$serviciosReferencias->traerValoreshabilitacionestransitoriasPorDocumentacionJugadorActivas($row[0],$id);
				?>
                	<?php
						if ($row[3] == 'Si') { 
							$check = 'checked';
						} else {
							$check = '';
						}
						
                        if ($row[2] == 'Si') { 
                    
							$cadA = '<span class="glyphicon glyphicon-check"></span>';
						 } else { 
							$cadA = '<span class="glyphicon glyphicon-remove"></span>';
						 } ?>
                    <div class="col-md-4" style="margin-bottom:7px;">
                        
                            
                            <?php
							if (mysql_num_rows($resValores)>0) {
							?>
                            	<div class="input-group">
                            	<span class="input-group-addon">
                                <input type="checkbox" <?php echo $check; ?> aria-label="..." id="docu<?php echo $row[0]; ?>" name="docu<?php echo $row[0]; ?>">
                                </span>
                                <input type="text" class="form-control" aria-label="..." value="<?php echo $row[1]; ?>">
                                <span class="input-group-addon">
                                    <?php echo $cadA; ?>
                                </span>
								</div><!-- /input-group -->
                                <script type="text/javascript">
									$(document).ready(function() {
										$('#example-templates-button<?php echo $row[0]; ?>').multiselect({
											buttonContainer: '<div></div>',
											buttonClass: '',
											templates: {
												button: '<span class="multiselect<?php echo $row[0]; ?> dropdown-toggle" data-toggle="dropdown">(Valores)</span>'
											}
										});
										
										
									});
								</script>
								<style type="text/css">
									span.multiselect<?php echo $row[0]; ?> {
										padding: 2px 6px;
										font-weight: bold;
										cursor: pointer;
										z-index:99999999999999999999999;
									}
								</style>
                                <div class="FixedHeightContainer<?php echo $row[0]; ?>">
								<select id="example-templates-button<?php echo $row[0]; ?>" name="multiselect<?php echo $row[0]; ?>[]" required>
									<?php
										while ($rowV = mysql_fetch_array($resValores)) {
											if ($rowV[4] > 0) {
												$chequeado = 'selected="selected"';	
											} else {
												$chequeado = '';	
											}
									?>
                                    <option value="<?php echo $rowV[0]; ?>" <?php echo $chequeado; ?>><?php echo $rowV[2]; ?> - Habilita: <?php echo $rowV[3]; ?></option>

                                    <?php
										}
									?>
								</select>
                                </div>
                            <?php
							} else {
							?>
                            <div class="input-group">
                            <span class="input-group-addon">
                            <input type="checkbox" <?php echo $check; ?> aria-label="..." id="docu<?php echo $row[0]; ?>" name="docu<?php echo $row[0]; ?>">
                            </span>
                            <input type="text" class="form-control" aria-label="..." value="<?php echo $row[1]; ?>">
                            <span class="input-group-addon">
                            	<?php echo $cadA; ?>
                            </span>
                            </div><!-- /input-group -->
                            <?php
							} 
							?>
                        
                    </div><!-- /.col-lg-6 -->
                
                
                <?php
					}
				} 
				?>
            </div>
            <hr>
            
            
            
            
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
                    <?php if ($existeDocumentacionCargada == 1) { ?>
                    <li>
                        <button type="button" class="btn btn-success" id="equipos" style="margin-left:0px;">Continuar</button>
                    </li>
                    <?php } ?>
                    <li>
                        <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            <input type="hidden" id="accion" name="accion" value="<?php echo $insertar; ?>"/>
            <input type="hidden" id="refjugadores" name="refjugadores" value="<?php echo $id; ?>"/>
            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>
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
        <p><strong>Importante: </strong>Si elimina el <?php echo $singular; ?> se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	$('.volver').click(function(event){
		 
		url = "modificar.php?id="+<?php echo $id; ?>;
		$(location).attr('href',url);
	});//fin del boton modificar
	
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
	
	$('#equipos').click(function(event){
		 
		url = "equipos.php?id="+<?php echo $id; ?>;
		$(location).attr('href',url);
	});//fin del boton equipos
	
	function traerEquiposPorCountries(id, contenedor) {
		$.ajax({
			data:  {id: id, accion: 'traerEquiposPorCountries'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
			
			},
			success:  function (response) {
				$(contenedor).html(response);
			}
		});		
	}
	
	traerEquiposPorCountries($('#refcountries').val(), '#equiposRefequipos');
	
	$('#refcountries').change(function() {
		if  ($('#equiposRefFusion').prop('checked') == false) {
			traerEquiposPorCountries($(this).val(), '#equiposRefequipos');
		}
	});
	
	
	$('#equiposRefcountries').change(function() {
		if  ($('#equiposRefFusion').prop('checked') == true) {
			traerEquiposPorCountries($(this).val(), '#equiposRefequipos');
		}
	});
	
	$('#equiposRefFusion').click(function() {
		$('#equiposRefequipos').html('');
	});
	
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
			
	
	
	$('#cargar').click(function(){
		$('#formulario').submit();		
	});
	//al enviar el formulario
    $('#cargar3').click(function(){
		
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
											//url = "documentaciones.php?id="+<?php echo $id; ?>;
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
	
	$('#primero').addClass('collapse');

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
    
	
	
  </script>
<?php } ?>
</body>
</html>
