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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../jugadores/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Jugadores",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Jugador";

$plural = "Jugadores";

$eliminar = "eliminarJugadores";

$insertar = "insertarJugadores";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbjugadores";

$lblCambio	 	= array("reftipodocumentos","nrodocumento","fechanacimiento","fechaalta","fechabaja","refcountries");
$lblreemplazo	= array("Tipo Documento","Nro Documento","Fecha Nacimiento","Fecha Alta","Fecha Baja","Countries");


$resTipoDoc 	= $serviciosReferencias->traerTipodocumentos();
$cadRef 	= $serviciosFunciones->devolverSelectBox($resTipoDoc,array(1),'');

$resCountries 	= $serviciosReferencias->traerCountries();
$cadRef2	= '<option value="0">----  Seleccionar  ----</option>';
$cadRef2 	.= $serviciosFunciones->devolverSelectBox($resCountries,array(1),'');

$refdescripcion = array(0 => $cadRef,1 => $cadRef2);
$refCampo 	=  array("reftipodocumentos","refcountries");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////



//tip.tipodocumento,j.nrodocumento,j.apellido,j.nombres,j.email,j.fechanacimiento,j.fechaalta,j.fechabaja,cou.nombre as countrie,j.observaciones
/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "	<th>Tipo Documento</th>
					<th>Nro Doc</th>
					<th>Apellido</th>
					<th>Nombres</th>
					<th>Email</th>
					<th>Fecha Nac.</th>
					<th>Fecha Alta</th>
					<th>Fecha Baja</th>
					<th>Countrie</th>
					<th>Obs.</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resDocumentaciones2	=	$serviciosReferencias->traerDocumentaciones();


$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);


$resMotivosHabDeportivas	=	$serviciosReferencias->traerMotivoshabilitacionestransitoriasDeportivas('Edad');
$cadRef		=	$serviciosFunciones->devolverSelectBox($resMotivosHabDeportivas,array(2),'');

$resMotivosHabDocumentaciones	=	$serviciosReferencias->traerMotivoshabilitacionestransitoriasDocumentaciones('Edad');
$cadRef2	=	$serviciosFunciones->devolverSelectBox($resMotivosHabDocumentaciones,array(2),'');

$resTemporados	=	$serviciosReferencias->traerTemporadas();
$cadRef3	=	$serviciosFunciones->devolverSelectBox($resTemporados,array(1),'');

$resDocumentaciones	=	$serviciosReferencias->traerDocumentaciones();
$cadRef4	=	$serviciosFunciones->devolverSelectBox($resDocumentaciones,array(1),'');

$resCategoria		=	$serviciosReferencias->traerCategorias();
$cadRefCad			=	$serviciosFunciones->devolverSelectBox($resCategoria,array(1),'');

$resEquipo			=	$serviciosReferencias->traerEquipos();
$cadRefEquipo		=	$serviciosFunciones->devolverSelectBox($resEquipo,array(2),'');

$resTipoJugador		=	$serviciosReferencias->traerTipojugadores();
$cadRefTipoJug		=	$serviciosFunciones->devolverSelectBox($resTipoJugador,array(1),'');

