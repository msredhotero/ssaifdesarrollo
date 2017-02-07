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

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Equipos",$_SESSION['refroll_predio'],'');


$id = $_GET['id'];

$resResultado = $serviciosReferencias->traerEquiposPorId($id);

$refTemporada = $serviciosReferencias->traerUltimaTemporada();

if (mysql_num_rows($refTemporada)>0) {
	$idTemporada = mysql_result($refTemporada,0,0);	
} else {
	$idTemporada = 0;
}

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Equipo";

$plural = "Equipos";

$eliminar = "eliminarEquipos";

$modificar = "modificarEquipos";

$idTabla = "idequipo";

$tituloWeb = "Gestión: AIF";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbequipos";

$lblCambio	 	= array("refcountries","refcontactos","refcategorias","refdivisiones","fechaalta","fachebaja");
$lblreemplazo	= array("Countrie","Contacto","Categoria","Division","Fecha Alta","Fecha Baja");


$resCountries 	= $serviciosReferencias->traerCountriesPorId(mysql_result($resResultado,0,'refcountries'));
$cadRef 	= $serviciosFunciones->devolverSelectBoxActivo($resCountries,array(1),'', mysql_result($resResultado,0,'refcountries'));

$resContactos 	= $serviciosReferencias->traerContactosPorId(mysql_result($resResultado,0,'refcontactos'));
$cadRef2 	= $serviciosFunciones->devolverSelectBoxActivo($resContactos,array(2),'', mysql_result($resResultado,0,'refcontactos'));

$resCategorias 	= $serviciosReferencias->traerCategoriasPorId(mysql_result($resResultado,0,'refcategorias'));
$cadRef3 	= $serviciosFunciones->devolverSelectBoxActivo($resCategorias,array(1),'', mysql_result($resResultado,0,'refcategorias'));

$resDivisiones 	= $serviciosReferencias->traerDivisionesPorId(mysql_result($resResultado,0,'refdivisiones'));
$cadRef4 	= $serviciosFunciones->devolverSelectBoxActivo($resDivisiones,array(1),'', mysql_result($resResultado,0,'refdivisiones'));

$refdescripcion = array(0 => $cadRef,1 => $cadRef2,2 => $cadRef3,3 => $cadRef4);
$refCampo 	=  array("refcountries","refcontactos","refcategorias","refdivisiones");
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

////////		PARA LOS COMBOS 		//////////////////////////////////////////////////
$resCountriesT		=	$serviciosReferencias->traerCountries();
$cadRefCountries	=	$serviciosFunciones->devolverSelectBox($resCountriesT,array(1),'');

$resCategoria		=	$serviciosReferencias->traerCategoriasPorEquipos($id);
$cadRefCad			=	$serviciosFunciones->devolverSelectBox($resCategoria,array(1),'');

$resTipoJugador		=	$serviciosReferencias->traerTipojugadores();
$cadRefTipoJug		=	$serviciosFunciones->devolverSelectBox($resTipoJugador,array(1),'');
///////				FIN						//////////////////////////////////////////////

$resJugadoresEquipos = $serviciosReferencias->traerConectorActivosPorEquipos($id);


