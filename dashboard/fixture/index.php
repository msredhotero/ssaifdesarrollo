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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../fixture/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Estadisticas",$_SESSION['refroll_predio'],$_SESSION['email_predio']);





/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbfixture";

$lblCambio	 	= array("refconectorlocal","goleslocal","refconectorvisitante","golesvisitantes","fecha","reffechas","refcanchas","refarbitros","refestadospartidos","reftorneos","refetapas");
$lblreemplazo	= array("Equipo Local","Resultado 1","Equipo Visitante","Resultado 2","Fecha Juego","Fecha","Cancha","Arbitros","Estados Partidos","Torneo","Etapas");

$resConectorL	=	$serviciosReferencias->traerEquipos();
$cadRef			=	$serviciosFunciones->devolverSelectBox($resConectorL,array(0,1,2,3,4)," - ");

$resFechas		=	$serviciosReferencias->traerFechas();
$cadRef2		=	$serviciosFunciones->devolverSelectBox($resFechas,array(1),'');

$resCanchas		=	$serviciosReferencias->traerCanchas();
$cadRef3		=	$serviciosFunciones->devolverSelectBox($resCanchas,array(1),'');

$resArbitros	=	$serviciosReferencias->traerArbitros();
$cadRef4		=	$serviciosFunciones->devolverSelectBox($resArbitros,array(1),'');

$resEstadosP	=	$serviciosReferencias->traerEstadospartidos();
$cadRef5		=	'<option value="">-- seleccionar --</option>';
$cadRef5		.=	$serviciosFunciones->devolverSelectBox($resEstadosP,array(1),'');

$resTorneos		=	$serviciosReferencias->traerTorneos();
$cadRef6		=	$serviciosFunciones->devolverSelectBox($resTorneos,array(1,2,3,4),' - ');

$resEtapas		=	$serviciosReferencias->traerEtapas();
$cadRef7		=	"<option value='0'></option>";
$cadRef7		.=	$serviciosFunciones->devolverSelectBox($resEtapas,array(1,2),' - ');

$cadPosiciones = '<option value="0"></option>';
for ($i=1;$i<=64;$i++) {
	$cadPosiciones .= '<option value="'.$i.'">Posicion '.$i.'</option>';	
}

$refdescripcion = array(0 => $cadRef,1=>$cadRef,2=>$cadRef2,3=>$cadRef3,4=>$cadRef4,5=>$cadRef5,6=>$cadRef6,7=>$cadRef7,8=>$cadPosiciones);
$refCampo	 	= array("refconectorlocal","refconectorvisitante","reffechas","refcanchas","refarbitros","refestadospartidos","reftorneos","refetapas","posicion"); 
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  /////////////////////
$cabeceras2 		= "	<th>Equipo Local</th>
				<th>Resultado Local</th>
				<th>Resultado Visitante</th>
				<th>Equipo Visitante</th>
				<th>Categoria</th>
				<th>Arbitros</th>
				<th>Goles Local</th>
				<th>Goles Vist.</th>
				<th>Cancha</th>
				<th>Fecha Juego</th>
				<th>Fecha</th>
				<th>Hora</th>
				<th>Estado</th>";
				
$cabeceras 		= "	<th>Descripción</th>
					<th>Tipo Torneo</th>
					<th>Temporadas</th>
					<th>Categorias</th>
					<th>Divisiones</th>
					<th>Cant.Ascensos</th>
					<th>Cant.Descensos</th>
					<th>Respet.Def. Tipo Jugador</th>
					<th>Respet.Def. Hab.Transt.</th>
					<th>Respet.Def. Sansiones Acum.</th>
					<th>Acum.Goleadores</th>
					<th>Acum.Tabla Conformada</th>
					<th>Obs.</th>
					<th>Activo</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////