$resCountries		=	$serviciosReferencias->traerCountries();
$cadRefCountries	=	$serviciosFunciones->devolverSelectBox($resCountries,array(1),'');



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
	<script src="../../js/jquery.maskedinput.min.js" type="text/javascript"></script>
    
   <style>
   	.clickable{
    cursor: pointer;   
	}
	
	.panel-heading span {
		margin-top: -20px;
		font-size: 15px;
	}
	
	.errorNroDoc { 
		border:1px solid #F00;
		box-shadow: 0px 0px 3px #ccc, 0 10px 15px #eee inset;
		border-radius:2px;
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
	
		

    
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;"><?php echo $plural; ?> Cargados</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">
            	
                <div class="row">

                    
                    <div id="error" class="alert" style="margin:20px 10px;">
                    
                    </div>
                    
                    <div class="form-group col-md-12">
                    	<div class="cuerpoBox" id="resultados">
        					<?php
								$res	=	$serviciosReferencias->traerApellidoNombreMalos();
	
								$cad3 = '';
								//////////////////////////////////////////////////////busquedajugadores/////////////////////
								$cad3 = $cad3.'
											<div class="col-md-12">
											<div class="panel panel-info">
															<div class="panel-heading">
																<h3 class="panel-title">Resultado de la Busqueda</h3>
																
															</div>
															<div class="panel-body-predio" style="padding:5px 20px;">
																';
								$cad3 = $cad3.'
								<div class="row">
												<table id="example" class="table table-responsive table-striped" style="font-size:0.8em; padding:2px;">
													<thead>
													<tr>
														<th>Tipo Documento</th>
														<th>Nro Doc</th>
														<th>Apellido</th>
														<th>Nombres</th>
														<th>Email</th>
														<th>Fecha Nac.</th>
														<th>Fecha Alta</th>
														<th>Fecha Baja</th>
														<th>Countrie</th>
														<th>Acciones</th>
													</tr>
													</thead>
													<tbody id="resultadosProd">';
								while ($rowJ = mysql_fetch_array($res)) {
									$cad3 .= '<tr>
												<td>'.($rowJ[1]).'</td>
												<td>'.($rowJ[2]).'</td>
												<td><input type="text" id="apellido'.$rowJ[0].'" name="apellido'.$rowJ[0].'" value="'.utf8_encode($rowJ[3]).'"/></td>
												<td><input type="text" id="nombre'.$rowJ[0].'" name="nombre'.$rowJ[0].'" value="'.utf8_encode($rowJ[4]).'"/></td>
												<td>'.($rowJ[5]).'</td>
												<td>'.($rowJ[6]).'</td>
												<td>'.($rowJ[7]).'</td>
												<td>'.($rowJ[8]).'</td>
												<td>'.($rowJ[9]).'</td>
												<td><button type="button" class="btn btn-primary modificarJugadorNombreApellido" id="'.$rowJ[0].'">Guardar</button></td>
											 </tr>';
								}
								
								$cad3 = $cad3.'</tbody>
															</table></div>
														</div>
													</div>';
													
								echo $cad3;
							
							?>
       		 			</div>
					</div>
                
                </div>
                


            
            </form>
    	</div>
    </div>
    
    

 
    
   
</div>

    
</div>

<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$('#colapsarMenu').click();
	$('#fechaalta').val('<?php echo date('d/m/Y'); ?>');
	
	
	$('#buscar').click(function(e) {
        $.ajax({
				data:  {busqueda: $('#busqueda').val(),
						accion: 'buscarJugadoresNombresFiltro'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
						
				},
				success:  function (response) {
						$('#resultados').html(response);
						
				}
		});
		
	});
	
	
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
	

	

	$("#resultados").on("click",'.modificarJugadorNombreApellido', function(){
		
		idBtn = $(this).attr("id");

		
        $.ajax({
			data:  {idJugador: $(this).attr("id"), 
					apellido: $('#apellido'+$(this).attr("id")).val(), 
					nombre: $('#nombre'+$(this).attr("id")).val(),
					accion: 'modificarJugadorApellidoNombrePorId'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
				$(".alert").removeClass("alert-danger");
				$(".alert").removeClass("alert-info");
				$(".alert").removeClass("alert-success");
				$('#error').html('');	
			},
			success:  function (response) {
				if (response == '') {
					$(".alert").removeClass("alert-danger");
					$(".alert").removeClass("alert-info");
					$(".alert").addClass("alert-success");
					$('#error').html('<span class="glyphicon glyphicon-ok"></span> Se guardo correctamente');
					$('#'+idBtn).removeClass("btn-primary");
					$('#'+idBtn).addClass("btn-success");
					$('#'+idBtn).html('<span class="glyphicon glyphicon-ok"></span> Guardado');
					
				} else {
					$(".alert").removeClass("alert-success");
					$(".alert").removeClass("alert-info");
					$(".alert").addClass("alert-danger");
					$('#error').html('Huvo un error al guardar los datos, verifique los datos ingresados '.response);
					$('#'+idBtn).removeClass("btn-primary");
					$('#'+idBtn).addClass("btn-danger");
					$('#'+idBtn).html('<span class="glyphicon glyphicon-ban-circle"></span> Guardar');
				}
			}
		});
    });
	
	$('#primero').addClass('collapse');

});
</script>


 
    
<?php } ?>
</body>
</html>