$formulario 	= $serviciosFunciones->camposTablaVer($id, $idTabla,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$resTraerJugadores = $serviciosReferencias->traerJugadoresPorCountrie(mysql_result($resResultado,0,'refcountries'));

$cadJugadores = '';
	while ($row = mysql_fetch_array($resTraerJugadores)) {
		//$cadJugadores .= '"'.$row[0].'": "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'",';
		$cadJugadores .= '
		      {
				id: "'.$row[0].'",
				label: "'.$row['apellido'].', '.$row['nombres'].' - '.$row['nrodocumento'].'"
			  },';
	}
	
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
	<style type="text/css">
		
  
		
	</style>
    
   <link rel="stylesheet" href="../../css/chosen.css">
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
    
    <!-- CSS file -->
<link rel="stylesheet" href="../../css/easy-autocomplete.min.css">
<link rel="stylesheet" href="../../css/easy-autocomplete.themes.min.css"> 

    <style type="text/css">
		#map
		{
			width: 100%;
			height: 600px;
			border: 1px solid #d0d0d0;
		}

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
   
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

<h3><?php echo $plural; ?></h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Ver <?php echo $singular; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">
        	
			<div class="row">
			<?php echo $formulario; ?>
            </div>
            
            <div class="row" style="border-left:5px solid #099; margin-left:-10px;">
			
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

            <div class="row" style="border-left:5px solid #099; margin-left:-10px;">
                    <div class="form-group col-md-4" style="display:block">
                        <label for="reftipodocumentos" class="control-label" style="text-align:left">Categorias</label>
                        <div class="input-group col-md-12">
                            <select class="form-control" id="refcategorias" name="refcategorias">
                            	<?php echo $cadRefCad; ?>
                            </select>
                            <p class="help-block infoEdad"></p>
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
                    
                    <div class="form-group col-md-4" style="display:block">
                    	<label for="reftipodocumentos" class="control-label" style="text-align:left"> </label>
                        <div class="input-group col-md-12">
                        	<div style="position: relative; height: 80px;">
                                
                                <input id="round" class="countrie" style="widows:100%;"/>
                            </div>
                            <div id="selction-ajax"></div>
                            
                        </div>
                    </div>

            </div>

			<div class='row' style="margin-left:25px; margin-right:25px;">
                <div class='alert'>
                
                </div>
                <div id='load'>
                
                </div>
            </div>
            <hr>
            
            <div class="row" id="contMapa2" style="margin-left:25px; margin-right:25px;">

                <div class="col-md-12">
                	<div class="form-group col-md-12">
                        <label class="control-label" style="text-align:left; font-size:1.2em; text-decoration:underline; margin-bottom:4px;" for="fechas">Lista de Jugadores</label>
                        <div>
                        <div style="float:left; width:15px; height:15px; background-color:#FE2E2E; margin-right:10px; margin-bottom:8px; margin-top:1px;"></div>
                        <p>Jugadores Inhabilitados por falta de Documentacion o Habilitaciones Transitorias</p>
                        </div>
                        <div class="input-group col-md-12">
                            <table class="table table-bordered table-responsive table-striped">
                            <thead>
                            	<tr>
                                	<th>Nombre Completo</th>
                                    <th>Nro Documento</th>
                                    <th>Tipo Jugador</th>
                                    <th>Countrie</th>
                                    <th>Edad</th>
                                    <th>Activo</th>
                                    <th style="text-align:center">Modificar</th>
                                    <th style="text-align:center">Baja</th>
                                </tr>
                            </thead>
                            <tbody id="lstjugadores">
							<?php 
								$cantidad = 0;
								
								while ($rowC = mysql_fetch_array($resJugadoresEquipos)) {
									$cadCumpleEdad = '';
									$errorDoc = 'FALTA';
									$cadErrorDoc = '';
									$habilitacion= 'INHAB.';
									$transitoria= '';
									$valorDocumentacion = 0;
									
									$edad = $serviciosReferencias->verificarEdad($rowC['refjugadores']);
		
									$cumpleEdad = $serviciosReferencias->verificaEdadCategoriaJugador($rowC['refjugadores'], $rowC['refcategorias'], $rowC['idtipojugador']);
									
									$documentaciones = $serviciosReferencias->traerJugadoresdocumentacionPorJugadorValores($rowC['refjugadores']);
									
									if ($cumpleEdad == 1) {
										$cadCumpleEdad = "CUMPLE";	
									} else {
										// VERIFICO SI EXISTE ALGUNA HABILITACION TRANSITORIA
										$habilitacionTransitoria = $serviciosReferencias->traerJugadoresmotivoshabilitacionestransitoriasPorJugadorDeportiva($rowC['refjugadores'], $idTemporada, $rowC['refcategorias'],$id);
										if (mysql_num_rows($habilitacionTransitoria)>0) {
											$cadCumpleEdad = "HAB. TRANS.";	
										} else {
											$cadCumpleEdad = "NO CUMPLE";	
										}
									}
									
									if (mysql_num_rows($documentaciones)>0) {
										while ($rowH = mysql_fetch_array($documentaciones)) {
											if (($rowH['valor'] == 'No') && ($rowH['contravalor'] == 'No')) {
												if ($rowH['obligatoria'] == 'Si') {
													$valorDocumentacion += 1;	
												}
												$cadErrorDoc .= strtoupper($rowH['descripcion']).' - ';
											}
										}
										if ($cadErrorDoc == '') {
											$cadErrorDoc = 'OK';
											$errorDoc = 'OK';
										} else {
											$cadErrorDoc = substr($cadErrorDoc,0,-3);
										}
										
									} else {
										$cadErrorDoc = 'FALTA PRESENTAR DOCUMENTACIONES';
									}
									
									if ($valorDocumentacion == 0 && $cadCumpleEdad == 'CUMPLE') {
										$habilitacion= 'HAB.';	
									}
								$cantidad += 1;
							?>
                            	<?php 
									if (($habilitacion == 'HAB.') || ($cadCumpleEdad == 'HAB. TRANS.')) { 
                            			$color = '';		
                                 	} else { 
                                		$color = 'style="background-color: #FE2E2E; color: #FFF;"';
                                 	} 
								?>
                                <tr>
                            	<td <?php echo $color; ?>><?php echo $rowC['nombrecompleto']; ?></td>
                                <td align="right" <?php echo $color; ?>><?php echo $rowC['nrodocumento']; ?></td>
                                <td align="center" <?php echo $color; ?>><?php echo $rowC['tipojugador']; ?></td>
                                <td <?php echo $color; ?>><?php echo $rowC['countrie']; ?></td>
                                <td align="center" <?php echo $color; ?>><?php echo $rowC['edad']; ?></td>
                                <td align="center" <?php echo $color; ?>><?php echo $rowC['activo']; ?></td>
								<td <?php echo $color; ?> align="center"><img src="../../imagenes/editarIco.png" style="cursor:pointer;" id="<?php echo $rowC['refjugadores']; ?>" class="varModificarJugador"></td>
                                <td <?php echo $color; ?> align="center"><img src="../../imagenes/eliminarIco.png" style="cursor:pointer;" id="<?php echo $rowC['idconector']; ?>" class="varEliminarJugador"></td>
                                </tr>
                            <?php
								}
							?>
                            </tbody>
                            <tfoot>
                            	<td colspan="6" align="right">Total Jugadores:</td>
                                <td><?php echo $cantidad; ?></td>
                            </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                
            </div>

            
            
            
            <div class="row">
                <div class="col-md-12">
                <ul class="list-inline" style="margin-top:15px;">
                    <li>
                        <button type="button" class="btn btn-warning modificar" id="<?php echo $id; ?>" style="margin-left:0px;">Modificar</button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
                    </li>
                </ul>
                </div>
            </div>
            <input type="hidden" id="countrieID" name="countrieID" value="<?php echo mysql_result($resResultado,0,'refcountries'); ?>" />
            </form>
    	</div>
    </div>
    
    
   
</div>


</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="1" style="z-index:500000;" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detalle de Venta</h4>
      </div>
      <div class="modal-body detalleJugador">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div id="dialog2" title="Quitar al jugador del Equipo">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea quitar el jugador?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si quitará el jugador del equipo pero no perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>


<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script src="../../js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
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
	
	
  </script>

<!-- JS file -->
<script src="../../js/jquery.easy-autocomplete.min.js"></script> 




<script type="text/javascript">
$(document).ready(function(){

	
	$('.volver').click(function(event){
		 
		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar
	
	
	$('#esfusion').click(function() {
		$('#round').val('');
		$('#selction-ajax').html('');
		if  ($('#esfusion').prop('checked') == false) {
			$('#countrieID').val(<?php echo mysql_result($resResultado,0,'refcountries'); ?>);
			$('#refcountriesauxDiv').hide();
		} else {
			$('#refcountriesauxDiv').show();
			
		}
	});

	
	$('#refcountriesaux').chosen().change(function(event, data) {
	   // arguments.length === 2
	   if  ($('#esfusion').prop('checked') == true) {
		   $('#selction-ajax').html('');
		   $('#countrieID').val($('#refcountriesaux').chosen().val());
		   $('#round').val('');
		}
	});



	function agregarJugador(refjugadores, reftipojugadores, refequipos, refcountries, refcategorias, esfusion, refcountriesaux, reftemporada) {
		
		$.ajax({
			data:  {refjugadores: refjugadores, 
					reftipojugadores: reftipojugadores, 
					refequipos: refequipos, 
					refcountries: refcountries, 
					refcategorias: refcategorias, 
					esfusion: esfusion, 
					refcountriesaux: refcountriesaux, 
					reftemporada: reftemporada,
					accion: 'insertarConectorAjax'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
			
			},
			success:  function (response) {
				
				if (response.indexOf('<tr>') != -1)
				{
					$('#lstjugadores').prepend(response);	
					$(".alert").removeClass("alert-danger");
					$(".alert").removeClass("alert-success");
					$(".alert").addClass("alert-success");
					$(".alert").html('Se cargo correctamente el jugador al equipo');
				} else {
					$(".alert").removeClass("alert-danger");
					$(".alert").removeClass("alert-success");
					$(".alert").addClass("alert-danger");
					$(".alert").html('<strong>Error!</strong> '+response);
						
				}
				
				
			}
		});	
	}
	
	$(document).on('click', '.agregarJugador', function(e){
		agregarJugador($(this).attr("id"), $('#reftipojugadores').val(), <?php echo $id; ?>, <?php echo mysql_result($resResultado,0,'refcountries'); ?>, $('#refcategorias').val(), $('#refcategorias').prop('checked'), $('#refcountriesaux').val(), <?php echo $idTemporada; ?>);
	});//fin del boton modificar
	
	function traerDefinicionesPorTemporadaCategoriaTipoJugador(resTemporada, resCategoria, resTipoJugador) {
		
		$.ajax({
			async: false,
			url:   '../../ajax/ajax.php',
			data:  {
				resTemporada: resTemporada, 
				resCategoria: resCategoria, 
				resTipoJugador: resTipoJugador, 
				accion: 'traerDefinicionesPorTemporadaCategoriaTipoJugador'
			},
			type:  'post',
			beforeSend: function () {
				$('.infoEdad').html('');
			},
			success:  function (response) {
				$('.infoEdad').html(response);	
				
			}
		});	
	
	}
	
	traerDefinicionesPorTemporadaCategoriaTipoJugador(<?php echo $idTemporada; ?>,$('#refcategorias').val(),$('#reftipojugadores').val());
	
	$('#refcategorias').change(function() {
		traerDefinicionesPorTemporadaCategoriaTipoJugador(<?php echo $idTemporada; ?>, $(this).val(), $('#reftipojugadores').val());
	});
	
	$('#reftipojugadores').change(function() {
		traerDefinicionesPorTemporadaCategoriaTipoJugador(<?php echo $idTemporada; ?>, $('#refcategorias').val(), $(this).val());
	});
	
	$(document).on('click', '.varModificarJugador', function(e){
		url = "../jugadores/modificar.php?id="+$(this).attr("id");
		$(location).attr('href',url);
	});//fin del boton modificar
	
	$(document).on('click', '.varEliminarJugador', function(e){

		  if (!isNaN($(this).attr("id"))) {
			$("#idEliminar").val($(this).attr("id"));
			$("#dialog2").dialog("open");

			
			//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
			//$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
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
							data:  {id: $('#idEliminar').val(), accion: 'eliminarConectorDefinitivamente'},
							url:   '../../ajax/ajax.php',
							type:  'post',
							beforeSend: function () {
									
							},
							success:  function (response) {
									url = "ver.php?id=" + <?php echo $id; ?>;
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
			

	$('.modificar').click(function(event){
		 
		usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar
	
	$('#refcountriesauxDiv').hide();
	
	$( "#autocomplete-ajax" ).click(function() {
		$(".alert").html('');
		$(".alert").removeClass("alert-danger");
		$(".alert").removeClass("alert-success");
	});

	
	var options = {

	  url: function(phrase) {
		return "../../json/jugadoresPorEquipos.php?countrie="+$('#countrieID').val();
	  },
	
	  getValue: function(element) {
		return element.name;
	  },
	
	  ajaxSettings: {
		dataType: "json",
		method: "GET",
		data: {
		  dataType: "json"
		}
	  },
	
	  preparePostData: function(data) {
		data.phrase = $("#round").val();
		return data;
	  },
	  
	  list: {
			onClickEvent: function() {
				var value = $("#round").getSelectedItemData().id;
	
				$('#selction-ajax').html('<button type="button" class="btn btn-success agregarJugador" id="' + value + '" style="margin-left:0px;">Agregar</button>');
			},
			
			match: {
				enabled: true
			}
	  },
	  theme: "round",
	  requestDelay: 100
	};
	
	$("#round").easyAutocomplete(options);

});
</script>

  


<?php } ?>
</body>
</html>
