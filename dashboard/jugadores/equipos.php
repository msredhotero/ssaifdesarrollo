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


$refTemporada = $serviciosReferencias->traerUltimaTemporada();

if (mysql_num_rows($refTemporada)>0) {
	$idTemporada = mysql_result($refTemporada,0,0);	
} else {
	$idTemporada = 0;
}

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Jugador";

$plural = "Jugadores";

$eliminar = "eliminarConector";

$insertar = "insertarConector";

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
$cabeceras 		= "	<th>Categoria</th>
					<th>Equipo</th>
					<th>Countrie</th>
					<th>Tipo Jugador</th>
					<th>Es Fusion</th>
					<th>Activo</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resDocumentaciones2	=	$serviciosReferencias->traerDocumentaciones();

$resCantidadConectoresActivos  =	$serviciosReferencias->traerConectorActivos($id);

$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerConector($id),6);

$resMotivosHabDeportivas	=	$serviciosReferencias->traerMotivoshabilitacionestransitoriasDeportivas('Edad');
$cadRef		=	$serviciosFunciones->devolverSelectBox($resMotivosHabDeportivas,array(2),'');

$resMotivosHabDocumentaciones	=	$serviciosReferencias->traerMotivoshabilitacionestransitoriasDocumentaciones('Edad');
$cadRef2	=	$serviciosFunciones->devolverSelectBox($resMotivosHabDocumentaciones,array(2),'');

$resTemporados	=	$serviciosReferencias->traerTemporadas();
$cadRef3	=	$serviciosFunciones->devolverSelectBox($resTemporados,array(1),'');

$resDocumentaciones	=	$serviciosReferencias->traerJugadoresdocumentacionPorJugadorValores($id);

$resCategoria		=	$serviciosReferencias->traerCategorias();
$cadRefCad			=	$serviciosFunciones->devolverSelectBox($resCategoria,array(1),'');

$resEquipo			=	$serviciosReferencias->traerEquipos();
$cadRefEquipo		=	$serviciosFunciones->devolverSelectBox($resEquipo,array(2),'');

$resTipoJugador		=	$serviciosReferencias->traerTipojugadores();
$cadRefTipoJug		=	$serviciosFunciones->devolverSelectBox($resTipoJugador,array(1),'');

$resCountries		=	$serviciosReferencias->traerCountries();
$cadRefCountries	=	$serviciosFunciones->devolverSelectBox($resCountries,array(1),'');

$resResultado = $serviciosReferencias->traerJugadoresPorId($id);

$resCantidadDCTTJ = mysql_num_rows($serviciosReferencias->traerDefinicionescategoriastemporadastipojugador());

$resHabilitacionesTransitorias = $serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugador($id);


