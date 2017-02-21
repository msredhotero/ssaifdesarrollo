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

$id	= $_GET['id'];

$resResultado = $serviciosReferencias->traerJugadoresPorId($id);
/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Jugador";

$plural = "Jugadores";

$eliminar = "eliminarJugadoresmotivoshabilitacionestransitorias";

$insertar = "insertarJugadoresmotivoshabilitacionestransitorias";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbjugadores";

$lblCambio	 	= array("reftipodocumentos","nrodocumento","fechanacimiento","fechaalta","fechabaja","refcountries");
$lblreemplazo	= array("Tipo Documento","Nro Documento","Fecha Nacimiento","Fecha Alta","Fecha Baja","Countries");


$resTipoDoc 	= $serviciosReferencias->traerTipodocumentos();
$cadRef 	= $serviciosFunciones->devolverSelectBox($resTipoDoc,array(1),'');

$resCountries 	= $serviciosReferencias->traerCountries();
$cadRef2 	= $serviciosFunciones->devolverSelectBox($resCountries,array(1),'');

$refdescripcion = array(0 => $cadRef,1 => $cadRef2);
$refCampo 	=  array("reftipodocumentos","refcountries");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////



//tip.tipodocumento,j.nrodocumento,j.apellido,j.nombres,j.email,j.fechanacimiento,j.fechaalta,j.fechabaja,cou.nombre as countrie,j.observaciones
/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "	<th>Temporadas</th>
					<th>Documentaciones</th>
					<th>Motivos</th>
					<th>Equipo</th>
					<th>Categoria</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resDocumentaciones2	=	$serviciosReferencias->traerDocumentaciones();


$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugador($id),5);

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

$resCantidadDCTTJ = mysql_num_rows($serviciosReferencias->traerDefinicionescategoriastemporadastipojugador());

