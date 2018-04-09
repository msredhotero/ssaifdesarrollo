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

$resResultado = $serviciosReferencias->traerJugadoresprePorIdUsuarioPre($id);

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


		$formulario 	= $serviciosFunciones->camposTablaModificar($_SESSION['id_usuariopredio'], 'idusuario', 'modificarJugadorespreRegistro',$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

		$foto1 = '';
		$foto2 = '';
		$foto3 = '';

		// traer foto
		$resFoto = $serviciosReferencias->traerDocumentacionjugadorimagenesPorJugadorDocumentacion(mysql_result($resResultado,0,0),1);
		if (mysql_num_rows($resFoto) > 0) {
			$estadoFoto = mysql_result($resFoto, 0,'estado');
			$idEstadoFoto = mysql_result($resFoto, 0,'refestados');
			$foto1 = mysql_result($resFoto, 0,'imagen');
		} else {
			$estadoFoto = 'Sin carga';
			$idEstadoFoto = 0;
			$foto1 = '';
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
				$spanFoto = 'text-primary glyphicon glyphicon-ban-circle';
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
		} else {
			$estadoNroDoc = 'Sin carga';
			$idEstadoNroDoc = 0;
			$foto2= '';
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
				$spanNroDoc = 'text-primary glyphicon glyphicon-ban-circle';
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
		} else {
			$estadoNroDocDorso = 'Sin carga';
			$idEstadoNroDocDorso = 0;
			$foto3 = '';
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
				$spanNroDocDorso = 'text-primary glyphicon glyphicon-ban-circle';
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
		} else {
			$estadoTitulo = 'Sin carga';
			$idEstadoTitulo = 0;
			$foto4 = '';
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
				$spanTitulo = 'text-primary glyphicon glyphicon-ban-circle';
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
		} else {
			$estadoExpensa = 'Sin carga';
			$idEstadoExpensa = 0;
			$foto5 = '';
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
				$spanExpensa = 'text-primary glyphicon glyphicon-ban-circle';
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
		} else {
			$estadoPartidaNacimiento = 'Sin carga';
			$idEstadoPartidaNacimiento = 0;
			$foto6 = '';
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
				$spanPartidaNacimiento = 'text-primary glyphicon glyphicon-ban-circle';
				break;
			case 3:
				$spanPartidaNacimiento = 'text-success glyphicon glyphicon-ok-sign';
				break;
			case 4:
				$spanPartidaNacimiento = 'text-danger glyphicon glyphicon-remove-sign';
				break;
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
			<script src='../js/jquery.maskedinput.min.js' type='text/javascript'></script>

			<link rel="stylesheet" href="../css/fileinput/fileinput.css"/>
			
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

		 
		<?php echo str_replace('..','../dashboard',$resMenu); ?>

		<div id="content">

		<h3>Bienvenido</h3>
			
		    <div class="boxInfoLargo">
		        <div id="headBoxInfo">
		        	<p style="color: #fff; font-size:18px; height:16px;">Bienvenido al panel de alta de socios/jugadores nuevos.</p>
		        	
		        </div>
		    	<div class="cuerpoBox">
		    		<div class="panel-group">
					  <div class="panel panel-info">
					    <div class="panel-heading">
					      <h4 class="panel-title">
					        <a data-toggle="collapse" href="#collapse1" class="abrir">Para mas informacion hacer click Aqui <spam class="glyphicon glyphicon-hand-left"></spam></a>
					      </h4>
					    </div>
					    <div id="collapse1" class="panel-collapse collapse">
					      	<h4 style="padding: 15px;">Antes de continuar le dejamos el enlace a nuestro reglamento donde podrá consultar los requisitos individuales para poder participar de los torneos <a href="http://www.aif.org.ar/como-inscribirse/" target="_blank">(link)</a></h4>
							<p style="padding: 15px;">Para continuar con el registro y quedar habilitado le pedimos que nos envíe las siguientes documentaciones en buena calidad:</p>
 							<ul class="list-group">
								<li class="list-group-item">** Foto tipo carnet con fondo liso (recuadro para adjuntar) formatos de imágenes tipo JPG</li>
								<li class="list-group-item">** Scan de Documento Nacional de Identidad (anverso y reverso) (recuadro para adj) formato JPG</li>
								<li class="list-group-item">Scan de Escritura de compraventa (recuadro para adj) formato PDF</li>
								<li class="list-group-item">Scan de Expensas o servicio a la fecha correspondiente a la propiedad (recuadro para adj) formato PDF</li>
								<li class="list-group-item">Scan de Partida de nacimiento/matrimonio (obligatorio solamente para quienes deban demostrar el vínculo con el propietario) (recuadro para adj) formato PDF</li>
							</ul>
							<p style="padding: 15px;">** Una vez enviadas la foto y el DNI, el personal de la AIFZN evaluará los archivos enviados y en caso de estar aprobados se adjuntará en un correo electrónico la FICHA DEL JUGADOR. Esta ficha deberá ser impresa y firmada en el recuadro correspondiente por el socio/jugador nuevo. Luego el delegado del country/barrio privado será el encargado de acercar la misma a nuestra oficina.</p>
 

							<p style="padding: 15px;">La documentación enviada será revisada por el personal de la AIFZN y el mismo responderá con un mail detallando los pasos siguientes para finalizar con el alta.</p>
					    </div>
					  </div>
					</div>
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
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 2000 KB</small></div>
				        </div>
				        <div class="col-sm-3 text-center">
				        <h4><span class="<?php echo $spanFoto; ?>"></span> Estado: <b><?php echo $estadoFoto; ?></b></h4>
				        <ul class="list-form mensajesFoto">

				        </ul>
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
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 5500 KB</small></div>

				            <h4><span class="<?php echo $spanNroDoc; ?>"></span> Estado: <b><?php echo $estadoNroDoc; ?></b></h4>
				            <ul class="list-form mensajesDocumento">

				        	</ul>
				        </div>

				        <div class="col-sm-6 text-center">
							<h4>Foto del Documento del dorso</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-3" name="avatar-3" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 5500 KB</small></div>

				            <h4><span class="<?php echo $spanNroDocDorso; ?>"></span> Estado: <b><?php echo $estadoNroDocDorso; ?></b></h4>
				            <ul class="list-form mensajesDocumentoDorso">

				        	</ul>
				        </div>

		            </div>


		            <div class="row">
						<div class="col-sm-6 text-center">
							<h4>Escritura (Comprimido)</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-4" name="avatar-4" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 30000 KB</small></div>

				            <h4><span class="<?php echo $spanTitulo; ?>"></span> Estado: <b><?php echo $estadoTitulo; ?></b></h4>
				            <ul class="list-form mensajesTitulo">

				        	</ul>
				        </div>

				        <div class="col-sm-6 text-center">
							<h4>Expensas (.pdf)</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-5" name="avatar-5" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 5500 KB</small></div>

				            <h4><span class="<?php echo $spanExpensa; ?>"></span> Estado: <b><?php echo $estadoExpensa; ?></b></h4>
				            <ul class="list-form mensajesExpensa">

				        	</ul>
				        </div>

		            </div>


		            <div class="row">
						<div class="col-sm-6 text-center">
							<h4>Partida de Nacimiento (Comprimido)</h4>
				            <div class="kv-avatar">
				                <div class="file-loading">
				                    <input id="avatar-6" name="avatar-6" type="file" required>
				                </div>
				            </div>
				            <div class="kv-avatar-hint"><small>Seleccionar Archivo < 30000 KB</small></div>

				            <h4><span class="<?php echo $spanPartidaNacimiento; ?>"></span> Estado: <b><?php echo $estadoPartidaNacimiento; ?></b></h4>
				            <ul class="list-form mensajesPartidaNacimiento">

				        	</ul>
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
		                        <button type="button" class="btn btn-warning" id="cargar" style="margin-left:0px;">Guardar</button>
		                    </li>
		                </ul>
		                </div>
		            </div>
		            </form>
		    	</div>
		    </div>


		   
		</div>


		</div>


		<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
		<script src="../bootstrap/js/dataTables.bootstrap.js"></script>
		<script type="text/javascript" src="../js/fileinput/fileinput.js"></script>
		<script>
		
		</script>

		<script type="text/javascript">
		$(document).ready(function(){

			$('.abrir').click();

			function eliminarFoto(documentacion, jugador) {
				$.ajax({
					data:  {documentacion: documentacion, 
							jugador: jugador,
							accion: 'eliminarFotoJugadores'},
					url:   '../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
							
					},
					success:  function (response) {
							alert(response);
							//url = "index.php";
							//$(location).attr('href',url);
							
					}
				});
			}

			var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
			    'onclick="alert(\'Call your custom code here.\')">' +
			    '<i class="glyphicon glyphicon-tag"></i>' +
			    '</button>'; 

			<?php
				if (mysql_num_rows($resFoto)>0) {
				$urlImg = "../data/".mysql_result($resFoto,0,0)."/".mysql_result($resFoto,0,'imagen');
			?>
			$("#avatar-1").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 2000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../uploads/jugador.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='file-preview-image' alt='Desert' title='Desert'>",
			    ],
			    initialPreviewConfig: [
				    {
				        caption: '<?php echo mysql_result($resFoto,0,'imagen'); ?>', 
				        width: '50%', 
				        key: 100, 
				        extra: {id: 100}
				    }
				]
			}).on('filecleared', function(event) {
	          eliminarFoto(1,<?php echo mysql_result($resResultado, 0,'idjugadorpre'); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-1").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 2000,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../uploads/jugador.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});
	    	<?php	
	    	}
	    	?>

	    	<?php
				if (mysql_num_rows($resFotoDocumento)>0) {
				$urlImg = "../data/".mysql_result($resFotoDocumento,0,0)."/".mysql_result($resFotoDocumento,0,'imagen');
			?>
			$("#avatar-2").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 5500,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='file-preview-image' alt='Desert' title='Desert'>",
			    ],
			    initialPreviewConfig: [
				    {
				        caption: '<?php echo mysql_result($resFotoDocumento,0,'imagen'); ?>', 
				        width: '150px', 
				        key: 100, 
				        extra: {id: 100}
				    }
				]
			}).on('filecleared', function(event) {
	          eliminarFoto(2,<?php echo mysql_result($resResultado, 0,'idjugadorpre'); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-2").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 5500,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});

	    	<?php	
	    	}
	    	?>





	    	<?php
				if (mysql_num_rows($resFotoDocumentoDorso)>0) {
				$urlImg = "../data/".mysql_result($resFotoDocumentoDorso,0,0)."/".mysql_result($resFotoDocumentoDorso,0,'imagen');
			?>
			$("#avatar-3").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 5500,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='file-preview-image' alt='Desert' title='Desert'>",
			    ],
			    initialPreviewConfig: [
				    {
				        caption: 'IMG_20160805_155004.jpg', 
				        width: '150px', 
				        key: 100, 
				        extra: {id: 100}
				    }
				]
			}).on('filecleared', function(event) {
	          eliminarFoto(99,<?php echo mysql_result($resResultado, 0,'idjugadorpre'); ?>);
	        });

	        <?php
	    	} else {
	    	?>
	    	$("#avatar-3").fileinput({
			    overwriteInitial: true,
			    maxFileSize: 5500,
			    showClose: false,
			    showCaption: false,
			    browseLabel: '',
			    removeLabel: '',
			    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			    removeTitle: 'Cancel or reset changes',
			    elErrorContainer: '#kv-avatar-errors-1',
			    msgErrorClass: 'alert alert-block alert-danger',
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			});

	    	<?php	
	    	}
	    	?>





	    	<?php
				if (mysql_num_rows($resTitulo)>0) {
				$urlImg = "../data/".mysql_result($resTitulo,0,0)."/".mysql_result($resTitulo,0,'imagen');
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
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["rar","jpg", "png", "gif"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='file-preview-image' alt='Desert' title='Desert'>",
			    ],
			    initialPreviewConfig: [
				    {
				        caption: 'IMG_20160805_155004.jpg', 
				        width: '150px', 
				        key: 100, 
				        extra: {id: 100}
				    }
				]
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
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["rar"]
			});

	    	<?php	
	    	}
	    	?>



	    	<?php
				if (mysql_num_rows($resExpensa)>0) {
				$urlImg = "../data/".mysql_result($resExpensa,0,0)."/".mysql_result($resExpensa,0,'imagen');
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
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='file-preview-image' alt='Desert' title='Desert'>",
			    ],
			    initialPreviewConfig: [
				    {
				        caption: 'IMG_20160805_155004.jpg', 
				        width: '150px', 
				        key: 100, 
				        extra: {id: 100}
				    }
				]
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
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["pdf"]
			});

	    	<?php	
	    	}
	    	?>




	    	<?php
				if (mysql_num_rows($resPartidaNacimiento)>0) {
				$urlImg = "../data/".mysql_result($resPartidaNacimiento,0,0)."/".mysql_result($resPartidaNacimiento,0,'imagen');
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
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["rar"],
			    initialPreview: [
			    	"<img src='<?php echo $urlImg; ?>' width='100%' class='file-preview-image' alt='Desert' title='Desert'>",
			    ],
			    initialPreviewConfig: [
				    {
				        caption: 'IMG_20160805_155004.jpg', 
				        width: '150px', 
				        key: 100, 
				        extra: {id: 100}
				    }
				]
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
			    defaultPreviewContent: '<img src="../uploads/documento_img.png" alt="Your Avatar">',
			    layoutTemplates: {actionDelete: "", main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
			    allowedFileExtensions: ["rar"]
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
						url:   '../ajax/ajax.php',
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
					url: '../ajax/ajax.php',  
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
			
			$("#refcountries").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});

		});
		</script>
<?php } ?>
</body>
</html>
