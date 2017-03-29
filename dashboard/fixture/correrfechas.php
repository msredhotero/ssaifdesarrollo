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
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Fixture",$_SESSION['refroll_predio'],'');


$id		=	$_GET['id'];

$resResult = $serviciosReferencias->traerFixtureTodoPorTorneo($id);

$resFechasDelFixture = $serviciosReferencias->traerFechasFixturePorTorneo($id);

$cadFechas = $serviciosFunciones->devolverSelectBox($resFechasDelFixture,array(1),'');

$resResultado = $serviciosReferencias->traerTorneosPorId($id);

$idCategoria = mysql_result($resResultado,0,'refcategorias');

$idTemporada = mysql_result($serviciosReferencias->traerUltimaTemporada(),0,0);

// dia que se juega los partidos
$resDias = $serviciosReferencias->traerDefinicionescategoriastemporadasPorTemporadaCategoria($idTemporada, $idCategoria);

$diaDeJuego = mysql_result($resDias,0,'refdias');

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbfixture";

$lblCambio	 	= array("refconectorlocal","goleslocal","refconectorvisitante","golesvisitantes","fecha","reffechas","refcanchas","refarbitros","refestadospartidos","reftorneos","puntoslocal","puntosvisita","calificacioncancha");
$lblreemplazo	= array("Equipo Local","Resultado 1","Equipo Visitante","Resultado 2","Fecha Juego","Fecha","Cancha","Arbitros","Estados Partidos","Torneo","Puntos Local","Puntos Visitante","Calificacion Cancha");

$resConectorL	=	$serviciosReferencias->traerEquipoPorTorneo(mysql_result($resResult,0,'reftorneos'));
$cadRef			=	$serviciosFunciones->devolverSelectBoxActivo($resConectorL,array(1,2)," - ", mysql_result($resResult,0,'refconectorlocal'));

$resConectorV	=	$serviciosReferencias->traerEquipoPorTorneo(mysql_result($resResult,0,'reftorneos'));
$cadRefV		=	$serviciosFunciones->devolverSelectBoxActivo($resConectorV,array(1,2)," - ", mysql_result($resResult,0,'refconectorvisitante'));

$resFechas		=	$serviciosReferencias->traerFechas();
$cadRef2		=	$serviciosFunciones->devolverSelectBoxActivo($resFechas,array(1),'', mysql_result($resResult,0,'reffechas'));

$resCanchas		=	$serviciosReferencias->traerCanchas();
$cadRef3		=	'<option value="">-- seleccionar --</option>';
$cadRef3		.=	$serviciosFunciones->devolverSelectBoxActivo($resCanchas,array(1),'',mysql_result($resResult,0,'refcanchas'));

$resArbitros	=	$serviciosReferencias->traerArbitros();
$cadRef4		=	'<option value="">-- seleccionar --</option>';
$cadRef4		.=	$serviciosFunciones->devolverSelectBoxActivo($resArbitros,array(1),'',mysql_result($resResult,0,'refarbitros'));

$resEstadosP	=	$serviciosReferencias->traerEstadospartidos();
$cadRef5		=	'<option value="">-- seleccionar --</option>';
$cadRef5		.=	$serviciosFunciones->devolverSelectBoxActivo($resEstadosP,array(1),'',mysql_result($resResult,0,'refestadospartidos'));

$resTorneos		=	$serviciosReferencias->traerTorneosPorId(mysql_result($resResult,0,'reftorneos'));
$cadRef6		=	$serviciosFunciones->devolverSelectBoxActivo($resTorneos,array(1),'',mysql_result($resResult,0,'reftorneos'));

$refdescripcion = array(0 => $cadRef,1=>$cadRefV,2=>$cadRef2,3=>$cadRef3,4=>$cadRef4,5=>$cadRef5,6=>$cadRef6);
$refCampo	 	= array("refconectorlocal","refconectorvisitante","reffechas","refcanchas","refarbitros","refestadospartidos","reftorneos"); 
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  /////////////////////
$cabeceras2 		= "	<th>Equipo Local</th>
				<th>Resultado Local</th>
				<th>Resultado Visitante</th>
				<th>Equipo Visitante</th>
				<th>Categoria</th>
				<th>Arbitros</th>
				<th>Juez 1</th>
				<th>Juez 2</th>
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

