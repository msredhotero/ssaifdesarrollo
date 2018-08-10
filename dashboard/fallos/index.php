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


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Fallo";

$plural = "Fallos";

$eliminar = "eliminarSancionesfallos";

$insertar = "insertarSancionesfallos";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbsancionesfallos";

$lblCambio	 	= array("refsancionesjugadores","cantidadfechas","fechadesde","fechahasta","fechascumplidas","pendientescumplimientos","pendientesfallo","generadaporacumulacion");
$lblreemplazo	= array("Jugador","Cant. Fechas","Fechas Desde","Fecha Hasta","Fechas Cumplidas","Pend. Cumplimiento","Pend. Fallo","Generada x Acumu.");

$refSancionJugador	=	$serviciosReferencias->traerSancionesjugadores();
$cadRef 	= '';

$refdescripcion = array();
$refCampo 	=  array();
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "	<th bgcolor='#E0ECF8'>Jugador</th>
					<th bgcolor='#E0ECF8'>Nro Documento</th>
					<th bgcolor='#E0ECF8'>Equipo</th>
					<th bgcolor='#E0ECF8'>Fecha</th>
					<th bgcolor='#E0ECF8'>Tipo Sanción</th>
					<th bgcolor='#E0ECF8'>Cantidad</th>
					<th bgcolor='#E0ECF8'>Cant. Fechas</th>
					<th bgcolor='#E0ECF8'>Fecha Desde</th>
					<th bgcolor='#E0ECF8'>Fecha Hasta</th>
					<th bgcolor='#E0ECF8'>Amarillas</th>
					<th bgcolor='#E0ECF8'>Fechas Cumplidas</th>
					<th bgcolor='#E0ECF8'>Pend. de Cumplimiento</th>
					<th bgcolor='#E0ECF8'>Pend. de Fallo</th>
					<th bgcolor='#E0ECF8'>Generada x Acumu.</th>
					<th bgcolor='#E0ECF8'>Obs.</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////



//$resFallosAcu = $serviciosReferencias->traerSancionesJugadoresConFallosAcumulados();
//$lstCargadosAcumulados 	= $serviciosFunciones->camposTablaView($cabeceras,$resFallosAcu,87);


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

	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.css">
	
    
   
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
        	<p style="color: #fff; font-size:18px; height:16px;"><?php echo $plural; ?> Cargados</p>
        	
        </div>
    	<div class="cuerpoBox">
    		<table id="example" class="display table " style="width:100%">
        	<thead>
		            <tr>
		                <th>Jugador</th>
		                <th>Nro Documento</th>
		                <th>Equipo</th>
		                <th>Fecha</th>
		                <th>Tipo Sancion</th>
		                <th>Cant.</th>
		                <th>Cant. Fechas</th>
		                <th>Desde</th>
		                <th>Hasta</th>
		                <th>Amarillas</th>
		                <th>Fechas Cumplidas</th>
		                <th>Pend. Cump.</th>
		                <th>Pend. Fallo</th>
		                <th>Acciones</th>
		            </tr>
		        </thead>
		        <tfoot>
		            <tr>
		                <th>Jugador</th>
		                <th>Nro Documento</th>
		                <th>Equipo</th>
		                <th>Fecha</th>
		                <th>Tipo Sancion</th>
		                <th>Cant.</th>
		                <th>Cant. Fechas</th>
		                <th>Desde</th>
		                <th>Hasta</th>
		                <th>Amarillas</th>
		                <th>Fechas Cumplidas</th>
		                <th>Pend. Cump.</th>
		                <th>Pend. Fallo</th>
		                <th>Acciones</th>
		            </tr>
		        </tfoot>
		    </table>
    	</div>
    </div>
    
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Suspendidos por Acumulacion de Amarillas</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<table id="example2" class="display" style="width:100%">
        	<thead>
		            <tr>
		                <th>Jugador</th>
		                <th>Nro Documento</th>
		                <th>Equipo</th>
		                <th>Fecha</th>
		                <th>Tipo Sancion</th>
		                <th>Cant.</th>
		                <th>Cant. Fechas</th>
		                <th>Desde</th>
		                <th>Hasta</th>
		                <th>Amarillas</th>
		                <th>Fechas Cumplidas</th>
		                <th>Pend. Cump.</th>
		                <th>Pend. Fallo</th>
		                <th>Acciones</th>
		            </tr>
		        </thead>
		        <tfoot>
		            <tr>
		                <th>Jugador</th>
		                <th>Nro Documento</th>
		                <th>Equipo</th>
		                <th>Fecha</th>
		                <th>Tipo Sancion</th>
		                <th>Cant.</th>
		                <th>Cant. Fechas</th>
		                <th>Desde</th>
		                <th>Hasta</th>
		                <th>Amarillas</th>
		                <th>Fechas Cumplidas</th>
		                <th>Pend. Cump.</th>
		                <th>Pend. Fallo</th>
		                <th>Acciones</th>
		            </tr>
		        </tfoot>
		    </table>
    	</div>
    </div>
    
    

    
    
   
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar Sancion Por 5 amarilla</h4>
      </div>
      <div class="modal-body">
        <p>¿Desea eliminar definitivamente esta sancion?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="eliminarAcumulada" data-dismiss="modal">Confirmar</button>
        <input type="hidden" name="idacumulada" id="idacumulada" value="">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>



</div>




<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$('#example').dataTable({
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "../../json/jsfallosajax.php",
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
	});


	$('#example2').dataTable({
	"bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "../../json/jsacumuladasajax.php",
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
	});
	
	


	
	$("#example2").on("click",'.varborraracumulados', function(){
		  usersid =  $(this).attr("id");
		  $('#idacumulada').val(usersid);
		  $('#myModal').modal();
	});//fin del boton eliminar
	
	

	$('#eliminarAcumulada').click(function() {
		eliminar();
	});

	function eliminar() {
		$.ajax({
			data:  {id: $('#idacumulada').val(), 
					accion: 'eliminarSancionesfallosacumuladas'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
				url = "index.php";
				$(location).attr('href',url);
					
			}
		});

	}
	
	



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
