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
$resMenu = $serviciosHTML->menuD($_SESSION['nombre_predio'],"Dashboard",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


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
			


			
		    <script src="../js/jquery.easy-autocomplete.min.js"></script> 

			<!-- CSS file -->
			<link rel="stylesheet" href="../css/easy-autocomplete.min.css"> 

			<!-- Additional CSS Themes file - not required-->
			<link rel="stylesheet" href="../css/easy-autocomplete.themes.min.css"> 

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

		 
		<?php echo str_replace('****','..', str_replace('..','../dashboard',$resMenu)); ?>

		<div id="content">

		<h3>Bienvenido</h3>
			
		    <?php
			if (($_SESSION['idroll_predio'] == 1) || ($_SESSION['idroll_predio'] == 2)) {
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
		                                
		        							
		        						<input id="lstjugadores" style="width:80%;">
		        							
		        						
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
			
			/*
			$("select.flexselect").flexselect();

			$("select.flexselect").change(function() {
				
				$('#selction-ajax').html('<button type="button" class="btn btn-warning varJugadorModificar" id="' + $("select.flexselect").val() + '" style="margin-left:0px;">Modificar</button> \
					<button type="button" class="btn btn-success varJugadorDocumentaciones" id="' + $("select.flexselect").val() + '" style="margin-left:0px;">Documentaciones</button> \
					<button type="button" class="btn btn-success varJugadorEquipos" id="' + $("select.flexselect").val() + '" style="margin-left:0px;">Equipos</button> \
					<button type="button" class="btn btn-success varJugadorHabilitaciones" id="' + $("select.flexselect").val() + '" style="margin-left:0px;">Habilitaciones</button>');
			});
*/

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

			/*
			$("#lstjugadores").autocomplete({
			    source: function (request, response) {
			        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
			        $.ajax({
			        	data:  {busqueda: $('#lstjugadores').val()},
			        	type:  'post',
			            url: "../json/jsbuscarjugadores.php",
			            dataType: "json",
			            success: function (data) {
			                response($.map(data, function(v,i){
			                    var text = v.MainName;
			                    if ( text && ( !request.term || matcher.test(text) ) ) {
			                        return {
			                                label: v.apellido,
			                                value: v.id
			                               };
			                    }
			                }));
			            }
			        });
			    }
			});

*/

		var options = {

			url: "../json/jsbuscarjugadores.php",

			getValue: function(element) {
				return element.apellido + ' ' + element.nombres + ' ' + element.nrodocumento;
			},

			ajaxSettings: {
		        dataType: "json",
		        method: "POST",
		        data: {
		            busqueda: $("#lstjugadores").val()
		        }
		    },
		    
		    preparePostData: function (data) {
		        data.busqueda = $("#lstjugadores").val();
		        return data;
		    },
			
			list: {
				maxNumberOfElements: 15,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var value = $("#lstjugadores").getSelectedItemData().id;
					
					$("#selction-ajax").html('<button type="button" class="btn btn-warning varJugadorModificar" id="' + value + '" style="margin-left:0px;">Modificar</button> \
					<button type="button" class="btn btn-success varJugadorDocumentaciones" id="' + value + '" style="margin-left:0px;">Documentaciones</button> \
					<button type="button" class="btn btn-success varJugadorEquipos" id="' + value + '" style="margin-left:0px;">Equipos</button> \
					<button type="button" class="btn btn-success varJugadorHabilitaciones" id="' + value + '" style="margin-left:0px;">Habilitaciones</button>');
				}
			},
			theme: "square"
		};

		$("#lstjugadores").easyAutocomplete(options);
			
			
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


			$('#selction-ajax').on("click",'.varJugadorDocumentaciones', function(){
				  usersid =  $(this).attr("id");
				  if (!isNaN(usersid)) {
					
					url = "jugadores/documentaciones.php?id=" + usersid;
					$(location).attr('href',url);
				  } else {
					alert("Error, vuelva a realizar la acción.");	
				  }
			});//fin del boton eliminar


			$('#selction-ajax').on("click",'.varJugadorEquipos', function(){
				  usersid =  $(this).attr("id");
				  if (!isNaN(usersid)) {
					
					url = "jugadores/equipos.php?id=" + usersid;
					$(location).attr('href',url);
				  } else {
					alert("Error, vuelva a realizar la acción.");	
				  }
			});//fin del boton eliminar


			$('#selction-ajax').on("click",'.varJugadorHabilitaciones', function(){
				  usersid =  $(this).attr("id");
				  if (!isNaN(usersid)) {
					
					url = "jugadores/habilitaciones.php?id=" + usersid;
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




<?php } /* de la session */ ?>
</body>
</html>