<h3>Fixture</h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Modificar Fechas Fixture</p>
        	
        </div>
    	<div class="cuerpoBox">
    		<form class="form-inline formulario" role="form">
            <div class="row" style="margin-left:25px; margin-right:25px;">
    			<div class="row" align="center">
                    <ul class="list-inline">
                        <li>
                            Seleccione la fecha desde la cual se va a modificar y cuando finalizaria el torneo
                        </li>
                    </ul>
                </div>
                
                <div class="row" align="center">
                    <ul class="list-inline">
    
                        
                        <div class="form-group col-md-4">
                            <label for="nuevafecha" class="control-label" style="text-align:left">Fecha Cierre Torneo</label>
                            <div class="input-group col-md-6">
                                <input class="form-control" type="text" name="fechacierre" id="fechacierre" value="Date"/>
                            </div>
                            
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label class="control-label" style="text-align:left" for="reffecha">Fecha Desde</label>
                            <div class="input-group col-md-12">
                                <select id="reffechas" class="form-control" name="reffechas">
                                    <?php echo $cadFechas; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label class="control-label" style="text-align:left" for="reffecha">Accion</label>
                            <div class="input-group col-md-12">
                                <div align="center">
                                <button style="margin-left:0px;" id="modificarnuevafecha" class="btn btn-warning" type="button">Correr</button>
                                </div>
                            </div>
                        </div>
    
                    </ul>
                </div>
            </div>
            
            <hr>
            
            <div class="row" style="margin-left:25px; margin-right:25px;">
    			<div class="row" align="center">
                    <ul class="list-inline">
                        <li>
                            Seleccione una fecha y un nuevo dia de juego
                        </li>
                    </ul>
                </div>
                
                <div class="row" align="center">
                    <ul class="list-inline">
    
                        
                        <div class="form-group col-md-4">
                            <label for="nuevafecha" class="control-label" style="text-align:left">Nueva Fecha</label>
                            <div class="input-group col-md-6">
                                <input class="form-control" type="text" name="nuevafecha" id="nuevafecha" value="Date"/>
                            </div>
                            
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label class="control-label" style="text-align:left" for="reffecha">Fecha a asignar</label>
                            <div class="input-group col-md-12">
                                <select id="reffechan" class="form-control" name="reffechan">
                                    <?php echo $cadFechas; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label class="control-label" style="text-align:left" for="reffecha">Accion</label>
                            <div class="input-group col-md-12">
                                <div align="center">
                                <button style="margin-left:0px;" id="modificarnuevafecha" class="btn btn-warning" type="button">Modificar</button>
                                </div>
                            </div>
                        </div>
    
                    </ul>
                </div>
            </div>
            
            
            
            <div class="row" style="margin-left:25px; margin-right:25px;">
                <div class="alert"> </div>
                <div id="load"> </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    
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



<script type="text/javascript">
$(document).ready(function(){

	 <?php 
		echo $serviciosHTML->validacion($tabla);
	
	?>
	
	$('#chequearF').click( function() {
		url = "chequear.php";
		$(location).attr('href',url);
	});
        
        $('#fixtureM').click( function() {
		url = "fixturemanual.php";
		$(location).attr('href',url);
	});
	
	$('#generar').click( function() {
		url = "generarfixture.php";
		$(location).attr('href',url);
	});
	
	$('#conductaF').click( function() {
		url = "conductafixture.php";
		$(location).attr('href',url);
	});
	
	$('.volver').click(function(event){
		 
		url = "index.php";
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
<script>
  $(function() {
	  $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '<Ant',
 nextText: 'Sig>',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 dateFormat: 'dd/mm/yy',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 $.datepicker.setDefaults($.datepicker.regional['es']);
 

	
    $( "#nuevafecha" ).datepicker({
		beforeShowDay: function(date) {
			var day = date.getDay();
			return [(day == <?php echo $diaDeJuego; ?>)];
		}
	});
	
	
    $( "#nuevafecha" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	
	$( "#fechacierre" ).datepicker({
		beforeShowDay: function(date) {
			var day = date.getDay();
			return [(day == <?php echo $diaDeJuego; ?>)];
		}
	});

    $( "#fechacierre" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  });
  </script>


<?php } ?>
</body>
</html>
