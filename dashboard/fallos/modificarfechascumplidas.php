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

$resFixture		=	$serviciosReferencias->traerFixturePorId(mysql_result($resResultado,0,'reffixture'));

$resSanciones	=	$serviciosReferencias->traerMovimientosancionesIdSancionPorSancionJugador(mysql_result($resResultado,0,'refjugadores'));
$resFS		=	$serviciosReferencias->traerMovimientosancionesCompletoPorSancionesJugadores($id);
/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Fallo";

$plural = "Fallos";

$eliminar = "eliminarMovimientosanciones";

$insertar = "modificarMovimientosanciones";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbmovimientosanciones";

$cabeceras 		= "	<th bgcolor='#E0ECF8'>Fecha</th>
					<th bgcolor='#E0ECF8'>Cumplida</th>
					<th bgcolor='#E0ECF8'>Finalizo</th>
					<th bgcolor='#E0ECF8'>Tipo Fallo</th>";
//////////////////////////////////////////////  FIN de los opciones //////////////////////////



$fallo	= '';
$cadFechasS = '';

	
	$cadFechasS .= '<ul class="list-group">
              <li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-user"></span> Jugador</li>
              <li class="list-group-item list-group-item-default">Nombre Completo:'.mysql_result($resDetalles,0,'jugador').'</li>
              <li class="list-group-item list-group-item-default">Nro Documento:'.mysql_result($resDetalles,0,'nrodocumento').'</li>
              <li class="list-group-item list-group-item-default">Fecha de la sación:'.mysql_result($resDetalles,0,'fecha').'</li>
              <li class="list-group-item list-group-item-default">Sanción:'.mysql_result($resDetalles,0,'tiposancion').'</li>
			  <li class="list-group-item list-group-item-default">Categoria:'.mysql_result($resDetalles,0,'categoria').'</li>
			  <li class="list-group-item list-group-item-default">División:'.mysql_result($resDetalles,0,'division').'</li>
			  <li class="list-group-item list-group-item-default">Fechas:'.mysql_result($resDetalles,0,'cantidadfechas').'</li>
			  <li class="list-group-item list-group-item-default">Obs.:'.mysql_result($resDetalles,0,'observaciones').'</li>
              
            </ul><hr>';
			
	
	
	
	$cadFechasS .= '<ul class="list-inline">';
	while ($rowFS = mysql_fetch_array($resFS)) {
		$check = '';

		if ($rowFS['cumplidas'] == 'Si') {
			$check = 'checked';	
		}
		$cadFechasS = $cadFechasS."<li>".'<input id="'.$rowFS[0].'" '.$check.' class="form-control cumplir" type="checkbox" style="width:50px;" name="fecha'.$rowFS[0].'"><p>'.$rowFS[1].'</p>'."</li>";
	}
		

	$cadFechasS = $cadFechasS.'</ul>';		
			

//$resFechas = $serviciosReferencias->traerFechasFixturePorTorneo(mysql_result($resFixture,0,'reftorneos'));




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

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Modificar Cumplimiento</p>
        	
        </div>
    	<div class="cuerpoBox">
            <form name="form" id="form" method="post">
            <?php
				echo $cadFechasS;
			?>
				<h5>* Con solo hacer click modificara si cumplio o no la fecha</h5>
                <button type="button" class="btn btn-default volver">Volver</button>
            </form>
            
    	</div>
    </div>


   
</div>


</div>

<div id="dialog2" title="Modificar Fecha Cumplida">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea modificar el cumplimiento?.<span id="proveedorEli"></span>
        </p>
        
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
        <input type="hidden" value="" id="cumplirfecha" name="cumplirfecha">
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
	
	
	$('.volver').click(function(e) {
        url = "modificarfechas.php?id="+<?php echo $id; ?>;
		$(location).attr('href',url);
    });
	
	
	$(".cuerpoBox").on("click",'.cumplir', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			if( $(this).prop('checked') ) {
				$('#cumplirfecha').val(1);
			}  else {
				$('#cumplirfecha').val(0);	
			}

			$("#idEliminar").val(usersid);
			$("#dialog2").dialog("open");
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
			"Modificar": function() {

				$.ajax({
							data:  {id: $('#idEliminar').val(), 
									cumple: $('#cumplirfecha').val(),
									accion: 'modificarMovimientosSancionesFechaCumplida'},
							url:   '../../ajax/ajax.php',
							type:  'post',
							beforeSend: function () {
									
							},
							success:  function (response) {
									url = "modificarfechascumplidas.php?id="+<?php echo $id; ?>;
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