$formulario 	= $serviciosFunciones->camposTabla("insertarFixtureNuevo",$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$refTorneos		=	$serviciosReferencias->traerTorneos();

?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title>Gestión: AIF</title>
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
    <link rel="stylesheet" href="../../css/bootstrap-timepicker.css">
    <script src="../../js/bootstrap-timepicker.min.js"></script>
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

<h3>Estadisticas</h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Estadisticas</p>
        	
        </div>
    	<div class="cuerpoBox">
    		
            
            <div class="row" id="contMapa2" style="margin-left:25px; margin-right:25px;">

                <div class="col-md-12">
                	<div class="form-group col-md-12">
                        <label class="control-label" style="text-align:left; font-size:1.2em; text-decoration:underline; margin-bottom:4px;" for="fechas">Lista de Torneos</label>
                        <div>
                        <div class="input-group col-md-12">
                            <table class="table table-bordered table-responsive table-striped" id="example">
                            <thead>
                            	<tr>
                                	<th>Nombre</th>
                                    <th>Temporada</th>
                                    <th>Categoria</th>
                                    <th>División</th>
                                    <th style="text-align:center">Ver</th>
                                    <th style="text-align:center">Posiciones</th>
                                    <th style="text-align:center">Generar Fixture</th>
                                    <th style="text-align:center">Fixture Manual</th>
                                    <th style="text-align:center">Correr Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="lstjugadores">
							<?php 
								$cantidad = 0;
								
								while ($rowC = mysql_fetch_array($refTorneos)) {
									$existe = mysql_num_rows($serviciosReferencias->traerFixtureTodoPorTorneo($rowC['idtorneo']));
									
							?>
                            	<tr>
                                	<td><?php echo $rowC['descripcion']; ?></td>
                                    <td><?php echo $rowC['temporada']; ?></td>
                                    <td><?php echo $rowC['categoria']; ?></td>
                                    <td><?php echo $rowC['division']; ?></td>
                                    <td align="center"><img src="../../imagenes/verIco.png" style="cursor:pointer;" id="<?php echo $rowC['idtorneo']; ?>" class="varver"></td>
                                    <td align="center"><img src="../../imagenes/posicionesfix.png" style="cursor:pointer;" id="<?php echo $rowC['idtorneo']; ?>" class="varposiciones"></td>
                                    <td align="center"><?php if ($existe < 1) { ?><img src="../../imagenes/Icon_Calendar.png" style="cursor:pointer;" id="<?php echo $rowC['idtorneo']; ?>" class="vargenerar"><?php } ?></td>
                                    <td align="center"><?php if ($existe < 1) { ?><img src="../../imagenes/Icon_Calendar.png" style="cursor:pointer;" id="<?php echo $rowC['idtorneo']; ?>" class="varmanual"><?php } ?></td>
                                    <td align="center"><?php if ($existe > 0) { ?><span id="<?php echo $rowC['idtorneo']; ?>" class="glyphicon glyphicon-transfer correrFecha" style="cursor:pointer;"></span><?php } ?></td>
                                    
                                </tr>
                            <?php
								$cantidad += 1;
								}
							?>
                            </tbody>
                            <tfoot>
                            	<td colspan="5" align="right">Total Torneos Activos:</td>
                                <td><?php echo $cantidad; ?></td>
                            </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                
            </div>

    	</div>
    </div>




    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga del Partido</p>
        	
        </div>
    	<div class="cuerpoBox">

            <form class="form-inline formulario" role="form">
            <div class="row" style="margin-left:25px; margin-right:25px;">
    		<?php echo $formulario; ?>
            </div>
            
            <div class="row" style="margin-left:25px; margin-right:25px;">
                <div class="alert"> </div>
                <div id="load"> </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                        <button type="button" class="btn btn-primary" id="cargar" style="margin-left:0px;">Guardar</button>
                    </li>
                   <!-- <li>
                        <button type="button" class="btn btn-success" id="chequearF" style="margin-left:0px;">Chequear Fixture</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-success" id="conductaF" style="margin-left:0px;">Cargar Conducta al Fixture</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-primary" id="fixtureM" style="margin-left:0px;">Fixture Manual</button>
                    </li>-->

                </ul>
                </div>
            </div>

            

            </form>
    </div>
    </div>
    
   
</div>


</div>
<div id="dialog2" title="Eliminar Fixture">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea eliminar el fixture?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si elimina el fixture se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>


<script type="text/javascript">
$(document).ready(function(){

	$('#example').dataTable({
		"order": [[ 1, "desc" ]],
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

	$('#timepicker2').timepicker({
		minuteStep: 15,
		showSeconds: false,
		showMeridian: false,
		defaultTime: false
		});
	 <?php 
		echo $serviciosHTML->validacion($tabla);
	
	?>
	
	$('#chequearF').click( function() {
		url = "chequear.php";
		$(location).attr('href',url);
	});
        
    $('.varmanual').click( function() {
		url = "fixturemanual.php?id="+$(this).attr("id");
		$(location).attr('href',url);
	});
	

	$("#example").on("click",'.correrFecha', function(){
		url = "correrfechas.php?id="+$(this).attr("id");
		$(location).attr('href',url);
	});
	

	$("#example").on("click",'.vargenerar', function(){
		url = "../torneos/equipos.php?id="+$(this).attr("id");
		$(location).attr('href',url);
	});
	

	$("#example").on("click",'.varver', function(){
		url = "ver.php?id="+$(this).attr("id");
		$(location).attr('href',url);
	});
	

	$("#example").on("click",'.varposiciones', function(){	
		url = "../posiciones/posiciones.php?id="+$(this).attr("id");
		$(location).attr('href',url);
	});
	
	$('#conductaF').click( function() {
		url = "conductafixture.php";
		$(location).attr('href',url);
	});
	
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
	
	function jugo(idFixture) {
		$.ajax({
				data:  {idFixture: idFixture, accion: 'marcarJugo'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						alert('Se marco correctamente');
						
				}
		});	
	}
	
	function chequeado(idFixture) {
		$.ajax({
				data:  {idFixture: idFixture, accion: 'marcarChequeado'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						alert('Se marco correctamente');
						
				}
		});	
	}
	
	$("#example").on("click",'.jugo', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			$.ajax({
				data:  {idFixture: usersid, accion: 'marcarJugo'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						alert('Se marco correctamente');
						
				}
			});	
			
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton jugo
	
	
	$("#example").on("click",'.chequeado', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
		  	$.ajax({
					data:  {idFixture: usersid, accion: 'marcarChequeado'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
							alert('Se marco correctamente');
							
					}
			});

		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton chequeado
	
	
	$('.estadistica').click(function(event){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			url = "../estadisticas/estadisticas.php?id="+usersid;
			$(location).attr('href',url);

			
			//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
			//$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton estadisticas
	

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
									data:  {id: $('#idEliminar').val(), accion: 'eliminarFixture'},
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
                                            $(".alert").html('<strong>Ok!</strong> Se cargo exitosamente el <strong>Fixture</strong>. ');
											$(".alert").delay(3000).queue(function(){
												/*aca lo que quiero hacer 
												  después de los 2 segundos de retraso*/
												$(this).dequeue(); //continúo con el siguiente ítem en la cola
												
											});
											$("#load").html('');
											//url = "index.php";
											var a = $('#reftorneoge_a option:selected').html();
											var b = $('#reftorneoge_b option:selected').html();
											a = a.split(' - ');
											b = b.split(' - ');
											
											$('#resultados').prepend('<tr><td>' + a[1] + '</td><td></td><td></td><td>' + 
																		+ b[1] + '</td><td>' + 
																		a[0] + '</td><td>' + 
																		$('#fechajuego option:selected').html() + '</td><td>' + 
																		$('#reffecha option:selected').html() + '</td><td>' + 
																		$('#hora option:selected').html() + '</td><td style="color:#f00;">Nuevo</td></tr>').fadeIn(300);
											
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
