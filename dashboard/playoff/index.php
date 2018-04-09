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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../playoff/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"PlayOff",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "PlayOff";

$plural = "PlayOff";

$eliminar = "eliminarCategorias";

$insertar = "insertarCategorias";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "tbcategorias";

$lblCambio	 	= array("");
$lblreemplazo	= array("");


$cadRef 	= '';

$refdescripcion = array();
$refCampo 	=  array();
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "	<th>Categorias</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$prePlayOff		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapas(1);
$PlayOff		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapas(2);
$Octavos		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapas(3);
$Cuartos		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapas(4);
$SemiFinal		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapas(5);
$Tercer			=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapas(6);
$Final			=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapas(7);



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
   <style>
   	main{
  display:flex;
  flex-direction:row;
}
.round{
  display:flex;
  flex-direction:column;
  justify-content:center;
  width:240px;
  list-style:none;
  padding:0;
}
  .round .spacer{ flex-grow:1; }
  .round .spacer:first-child,
  .round .spacer:last-child{ flex-grow:.5; }

  .round .game-spacer{
    flex-grow:1;
  }



li.game{
  padding-left:20px;
  
}

  li.game.winner{
    font-weight:bold;
  }
  li.game span{
    float:right;
    margin-right:5px;
	
  }

  li.game-top{ background-color:#46953E;}

  li.game-spacer{ 
    border-right:2px solid #46953E;
    min-height:40px;
  }
  
  li.game-spacer-sin{ 
    border-right:none;
    min-height:40px;
  }

  li.game-bottom{ 
	background-color:#46953E;
  }
   
   </style>
 
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
        	<form class="form-inline formulario" role="form">
       
				<h4>PlayOff</h4>
                <main id="tournament">
                	
                	<ul class="round round-1">
                        <?php
						$i = 0;
						for ($i=1;$i<=16;$i++) {
							
							$resPlayOff 		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapasPosicion(1,$i);
							if (mysql_num_rows($resPlayOff)>0) {
								$equipoLocal		=	mysql_result($resPlayOff,0,'equipolocal');
								$equipovisitante	=	mysql_result($resPlayOff,0,'equipovisitante');
								$goleslocal			=	mysql_result($resPlayOff,0,'goleslocal');
								$golesvisitantes	=	mysql_result($resPlayOff,0,'golesvisitantes');
								$estadoPartido		=	mysql_result($resPlayOff,0,'refestadospartidos');
							} else {
								$equipoLocal		=	'&nbsp;';
								$equipovisitante	=	'&nbsp;';
								$goleslocal			=	'&nbsp;';
								$golesvisitantes	=	'&nbsp;';
								$estadoPartido		=	'&nbsp;';
	
							}
						?>
							<?php
                            if ($estadoPartido == 1) {
                            ?>
                            <li class="spacer">&nbsp;</li>
                        
                            <li class="game game-top winner"><?php echo $equipoLocal; ?> <span><?php echo $goleslocal; ?></span></li>
                            <li class="game game-spacer">&nbsp;</li>
                            <li class="game game-bottom "><?php echo $equipovisitante; ?> <span><?php echo $golesvisitantes; ?></span></li>
                            <?php
                            } else {
                            ?>
                            <li class="spacer">&nbsp;</li>
                        
                            <li class="game game-top"><?php echo $equipoLocal; ?> <span><?php echo $goleslocal; ?></span></li>
                            <li class="game game-spacer">&nbsp;</li>
                            <li class="game game-bottom winner"><?php echo $equipovisitante; ?> <span><?php echo $golesvisitantes; ?></span></li>

                            
                            <?php    
                            }
                            ?>
                        	
                        <?php
						}
						?>
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-2">
                        <?php
						for ($i=1;$i<=8;$i++) {
							
							$resPlayOff 		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapasPosicion(3,$i);
							if (mysql_num_rows($resPlayOff)>0) {
								$equipoLocal		=	mysql_result($resPlayOff,0,'equipolocal');
								$equipovisitante	=	mysql_result($resPlayOff,0,'equipovisitante');
								$goleslocal			=	mysql_result($resPlayOff,0,'goleslocal');
								$golesvisitantes	=	mysql_result($resPlayOff,0,'golesvisitantes');
								$estadoPartido		=	mysql_result($resPlayOff,0,'refestadospartidos');
							} else {
								$equipoLocal		=	'&nbsp;';
								$equipovisitante	=	'&nbsp;';
								$goleslocal			=	'&nbsp;';
								$golesvisitantes	=	'&nbsp;';
								$estadoPartido		=	'&nbsp;';
	
							}
						?>
							<?php
                            if ($estadoPartido == 1) {
                            ?>
                            <li class="spacer">&nbsp;</li>
                        
                            <li class="game game-top winner"><?php echo $equipoLocal; ?> <span><?php echo $goleslocal; ?></span></li>
                            <li class="game game-spacer">&nbsp;</li>
                            <li class="game game-bottom "><?php echo $equipovisitante; ?> <span><?php echo $golesvisitantes; ?></span></li>
                            <?php
                            } else {
                            ?>
                            <li class="spacer">&nbsp;</li>
                        
                            <li class="game game-top"><?php echo $equipoLocal; ?> <span><?php echo $goleslocal; ?></span></li>
                            <li class="game game-spacer">&nbsp;</li>
                            <li class="game game-bottom winner"><?php echo $equipovisitante; ?> <span><?php echo $golesvisitantes; ?></span></li>

                            
                            <?php    
                            }
                            ?>
                        	
                        <?php
						}
						?>
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-3">
                        <?php
						for ($i=1;$i<=4;$i++) {
							
							$resPlayOff 		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapasPosicion(4,$i);
							if (mysql_num_rows($resPlayOff)>0) {
								$equipoLocal		=	mysql_result($resPlayOff,0,'equipolocal');
								$equipovisitante	=	mysql_result($resPlayOff,0,'equipovisitante');
								$goleslocal			=	mysql_result($resPlayOff,0,'goleslocal');
								$golesvisitantes	=	mysql_result($resPlayOff,0,'golesvisitantes');
								$estadoPartido		=	mysql_result($resPlayOff,0,'refestadospartidos');
							} else {
								$equipoLocal		=	'&nbsp;';
								$equipovisitante	=	'&nbsp;';
								$goleslocal			=	'&nbsp;';
								$golesvisitantes	=	'&nbsp;';
								$estadoPartido		=	'&nbsp;';
	
							}
						?>
							<?php
                            if ($estadoPartido == 1) {
                            ?>
                            <li class="spacer">&nbsp;</li>
                        
                            <li class="game game-top winner"><?php echo $equipoLocal; ?> <span><?php echo $goleslocal; ?></span></li>
                            <li class="game game-spacer">&nbsp;</li>
                            <li class="game game-bottom "><?php echo $equipovisitante; ?> <span><?php echo $golesvisitantes; ?></span></li>
                            <?php
                            } else {
                            ?>
                            <li class="spacer">&nbsp;</li>
                        
                            <li class="game game-top"><?php echo $equipoLocal; ?> <span><?php echo $goleslocal; ?></span></li>
                            <li class="game game-spacer">&nbsp;</li>
                            <li class="game game-bottom winner"><?php echo $equipovisitante; ?> <span><?php echo $golesvisitantes; ?></span></li>

                            
                            <?php    
                            }
                            ?>
                        	
                        <?php
						}
						?>
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-4">
                        <?php
						for ($i=1;$i<=2;$i++) {
							
							$resPlayOff 		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapasPosicion(5,$i);
							if (mysql_num_rows($resPlayOff)>0) {
								$equipoLocal		=	mysql_result($resPlayOff,0,'equipolocal');
								$equipovisitante	=	mysql_result($resPlayOff,0,'equipovisitante');
								$goleslocal			=	mysql_result($resPlayOff,0,'goleslocal');
								$golesvisitantes	=	mysql_result($resPlayOff,0,'golesvisitantes');
								$estadoPartido		=	mysql_result($resPlayOff,0,'refestadospartidos');
							} else {
								$equipoLocal		=	'&nbsp;';
								$equipovisitante	=	'&nbsp;';
								$goleslocal			=	'&nbsp;';
								$golesvisitantes	=	'&nbsp;';
								$estadoPartido		=	'&nbsp;';
	
							}
						?>
							<?php
                            if ($estadoPartido == 1) {
                            ?>
                            <li class="spacer">&nbsp;</li>
                        
                            <li class="game game-top winner"><?php echo $equipoLocal; ?> <span><?php echo $goleslocal; ?></span></li>
                            <li class="game game-spacer">&nbsp;</li>
                            <li class="game game-bottom "><?php echo $equipovisitante; ?> <span><?php echo $golesvisitantes; ?></span></li>
                            <?php
                            } else {
                            ?>
                            <li class="spacer">&nbsp;</li>
                        
                            <li class="game game-top"><?php echo $equipoLocal; ?> <span><?php echo $goleslocal; ?></span></li>
                            <li class="game game-spacer">&nbsp;</li>
                            <li class="game game-bottom winner"><?php echo $equipovisitante; ?> <span><?php echo $golesvisitantes; ?></span></li>

                            
                            <?php    
                            }
                            ?>
                        	
                        <?php
						}
						?>
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-5">
                        <?php
						for ($i=1;$i<=1;$i++) {
							
							$resPlayOff 		=	$serviciosReferencias->traerFixtureTodoPorTorneoPlayOffPorEtapasPosicion(7,$i);
							
							if (mysql_num_rows($resPlayOff)>0) {
								$equipoLocal		=	mysql_result($resPlayOff,0,'equipolocal');
								$equipovisitante	=	mysql_result($resPlayOff,0,'equipovisitante');
								$goleslocal			=	mysql_result($resPlayOff,0,'goleslocal');
								$golesvisitantes	=	mysql_result($resPlayOff,0,'golesvisitantes');
								$estadoPartido		=	mysql_result($resPlayOff,0,'refestadospartidos');
							} else {
								$equipoLocal		=	'&nbsp;';
								$equipovisitante	=	'&nbsp;';
								$goleslocal			=	'&nbsp;';
								$golesvisitantes	=	'&nbsp;';
								$estadoPartido		=	'&nbsp;';
	
							}
						?>
							<?php
                            if ($estadoPartido == 1) {
                            ?>
                            <li class="spacer">&nbsp;</li>
                        
                            <li class="game game-top winner"><?php echo $equipoLocal; ?> <span><?php echo $goleslocal; ?></span></li>
                            <li class="game game-spacer">&nbsp;</li>
                            <li class="game game-bottom "><?php echo $equipovisitante; ?> <span><?php echo $golesvisitantes; ?></span></li>
                            <?php
                            } else {
                            ?>
                            <li class="spacer">&nbsp;</li>

                        
                            <li class="game game-top"><?php echo $equipoLocal; ?> <span><?php echo $goleslocal; ?></span></li>
                            <li class="game game-spacer">&nbsp;</li>
                            <li class="game game-bottom winner"><?php echo $equipovisitante; ?> <span><?php echo $golesvisitantes; ?></span></li>

                            
                            <?php    
                            }
                            ?>
                        	
                        <?php
						}
						?>
                        <li class="spacer">&nbsp;</li>
                    </ul>	
                    

                </main>
   

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
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;"><?php echo $plural; ?> Cargados</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<?php //echo $lstCargados; ?>
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
	
	$('#activo').prop('checked',true);

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
