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

$resCantidadJugadores = mysql_num_rows($serviciosReferencias->traerJugadores());

$resTraerJugadores = $serviciosReferencias->traerJugadores();

$cadJugadores = '';
	$cadJugadores .= '<option value="0"> </option>';
	while ($row = mysql_fetch_array($resTraerJugadores)) {

		$cadJugadores .= '<option value="'.$row[0].'">'.$row['apellido'].' '.$row['nombres'].' - '.$row['nrodocumento'].'</option>';
	}
		
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
									data:  {id: $('#idEliminar').val(), accion: '<?php echo $eliminar; ?>'},
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


<?php } ?>
</body>
</html>
