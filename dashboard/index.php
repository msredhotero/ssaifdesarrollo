<?php

session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../error.php');
} else {


include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosUsuario = new ServiciosUsuarios();
$serviciosHTML = new ServiciosHTML();
$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();



$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menuD($_SESSION['nombre_predio'],"Dashboard",$_SESSION['refroll_predio'],'');


if ($_SESSION['idroll_predio'] == 4) {


		/////////////////////// Opciones pagina ///////////////////////////////////////////////
		$singular = "Jugador Por Club";

		$plural = "Jugadores Por Club";

		$eliminar = "eliminarJugadoresclub";

		$insertar = "insertarJugadoresclub";

		$tituloWeb = "Gestión: AIF";
		//////////////////////// Fin opciones ////////////////////////////////////////////////


		/////////////////////// Opciones para la creacion del formulario  /////////////////////
		$tabla 			= "dbjugadoresclub";

		$lblCambio	 	= array("");
		$lblreemplazo	= array("");


		$cadRef 	= '';

		$refdescripcion = array();
		$refCampo 	=  array();
		//////////////////////////////////////////////  FIN de los opciones //////////////////////////

		if ($_SESSION['idroll_predio'] == 4) {
			$resJugadoresPorCountries = $serviciosReferencias->traerJugadoresClubPorCountrieActivos($_SESSION['club_predio']);
			$refClub = $_SESSION['club_predio'];
		} else {
			$resJugadoresPorCountries = $serviciosReferencias->traerJugadoresClubPorCountrie($_GET['id']);	
			$refClub = $_GET['id'];
		}


		$resPermiteRegistrar = $serviciosReferencias->traerVigenciasoperacionesPorModuloVigencias(2,date('Y-m-d'));

		if (mysql_num_rows($resPermiteRegistrar)>0) {
			$permiteRegistrar = 1;
		} else {
			$permiteRegistrar = 0;
		}


		$resTemporadas = $serviciosReferencias->traerUltimaTemporada(); 

		if (mysql_num_rows($resTemporadas)>0) {
		    $ultimaTemporada = mysql_result($resTemporadas,0,0);    
		} else {
		    $ultimaTemporada = 0;   
		}

		/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////


		//////////////////////////////////////////////  FIN de los opciones //////////////////////////



		/////////////////////// Opciones para la creacion del formulario  /////////////////////
		$tabla2			= "dbjugadorespre";

		$lblCambio2	 	= array("reftipodocumentos","nrodocumento","fechanacimiento","fechaalta","fechabaja","refcountries","refusuarios","numeroserielote");
		$lblreemplazo2	= array("Tipo Documento","Nro Documento","Fecha Nacimiento","Fecha Alta","Fecha Baja","Countries","Usuario","Nro Serie Lote");


		$resTipoDoc 	= $serviciosReferencias->traerTipodocumentos();
		$cadRefj 	= $serviciosFunciones->devolverSelectBox($resTipoDoc,array(1),'');

		$resCountries 	= $serviciosReferencias->traerCountriesPorId($refClub);
		$cadRef2j 	= $serviciosFunciones->devolverSelectBox($resCountries,array(1),'');

		$resUsua = $serviciosUsuario->traerUsuarioId($_SESSION['id_usuariopredio']);
		$cadRef3j 	= $serviciosFunciones->devolverSelectBox($resUsua,array(3),'');

		$refdescripcion2 = array(0 => $cadRefj,1 => $cadRef2j,2 => $cadRef3j);
		$refCampo2 	=  array("reftipodocumentos","refcountries","refusuarios");

		$formularioJugador 	= $serviciosFunciones->camposTabla("insertarJugadorespre" ,$tabla2,$lblCambio2,$lblreemplazo2,$refdescripcion2,$refCampo2);
		//////////////////////////////////////////////  FIN de los opciones //////////////////////////


		$cabeceras 		= "	<th>Tipo Documento</th>
							<th>Nro Doc</th>
							<th>Apellido</th>
							<th>Nombres</th>
							<th>Email</th>
							<th>Fecha Nac.</th>
							<th>Fecha Alta</th>
							<th>Nro Serie Lote</th>
							<th>Obs.</th>";

		$lstNuevosJugadores = $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerJugadoresprePorCountries($refClub),9);



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


		<link href="../css/estiloDash.css" rel="stylesheet" type="text/css">
		    

		    
		    <script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
		    <link rel="stylesheet" href="../css/jquery-ui.css">

		    <script src="../js/jquery-ui.js"></script>
		    
			<!-- Latest compiled and minified CSS -->
		    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
			<!--<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>-->
		    <!-- Latest compiled and minified JavaScript -->
		    <script src="../bootstrap/js/bootstrap.min.js"></script>
			<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
			<script src="../js/jquery.maskedinput.min.js" type="text/javascript"></script>
		    
		   
		   <link href="../css/perfect-scrollbar.css" rel="stylesheet">
		      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
		      <script src="../js/jquery.mousewheel.js"></script>
		      <script src="../js/perfect-scrollbar.js"></script>
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
		        	<p style="color: #fff; font-size:18px; height:16px;">Jugadores del club</p>
		        	
		        </div>
		    	<div class="cuerpoBox">
		        	<form class="form-inline formulario" role="form">
		        	<div class="row">

					<?php 
						$country = '';
						$fecha = '';
						$cadCabecera = '';
						$primero = 0;
						while ($row = mysql_fetch_array($resJugadoresPorCountries)) {
							if ($country != $refClub)  {
								
								
								$cadCabecera .= '<div class="col-md-12">
												<table class="table table-striped" style="padding:2px;" id="example">
												<thead>
													<tr>
														<th>Apellido</th>
														<th>Nombre</th>
														<th>Nro Documento</th>
														<th>Numero de Socio/Lote</th>
														<th>Baja</th>
														<th>Art 2 Inciso D</th>
														<th>Accion</th>
					
													</tr>
												</thead>
												<tbody>';
												
								$primero = 1;
								$country = $refClub;	
							}
							
							$cadCabecera .= "<tr>
												<td>".$row['apellido']."</td>
												<td>".$row['nombres']."</td>
												<td>".$row['nrodocumento']."</td>
												<td><input class='form-control' type='text' name='numeroserielote".$row['idjugador']."' id='numeroserielote".$row['idjugador']."' value='".$row['numeroserielote']."'/></td>
												<td><input class='form-control' type='checkbox' name='fechabaja".$row['idjugador']."' id='fechabaja".$row['idjugador']."' ".($row['fechabaja'] == 'Si' ? 'checked' : '')."/></td>
												<td><input class='form-control' type='checkbox' name='articulo".$row['idjugador']."' id='articulo".$row['idjugador']."'  ".($row['articulo'] == 'Si' ? 'checked' : '')."/></td>
												
												<td>";
							if ($permiteRegistrar == 1) {
								$cadCabecera .=			"<button type='button' class='btn btn-primary guardarJugadorClubSimple' id='".$row['idjugador']."'>Guardar</button>";
							}
							$cadCabecera .= "</td>
											</tr>";
					
						}
						
						$cadCabecera .= '</tbody></table></div>';
						
						echo $cadCabecera;
					?>
		            </div>

		            <div class="row" style="padding: 25px;">
		            	<div class="panel panel-primary">
						  <div class="panel-heading">Jugadores Nuevos</div>
						  <div class="panel-body"><?php echo str_replace('example','example1', $lstNuevosJugadores); ?></div>
						</div>


						<div class="col-md-6">
							<label class="control-label">Seleccione un año para generar el reporte</label>
		            		<select id="anio" name="anio" class="form-control">
		            		<?php
		            			if (date('m') >= 6) {
		            		?>
		            			<option value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
		            			<option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
		            		<?php
		            			} else {
		            		?>
		            			<option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
		            			<option value="<?php echo date('Y') + 1; ?>"><?php echo date('Y') + 1; ?></option>
		            			

		            		<?php
		            			}
		            		?>
		            		
		            		</select>
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
		                        <button type="button" class="btn btn-danger" id="btnImprimir" style="margin-left:0px;">Imprimir</button>
		                    </li>
		                    <li>
		                    	<button type="button" data-toggle="modal" data-target="#myModal3" class="btn btn-success" id="agregarContacto"><span class="glyphicon glyphicon-plus"></span> Agregar Jugador</button>
		                    </li>
		                    <li>
		                        <button type="button" class="btn btn-info" id="btnExcel1" style="margin-left:0px;" onClick="location.href = 'http://www.aif.org.ar/wp-content/uploads/2017/12/buenafe.xlsx'"><span class="glyphicon glyphicon-save"></span> Lista de Buena Fe/Altas de equipos</button>
		                    </li>
		                    <li>
		                        <button type="button" class="btn btn-info" id="btnExcel2" style="margin-left:0px;" onClick="location.href = 'http://www.aif.org.ar/wp-content/uploads/2016/09/buenafemo.xlsx'"><span class="glyphicon glyphicon-save"></span> Modificaciones de Lista de Buena Fe/Altas de equipos</button>
		                    </li>
		                    <li>
		                        <button type="button" class="btn btn-danger" id="btnCondicionJugador" style="margin-left:0px;">Reporte Condicion de Jugadores</button>
		                    </li>
		                </ul>
		                </div>
		            </div>
		            <input type="hidden" id="refcountries" name="refcountries" value="<?php echo $refClub; ?>"/>
		            </form>
		    	</div>
		    </div>
		    
		    

		<div id="dialog2" title="Eliminar Jugadores">
		    	<p>
		        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
		            ¿Esta seguro que desea eliminar el Jugador?.<span id="proveedorEli"></span>
		        </p>
		        
		        <input type="hidden" value="" id="idEliminar" name="idEliminar">
		</div>

		    
		<!-- Modal del guardar-->
		<div class="modal fade" id="myModal3" tabindex="1" style="z-index:500000;" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <form class="form-inline formulario" role="form">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Crear Jugador</h4>
		      </div>
		      <div class="modal-body">
		        <?php echo $formularioJugador; ?>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary" data-dismiss="modal" id="cargarJugador">Agregar</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        
		      </div>
		      </form>
		    </div>
		  </div>
		</div>

		  <!-- del modal -->
		   
		</div>


		</div>

		<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
		<script src="../bootstrap/js/dataTables.bootstrap.js"></script>

		<script src="../js/bootstrap-datetimepicker.min.js"></script>
		<script src="../js/bootstrap-datetimepicker.es.js"></script>

		<script type="text/javascript">
		$(document).ready(function(){
			$('#example').dataTable({
				"lengthMenu": [[50, 100 -1], [50, 100, "All"]],
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

			$('#fechaalta').val('<?php echo date('d/m/Y'); ?>');

			$('#btnImprimir').click(function() {
				window.open("../reportes/rptJugadoresPorCountries.php?refcountries1=" + <?php echo $refClub; ?> + "&bajas1=0" ,'_blank');
			});


			$('#btnCondicionJugador').click(function() {
				window.open("../reportes/rptCondicionJugadorManual.php?id=0&reftemporada=" + <?php echo $ultimaTemporada; ?> + "&bajaequipos=1" + "&refcountries=" + <?php echo $refClub; ?> + "&anio=" + $('#anio').val() ,'_blank');
			});
			
			$("#example").on("click",'.guardarJugadorClubSimple', function(){
				
				idBtn = $(this).attr("id");
				var fechabaja = 0;
				if ($('#fechabaja'+$(this).attr("id")).prop('checked')) {
					fechabaja = 1;	
				}
				
				var articulo = 0;
				if ($('#articulo'+$(this).attr("id")).prop('checked')) {
					articulo = 1;	
				}
				
				$('#myModal').modal("show");
		        $.ajax({
					data:  {idjugador: $(this).attr("id"), 
							idclub: <?php echo $refClub; ?>, 
							numeroserielote: $('#numeroserielote'+$(this).attr("id")).val(), 
							fechabaja: fechabaja, 
							articulo: articulo, 
							accion: 'guardarJugadorClubSimple'},
					url:   '../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
						if (response == '') {
							$('#error').html('<span class="glyphicon glyphicon-ok"></span> Se guardo correctamente');
							$('#'+idBtn).removeClass("btn-primary");
							$('#'+idBtn).removeClass("btn-danger");
							$('#'+idBtn).addClass("btn-success");
							$('#'+idBtn).html('<span class="glyphicon glyphicon-ok"></span> Guardado');
							
						} else {
							$('#error').html('Huvo un error al guardar los datos, verifique los datos ingresados '.response);
							$('#'+idBtn).removeClass("btn-primary");
							$('#'+idBtn).removeClass("btn-success");
							$('#'+idBtn).addClass("btn-danger");
							$('#'+idBtn).html('<span class="glyphicon glyphicon-ban-circle"></span> Guardar');
						}
					}
				});
		    });

			$("#example1").on("click",'.varborrar', function(){
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
			
			$("#example1").on("click",'.varmodificar', function(){
				usersid =  $(this).attr("id");
				url = "modificarjugador.php?id=" + usersid;
				$(location).attr('href',url);

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
											data:  {id: $('#idEliminar').val(), accion: 'eliminarJugadorespre'},
											url:   '../ajax/ajax.php',
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
				
				if (validador() == "")
		        {
					//información del formulario
					var formData = new FormData($(".formulario")[0]);
					var message = "";
					//hacemos la petición ajax  
					$.ajax({
						url: '../ajax/ajax.php',  
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
							$("#load").html('<img src="../imagenes/load13.gif" width="50" height="50" />');       
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




		    //al enviar el formulario
		    $('#cargarJugador').click(function(){
				
					//información del formulario
					var formData = new FormData($(".formulario")[1]);
					var message = "";
					//hacemos la petición ajax  
					$.ajax({
						url: '../ajax/ajax.php',  
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
							$("#load").html('<img src="../imagenes/load13.gif" width="50" height="50" />');       
						},
						//una vez finalizado correctamente
						success: function(data){
							
							if (!isNaN(data)) {
								$(".alert").removeClass("alert-danger");
								$(".alert").removeClass("alert-info");
								$(".alert").addClass("alert-success");
								$(".alert").html('<strong>Ok!</strong> Se cargo exitosamente el <strong>Jugador</strong>. ');
								$(".alert").delay(3000).queue(function(){
									/*aca lo que quiero hacer 
									  después de los 2 segundos de retraso*/
									$(this).dequeue(); //continúo con el siguiente ítem en la cola
									
								});

								url = "index.php";
								$(location).attr('href',url);
								$("#load").html('');

								
								
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




<?php

} else {
	if ($_SESSION['idroll_predio'] == 5) {
		// rol:socio

		/////////////////////// Opciones pagina ///////////////////////////////////////////////
		$singular = "Orden";

		$plural = "Ordenes";

		$eliminar = "eliminarOrdenes";

		$insertar = "insertarOrdenes";

		$tituloWeb = "Gestión: AIF";
		//////////////////////// Fin opciones ////////////////////////////////////////////////


		/////////////////////// Opciones para la creacion del formulario  /////////////////////

		/////////////////////// Opciones para la creacion del view  patente,refmodelo,reftipovehiculo,anio/////////////////////
		$cabeceras 		= "	<th>Nro</th>
							<th>Dueño</th>
							<th>Vehiculo</th>
							<th>Fecha</th>
							<th>Reparación</th>
							<th>Presup. Aprox.</th>
							<th>Saldo</th>
							<th>Estado</th>";

		//////////////////////////////////////////////  FIN de los opciones //////////////////////////

		//$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerOrdenesActivos(),95);
		//$lstCargadosMora 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerOrdenesMora(),94);

		$resResultado = $serviciosReferencias->traerJugadoresprePorIdUsuario($_SESSION['id_usuariopredio']);

		/////////////////////// Opciones para la creacion del formulario  /////////////////////
		$tabla 			= "dbjugadorespre";

		$lblCambio	 	= array("reftipodocumentos","fechanacimiento","refcountries","refusuarios","numeroserielote");
		$lblreemplazo	= array("Tipo Documento","Fecha Nacimiento","Club","Delegado","Nro Serie Lote");


		$resTipoDoc 	= $serviciosReferencias->traerTipodocumentos();
		$cadRef 	= $serviciosFunciones->devolverSelectBoxActivo($resTipoDoc,array(1),'', mysql_result($resResultado,0,'reftipodocumentos'));

		$resCountry 	= $serviciosReferencias->traerCountriesPorId(mysql_result($resResultado,0,'refcountries'));
		$cadRef2 	= $serviciosFunciones->devolverSelectBoxActivo($resCountry,array(1),'', mysql_result($resResultado,0,'refcountries'));

		$resDelegado 	= $serviciosUsuario->traerUsuarioId(mysql_result($resResultado,0,'refusuarios'));
		$cadRef3 	= $serviciosFunciones->devolverSelectBoxActivo($resDelegado,array(3),'', mysql_result($resResultado,0,'refusuarios'));

		//die(var_dump($cadRef3));
		$refdescripcion = array(0 => $cadRef,1 => $cadRef2,2 => $cadRef3);
		$refCampo 	=  array("reftipodocumentos","refcountries","refusuarios");
		//////////////////////////////////////////////  FIN de los opciones //////////////////////////


		$formulario 	= $serviciosFunciones->camposTablaModificar($_SESSION['id_usuariopredio'], 'idusuario', 'modificarJugadorespreRegistro',$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);


		?>

		<!DOCTYPE HTML>
		<html>

		<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">



		<title>Gesti&oacute;n: AIF</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">


		<link href="../css/estiloDash.css" rel="stylesheet" type="text/css">
		    

		    
		    <script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
		    <link rel="stylesheet" href="../css/jquery-ui.css">

		    <script src="../js/jquery-ui.js"></script>
		    
			<!-- Latest compiled and minified CSS -->
		    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
			<!--<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>-->
		    <!-- Latest compiled and minified JavaScript -->
		    <script src="../bootstrap/js/bootstrap.min.js"></script>
			<script src='../js/jquery.maskedinput.min.js' type='text/javascript'></script>

			<link rel="stylesheet" href="../css/fileinput/fileinput.css"/>
			
		    <script src="../js/liquidmetal.js" type="text/javascript"></script>
		    <script src="../js/jquery.flexselect.js" type="text/javascript"></script>
		   <link rel="stylesheet" href="../css/flexselect.css" type="text/css" media="screen" />
		   <link href="../css/perfect-scrollbar.css" rel="stylesheet">
		      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
		      <script src="../js/jquery.mousewheel.js"></script>
		      <script src="../js/perfect-scrollbar.js"></script>
		      <script>
		      jQuery(document).ready(function ($) {
		        "use strict";
		        $('#navigation').perfectScrollbar();
		      });
		    </script>

		    <style>
			.kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
			    margin: 0;
			    padding: 0;
			    border: none;
			    box-shadow: none;
			    text-align: center;
			}
			.kv-avatar {
			    display: inline-block;
			}
			.kv-avatar .file-input {
			    display: table-cell;
			    width: 213px;
			}
			.kv-reqd {
			    color: red;
			    font-family: monospace;
			    font-weight: normal;
			}
			</style>
		    
		    
		</head>

		<body>

		 
		<?php echo str_replace('..','../dashboard',$resMenu); ?>

		<div id="content">

		<h3>Bienvenido</h3>
			
		    <div class="boxInfoLargo">
		        <div id="headBoxInfo">
		        	<p style="color: #fff; font-size:18px; height:16px;">Alta de Usuario (Datos Cargados)</p>
		        	
		        </div>
		    	<div class="cuerpoBox">
		        	<form class="form-inline formulario" role="form">
		        	<div class="row">
		        		<div class="col-sm-3 text-center">

		        		</div>
						<div class="col-sm-6 text-center">
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-1" name="avatar-1" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Select file < 1500 KB</small></div>
				        </div>
				        <div class="col-sm-3 text-center">

				        </div>
		            </div>
					<div class="row">
					<?php echo $formulario; ?>
					<input type="hidden" id="nrodocumento" name="nrodocumento" value="<?php echo mysql_result($resResultado, 0,'nrodocumento'); ?>">
					<input type="hidden" id="fechaalta" name="fechaalta" value="<?php echo mysql_result($resResultado, 0,'fechaalta'); ?>">
					<input type="hidden" id="email" name="email" value="<?php echo mysql_result($resResultado, 0,'email'); ?>">
					<input type="hidden" id="numeroserielote" name="numeroserielote" value="<?php echo mysql_result($resResultado, 0,'numeroserielote'); ?>">
					<input type="hidden" id="id" name="id" value="<?php echo mysql_result($resResultado, 0,0); ?>">
		            </div>
		            
		            <div class="row">
						<div class="col-sm-6 text-center">
							<h4>Foto del Documento del frente</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-2" name="avatar-2" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Select file < 5500 KB</small></div>
				        </div>

				        <div class="col-sm-6 text-center">
				        	<h4>Foto del Documento del dorso</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-3" name="avatar-3" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Select file < 5500 KB</small></div>
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
		                        <button type="button" class="btn btn-warning" id="cargar" style="margin-left:0px;">Guardar</button>
		                    </li>
		                </ul>
		                </div>
		            </div>
		            </form>
		    	</div>
		    </div>

		    <div class="boxInfoLargo">
		        <div id="headBoxInfo">
		        	<p style="color: #fff; font-size:18px; height:16px;">Suba la Foto del Documento (frente y dorso)</p>
		        	
		        </div>
		    	<div class="cuerpoBox">
		        	<form class="form-inline formulario" role="form">
		        	
					
		            </form>
		    	</div>
		    </div>
		   
		</div>


		</div>


		<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
		<script src="../bootstrap/js/dataTables.bootstrap.js"></script>
		<script type="text/javascript" src="../js/fileinput/fileinput.js"></script>
		<script>
		
		</script>

		<script type="text/javascript">
		$(document).ready(function(){

			function eliminarFoto(documentacion, jugador) {
				$.ajax({
					data:  {documentacion: documentacion, 
							jugador: jugador,
							accion: 'eliminarFotoJugadores'},
					url:   '../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
							alert(response);
							//url = "index.php";
							//$(location).attr('href',url);
							
					}
				});
			}

			var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
			    'onclick="alert(\'Call your custom code here.\')">' +
			    '<i class="glyphicon glyphicon-tag"></i>' +
			    '</button>'; 
			$("#avatar-1").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 1500,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../uploads/default_avatar_male.jpg" alt="Your Avatar">',
			    layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='../data/1/IMG_20160805_155004.jpg' width='120' class='file-preview-image' alt='Desert' title='Desert'>",
			    ],
			    initialPreviewConfig: [
				    {
				        caption: 'IMG_20160805_155004.jpg', 
				        width: '120px', 
				        key: 100, 
				        extra: {id: 100}
				    }
				]
			}).on('filecleared', function(event) {
	          eliminarFoto(1,<?php echo mysql_result($resResultado, 0,'idjugadorpre'); ?>);
	        });

			$("#avatar-2").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 5500,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});

			$("#avatar-3").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 5500,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});

			
			$('#colapsarMenu').click();


			$('#numeroserielote').prop('disabled',true);
			$('#nrodocumento').prop('disabled',true);
			$('#email').prop('disabled',true);
			$('#fechaalta').prop('disabled',true);
			
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
			
			
			$('#buscar').click(function(e) {
		        $.ajax({
						data:  {busqueda: $('#busqueda').val(),
								tipobusqueda: $('#tipobusqueda').val(),
								accion: 'buscarJugadores'},
						url:   '../ajax/ajax.php',
						type:  'post',
						beforeSend: function () {
								
						},
						success:  function (response) {
								$('#resultadosJuagadores').html(response);
								
						}
				});
				
			});
			
			
			//al enviar el formulario
		    $('#cargar').click(function(){
				

				//información del formulario
				var formData = new FormData($(".formulario")[0]);
				var message = "";
				//hacemos la petición ajax  
				$.ajax({
					url: '../ajax/ajax.php',  
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
						$("#load").html('<img src="../imagenes/load13.gif" width="50" height="50" />');       
					},
					//una vez finalizado correctamente
					success: function(data){

						if (data == '') {
		                                        $(".alert").removeClass("alert-danger");
												$(".alert").removeClass("alert-info");
		                                        $(".alert").addClass("alert-success");
		                                        $(".alert").html('<strong>Ok!</strong> Sus datos fueron guardados correctamente. ');
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
				
		    });
			
			

			$('#selction-ajax').on("click",'.varJugadorModificar', function(){
				  usersid =  $(this).attr("id");
				  if (!isNaN(usersid)) {
					
					url = "jugadores/modificar.php?id=" + usersid;
					$(location).attr('href',url);
				  } else {
					alert("Error, vuelva a realizar la acción.");	
				  }
			});//fin del boton eliminar
			
			$('table.table').on("click",'.varborrar', function(){
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
			
			$("#refcountries").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});

		});
		</script>


<?php } else { /* fin del usuario rol 5 */ ?>


		<!DOCTYPE HTML>
		<html>

		<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">



		<title>Gesti&oacute;n: AIF</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">


		<link href="../css/estiloDash.css" rel="stylesheet" type="text/css">
		    

		    
		    <script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
		    <link rel="stylesheet" href="../css/jquery-ui.css">

		    <script src="../js/jquery-ui.js"></script>
		    
			<!-- Latest compiled and minified CSS -->
		    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
			<!--<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>-->
		    <!-- Latest compiled and minified JavaScript -->
		    <script src="../bootstrap/js/bootstrap.min.js"></script>
			


			
		    <script src="../js/liquidmetal.js" type="text/javascript"></script>
		    <script src="../js/jquery.flexselect.js" type="text/javascript"></script>
		   <link rel="stylesheet" href="../css/flexselect.css" type="text/css" media="screen" />
		   <link href="../css/perfect-scrollbar.css" rel="stylesheet">
		      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
		      <script src="../js/jquery.mousewheel.js"></script>
		      <script src="../js/perfect-scrollbar.js"></script>
		      <script>
		      jQuery(document).ready(function ($) {
		        "use strict";
		        $('#navigation').perfectScrollbar();
		      });
		    </script>
		    
		    
		</head>

		<body>

		 
		<?php echo str_replace('..','../dashboard',$resMenu); ?>

		<div id="content">

		<h3>Bienvenido</h3>
			
		    <?php
			if ($_SESSION['idroll_predio'] == 1) {
				$resCantidadJugadores = $serviciosReferencias->traerCantidadJugadores();
				$resJuga = $serviciosReferencias->traerJugadoresAutocompletar();
				$cadJugadores = '<option value="0"></option>';
				while ($rowJ = mysql_fetch_array($resJuga)) {
					$cadJugadores .= '<option value="'.$rowJ[0].'">'.$rowJ[1].'</option>';
				}
			?>
			<div class="row" style="margin-right:15px;">
		    <div class="col-md-12">
		    <div class="panel" style="border-color:#006666;">
						<div class="panel-heading" style="background-color:#006666; color:#FFF; ">
							<h3 class="panel-title">jugadores <span class="badge"><?php echo $resCantidadJugadores; ?></span></h3>
							<span class="pull-right clickable panel-collapsed" style="margin-top:-15px; cursor:pointer;"><i class="glyphicon glyphicon-chevron-up"></i></span>
						</div>
		                    <div class="panel-body">
		                    	<div class="row">

		                            
		                            <div class="form-group col-md-12">
		                                 <h4>Busqueda por Nombre Completo o Nro Documento</h4>
		                                
		        							
		        						<select id="lstjugadores" class="flexselect form-control">
		        							<?php echo $cadJugadores; ?>
		        						</select>
		        						<div id="selction-ajax" style="margin-top: 10px;"></div>
		                            </div>
		                            
		                            <div class="form-group col-md-12">
		                                <div class="cuerpoBox" id="resultadosJuagadores">
		                
		                                </div>
		                            </div>
		                            
		                            
							</div><!-- fin del contenedor detalle -->
		                    </div>		
						</div>
		            </div>
		    
		    </div>
		    </div>
		    
		    
		    
		    
		    <?php
			}
			?>
		   
		</div>


		</div>



		<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
		<script src="../bootstrap/js/dataTables.bootstrap.js"></script>

		<script type="text/javascript">
		$(document).ready(function(){
			$("select.flexselect").flexselect();

			$("select.flexselect").change(function() {
				
				$('#selction-ajax').html('<button type="button" class="btn btn-warning varJugadorModificar" id="' + $("select.flexselect").val() + '" style="margin-left:0px;">Modificar</button>');
			});

			$('#colapsarMenu').click();
			
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
			
			
			$('#buscar').click(function(e) {
		        $.ajax({
						data:  {busqueda: $('#busqueda').val(),
								tipobusqueda: $('#tipobusqueda').val(),
								accion: 'buscarJugadores'},
						url:   '../ajax/ajax.php',
						type:  'post',
						beforeSend: function () {
								
						},
						success:  function (response) {
								$('#resultadosJuagadores').html(response);
								
						}
				});
				
			});
			
			
			
			$('table.table').dataTable({
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
			

			$('#selction-ajax').on("click",'.varJugadorModificar', function(){
				  usersid =  $(this).attr("id");
				  if (!isNaN(usersid)) {
					
					url = "jugadores/modificar.php?id=" + usersid;
					$(location).attr('href',url);
				  } else {
					alert("Error, vuelva a realizar la acción.");	
				  }
			});//fin del boton eliminar
			
			$('table.table').on("click",'.varborrar', function(){
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
			
			$('table.table').on("click",'.varmodificar', function(){
				  usersid =  $(this).attr("id");
				  if (!isNaN(usersid)) {
					
					url = "ordenes/modificar.php?id=" + usersid;
					$(location).attr('href',url);
				  } else {
					alert("Error, vuelva a realizar la acción.");	
				  }
			});//fin del boton modificar
			
			
			$('table.table').on("click",'.varpagar', function(){
				
				  usersid =  $(this).attr("id");
				  if (!isNaN(usersid)) {
					
					url = "pagos/pagar.php?id="+usersid;
					$(location).attr('href',url);
				  } else {
					alert("Error, vuelva a realizar la acción.");	
				  }
			});//fin del boton pagos
			
			
			$('table.table').on("click",'.varpagos', function(){
					
				  usersid =  $(this).attr("id");
				  if (!isNaN(usersid)) {

					$.ajax({
							data:  {id: usersid, accion: 'traerPagosPorOrden'},
							url:   '../ajax/ajax.php',
							type:  'post',
							beforeSend: function () {
									
							},
							success:  function (response) {
									$('.userasignates').html(response);
									
							}
					});
					
					//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
					//$(location).attr('href',url);
				  } else {
					alert("Error redo action.");	
				  }
			});//fin del boton eliminar
			
			
			$('table.table').on("click",'.varfinalizar', function(){

				  usersid =  $(this).attr("id");
				  if (!isNaN(usersid)) {

					$.ajax({
							data:  {id: usersid, usuario: '<?php echo $_SESSION['nombre_predio']; ?>', accion: 'finalizarOrden'},
							url:   '../ajax/ajax.php',
							type:  'post',
							beforeSend: function () {
									
							},
							success:  function (response) {
									if (response == '') {
										$(".alert").removeClass("alert-danger");
										$(".alert").removeClass("alert-info");
										$(".alert").addClass("alert-success");
										$(".alert").html('<strong>Ok!</strong> Se finalizo exitosamente la <strong>Orden</strong>. ');
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
										$(".alert").html('<strong>Error!</strong> '+response);
										$("#load").html('');
									}
									
							}
					});
					
					//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
					//$(location).attr('href',url);
				  } else {
					alert("Error redo action.");	
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
											data:  {id: $('#idEliminar').val(), accion: 'eliminarJugadoresPre'},
											url:   '../ajax/ajax.php',
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

		});
		</script>



<?php } } /* fin de cualquier usuario rol distinto de 4 y 5 */ ?>
<?php } /* de la session */ ?>
</body>
</html>