$resDocumentacionesCargadas	=	$serviciosReferencias->traerJugadoresdocumentacionPorJugadorValores($id);

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
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Carga del jugador (Nro Documento Unico).</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Paso 2</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="documentaciones.php?id=<?php echo $id; ?>" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Carga de la Documentación presentada.</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Paso 3</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="equipos.php?id=<?php echo $id; ?>" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Asignar al Jugador a un Equipo.</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step active"><!-- active -->
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
            
            <hr>
            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <h4 style="text-decoration:underline;">Documentaciones</h4>
                <?php
					while ($rowD = mysql_fetch_array($resDocumentacionesCargadas)) {
					if ($rowD['obligatoria'] == 'Si') {
						if (($rowD['valor'] == 'No') && ($rowD['contravalor'] == 'No')) {
							$noHabilitaDocumentacion = array($rowD['refdocumentaciones']=>0);
						}
					}
				?>
                	<div class="col-md-4">
                    	<?php
							if ($rowD['valor'] == 'Si') {
						?>
                    	<p><span style="color:#3C0;" class="glyphicon glyphicon-ok"></span> <?php echo $rowD['descripcion']; ?></p>
                        <?php 
							} else { 
								if ($rowD['contravalor'] == 'Si') {
						?>
                        		<p><span style="color:#3C0;" class="glyphicon glyphicon-ok"></span> <?php echo $rowD['descripcion']; ?></p>
                        <?php
								} else {
						?>
                    			<p><span style="color:#F00;" class="glyphicon glyphicon-remove"></span> <?php echo $rowD['descripcion']; ?></p>
                        <?php		
								}
							}
						?>
                    </div>
                <?php
					}
				?>
            </div>
            
        	<div class='row' style="margin-left:25px; margin-right:25px;">
				<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Habilitaciones Transitorias (Deportiva)</h3>
					<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
				</div>
                <div class="panel-body" id="primero">
                	<form class="form-inline formulario" role="form">
                    <div class="row">
                    
                	<div class="form-group col-md-3" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Fusión</label>
                        <div class="input-group col-md-12 fontcheck">
                            <input type="checkbox" class="form-control" id="esfusion" name="esfusion" style="width:50px;" required> <p>Si/No</p>
                        </div>
                    </div>
                    <div class="form-group col-md-9" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Countries</label>
                        <div class="input-group col-md-12" id="refcountriesauxDiv">
                            <select id="refcountriesaux" name="refcountriesaux" class="chosen-select" style="width:100%;">
                            	<?php echo $cadRefCountries; ?>
                            </select>
                        </div>
                    </div>
                    </div>
                    <hr>
                    
            		<div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Temporadas</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="reftemporadasA" name="reftemporadasA">
                            	<?php echo $cadRef3; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Categorias</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refcategoriasA" name="refcategoriasA">
                            	<?php echo $cadRefCad; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Equipo</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refequiposA" name="refequiposA">
                            	
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-4" style="display:none;">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Documentaciones</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refdocumentacionesA" name="refdocumentacionesA">
                            	<?php echo $cadRef4; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Motivos</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refmotivoshabilitacionestransitoriasA" name="refmotivoshabilitacionestransitoriasA">
                            	<?php echo $cadRef; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-4" style="display:block">
                        <label for="fechanacimiento" class="control-label" style="text-align:left">Fecha Limite</label>
                        <div class="input-group col-md-12">
                            <input class="form-control" name="fechalimiteA" id="fechalimiteA" type="text">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        
                    </div>
                    
                    
                    <div class="form-group col-md-8" style="display:block">
                        <label for="observaciones" class="control-label" style="text-align:left">Observaciones</label>
                        <div class="input-group col-md-12">
                            <textarea type="text" rows="6" cols="6" class="form-control" id="observacionesA" name="observacionesA" placeholder="Ingrese el Observaciones..." required></textarea>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                        <ul class="list-inline" style="margin-top:15px;">
                            <li>
                                <button type="button" class="btn btn-primary" id="cargarHabilitacionesDeportiva" style="margin-left:0px;">Guardar</button>
                            </li>
                        </ul>
                        </div>
                    </div>
                    
                    <div class='row' style="margin-left:25px; margin-right:25px;">
                        <div class='alert' id="errorDepo">
                        
                        </div>
                        <div id='load'>
                        
                        </div>
                    </div>
                    
                    <input type="hidden" id="refjugadores" name="refjugadores" value="<?php echo $id; ?>"/>
            		<input type="hidden" id="refcountries" name="refcountries" value="<?php echo mysql_result($resResultado,0,'refcountries'); ?>"/>
                    <input type="hidden" id="accion" name="accion" value="insertarJugadoresmotivoshabilitacionestransitoriasA"/>
                    
                    </form>
                    
				</div>
            </div>
            
            <div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Habilitaciones Transitorias (Documentaciones)</h3>
					<span class="pull-right clickable panel-collapsed"><i class="glyphicon glyphicon-chevron-down"></i></span>
				</div>
                <div class="panel-body collapse">
                	<form class="form-inline formulario" role="form">
            		<div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Temporadas</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="reftemporadasB" name="reftemporadasB">
                            	<?php echo $cadRef3; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Documentaciones</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refdocumentacionesB" name="refdocumentacionesB">
                            	<?php echo $cadRef4; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- esto no van, les pongo el primero que encuentro -->
                    <div class="form-group col-md-4" style="display:none">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Categorias</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refcategoriasB" name="refcategoriasB">
                            	<?php echo $cadRefCad; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4" style="display:none">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Equipo</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refequiposB" name="refequiposB">
                            	
                            </select>
                        </div>
                    </div>
                    <!-- no van -->
                    
                    <div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Motivos</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refmotivoshabilitacionestransitoriasB" name="refmotivoshabilitacionestransitoriasB">
                            	<?php echo utf8_decode($cadRef2); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-4" style="display:block">
                        <label for="fechanacimiento" class="control-label" style="text-align:left">Fecha Limite</label>
                        <div class="input-group col-md-12">
                            <input class="form-control" name="fechalimiteB" id="fechalimiteB" type="text">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    
                    
                    <div class="form-group col-md-8" style="display:block">
                        <label for="observaciones" class="control-label" style="text-align:left">Observaciones</label>
                        <div class="input-group col-md-12">
                            <textarea type="text" rows="6" cols="6" class="form-control" id="observacionesB" name="observacionesB" placeholder="Ingrese el Observaciones..." required></textarea>
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
                    
                     
            
                    <div class='row' style="margin-left:25px; margin-right:25px;">
                        <div class='alert' id="errorDocu">
                        
                        </div>
                        <div id='load'>
                        
                        </div>
                    </div>
                    
                    
                    
                    <input type="hidden" id="refjugadores" name="refjugadores" value="<?php echo $id; ?>"/>
            		<input type="hidden" id="refcountries" name="refcountries" value="<?php echo mysql_result($resResultado,0,'refcountries'); ?>"/>
                    <input type="hidden" id="accion" name="accion" value="insertarJugadoresmotivoshabilitacionestransitoriasB"/>
                    </form>
								
				</div>
            </div>
            
            
            <?php
	
			if ($resCantidadDCTTJ == 0) {
			
			?>
			<div class='row' style="margin-left:25px; margin-right:25px;">
				<div class='alert alert-danger' id="erroresRaros">
					<p>No existen Definiciones Categorias Temporadas Tipo Jugador cargadas</p>
				</div>
				
			</div>
			<?php
			}
			?>     
                 
            </div>
            
            
            
            
            
            
            
            
            
    	</div>
    </div>
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Habilitaciones Cargadas para <span style="color: #202020;">(<?php echo mysql_result($resResultado,0,'apellido').', '.mysql_result($resResultado,0,'nombres'); ?>)</span></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<?php echo $lstCargados; ?>
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
	
	$("#fechalimiteA").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
	$("#fechalimiteB").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
	
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
	
	function traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion(idDocumentacion,contenedor) {
		$.ajax({
			data:  {id: idDocumentacion, accion: 'traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
			
			},
			success:  function (response) {
				$(contenedor).html(response);
			}
		});	
	}
	
	traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion( $('#refdocumentacionesB').val() ,'#refmotivoshabilitacionestransitoriasB' );

	$('#refdocumentacionesB').change(function() {
		traerMotivoshabilitacionestransitoriasDocumentacionesPorDocumentacion($(this).val(),'#refmotivoshabilitacionestransitoriasB');
	});
	
	traerEquiposPorCountries(<?php echo mysql_result($resResultado,0,'refcountries'); ?>, '#refequiposA');
	traerEquiposPorCountries(<?php echo mysql_result($resResultado,0,'refcountries'); ?>, '#refequiposB');
	
	$('#esfusion').click(function() {
		$('#refequiposA').html('');
		if  ($('#esfusion').prop('checked') == false) {
			$('#refcountriesauxDiv').hide();
			traerEquiposPorCountries(<?php echo mysql_result($resResultado,0,'refcountries'); ?>, '#refequiposA');
		} else {
			$('#refcountriesauxDiv').show();	
		}
	});

	
	
	$('#refcountriesaux').change(function() {
		if  ($('#esfusion').prop('checked') == true) {
			traerEquiposPorCountries($(this).val(), '#refequiposA');
		}
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
			
			url = "habilitacionesmodificar.php?id=" + usersid + "&idJugador=" + <?php echo $id; ?>;
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
											url = "habilitaciones.php?id="+<?php echo $id; ?>;
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
    $('#cargarHabilitacionesDeportiva').click(function(){

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
                                            $("#errorDepo").removeClass("alert-danger");
											$("#errorDepo").removeClass("alert-info");
                                            $("#errorDepo").addClass("alert-success");
                                            $("#errorDepo").html('<strong>Ok!</strong> Se cargo exitosamente la <strong>Habilitacion</strong>. ');
											$("#errorDepo").delay(3000).queue(function(){
												/*aca lo que quiero hacer 
												  después de los 2 segundos de retraso*/
												$(this).dequeue(); //continúo con el siguiente ítem en la cola
												
											});
											$("#load").html('');
											url = "habilitaciones.php?id="+<?php echo $id; ?>;
											$(location).attr('href',url);
                                            
											
                                        } else {
                                        	$("#errorDepo").removeClass("alert-danger");
                                            $("#errorDepo").addClass("alert-danger");
                                            $("#errorDepo").html('<strong>Error!</strong> '+data);
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
	
	
	//al enviar el formulario
    $('#cargar').click(function(){

			//información del formulario
			var formData = new FormData($(".formulario")[1]);
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
                                            $("#errorDocu").removeClass("alert-danger");
											$("#errorDocu").removeClass("alert-info");
                                            $("#errorDocu").addClass("alert-success");
                                            $("#errorDocu").html('<strong>Ok!</strong> Se cargo exitosamente la <strong>habilitacion</strong>. ');
											$("#errorDocu").delay(3000).queue(function(){
												/*aca lo que quiero hacer 
												  después de los 2 segundos de retraso*/
												$(this).dequeue(); //continúo con el siguiente ítem en la cola
												
											});
											$("#load").html('');
											url = "habilitaciones.php?id="+<?php echo $id; ?>;
											$(location).attr('href',url);
                                            
											
                                        } else {
                                        	$("#errorDocu").removeClass("alert-danger");
                                            $("#errorDocu").addClass("alert-danger");
                                            $("#errorDocu").html('<strong>Error!</strong> '+data);
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
	$('#refcountriesauxDiv').hide();
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