$noHabilitaDocumentacion = array();

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
              <a href="modificar.php?id=<?php echo $id; ?>" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Carga del jugador (Nro Documento Unico).</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Paso 2</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="documentaciones.php?id=<?php echo $id; ?>" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Carga de la Documentación presentada.</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step active"><!-- complete -->
              <div class="text-center bs-wizard-stepnum">Paso 3</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">Asignar al Jugador a un Equipo.</div>
            </div>
            
            <div class="col-xs-3 bs-wizard-step disabled"><!-- active -->
              <div class="text-center bs-wizard-stepnum">Paso 4</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center"> Carga de las Habilitaciones Transitorias (Deportivas y Documentaciones)</div>
            </div>
            

        </div>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de Equipos</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<ul class="list-group">
              <li class="list-group-item list-group-item-info"><span class="glyphicon glyphicon-user"></span> Jugador</li>
              <li class="list-group-item list-group-item-default">Nombre Completo: <?php echo mysql_result($resResultado,0,'apellido').', '.mysql_result($resResultado,0,'nombres'); ?></li>
              <li class="list-group-item list-group-item-default">Nro Documento: <?php echo mysql_result($resResultado,0,'nrodocumento'); ?></li>
              <li class="list-group-item list-group-item-default">Fecha de Nacimiento: <?php echo mysql_result($resResultado,0,'fechanacimiento'); ?></li>
              <li class="list-group-item list-group-item-default">Countrie: <?php echo mysql_result($serviciosReferencias->traerCountriesPorId(mysql_result($resResultado,0,'refcountries')),0,'nombre'); ?></li>
            </ul>
            
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
                    <div class="row">
                    <div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Categorias</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refcategorias" name="refcategorias">
                            	<?php echo $cadRefCad; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Equipo</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refequipos" name="refequipos">
                            	<?php echo $cadRefEquipo; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Tipo Jugador</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="reftipojugadores" name="reftipojugadores">
                            	<?php echo $cadRefTipoJug; ?>
                            </select>
                        </div>
                    </div>
                    </div>

            </div>
            <hr>
            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <h4 style="text-decoration:underline;">Documentaciones</h4>
                <?php
					while ($rowD = mysql_fetch_array($resDocumentaciones)) {
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
                <h4 style="text-decoration:underline;">Habilitaciones Transitorias</h4>
                <?php
					while ($rowD = mysql_fetch_array($resHabilitacionesTransitorias)) {
					
					if (array_key_exists((integer)$rowD['refdocumentaciones'], $noHabilitaDocumentacion)) {
						
						$noHabilitaDocumentacion = array($rowD['refdocumentaciones']=>1);
						//die(var_dump($noHabilitaDocumentacion));
					}
				?>
                	<div class="col-md-12">
					<?php if ($rowD['motivos'] == 'Edad') { ?>
                    	<p><span style="color:#3C0;" class="glyphicon glyphicon-ok"></span> <?php echo 'Documentación: '.$rowD['documentacion'].' - Motivos: '.$rowD['motivos'].' - Temporada: '.$rowD['temporada'].' - Equipo: '.$rowD['equipo'].' - Categoria: '.$rowD['categoria']; ?></p>
                    <?php } else { ?>
                    	<p><span style="color:#3C0;" class="glyphicon glyphicon-ok"></span> <?php echo 'Documentación: '.$rowD['documentacion'].' - Motivos: '.$rowD['motivos'].' - Categoria: '.$rowD['categoria']; ?></p>
                    <?php } ?>
                    </div>
                <?php
					}
				?>
            </div>
            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert alert-danger' id="erroresEdad">
                
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
            
            <?php if (mysql_num_rows($resCantidadConectoresActivos) > 0) { ?>
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert alert-info' id="erroresCargos">
                	<p><strong>Importante!</strong> El jugador esta jugando actualmente para el equipo <strong><?php echo mysql_result($resCantidadConectoresActivos,0,2); ?></strong>, si lo carga un otro equipo este se dara de baja automaticamente.</p>
                </div>
                <div id='load'>
                
                </div>
            </div>
            <?php } ?>
            
            <?php if (in_array(0,$noHabilitaDocumentacion)) { ?>
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert alert-warning' id="erroresDocumentaciones">
                	<p><strong>Importante!</strong> El jugador no tiene completa su documentación, si lo carga a un equipo sera inhabilitado.</p>
                </div>
                <div id='load'>
                
                </div>
            </div>
            <?php } ?>
            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert' id="erroresCarga">
                
                </div>
                <div id='load'>
                
                </div>
            </div>
            
            
            
            <div class='row' style="margin-left:25px; margin-right:25px;">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                	
                    <li>
                        <button type="button" class="btn btn-primary" id="cargar" style="margin-left:0px;">Guardar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-success" id="habilitaciones" style="margin-left:0px;">Continuar</button>
                    </li>
                </ul>
                </div>
            </div>
            <input type="hidden" id="accion" name="accion" value="<?php echo $insertar; ?>"/>
            <input type="hidden" id="refjugadores" name="refjugadores" value="<?php echo $id; ?>"/>
            <input type="hidden" id="reftemporada" name="reftemporada" value="<?php echo $idTemporada; ?>"/>
            <input type="hidden" id="refcountries" name="refcountries" value="<?php echo mysql_result($resResultado,0,'refcountries'); ?>"/>
            </form>
    	
    </div>
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;"><?php echo $plural; ?> Cargados a Equipos</p>
        	
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
	
	$('#habilitaciones').click(function(event){
		 
		url = "habilitaciones.php?id="+<?php echo $id; ?>;
		$(location).attr('href',url);
	});//fin del boton habilitaciones
	

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
	
	function traerEquiposPorCountries(id, contenedor) {
		$.ajax({
			data:  {id: id, accion: 'traerEquiposPorCountries'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
			
			},
			success:  function (response) {
				$(contenedor).html(response);
				verificaEdadCategoriaJugador(<?php echo $id; ?>, $('#refcategorias').val(),$('#reftipojugadores').val(), $('#refequipos').val(),<?php echo $idTemporada; ?>);
			}
		});		
	}
	
	function traerEquipoPorCategoria(id, contenedor, idCountrie) {
		$.ajax({
			data:  {id: id,idCountrie: idCountrie, accion: 'traerEquipoPorCategoria'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
			
			},
			success:  function (response) {
				$(contenedor).html(response);
				verificaEdadCategoriaJugador(<?php echo $id; ?>, $('#refcategorias').val(),$('#reftipojugadores').val(), $('#refequipos').val(),<?php echo $idTemporada; ?>);
			}
		});		
	}
	
	
	
	function verificaEdadCategoriaJugador(refjugador, refcategoria, tipoJugador, refequipo, reftemporada) {
		$.ajax({
			data:  {refjugador: refjugador,
					refcategoria: refcategoria,
					tipoJugador: tipoJugador,
					refequipo: refequipo,
					reftemporada: reftemporada,
					accion: 'verificaEdadCategoriaJugador'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
			
			},
			success:  function (response) {
				if (response == 0) {
					$("#erroresEdad").removeClass("alert-danger");
					$("#erroresEdad").addClass("alert-danger");
					$("#erroresEdad").html('<strong>Error!</strong> El Jugador no tiene la edad para esta categoria o no posee una habilitación transitoria para acreditarlo');
					$('#cargar').hide();
				} else {
					$("#erroresEdad").removeClass("alert-danger");
					$("#erroresEdad").removeClass("alert-info");
					$("#erroresEdad").addClass("alert-success");
					$("#erroresEdad").html('<strong>Correcto!</strong> El Jugador esta en condiciones de ingresar a esta categoria');
					$('#cargar').show();
				}
			}
		});	
	}
	
	
	
	$('#refcategorias').change(function(e) {
        
		if  ($('#esfusion').prop('checked') == false) {
			traerEquipoPorCategoria($(this).val(), '#refequipos', <?php echo mysql_result($resResultado,0,'refcountries'); ?>);
		} else {
			traerEquipoPorCategoria($(this).val(), '#refequipos', $('#refcountriesaux').val());
		}
		
		verificaEdadCategoriaJugador(<?php echo $id; ?>, $('#refcategorias').val(),$('#reftipojugadores').val(), $('#refequipos').val(),<?php echo $idTemporada; ?>);
    });
	
	$('#reftipojugadores').change(function(e) {
        verificaEdadCategoriaJugador(<?php echo $id; ?>, $('#refcategorias').val(),$('#reftipojugadores').val(), $('#refequipos').val(),<?php echo $idTemporada; ?>);
    });
	
	$('#refequipos').change(function() {
		verificaEdadCategoriaJugador(<?php echo $id; ?>, $('#refcategorias').val(),$('#reftipojugadores').val(), $('#refequipos').val(),<?php echo $idTemporada; ?>);
	});
	
	
	//traerEquiposPorCountries(<?php echo mysql_result($resResultado,0,'refcountries'); ?>, '#refequipos');
	traerEquipoPorCategoria($('#refcategorias').val(), '#refequipos', <?php echo mysql_result($resResultado,0,'refcountries'); ?>);
	
	
	$('#esfusion').click(function() {
		
		if  ($('#esfusion').prop('checked') == false) {
			
			traerEquiposPorCountries(<?php echo mysql_result($resResultado,0,'refcountries'); ?>, '#refequipos');
			$('#refcountriesauxDiv').hide();
		} else {
			traerEquipoPorCategoria($(this).val(), '#refequipos', $('#refcountriesaux').val());
			$('#refcountriesauxDiv').show();	
		}
		
		
	});

	
	
	$('#refcountriesaux').change(function() {
		if  ($('#esfusion').prop('checked') == true) {
			traerEquiposPorCountries($(this).val(), '#refequipos');
		}
	});
	
	$('#esfusion').click(function() {
		$('#refequipos').html('');
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
									url = "equipos.php?id="+<?php echo $id; ?>;
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
	
	
	
			
				$("#refequipos").click(function(event) {
					$("#refequipos").removeClass("alert-danger");
					if ($(this).val() == "") {
						$("#refequipos").attr("value","");
						$("#refequipos").attr("placeholder","Ingrese el Equipo...");
					}
				});
			
				$("#refequipos").change(function(event) {
					$("#refequipos").removeClass("alert-danger");
					$("#refequipos").attr("placeholder","Ingrese el Equipo");
				});
	
			
				$("#refcategorias").click(function(event) {
					$("#refcategorias").removeClass("alert-danger");
					if ($(this).val() == "") {
						$("#refcategorias").attr("value","");
						$("#refcategorias").attr("placeholder","Ingrese el categorias...");
					}
				});
			
				$("#refcategorias").change(function(event) {
					$("#refcategorias").removeClass("alert-danger");
					$("#refcategorias").attr("placeholder","Ingrese el categorias");
				});
						
						
			function validador(){

					$error = "";
			
			
				
				
			
					
			
					if ($("#refcategorias").val() == null) {
						$error = "Es obligatorio el campo categorias.";
						alert($error);
						$("#refcategorias").addClass("alert-danger");
						$("#refcategorias").attr("placeholder",$error);
					}
					
					
					if ($("#refequipos").val() == null) {
						$error = "Es obligatorio el campo Equipo.";
						alert($error);
						$("#refequipos").addClass("alert-danger");
						$("#refequipos").attr("placeholder",$error);
					}
						
						
					return $error;
			}
	

	
	
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

					if (!isNaN(data)) {
							$("#erroresCarga").removeClass("alert-danger");
							$("#erroresCarga").removeClass("alert-info");
							$("#erroresCarga").addClass("alert-success");
							$("#erroresCarga").html('<strong>Ok!</strong> Se cargo exitosamente el <strong><?php echo $singular; ?></strong>. ');
							$("#erroresCarga").delay(3000).queue(function(){
								/*aca lo que quiero hacer 
								  después de los 2 segundos de retraso*/
								$(this).dequeue(); //continúo con el siguiente ítem en la cola
								
							});
							$("#load").html('');
							url = "equipos.php?id="+<?php echo $id; ?>;
							$(location).attr('href',url);
							
							
						} else {
							$("#erroresCarga").removeClass("alert-danger");
							$("#erroresCarga").addClass("alert-danger");
							$("#erroresCarga").html('<strong>Error!</strong> '+data);
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
