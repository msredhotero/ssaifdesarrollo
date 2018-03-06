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

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../altasocios/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Alta Socios",$_SESSION['refroll_predio'],$_SESSION['email_predio']);


$id = $_GET['id'];

$resResultado = $serviciosReferencias->traerJugadoresprePorId($id);
$resResultadoAux = $serviciosReferencias->traerJugadoresprePorId($id);

$existeJugador = $serviciosReferencias->existeJugador(mysql_result($resResultadoAux,0,'nrodocumento'));

		/////////////////////// Opciones para la creacion del formulario  /////////////////////
		$tabla 			= "dbjugadorespre";

		$lblCambio	 	= array("reftipodocumentos","fechanacimiento","refcountries","refusuarios","numeroserielote");
		$lblreemplazo	= array("Tipo Documento","Fecha Nacimiento","Club","Delegado","Nro Serie Lote");


		$resTipoDoc 	= $serviciosReferencias->traerTipodocumentos();
		$cadRef 	= $serviciosFunciones->devolverSelectBoxActivo($resTipoDoc,array(1),'', mysql_result($resResultado,0,'reftipodocumentos'));

		$resCountry 	= $serviciosReferencias->traerCountriesPorId(mysql_result($resResultado,0,'refcountries'));
		$cadRef2 	= $serviciosFunciones->devolverSelectBoxActivo($resCountry,array(1),'', mysql_result($resResultado,0,'refcountries'));

		$resDelegado 	= $serviciosUsuario->traerUsuarioId(mysql_result($resResultado,0,'refusuarios'));
		$cadRef3 	= $serviciosFunciones->devolverSelectBoxActivo($resDelegado,array(3),'', mysql_result($resResultado,0,'refusuarios'));

		//die(var_dump($cadRef3));
		$refdescripcion = array(0 => $cadRef,1 => $cadRef2,2 => $cadRef3);
		$refCampo 	=  array("reftipodocumentos","refcountries","refusuarios");
		//////////////////////////////////////////////  FIN de los opciones //////////////////////////


		$formulario 	= $serviciosFunciones->camposTablaModificar($id, 'idjugadorpre', 'modificarJugadorespreRegistro',$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

		$foto1 = '';
		$foto2 = '';
		$foto3 = '';

		// traer foto
		$resFoto = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacion(mysql_result($resResultado,0,0),1);
		if (mysql_num_rows($resFoto) > 0) {
			$estadoFoto = mysql_result($resFoto, 0,'estado');
			$idEstadoFoto = mysql_result($resFoto, 0,'refestados');
			$foto1 = mysql_result($resFoto, 0,'imagen');
			$id1 = mysql_result($resFoto, 0,0);
		} else {
			$estadoFoto = 'Sin carga';
			$idEstadoFoto = 0;
			$foto1 = '';
			$id1 = 0;
		}

		$spanFoto = '';

		switch ($idEstadoFoto) {
			case 0:
				$spanFoto = 'text-muted glyphicon glyphicon-exclamation-sign';
				break;
			case 1:
				$spanFoto = 'text-info glyphicon glyphicon-plus-sign';
				break;
			case 2:
				$spanFoto = 'text-warning glyphicon glyphicon-ban-circle';
				break;
			case 3:
				$spanFoto = 'text-success glyphicon glyphicon-ok-sign';
				break;
			case 4:
				$spanFoto = 'text-danger glyphicon glyphicon-remove-sign';
				break;
		}
		


		// traer imagen
		$resFotoDocumento = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacion(mysql_result($resResultado,0,0),2);

		if (mysql_num_rows($resFotoDocumento) > 0) {
			$estadoNroDoc = mysql_result($resFotoDocumento, 0,'estado');
			$idEstadoNroDoc = mysql_result($resFotoDocumento, 0,'refestados');
			$foto2 = mysql_result($resFotoDocumento, 0,'imagen');
			$id2 = mysql_result($resFotoDocumento, 0,0);
		} else {
			$estadoNroDoc = 'Sin carga';
			$idEstadoNroDoc = 0;
			$foto2= '';
			$id2 = 0;
		}


		$spanNroDoc = '';
		switch ($idEstadoNroDoc) {
			case 0:
				$spanNroDoc = 'text-muted glyphicon glyphicon-exclamation-sign';
				break;
			case 1:
				$spanNroDoc = 'text-info glyphicon glyphicon-plus-sign';
				break;
			case 2:
				$spanNroDoc = 'text-warning glyphicon glyphicon-ban-circle';
				break;
			case 3:
				$spanNroDoc = 'text-success glyphicon glyphicon-ok-sign';
				break;
			case 4:
				$spanNroDoc = 'text-danger glyphicon glyphicon-remove-sign';
				break;
		}

		$resFotoDocumentoDorso = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacion(mysql_result($resResultado,0,0),99);

		if (mysql_num_rows($resFotoDocumentoDorso) > 0) {
			$estadoNroDocDorso = mysql_result($resFotoDocumentoDorso, 0,'estado');
			$idEstadoNroDocDorso = mysql_result($resFotoDocumentoDorso, 0,'refestados');
			$foto3 = mysql_result($resFotoDocumentoDorso, 0,'imagen');
			$id3 = mysql_result($resFotoDocumentoDorso, 0,0);
		} else {
			$estadoNroDocDorso = 'Sin carga';
			$idEstadoNroDocDorso = 0;
			$foto3 = '';
			$id3 = 0;
		}


		$spanNroDocDorso = '';
		switch ($idEstadoNroDocDorso) {
			case 0:
				$spanNroDocDorso = 'text-muted glyphicon glyphicon-exclamation-sign';
				break;
			case 1:
				$spanNroDocDorso = 'text-info glyphicon glyphicon-plus-sign';
				break;
			case 2:
				$spanNroDocDorso = 'text-warning glyphicon glyphicon-ban-circle';
				break;
			case 3:
				$spanNroDocDorso = 'text-success glyphicon glyphicon-ok-sign';
				break;
			case 4:
				$spanNroDocDorso = 'text-danger glyphicon glyphicon-remove-sign';
				break;
		}


		/*******-------------------------------------------------------*/

		$resTitulo = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacion(mysql_result($resResultado,0,0),4);

		if (mysql_num_rows($resTitulo) > 0) {
			$estadoTitulo = mysql_result($resTitulo, 0,'estado');
			$idEstadoTitulo = mysql_result($resTitulo, 0,'refestados');
			$foto4 = mysql_result($resTitulo, 0,'imagen');
			$id4 = mysql_result($resTitulo, 0,0);
		} else {
			$estadoTitulo = 'Sin carga';
			$idEstadoTitulo = 0;
			$foto4 = '';
			$id4 = 0;
		}


		$spanTitulo = '';
		switch ($idEstadoTitulo) {
			case 0:
				$spanTitulo = 'text-muted glyphicon glyphicon-exclamation-sign';
				break;
			case 1:
				$spanTitulo = 'text-info glyphicon glyphicon-plus-sign';
				break;
			case 2:
				$spanTitulo = 'text-warning glyphicon glyphicon-ban-circle';
				break;
			case 3:
				$spanTitulo = 'text-success glyphicon glyphicon-ok-sign';
				break;
			case 4:
				$spanTitulo = 'text-danger glyphicon glyphicon-remove-sign';
				break;
		}



		/*******-------------------------------------------------------*/

		$resExpensa = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacion(mysql_result($resResultado,0,0),6);

		if (mysql_num_rows($resExpensa) > 0) {
			$estadoExpensa = mysql_result($resExpensa, 0,'estado');
			$idEstadoExpensa = mysql_result($resExpensa, 0,'refestados');
			$foto5 = mysql_result($resExpensa, 0,'imagen');
			$id5 = mysql_result($resExpensa, 0,0);
		} else {
			$estadoExpensa = 'Sin carga';
			$idEstadoExpensa = 0;
			$foto5 = '';
			$id5 = 0;
		}


		$spanExpensa = '';
		switch ($idEstadoExpensa) {
			case 0:
				$spanExpensa = 'text-muted glyphicon glyphicon-exclamation-sign';
				break;
			case 1:
				$spanExpensa = 'text-info glyphicon glyphicon-plus-sign';
				break;
			case 2:
				$spanExpensa = 'text-warning glyphicon glyphicon-ban-circle';
				break;
			case 3:
				$spanExpensa = 'text-success glyphicon glyphicon-ok-sign';
				break;
			case 4:
				$spanExpensa = 'text-danger glyphicon glyphicon-remove-sign';
				break;
		}



		/*******-------------------------------------------------------*/

		$resPartidaNacimiento = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacion(mysql_result($resResultado,0,0),9);

		if (mysql_num_rows($resPartidaNacimiento) > 0) {
			$estadoPartidaNacimiento = mysql_result($resPartidaNacimiento, 0,'estado');
			$idEstadoPartidaNacimiento = mysql_result($resPartidaNacimiento, 0,'refestados');
			$foto6 = mysql_result($resPartidaNacimiento, 0,'imagen');
			$id6 = mysql_result($resPartidaNacimiento, 0,0);
		} else {
			$estadoPartidaNacimiento = 'Sin carga';
			$idEstadoPartidaNacimiento = 0;
			$foto6 = '';
			$id6 = 0;
		}


		$spanPartidaNacimiento = '';
		switch ($idEstadoPartidaNacimiento) {
			case 0:
				$spanPartidaNacimiento = 'text-muted glyphicon glyphicon-exclamation-sign';
				break;
			case 1:
				$spanPartidaNacimiento = 'text-info glyphicon glyphicon-plus-sign';
				break;
			case 2:
				$spanPartidaNacimiento = 'text-warning glyphicon glyphicon-ban-circle';
				break;
			case 3:
				$spanPartidaNacimiento = 'text-success glyphicon glyphicon-ok-sign';
				break;
			case 4:
				$spanPartidaNacimiento = 'text-danger glyphicon glyphicon-remove-sign';
				break;
		}


		$resEstados = $serviciosReferencias->traerEstados();
		$cadRefEstados 	= $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');



		?>

		<!DOCTYPE HTML>
		<html>

		<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">



		<title>Gesti&oacute;n: AIF</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">


		<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">
		    

		    
		    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
		    <link rel="stylesheet" href="../../css/jquery-ui.css">

		    <script src="../../js/jquery-ui.js"></script>
		    
			<!-- Latest compiled and minified CSS -->
		    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
			<!--<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>-->
		    <!-- Latest compiled and minified JavaScript -->
		    <script src="../../bootstrap/js/bootstrap.min.js"></script>
			<script src='../../js/jquery.maskedinput.min.js' type='text/javascript'></script>

			<link rel="stylesheet" href="../../css/fileinput/fileinput.css"/>

			<script src="../../js/fileinput/plugins/sortable.min.js"></script>
			<!-- purify plugin for safe rendering HTML content in preview -->
			<script src="../../js/fileinput/plugins/purify.min.js"></script>
			
		    <script src="../../js/liquidmetal.js" type="text/javascript"></script>
		    <script src="../../js/jquery.flexselect.js" type="text/javascript"></script>
		   <link rel="stylesheet" href="../../css/flexselect.css" type="text/css" media="screen" />
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
			.kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
			    margin: 0;
			    padding: 0;
			    border: none;
			    box-shadow: none;
			    text-align: center;
			}
			.kv-avatar {
			    display: inline-block;
			}
			.kv-avatar .file-input {
			    display: table-cell;
			    width: 213px;
			}
			.kv-reqd {
			    color: red;
			    font-family: monospace;
			    font-weight: normal;
			}
			</style>
		    
		    
		</head>

		<body>

		 
		<?php echo $resMenu; ?>

		<div id="content">

		<h3>Bienvenido</h3>
			
		    <div class="boxInfoLargo">
		        <div id="headBoxInfo">
		        	<p style="color: #fff; font-size:18px; height:16px;">Bienvenido al panel de alta de socios/jugadores nuevos.</p>
		        	
		        </div>
		    	<div class="cuerpoBox">
		    		
		        	<form class="form-inline formulario" role="form" enctype="multipart/form-data">
		        	<div class="row">
		        		<div class="col-sm-3 text-center">

		        		</div>
						<div class="col-sm-6 text-center">
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-1" name="avatar-1" type="file" value="<?php echo $foto1; ?>" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 6000 KB</small></div>
				            <p>Rotar la imagen <button type="button" class="btn btn-default" id="rotarIzquierda" style="margin-left:0px;">Izquierda</button></p>
				        </div>
				        <div class="col-sm-3 text-center">
				        <h4><span class="<?php echo $spanFoto; ?>"></span> Estado: <b><?php echo $estadoFoto; ?></b></h4>
				        	<div class="form-group col-md-12" style="display:block">
								<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
								<div class="input-group col-md-12">
									<select class="form-control" id="refestados<?php echo $id1; ?>" name="refestados<?php echo $id1; ?>">
										<?php echo $cadRefEstados; ?>
									</select>
								</div>
								<button type="button" class="btn btn-primary guardarEstado" id="<?php echo $id1; ?>" style="margin-left:0px;">Guardar Estado</button>
							</div>
				        </div>
		            </div>
					<div class="row">
					<?php echo $formulario; ?>
					<input type="hidden" id="nrodocumento" name="nrodocumento" value="<?php echo mysql_result($resResultado, 0,'nrodocumento'); ?>">
					<input type="hidden" id="fechaalta" name="fechaalta" value="<?php echo mysql_result($resResultado, 0,'fechaalta'); ?>">
					<input type="hidden" id="email" name="email" value="<?php echo mysql_result($resResultado, 0,'email'); ?>">
					<input type="hidden" id="numeroserielote" name="numeroserielote" value="<?php echo mysql_result($resResultado, 0,'numeroserielote'); ?>">
					<input type="hidden" id="id" name="id" value="<?php echo mysql_result($resResultado, 0,0); ?>">
		            </div>
		            
		            <div class="row">
						<div class="col-sm-6 text-center">
							<h4>Foto del Documento del frente</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-2" name="avatar-2" value="<?php echo $foto2; ?>" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 6000 KB</small></div>

				            <h4><span class="<?php echo $spanNroDoc; ?>"></span> Estado: <b><?php echo $estadoNroDoc; ?></b></h4>
				            <div class="form-group col-md-12" style="display:block">
								<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
								<div class="input-group col-md-12">
									<select class="form-control" id="refestados<?php echo $id2; ?>" name="refestados<?php echo $id2; ?>">
										<?php echo $cadRefEstados; ?>
									</select>
								</div>
								<button type="button" class="btn btn-primary guardarEstado" id="<?php echo $id2; ?>" style="margin-left:0px;">Guardar Estado</button>
							</div>
				        </div>

				        <div class="col-sm-6 text-center">
							<h4>Foto del Documento del dorso</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-3" name="avatar-3" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 6000 KB</small></div>

				            <h4><span class="<?php echo $spanNroDocDorso; ?>"></span> Estado: <b><?php echo $estadoNroDocDorso; ?></b></h4>
				            <div class="form-group col-md-12" style="display:block">
								<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
								<div class="input-group col-md-12">
									<select class="form-control" id="refestados<?php echo $id3; ?>" name="refestados<?php echo $id3; ?>">
										<?php echo $cadRefEstados; ?>
									</select>
								</div>
								<button type="button" class="btn btn-primary guardarEstado" id="<?php echo $id3; ?>" style="margin-left:0px;">Guardar Estado</button>
							</div>
				        </div>

		            </div>

		            <hr>
		            <div class="row">
		            	<div class="col-sm-12">
		            		<div class="alert alert-info"><span class="glyphicon glyphicon-info-sign"></span> Notificacion para los datos de la foto individual y la imagen del documento de identidad</div>
		            	</div>
		            	<div class="col-sm-12">

		            		<div class="form-group col-md-6" style="display:block">
								<label for="apellido" class="control-label" style="text-align:left">Mensaje</label>
								<div class="input-group col-md-12">
									<input type="text" class="form-control" name="mensaje" id="mensaje">
								</div>
							</div>
							<input type="hidden" name="idpagina" id="idpagina" value="0"/>
							<input type="hidden" name="autor" id="autor" value="<?php echo $_SESSION['nombre_predio'];?>"/>
							<input type="hidden" name="destinatario" id="destinatario" value="<?php echo mysql_result($resResultado,0,'email'); ?>"/>
							<input type="hidden" name="url" id="url" value="../"/>
							<input type="hidden" name="estilo" id="estilo" value=" "/>
							<input type="hidden" name="fecha" id="fecha" value=" "/>
							<input type="hidden" name="id1" id="id1" value="<?php echo $id;?>"/>
							<input type="hidden" name="id1" id="id2" value="0"/>
							<input type="hidden" name="id1" id="id3" value="0"/>



							<div class="form-group col-md-6" style="display:block">
								<label for="apellido" class="control-label" style="text-align:left">Estado</label>
								<div class="input-group col-md-12">
									<select class="form-control" name="icono" id="icono">
										<option value="glyphicon glyphicon-ok">Aceptado</option>
										<option value="glyphicon glyphicon-remove">Rechazado</option>
									</select>
								</div>
							</div>
		            	</div>
		            	<div class="col-sm-12">
		            		<ul class="list-inline">
		            			<li>Acciones: </li>
		            			<li>
		            				<button type="button" class="btn btn-info" id="generarFicha"style="margin-left:0px;"><span class="glyphicon glyphicon-file"></span> Generar Ficha Jugador</button>
		            			</li>
		            			<li>
		            				<button type="button" class="btn btn-success" id="notificar" style="margin-left:0px;"><span class="glyphicon glyphicon-envelope"></span> Generar Notificacion</button>
		            			</li>
		            			<?php
		            			if (($idEstadoFoto == 3) && ($idEstadoNroDoc == 3) && ($idEstadoNroDocDorso == 3) && ($existeJugador == 0)) {
		            			?>
		            			<li>
		            				<button type="button" class="btn btn-danger" id="jugadorNuevo" style="margin-left:0px;"><span class="glyphicon glyphicon-plus"></span> Generar Jugador Nuevo</button>
		            			</li>
		            			<li>** Recuerde que una vez que apriete este boton ya se generara el jugador y sus documentaciones.</li>
		            			<?php
		            			}
		            			?>
		            		</ul>
		            	</div>
		            </div>
		            <hr>




		            <div class="row">
						<div class="col-sm-4 text-center">
							<h4>Escritura (pdf)</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-4" name="avatar-4" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 30000 KB</small></div>

				            <h4><span class="<?php echo $spanTitulo; ?>"></span> Estado: <b><?php echo $estadoTitulo; ?></b></h4>
				            <div class="form-group col-md-12" style="display:block">
								<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
								<div class="input-group col-md-12">
									<select class="form-control" id="refestados<?php echo $id4; ?>" name="refestados<?php echo $id4; ?>">
										<?php echo $cadRefEstados; ?>
									</select>
								</div>
								<button type="button" class="btn btn-primary guardarEstado" id="<?php echo $id4; ?>" style="margin-left:0px;">Guardar Estado</button>
							</div>
				        </div>

				        <div class="col-sm-4 text-center">
							<h4>Expensas (pdf)</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-5" name="avatar-5" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 30000 KB</small></div>

				            <h4><span class="<?php echo $spanExpensa; ?>"></span> Estado: <b><?php echo $estadoExpensa; ?></b></h4>
				            <div class="form-group col-md-12" style="display:block">
								<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
								<div class="input-group col-md-12">
									<select class="form-control" id="refestados<?php echo $id5; ?>" name="refestados<?php echo $id5; ?>">
										<?php echo $cadRefEstados; ?>
									</select>
								</div>
								<button type="button" class="btn btn-primary guardarEstado" id="<?php echo $id5; ?>" style="margin-left:0px;">Guardar Estado</button>
							</div>
				        </div>

				        <div class="col-sm-4 text-center">
							<h4>Partida de Nacimiento (pdf)</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-6" name="avatar-6" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 30000 KB</small></div>

				            <h4><span class="<?php echo $spanPartidaNacimiento; ?>"></span> Estado: <b><?php echo $estadoPartidaNacimiento; ?></b></h4>
				            <div class="form-group col-md-12" style="display:block">
								<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
								<div class="input-group col-md-12">
									<select class="form-control" id="refestados<?php echo $id6; ?>" name="refestados<?php echo $id6; ?>">
										<?php echo $cadRefEstados; ?>
									</select>
								</div>
								<button type="button" class="btn btn-primary guardarEstado" id="<?php echo $id6; ?>" style="margin-left:0px;">Guardar Estado</button>
							</div>
				        </div>

		            </div>
		            
		            
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


		   
		</div>


		</div>

		<!-- Modal -->
		<div class="modal fade" id="myModal3" tabindex="1" style="z-index:500000;" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <form class="form-inline formulario" role="form">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Estado Documentación</h4>
		      </div>
		      <div class="modal-body" id="resultadoPresentacion">
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <input type="hidden" name="refcountries" id="refcountries" value="0"/>
		      </div>
		      </form>
		    </div>
		  </div>
		</div>


		<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
		<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>
		<script type="text/javascript" src="../../js/fileinput/fileinput.js"></script>
		<script>
		
		</script>

		<script type="text/javascript">
		$(document).ready(function(){

			$('.abrir').click();

			$('#generarFicha').click(function() {
				window.open("../../reportes/rptAltaSocio.php?id=<?php echo $id; ?>" ,'_blank');	
			});

			function eliminarFoto(documentacion, jugador) {
				$.ajax({
					data:  {documentacion: documentacion, 
							jugador: jugador,
							accion: 'eliminarFotoJugadores'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
							alert(response);
							url = "modificar.php?id=<?php echo $id; ?>";
							$(location).attr('href',url);
							
					}
				});
			}


			<?php
				if (mysql_num_rows($resFoto)>0) {
				$urlImg = "./../data/".mysql_result($resFoto,0,0)."/".mysql_result($resFoto,0,'imagen');
				$direc = "./../data/".mysql_result($resFoto,0,0);
			?>
			function rotarImagenIzquierda() {
				
				$.ajax({
					data:  {imagen: '<?php echo $urlImg; ?>', 
							rotar: 90,
							directorio: '<?php echo $direc; ?>',
							accion: 'rotarImagen'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
							url = "modificar.php?id=<?php echo $id; ?>";
							$(location).attr('href',url);
							
					}
				});
			}


			function rotarImagenDerecha() {
				
				$.ajax({
					data:  {imagen: '<?php echo $urlImg; ?>', 
							rotar: 270,
							directorio: '<?php echo $direc; ?>',
							accion: 'rotarImagen'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
							url = "modificar.php?id=<?php echo $id; ?>";
							$(location).attr('href',url);
							
					}
				});
			}

			$('#rotarIzquierda').click(function() {
				rotarImagenIzquierda();
			});
			<?php
			}
			?>

			function presentardocumentacion(id) {
				$.ajax({
					data:  {id: id, 
							accion: 'presentardocumentacion'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
							$('#resultadoPresentacion').html(response);
							//url = "index.php";
							//$(location).attr('href',url);
							
					}
				});
			}

			function generarNotificacion(mensaje,idpagina,autor,destinatario,id1,id2,id3,icono,estilo,fecha,url) {
				$.ajax({
					data:  {mensaje: mensaje, 
							idpagina: idpagina,
							autor: autor,
							destinatario: destinatario,
							id1: id1,
							id2: id2,
							id3: id3,
							icono: icono,
							estilo: estilo,
							fecha: fecha,
							url: url,
							email: '<?php echo mysql_result($resResultadoAux,0,"email"); ?>',
							accion: 'generarNotificacion'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
							
							alert('Se genero la Notificacion y se envio un email al destinatario')
							
					}
				});
			}

			$('#notificar').click(function() {
				generarNotificacion($('#mensaje').val(),$('#idpagina').val(),$('#autor').val(),$('#destinatario').val(),$('#id1').val(),$('#id2').val(),$('#id3').val(),$('#icono').val(),$('#fecha').val(),$('#url').val());
			});



			function guardarEstado(id, refestados) {
				$.ajax({
					data:  {id: id, 
							refestados: refestados,
							existeJugador: <?php echo $existeJugador; ?>,
							accion: 'guardarEstado'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
							
							url = "modificar.php?id=<?php echo $id; ?>";
							$(location).attr('href',url);
							
					}
				});
			}

			$('.guardarEstado').click(function() {
				usersid =  $(this).attr("id");

				guardarEstado(usersid, $('#refestados'+usersid).val());
			});

			function jugadorNuevo(id, idEstadoExpensas, idEstadoPartidaDeNacimiento, idTitulo) {
				$.ajax({
					data:  {id: id, 
							idEstadoExpensas: idEstadoExpensas,
							idEstadoPartidaDeNacimiento: idEstadoPartidaDeNacimiento,
							idTitulo: idTitulo,
							accion: 'jugadorNuevo'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
							alert('El Jugador Ya fue creado y su documentacion también.')
							url = "../jugadores/modificar.php?id="+response;
							$(location).attr('href',url);
							
					}
				});
			}

			$('#jugadorNuevo').click(function() {

				var expensa = 0;
				var partidaNaci = 0;
				var titulo = 0;

				if (<?php echo $idEstadoExpensa; ?> == 3) {
					expensa = 1;
				}
				if (<?php echo $idEstadoPartidaNacimiento; ?> == 3) {
					partidaNaci = 1;
				}
				if (<?php echo $idEstadoTitulo; ?> == 3) {
					titulo = 1;
				}
				jugadorNuevo(<?php echo $id; ?>, expensa, partidaNaci, titulo);
			});
			

			$('#presentar').click(function() {
				presentardocumentacion(<?php echo mysql_result($resResultado,0,0); ?>);
			});

			var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
			    'onclick="alert(\'Call your custom code here.\')">' +
			    '<i class="glyphicon glyphicon-tag"></i>' +
			    '</button>'; 

			<?php
				if (mysql_num_rows($resFoto)>0) {
				$urlImg = "../../data/".mysql_result($resFoto,0,0)."/".mysql_result($resFoto,0,'imagen');
			?>
			$("#avatar-1").fileinput({
			    overwriteInitial: false,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    <?php
			    if (($idEstadoFoto == 0) || ($idEstadoFoto == 1) || ($idEstadoFoto == 4)) {
			    ?>
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    <?php
				} else {
				?>
				layoutTemplates: {actionDelete: "", main2: '{preview}'},
				<?php
				} 
				?>
			    allowedFileExtensions: ["jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' class='kv-preview-data file-preview-image' alt='Foto Perfil' title='Foto Perfil'>"
			    ],
			    initialPreviewAsData: false, // allows you to set a raw markup
    			initialPreviewFileType: 'image',
			    initialPreviewConfig: [
				    {caption: "<?php echo mysql_result($resFoto,0,'imagen'); ?>", size: 827000, width: "120px", url: '<?php echo "../../data/".mysql_result($resFoto,0,0); ?>', key: 1}
				],
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(1,<?php echo mysql_result($resResultado, 0,'idjugadorpre'); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-1").fileinput({
			    overwriteInitial: true,
			    autoOrientImage: true,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/jugador.png" alt="Your Avatar">',
			    <?php
			    if (($idEstadoFoto == 0) || ($idEstadoFoto == 1) || ($idEstadoFoto == 4)) {
			    ?>
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    <?php
				} else {
				?>
				layoutTemplates: {actionDelete: "", main2: '{preview}'},
				<?php
				} 
				?>
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});
	    	<?php	
	    	}
	    	?>

	    	<?php
				if (mysql_num_rows($resFotoDocumento)>0) {
				$urlImg = "../../data/".mysql_result($resFotoDocumento,0,0)."/".mysql_result($resFotoDocumento,0,'imagen');
			?>
			$("#avatar-2").fileinput({
			    overwriteInitial: false,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    <?php
			    if (($idEstadoNroDoc == 0) || ($idEstadoNroDoc == 1) || ($idEstadoNroDoc == 4)) {
			    ?>
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    <?php
				} else {
				?>
				layoutTemplates: {actionDelete: "", main2: '{preview}'},
				<?php
				} 
				?>
			    allowedFileExtensions: ["jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' class='kv-preview-data file-preview-image' alt='Foto Documento Frente' title='Foto Documento Frente'>"
			    ],
			    initialPreviewAsData: false, // allows you to set a raw markup
    			initialPreviewFileType: 'image',
			    initialPreviewConfig: [
				    {caption: "<?php echo mysql_result($resFotoDocumento,0,'imagen'); ?>", size: 827000, width: "120px", url: '<?php echo "../../data/".mysql_result($resFotoDocumento,0,0); ?>', key: 1}
				],
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(2,<?php echo mysql_result($resResultado, 0,'idjugadorpre'); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-2").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    <?php
			    if (($idEstadoNroDoc == 0) || ($idEstadoNroDoc == 1) || ($idEstadoNroDoc == 4)) {
			    ?>
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    <?php
				} else {
				?>
				layoutTemplates: {actionDelete: "", main2: '{preview}'},
				<?php
				} 
				?>
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});

	    	<?php	
	    	}
	    	?>





	    	<?php
				if (mysql_num_rows($resFotoDocumentoDorso)>0) {
				$urlImg = "../../data/".mysql_result($resFotoDocumentoDorso,0,0)."/".mysql_result($resFotoDocumentoDorso,0,'imagen');
			?>
			$("#avatar-3").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    <?php
			    if (($idEstadoNroDocDorso == 0) || ($idEstadoNroDocDorso == 1) || ($idEstadoNroDocDorso == 4)) {
			    ?>
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    <?php
				} else {
				?>
				layoutTemplates: {actionDelete: "", main2: '{preview}'},
				<?php
				} 
				?>
			    allowedFileExtensions: ["jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='kv-preview-data file-preview-image' alt='Foto Documento Dorso' title='Foto Documento Dorso'>",
			    ],
			    initialPreviewAsData: false, // allows you to set a raw markup
    			initialPreviewFileType: 'image',
			    initialPreviewConfig: [
				    {caption: "<?php echo mysql_result($resFotoDocumentoDorso,0,'imagen'); ?>", size: 827000, width: "120px", url: '<?php echo "../../data/".mysql_result($resFotoDocumentoDorso,0,0); ?>', key: 1}
				],
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(99,<?php echo mysql_result($resResultado, 0,'idjugadorpre'); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-3").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 6000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    <?php
			    if (($idEstadoNroDocDorso == 0) || ($idEstadoNroDocDorso == 1) || ($idEstadoNroDocDorso == 4)) {
			    ?>
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    <?php
				} else {
				?>
				layoutTemplates: {actionDelete: "", main2: '{preview}'},
				<?php
				} 
				?>
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});

	    	<?php	
	    	}
	    	?>





	    	<?php
				if (mysql_num_rows($resTitulo)>0) {
				$urlImg = "../../data/".mysql_result($resTitulo,0,0)."/".mysql_result($resTitulo,0,'imagen');
			?>
			$("#avatar-4").fileinput({
			    overwriteInitial: false,
			    maxFileSize: 10000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-5',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf"],
			    initialPreview: [
			    	'../../data/<?php echo mysql_result($resTitulo,0,0); ?>/<?php echo mysql_result($resTitulo,0,'imagen'); ?>'
			    ],
				initialPreviewFileType: 'image',
			    initialPreviewAsData: true, // allows you to set a raw markup
			    initialPreviewConfig: [
				    {type: "pdf", size: 8000, caption: "PDF Sample", filename: "<?php echo mysql_result($resTitulo,0,'imagen'); ?>",  key: 1}
				],
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    },
			    preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
			    previewFileIconSettings: { // configure your icon file extensions
			        'doc': '<i class="fa fa-file-word-o text-primary"></i>',
			        'xls': '<i class="fa fa-file-excel-o text-success"></i>',
			        'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
			        'pdf': '<img src="../../imagenes/pdf.png">',
			        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
			        'htm': '<i class="fa fa-file-code-o text-info"></i>',
			        'txt': '<i class="fa fa-file-text-o text-info"></i>',
			        'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
			        'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
			        // note for these file types below no extension determination logic 
			        // has been configured (the keys itself will be used as extensions)
			        'jpg': '<img src="../../imagenes/sin_img.jpg">', 
			        'gif': '<i class="fa fa-file-photo-o text-muted"></i>', 
			        'png': '<img src="../../imagenes/sin_img.jpg">'    
			    },
			    previewFileExtSettings: { // configure the logic for determining icon file extensions
			        'doc': function(ext) {
			            return ext.match(/(doc|docx)$/i);
			        },
			        'xls': function(ext) {
			            return ext.match(/(xls|xlsx)$/i);
			        },
			        'ppt': function(ext) {
			            return ext.match(/(ppt|pptx)$/i);
			        },
			        'zip': function(ext) {
			            return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
			        },
			        'htm': function(ext) {
			            return ext.match(/(htm|html)$/i);
			        },
			        'txt': function(ext) {
			            return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
			        },
			        'mov': function(ext) {
			            return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
			        },
			        'mp3': function(ext) {
			            return ext.match(/(mp3|wav)$/i);
			        }
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(4,<?php echo mysql_result($resResultado, 0,'idjugadorpre'); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-4").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 30000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf"]
			});

	    	<?php	
	    	}
	    	?>



	    	<?php
				if (mysql_num_rows($resExpensa)>0) {
				$urlImg = "../../data/".mysql_result($resExpensa,0,0)."/".mysql_result($resExpensa,0,'imagen');
			?>
			$("#avatar-5").fileinput({
			    overwriteInitial: false,
			    maxFileSize: 10000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-5',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf","jpg", "png", "gif"],
			    <?php 
			    if (mysql_result($resExpensa,0,'type') == 'application/pdf') {
			    ?>
			    initialPreview: [
			    	'../../data/<?php echo mysql_result($resExpensa,0,0); ?>/<?php echo mysql_result($resExpensa,0,'imagen'); ?>'
			    ],

			    <?php
				} else {
				?>
				initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='kv-preview-data file-preview-image' alt='Desert' title='Desert'>",
			    ],
				<?php
				}
				?>
				initialPreviewFileType: 'image',
			    initialPreviewAsData: true, // allows you to set a raw markup
    			<?php 
			    if (mysql_result($resExpensa,0,'type') == 'application/pdf') {
			    ?>
			    initialPreviewConfig: [
				    {type: "pdf", size: 8000, caption: "PDF Sample", filename: "<?php echo mysql_result($resExpensa,0,'imagen'); ?>",  key: 1}
				],
			    <?php
				} else {
				?>
			    initialPreviewConfig: [
				    {caption: "<?php echo mysql_result($resExpensa,0,'imagen'); ?>", size: 827000, width: "120px", url: '<?php echo "../../data/".mysql_result($resExpensa,0,0); ?>', key: 1}
				],
				<?php
				}
				?>
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    },
			    preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
			    previewFileIconSettings: { // configure your icon file extensions
			        'doc': '<i class="fa fa-file-word-o text-primary"></i>',
			        'xls': '<i class="fa fa-file-excel-o text-success"></i>',
			        'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
			        'pdf': '<img src="../../imagenes/pdf.png">',
			        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
			        'htm': '<i class="fa fa-file-code-o text-info"></i>',
			        'txt': '<i class="fa fa-file-text-o text-info"></i>',
			        'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
			        'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
			        // note for these file types below no extension determination logic 
			        // has been configured (the keys itself will be used as extensions)
			        'jpg': '<img src="../../imagenes/sin_img.jpg">', 
			        'gif': '<i class="fa fa-file-photo-o text-muted"></i>', 
			        'png': '<img src="../../imagenes/sin_img.jpg">'    
			    },
			    previewFileExtSettings: { // configure the logic for determining icon file extensions
			        'doc': function(ext) {
			            return ext.match(/(doc|docx)$/i);
			        },
			        'xls': function(ext) {
			            return ext.match(/(xls|xlsx)$/i);
			        },
			        'ppt': function(ext) {
			            return ext.match(/(ppt|pptx)$/i);
			        },
			        'zip': function(ext) {
			            return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
			        },
			        'htm': function(ext) {
			            return ext.match(/(htm|html)$/i);
			        },
			        'txt': function(ext) {
			            return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
			        },
			        'mov': function(ext) {
			            return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
			        },
			        'mp3': function(ext) {
			            return ext.match(/(mp3|wav)$/i);
			        }
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(6,<?php echo mysql_result($resResultado, 0,'idjugadorpre'); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-5").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 10000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-5',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf","jpg", "png", "gif"]
			});

	    	<?php	
	    	}
	    	?>




	    	<?php
				if (mysql_num_rows($resPartidaNacimiento)>0) {
				$urlImg = "../../data/".mysql_result($resPartidaNacimiento,0,0)."/".mysql_result($resPartidaNacimiento,0,'imagen');
			?>
			$("#avatar-6").fileinput({
			    overwriteInitial: false,
			    maxFileSize: 10000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-5',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf","jpg", "png", "gif"],
			    <?php 
			    if (mysql_result($resPartidaNacimiento,0,'type') == 'application/pdf') {
			    ?>
			    initialPreview: [
			    	'../../data/<?php echo mysql_result($resPartidaNacimiento,0,0); ?>/<?php echo mysql_result($resPartidaNacimiento,0,'imagen'); ?>'
			    ],

			    <?php
				} else {
				?>
				initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='kv-preview-data file-preview-image' alt='Desert' title='Desert'>",
			    ],
				<?php
				}
				?>
				initialPreviewFileType: 'image',
			    initialPreviewAsData: true, // allows you to set a raw markup
    			<?php 
			    if (mysql_result($resPartidaNacimiento,0,'type') == 'application/pdf') {
			    ?>
			    initialPreviewConfig: [
				    {type: "pdf", size: 80000, caption: "PDF Sample", filename: "<?php echo mysql_result($resPartidaNacimiento,0,'imagen'); ?>",  key: 1}
				],
			    <?php
				} else {
				?>
			    initialPreviewConfig: [
				    {caption: "<?php echo mysql_result($resPartidaNacimiento,0,'imagen'); ?>", size: 827000, width: "120px", url: '<?php echo "../../data/".mysql_result($resPartidaNacimiento,0,0); ?>', key: 1}
				],
				<?php
				}
				?>
				purifyHtml: true, // this by default purifies HTML data for preview
			    uploadExtraData: {
			        img_key: "1000",
			        img_keywords: "happy, places"
			    },
			    preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
			    previewFileIconSettings: { // configure your icon file extensions
			        'doc': '<i class="fa fa-file-word-o text-primary"></i>',
			        'xls': '<i class="fa fa-file-excel-o text-success"></i>',
			        'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
			        'pdf': '<img src="../../imagenes/pdf.png">',
			        'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
			        'htm': '<i class="fa fa-file-code-o text-info"></i>',
			        'txt': '<i class="fa fa-file-text-o text-info"></i>',
			        'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
			        'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
			        // note for these file types below no extension determination logic 
			        // has been configured (the keys itself will be used as extensions)
			        'jpg': '<img src="../../imagenes/sin_img.jpg">', 
			        'gif': '<i class="fa fa-file-photo-o text-muted"></i>', 
			        'png': '<img src="../../imagenes/sin_img.jpg">'    
			    },
			    previewFileExtSettings: { // configure the logic for determining icon file extensions
			        'doc': function(ext) {
			            return ext.match(/(doc|docx)$/i);
			        },
			        'xls': function(ext) {
			            return ext.match(/(xls|xlsx)$/i);
			        },
			        'ppt': function(ext) {
			            return ext.match(/(ppt|pptx)$/i);
			        },
			        'zip': function(ext) {
			            return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
			        },
			        'htm': function(ext) {
			            return ext.match(/(htm|html)$/i);
			        },
			        'txt': function(ext) {
			            return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
			        },
			        'mov': function(ext) {
			            return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
			        },
			        'mp3': function(ext) {
			            return ext.match(/(mp3|wav)$/i);
			        }
			    }
			}).on('filecleared', function(event) {
	          eliminarFoto(9,<?php echo mysql_result($resResultado, 0,'idjugadorpre'); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-6").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 10000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-6',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../../uploads/IMG-20180215-WA0017.jpg" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf","jpg", "png"]
			});

	    	<?php	
	    	}
	    	?>


			
			$('#colapsarMenu').click();


			$('#numeroserielote').prop('disabled',true);
			$('#nrodocumento').prop('disabled',true);
			$('#email').prop('disabled',true);
			$('#fechaalta').prop('disabled',true);
			
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
						url:   '../../ajax/ajax.php',
						type:  'post',
						beforeSend: function () {
								
						},
						success:  function (response) {
								$('#resultadosJuagadores').html(response);
								
						}
				});
				
			});
			
			
			//al enviar el formulario
		    $('#cargar').click(function(){
				

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
						$("#load").html('<img src="../imagenes/load13.gif" width="50" height="50" />');  
						$('#cargar').hide();     
					},
					//una vez finalizado correctamente
					success: function(data){

						if (data == '') {
		                                        $(".alert").removeClass("alert-danger");
												$(".alert").removeClass("alert-info");
		                                        $(".alert").addClass("alert-success");
		                                        $(".alert").html('<strong>Ok!</strong> Sus datos fueron guardados correctamente. ');
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
				
		    });
			
			

			

		});
		</script>
<?php } ?>
</body>
</html>
